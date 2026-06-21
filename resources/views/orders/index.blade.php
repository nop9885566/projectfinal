<!DOCTYPE html>
<html lang="th">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>ออเดอร์ของฉัน | บรรจงคาเฟ่</title>
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link href="https://fonts.googleapis.com/css2?family=Prompt:wght@300;400;500;600;700&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
  <link rel="stylesheet" href="{{ asset('css/cafe.css') }}" />
</head>
<body>

<nav id="navbar" class="scrolled">
  <div class="nav-wrap">
    <a href="/" class="nav-logo">
      <i class="fa-solid fa-mug-hot"></i> บรรจงคาเฟ่
    </a>
    <ul class="nav-links" id="navLinks">
      <li><a href="/">หน้าแรก</a></li>
      <li><a href="/menu">เมนู</a></li>
      <li><a href="/gallery">แกลเลอรี</a></li>
      <li><a href="/orders" class="active">ออเดอร์ของฉัน</a></li>
    </ul>
    <form method="POST" action="{{ route('logout') }}" style="margin:0">
      @csrf
      <button type="submit" class="btn-nav">ออกจากระบบ</button>
    </form>
  </div>
</nav>

<div style="padding: 120px 2rem 2rem">
  <div class="container">

    <h2 style="margin-bottom:2rem">ออเดอร์ของฉัน</h2>

    @forelse($orders as $order)
    <div class="contact-card" style="margin-bottom:1.5rem">
      <div style="display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:1rem">
        <div>
          <strong>ออเดอร์ #{{ $order->id }}</strong>
          <span style="margin-left:1rem;color:#999;font-size:.9rem">
            {{ $order->created_at->format('d/m/Y H:i') }}
          </span>
        </div>
        <div>
          @php
            $statusMap = [
              'pending'   => ['label' => 'รอดำเนินการ', 'color' => '#e67e22'],
              'confirmed' => ['label' => 'ยืนยันแล้ว',  'color' => '#3498db'],
              'preparing' => ['label' => 'กำลังเตรียม', 'color' => '#9b59b6'],
              'completed' => ['label' => 'เสร็จแล้ว',   'color' => '#27ae60'],
              'cancelled' => ['label' => 'ยกเลิก',       'color' => '#e74c3c'],
            ];
            $s = $statusMap[$order->status];
          @endphp
          <span style="background:{{ $s['color'] }};color:#fff;padding:.3rem .8rem;border-radius:20px;font-size:.85rem">
            {{ $s['label'] }}
          </span>
        </div>
        <strong style="color:#7D8F69">฿{{ number_format($order->total_price, 2) }}</strong>
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
            <strong style="color:var(--text-light)">฿{{ number_format($item->price * $item->quantity, 2) }}</strong>
          </div>
        @endforeach
        @if($order->note)
          <div style="margin-top:.5rem;color:#999;font-size:.9rem">📝 หมายเหตุ: {{ $order->note }}</div>
        @endif
      </div>
    </div>
    @empty
      <div style="text-align:center;color:#999;padding:3rem">
        <div style="font-size:3rem">🛒</div>
        <p>ยังไม่มีออเดอร์</p>
        <a href="/menu" class="btn btn-primary">สั่งอาหารเลย</a>
      </div>
    @endforelse

  </div>
</div>

</body>
</html>