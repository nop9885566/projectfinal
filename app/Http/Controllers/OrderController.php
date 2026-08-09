<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Services\LineBotService;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    // ลูกค้าดูออเดอร์ตัวเอง
    public function index()
    {
        $orders = Order::where('user_id', auth()->id())
                       ->with('orderItems.product')
                       ->latest()
                       ->get();

        return view('orders.index', compact('orders'));
    }

    // ลูกค้าสั่งซื้อ
    public function store(Request $request)
    {
        $request->validate([
            'items'         => 'required|array',
            'items.*.id'    => 'required|exists:products,id',
            'items.*.qty'   => 'required|integer|min:1',
            'items.*.options'  => 'nullable|string',
            'note'             => 'nullable|string',
            'customer_name'    => auth()->check() ? 'nullable|string' : 'required|string|max:255',
            'customer_phone'   => auth()->check() ? 'nullable|string' : 'required|string|max:20',
        ]);

        $total = 0;
        $orderItems = [];
        $itemsText = "";

        foreach ($request->items as $item) {
            $product = Product::findOrFail($item['id']);
            
            // คำนวณราคาต่อชิ้นโดยเริ่มจากราคาฐานใน DB
            $itemPrice = $product->price;
            $optionsText = $item['options'] ?? '';
            
            // บวกราคาเพิ่มตามออปชั่นที่เลือก
            if ($optionsText) {
                if (str_contains($optionsText, 'วิปครีม')) $itemPrice += 15;
                if (str_contains($optionsText, 'เพิ่มช็อต')) $itemPrice += 15;
                if (str_contains($optionsText, 'เนย/แยม')) $itemPrice += 10;
                if (str_contains($optionsText, 'ไข่ดาว')) $itemPrice += 10;
                if (str_contains($optionsText, 'ไข่เจียว')) $itemPrice += 10;
                if (str_contains($optionsText, 'ข้าว')) $itemPrice += 10;
            }

            $subtotal = $itemPrice * $item['qty'];
            $total += $subtotal;
            $orderItems[] = [
                'product_id' => $product->id,
                'quantity'   => $item['qty'],
                'price'      => $itemPrice,
                'options'    => $optionsText ?: null,
            ];

            // สร้างข้อความรายการอาหารสำหรับส่ง LINE
            $itemsText .= "- " . $product->name . " x" . $item['qty'];
            if ($optionsText) {
                $itemsText .= " (" . $optionsText . ")";
            }
            $itemsText .= "\n";
        }

        $order = Order::create([
            'user_id'        => auth()->id(),
            'customer_name'  => $request->customer_name,
            'customer_phone' => $request->customer_phone,
            'status'         => 'pending',
            'total_price'    => $total,
            'note'           => $request->note,
        ]);

        $order->orderItems()->createMany($orderItems);

        // Redirect to payment page
        return redirect()->route('orders.payment', $order->id)->with('success', 'สั่งซื้อสำเร็จ กรุณาชำระเงิน');
    }

    // หน้าชำระเงินและอัปโหลดสลิป
    public function payment(Order $order)
    {
        return view('orders.payment', compact('order'));
    }

    public function uploadSlip(Request $request, Order $order)
    {
        $request->validate([
            'slip_image' => 'required|image|mimes:jpeg,png,jpg|max:5120',
        ], [
            'slip_image.required' => 'กรุณาอัปโหลดสลิปโอนเงิน',
            'slip_image.image' => 'ไฟล์ต้องเป็นรูปภาพเท่านั้น',
        ]);

        if ($request->hasFile('slip_image')) {
            $path = $request->file('slip_image')->store('slips', 'public');
            $order->update([
                'slip_image' => $path,
                'payment_status' => 'paid',
            ]);

            // Send LINE Bot Notification for slip upload
            try {
                $order->load('orderItems.product');
                $itemsText = "";
                foreach ($order->orderItems as $item) {
                    $itemsText .= "- " . $item->product->name . " x" . $item->quantity;
                    if ($item->options) {
                        $itemsText .= " (" . $item->options . ")";
                    }
                    $itemsText .= "\n";
                }

                $lineBot = app(LineBotService::class);
                $message = "💰 แจ้งชำระเงิน (ออเดอร์ใหม่)!\n";
                $message .= "รหัสออเดอร์: #" . $order->id . "\n";
                $message .= "ลูกค้า: " . $order->customer_name . "\n";
                $message .= "เบอร์โทร: " . ($order->customer_phone ?: 'ไม่ระบุ') . "\n";
                if (!empty($order->note)) {
                    $message .= "หมายเหตุ: " . $order->note . "\n";
                }
                $message .= "รายการสั่งซื้อ:\n" . $itemsText;
                $message .= "ยอดชำระ: ฿" . number_format($order->total_price, 2);
                
                // Get absolute URL to the slip image
                $imageUrl = asset('storage/' . $path);
                
                $lineBot->sendImageMessage($message, $imageUrl);
            } catch (\Exception $e) {
                \Illuminate\Support\Facades\Log::error("LINE Bot Error on uploadSlip: " . $e->getMessage());
            }
        }

        if (auth()->check()) {
            return redirect()->route('orders.queue', $order->id)->with('success', 'อัปโหลดสลิปสำเร็จ รอการตรวจสอบจากร้าน');
        } else {
            return redirect()->route('orders.queue', $order->id)->with('success', 'ส่งคำสั่งซื้อและสลิปสำเร็จ! เรากำลังดำเนินการให้ครับ');
        }
    }

    public function payLater(Order $order)
    {
        // Send LINE Bot Notification for pay later
        try {
            $order->load('orderItems.product');
            $itemsText = "";
            foreach ($order->orderItems as $item) {
                $itemsText .= "- " . $item->product->name . " x" . $item->quantity;
                if ($item->options) {
                    $itemsText .= " (" . $item->options . ")";
                }
                $itemsText .= "\n";
            }

            $lineBot = app(LineBotService::class);
            $message = "⏳ ลูกค้าแจ้งขอชำระเงินภายหลัง (หน้าร้าน)!\n";
            $message .= "รหัสออเดอร์: #" . $order->id . "\n";
            $message .= "ลูกค้า: " . $order->customer_name . "\n";
            $message .= "เบอร์โทร: " . ($order->customer_phone ?: 'ไม่ระบุ') . "\n";
            if (!empty($order->note)) {
                $message .= "หมายเหตุ: " . $order->note . "\n";
            }
            $message .= "รายการสั่งซื้อ:\n" . $itemsText;
            $message .= "ยอดรวม: ฿" . number_format($order->total_price, 2);
            
            $lineBot->sendTextMessage($message);
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error("LINE Bot Error on payLater: " . $e->getMessage());
        }

        if (auth()->check()) {
            return redirect()->route('orders.queue', $order->id)->with('success', 'ส่งคำสั่งซื้อเรียบร้อยแล้ว กรุณาชำระเงินที่หน้าร้าน');
        } else {
            return redirect()->route('orders.queue', $order->id)->with('success', 'ส่งคำสั่งซื้อเรียบร้อยแล้ว! กรุณาชำระเงินและรับสินค้าที่หน้าร้านครับ');
        }
    }


    // หน้าระบบแสดงคิว
    public function queue(Order $order)
    {
        // คำนวณคิวคร่าวๆ จากออเดอร์ที่ยังไม่เสร็จ (pending, confirmed, preparing) ที่มาก่อนออเดอร์นี้
        $queueCount = Order::whereIn('status', ['pending', 'confirmed', 'preparing'])
                           ->where('id', '<', $order->id)
                           ->count();
                           
        return view('orders.queue', compact('order', 'queueCount'));
    }

    // พนักงาน/Admin ดูออเดอร์
    public function manage(Request $request)
    {
        $filter = $request->query('filter', 'active');

        $query = Order::with(['user', 'orderItems.product']);

        if ($filter === 'completed') {
            $query->where('status', 'completed');
        } elseif ($filter === 'all') {
            // ดูทั้งหมด
        } else {
            // ค่าเริ่มต้น ('active'): แสดงเฉพาะออเดอร์ที่ยังไม่เสร็จ
            $query->where('status', '!=', 'completed');
        }

        $orders = $query->latest()->get();

        $activeCount = Order::where('status', '!=', 'completed')->count();
        $completedCount = Order::where('status', 'completed')->count();
        $allCount = Order::count();

        return view('dashboard.orders.index', compact('orders', 'filter', 'activeCount', 'completedCount', 'allCount'));
    }

    // พนักงาน/Admin อัปเดตสถานะออเดอร์
    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:pending,confirmed,preparing,completed,cancelled',
        ]);

        $order->update(['status' => $request->status]);

        return back()->with('success', 'อัปเดตสถานะสำเร็จ');
    }

    // พนักงาน/Admin ลบออเดอร์
    public function destroy(Order $order)
    {
        $order->delete();
        return back()->with('success', 'ลบออเดอร์เรียบร้อยแล้ว');
    }
}