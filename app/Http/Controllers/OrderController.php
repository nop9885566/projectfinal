<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
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

        foreach ($request->items as $item) {
            $product = Product::findOrFail($item['id']);
            
            // คำนวณราคาต่อชิ้นโดยเริ่มจากราคาฐานใน DB
            $itemPrice = $product->price;
            $optionsText = $item['options'] ?? '';
            
            // บวกราคาเพิ่มตามออปชั่นที่เลือก
            if ($optionsText) {
                if (str_contains($optionsText, 'ปั่น')) $itemPrice += 10;
                if (str_contains($optionsText, 'ไข่มุก')) $itemPrice += 10;
                if (str_contains($optionsText, 'เจลลี่')) $itemPrice += 10;
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
        }

        if (auth()->check()) {
            return redirect()->route('orders.index')->with('success', 'อัปโหลดสลิปสำเร็จ รอการตรวจสอบจากร้าน');
        } else {
            return redirect()->route('menu')->with('success', 'ส่งคำสั่งซื้อและสลิปสำเร็จ! เรากำลังดำเนินการให้ครับ');
        }
    }

    // พนักงาน/Admin ดูออเดอร์ทั้งหมด
    public function manage()
    {
        $orders = Order::with(['user', 'orderItems.product'])
                       ->latest()
                       ->get();

        return view('dashboard.orders.index', compact('orders'));
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
}