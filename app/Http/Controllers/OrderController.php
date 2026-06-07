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
            'note'          => 'nullable|string',
        ]);

        $total = 0;
        $orderItems = [];

        foreach ($request->items as $item) {
            $product = Product::findOrFail($item['id']);
            $subtotal = $product->price * $item['qty'];
            $total += $subtotal;
            $orderItems[] = [
                'product_id' => $product->id,
                'quantity'   => $item['qty'],
                'price'      => $product->price,
            ];
        }

        $order = Order::create([
            'user_id'     => auth()->id(),
            'status'      => 'pending',
            'total_price' => $total,
            'note'        => $request->note,
        ]);

        $order->orderItems()->createMany($orderItems);

        return redirect()->route('orders.index')->with('success', 'สั่งซื้อสำเร็จ');
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