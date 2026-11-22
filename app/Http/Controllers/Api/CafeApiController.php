<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\Subcategory;
use App\Models\Order;
use App\Models\OrderItem;
use App\Services\LineBotService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CafeApiController extends Controller
{
    /**
     * GET /api/products
     * ดึงรายการสินค้าทั้งหมด
     */
    public function products(Request $request)
    {
        $query = Product::with(['category', 'subcategory']);

        // Filter by category (slug: coffee, noncoffee, cake)
        if ($request->filled('category')) {
            $catSlug = $request->input('category');
            $query->whereHas('category', function ($q) use ($catSlug) {
                $q->where('slug', $catSlug);
            });
        }

        // Filter by subcategory name
        if ($request->filled('subcategory')) {
            $subName = $request->input('subcategory');
            $query->whereHas('subcategory', function ($q) use ($subName) {
                $q->where('name', $subName)->orWhere('slug', strtolower($subName));
            });
        }

        // Filter by availability
        if ($request->has('is_available')) {
            $query->where('is_available', $request->boolean('is_available'));
        }

        // Search
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        $products = $query->get()->map(function ($product) {
            return [
                'id'           => $product->id,
                'name'         => $product->name,
                'category'     => $product->category?->slug ?? '',
                'subcategory'  => $product->subcategory?->name,
                'description'  => $product->description,
                'price'        => (float) $product->price,
                'image'        => $product->image ? asset('storage/' . $product->image) : null,
                'is_available' => $product->is_available,
            ];
        });

        return response()->json([
            'success' => true,
            'data'    => $products,
        ]);
    }

    /**
     * GET /api/categories
     * ดึงหมวดหมู่ทั้งหมดพร้อม subcategories
     */
    public function categories()
    {
        $categories = Category::with(['subcategories' => function ($q) {
            $q->orderBy('sort_order');
        }])->orderBy('sort_order')->get();

        return response()->json([
            'success' => true,
            'data'    => $categories,
        ]);
    }

    /**
     * POST /api/orders
     * สร้างออเดอร์ใหม่
     */
    public function createOrder(Request $request)
    {
        Log::info('New API Order Request received:', $request->all());

        $request->validate([
            'customer_name'    => 'required|string|max:255',
            'customer_phone'   => 'required|string|max:20',
            'note'             => 'nullable|string',
            'items'            => 'required|array|min:1',
            'items.*.id'       => 'required',
            'items.*.qty'      => 'required|integer|min:1',
            'items.*.options'  => 'nullable|string',
        ]);

        $total = 0;
        $orderItems = [];
        $itemsText = "";

        foreach ($request->items as $item) {
            $product = Product::find($item['id']);
            if (!$product) {
                $product = Product::where('name', $item['name'] ?? '')->first();
            }

            $itemPrice = $product ? $product->price : (float)($item['unit_price'] ?? 50.0);
            $optionsText = $item['options'] ?? '';

            // บวกราคาเพิ่มตามออปชั่น
            if ($optionsText) {
                if (str_contains($optionsText, 'เพิ่มช็อต')) $itemPrice += 20;
                if (str_contains($optionsText, 'นมโอ๊ต')) $itemPrice += 15;
                if (str_contains($optionsText, 'วิปครีม')) $itemPrice += 15;
                if (str_contains($optionsText, 'เพิ่มบุก')) $itemPrice += 5;
            }

            $subtotal = $itemPrice * $item['qty'];
            $total += $subtotal;
            $orderItems[] = [
                'product_id' => $product ? $product->id : null,
                'quantity'   => $item['qty'],
                'price'      => $itemPrice,
                'options'    => $optionsText ?: null,
            ];

            $productName = $product ? $product->name : ($item['name'] ?? 'เครื่องดื่ม');
            $itemsText .= "- " . $productName . " x" . $item['qty'];
            if ($optionsText) {
                $itemsText .= " (" . $optionsText . ")";
            }
            $itemsText .= "\n";
        }

        $order = Order::create([
            'user_id'        => null,
            'customer_name'  => $request->customer_name,
            'customer_phone' => $request->customer_phone,
            'status'         => 'pending',
            'payment_status' => 'pending',
            'total_price'    => $total,
            'note'           => $request->note,
        ]);

        $order->orderItems()->createMany($orderItems);
        $order->load('orderItems.product');

        // คำนวณคิวก่อนหน้า
        $queueAhead = Order::whereIn('status', ['pending', 'confirmed', 'preparing'])
            ->where('id', '<', $order->id)
            ->count();

        // ส่งแจ้งเตือนเข้า LINE ทันที
        try {
            $lineBot = app(LineBotService::class);
            $message = "☕ มีออเดอร์ใหม่เข้ามา (จากเว็บ/แอป)!\n";
            $message .= "รหัสออเดอร์: #" . $order->id . "\n";
            $message .= "ลูกค้า: " . $order->customer_name . "\n";
            $message .= "เบอร์โทร: " . ($order->customer_phone ?: 'ไม่ระบุ') . "\n";
            if (!empty($order->note)) {
                $message .= "หมายเหตุ: " . $order->note . "\n";
            }
            $message .= "รายการสั่งซื้อ:\n" . $itemsText;
            $message .= "ยอดรวม: ฿" . number_format($order->total_price, 2);

            $lineBot->sendTextMessage($message);
            Log::info("LINE Notification sent for Order #{$order->id}");
        } catch (\Exception $e) {
            Log::error("LINE Notification failed on createOrder: " . $e->getMessage());
        }

        return response()->json([
            'success' => true,
            'order'   => $this->formatOrder($order, $queueAhead),
        ], 201);
    }

    /**
     * GET /api/orders/{id}
     * ดึงสถานะออเดอร์
     */
    public function getOrder(int $id)
    {
        $order = Order::with('orderItems.product')->findOrFail($id);

        $queueAhead = Order::whereIn('status', ['pending', 'confirmed', 'preparing'])
            ->where('id', '<', $order->id)
            ->count();

        return response()->json([
            'success' => true,
            'order'   => $this->formatOrder($order, $queueAhead),
        ]);
    }

    /**
     * POST /api/orders/{id}/pay-later
     * แจ้งชำระภายหลัง
     */
    public function payLater(int $id)
    {
        $order = Order::with('orderItems.product')->findOrFail($id);

        try {
            $lineBot = app(LineBotService::class);
            $message = "⏳ ลูกค้าแจ้งขอชำระเงินภายหลัง (หน้าร้าน)!\n";
            $message .= "รหัสออเดอร์: #" . $order->id . "\n";
            $message .= "ลูกค้า: " . $order->customer_name . "\n";
            $message .= "ยอดรวม: ฿" . number_format($order->total_price, 2);

            $lineBot->sendTextMessage($message);
        } catch (\Exception $e) {
            Log::error("LINE payLater failed: " . $e->getMessage());
        }

        return response()->json(['success' => true, 'message' => 'บันทึกเรียบร้อย']);
    }

    /**
     * POST /api/orders/{id}/payment
     * อัปโหลดสลิป
     */
    public function uploadSlip(Request $request, int $id)
    {
        $request->validate([
            'slip_image' => 'required|image|max:5120',
        ]);

        $order = Order::with('orderItems.product')->findOrFail($id);

        if ($request->hasFile('slip_image')) {
            $path = $request->file('slip_image')->store('slips', 'public');
            $order->update([
                'slip_image'     => $path,
                'payment_status' => 'paid',
            ]);

            try {
                $lineBot = app(LineBotService::class);
                $message = "💰 แจ้งชำระเงิน (แนบสลิปแล้ว)!\n";
                $message .= "รหัสออเดอร์: #" . $order->id . "\n";
                $message .= "ลูกค้า: " . $order->customer_name . "\n";
                $message .= "ยอดชำระ: ฿" . number_format($order->total_price, 2);

                $imageUrl = asset('storage/' . $path);
                $lineBot->sendImageMessage($message, $imageUrl);
            } catch (\Exception $e) {
                Log::error("LINE uploadSlip failed: " . $e->getMessage());
            }

            return response()->json([
                'success'  => true,
                'message'  => 'อัปโหลดสลิปสำเร็จ',
                'slip_url' => asset('storage/' . $path),
            ]);
        }

        return response()->json(['success' => false, 'message' => 'ไม่พบไฟล์สลิป'], 400);
    }

    /**
     * Format order for JSON response
     */
    private function formatOrder(Order $order, int $queueAhead = 0): array
    {
        return [
            'id'             => $order->id,
            'order_number'   => '#A' . str_pad($order->id, 3, '0', STR_PAD_LEFT),
            'queue_number'   => $order->id,
            'customer_name'  => $order->customer_name,
            'customer_phone' => $order->customer_phone,
            'total_price'    => (float) $order->total_price,
            'status'         => strtoupper($order->status),
            'payment_status' => $order->payment_status ?? 'unpaid',
            'note'           => $order->note,
            'queue_ahead'    => $queueAhead,
            'created_at'     => $order->created_at?->format('Y-m-d H:i:s'),
            'items'          => $order->orderItems->map(function ($item) {
                return [
                    'product_id' => $item->product_id,
                    'name'       => $item->product?->name ?? 'เครื่องดื่ม',
                    'quantity'   => $item->quantity,
                    'price'      => (float) $item->price,
                    'options'    => $item->options,
                ];
            })->toArray(),
        ];
    }
}
