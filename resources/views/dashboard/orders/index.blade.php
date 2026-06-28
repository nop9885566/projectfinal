<!DOCTYPE html>
<html lang="th">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>จัดการออเดอร์ | บรรจงคาเฟ่</title>
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link href="https://fonts.googleapis.com/css2?family=Prompt:wght@300;400;500;600;700&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
  <link rel="stylesheet" href="{{ asset('css/cafe.css') }}" />
</head>
<body>

@include('components.navbar')

<div style="padding: 120px 2rem 2rem">
  <div class="container">

    <h2 style="margin-bottom:2rem">จัดการออเดอร์</h2>

    @if(session('success'))
      <div style="background:#d4edda;color:#155724;padding:1rem;border-radius:8px;margin-bottom:1rem">
        {{ session('success') }}
      </div>
    @endif

    @forelse($orders as $order)
    <div class="contact-card" style="margin-bottom:1.5rem">
      <div style="display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:1rem">
        <div>
          <strong>ออเดอร์ #{{ $order->id }}</strong>
          <span style="margin-left:1rem;color:#999;font-size:.9rem">{{ $order->created_at->format('d/m/Y H:i') }}</span>
        </div>
        <div>
          @if($order->user)
            <strong><i class="fa-solid fa-user-check" style="color:#7D8F69"></i> {{ $order->user->name }}</strong>
          @else
            <strong><i class="fa-solid fa-user" style="color:#999"></i> {{ $order->customer_name }}</strong> (ลูกค้าทั่วไป)<br>
            <small style="color:#666"><i class="fa-solid fa-phone"></i> {{ $order->customer_phone }}</small>
          @endif
        </div>
        <div>
          <strong style="color:#7D8F69; font-size: 1.1rem;">฿{{ number_format($order->total_price, 2) }}</strong>
          <div style="margin-top: 5px; font-size: 0.85rem;">
            @if($order->payment_status === 'pending')
              <span style="background: #fdf0d5; color: #b87c00; padding: 3px 8px; border-radius: 6px;"><i class="fa-solid fa-clock"></i> รอชำระเงิน</span>
            @elseif($order->payment_status === 'paid')
              <span style="background: #e3f2fd; color: #0d47a1; padding: 3px 8px; border-radius: 6px;"><i class="fa-solid fa-file-invoice-dollar"></i> โอนแล้ว</span>
            @elseif($order->payment_status === 'verified')
              <span style="background: #e8f5e9; color: #1b5e20; padding: 3px 8px; border-radius: 6px;"><i class="fa-solid fa-check-double"></i> ตรวจสอบแล้ว</span>
            @else
              <span style="background: #ffebee; color: #b71c1c; padding: 3px 8px; border-radius: 6px;"><i class="fa-solid fa-triangle-exclamation"></i> ไม่สำเร็จ</span>
            @endif
          </div>
          @if($order->slip_image)
            <div style="margin-top: 6px;">
              <a href="{{ asset('storage/' . $order->slip_image) }}" target="_blank" style="font-size: 0.85rem; color: var(--green); text-decoration: none; border-bottom: 1px solid var(--green);"><i class="fa-solid fa-image"></i> ดูหลักฐานโอนเงิน</a>
            </div>
          @endif
        </div>

        {{-- อัปเดตสถานะและลบ --}}
        <div style="display:flex; gap:.5rem; flex-wrap:wrap; margin-top:1rem; width:100%;">
          <form method="POST" action="{{ route('orders.updateStatus', $order->id) }}" style="display:flex; gap:.5rem; flex-wrap:wrap; flex:1;">
            @csrf
            @method('PATCH')
            <select name="status"
                    style="padding:.5rem;border:1px solid #ddd;border-radius:8px;font-family:inherit; flex:1; min-width:120px;">
              <option value="pending"    {{ $order->status=='pending'    ? 'selected' : '' }}>⏳ รอดำเนินการ</option>
              <option value="confirmed"  {{ $order->status=='confirmed'  ? 'selected' : '' }}>✅ ยืนยันแล้ว</option>
              <option value="preparing"  {{ $order->status=='preparing'  ? 'selected' : '' }}>👨‍🍳 กำลังเตรียม</option>
              <option value="completed"  {{ $order->status=='completed'  ? 'selected' : '' }}>🎉 เสร็จแล้ว</option>
              <option value="cancelled"  {{ $order->status=='cancelled'  ? 'selected' : '' }}>❌ ยกเลิก</option>
            </select>
            <button type="submit" class="btn btn-primary" style="padding:.5rem 1rem; white-space:nowrap;">อัปเดต</button>
          </form>

          <form method="POST" action="{{ route('orders.destroy', $order->id) }}" onsubmit="return confirm('ยืนยันการลบออเดอร์นี้? ข้อมูลจะถูกลบถาวร');">
            @csrf
            @method('DELETE')
            <button type="submit" style="background:#dc3545; color:white; padding:.5rem 1rem; border:none; border-radius:8px; cursor:pointer; height:100%;" title="ลบออเดอร์"><i class="fa-solid fa-trash"></i></button>
          </form>
        </div>
      </div>

      {{-- รายการสินค้า --}}
      <div style="margin-top:1rem;border-top:1px solid #eee;padding-top:1rem">
        @foreach($order->orderItems as $item)
          <div style="display:flex;justify-content:space-between;align-items:flex-start;padding:.4rem 0;border-bottom:1px dashed #f5f5f5">
            <div>
              <span style="font-weight:600">{{ $item->product->name }} x{{ $item->quantity }}</span>
              @if($item->options)
                <div style="font-size:0.8rem;color:#7d8f69;margin-top:2px">✨ ตัวเลือก: {{ $item->options }}</div>
              @endif
            </div>
            <strong>฿{{ number_format($item->price * $item->quantity, 2) }}</strong>
          </div>
        @endforeach
        @if($order->note)
          <div style="margin-top:.5rem;color:#999;font-size:.9rem">📝 หมายเหตุ: {{ $order->note }}</div>
        @endif
      </div>
    </div>
    @empty
      <div style="text-align:center;color:#999;padding:3rem">ยังไม่มีออเดอร์</div>
    @endforelse

  </div>
</div>


</body>
</html>