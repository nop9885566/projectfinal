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

    {{-- Header & Filter Tabs --}}
    <div style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:1rem; margin-bottom:2rem;">
      <h2 style="margin:0;">จัดการออเดอร์</h2>

      <div class="menu-tabs" style="margin-bottom:0;">
        <a href="{{ route('orders.manage', ['filter' => 'active']) }}" 
           class="tab-btn {{ ($filter ?? 'active') === 'active' ? 'active' : '' }}">
           ⚡ ออเดอร์ที่ต้องจัดการ
           <span style="background: {{ ($filter ?? 'active') === 'active' ? 'rgba(255,255,255,0.25)' : 'rgba(0,0,0,0.06)' }}; padding:2px 8px; border-radius:12px; font-size:0.8rem; margin-left:4px;">{{ $activeCount ?? 0 }}</span>
        </a>
        <a href="{{ route('orders.manage', ['filter' => 'completed']) }}" 
           class="tab-btn {{ ($filter ?? '') === 'completed' ? 'active' : '' }}">
           🎉 เสร็จแล้ว
           <span style="background: {{ ($filter ?? '') === 'completed' ? 'rgba(255,255,255,0.25)' : 'rgba(0,0,0,0.06)' }}; padding:2px 8px; border-radius:12px; font-size:0.8rem; margin-left:4px;">{{ $completedCount ?? 0 }}</span>
        </a>
        <a href="{{ route('orders.manage', ['filter' => 'all']) }}" 
           class="tab-btn {{ ($filter ?? '') === 'all' ? 'active' : '' }}">
           📋 ทั้งหมด
           <span style="background: {{ ($filter ?? '') === 'all' ? 'rgba(255,255,255,0.25)' : 'rgba(0,0,0,0.06)' }}; padding:2px 8px; border-radius:12px; font-size:0.8rem; margin-left:4px;">{{ $allCount ?? 0 }}</span>
        </a>
      </div>
    </div>

    @if(session('success'))
      <div style="background:#d4edda;color:#155724;padding:1rem;border-radius:8px;margin-bottom:1.5rem">
        <i class="fa-solid fa-circle-check"></i> {{ session('success') }}
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
              <span style="background: #e8f8f5; color: #117a65; padding: 3px 8px; border-radius: 6px;"><i class="fa-solid fa-check-double"></i> ตรวจสอบแล้ว</span>
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

      {{-- Quick Action Buttons สำหรับเปลี่ยนสถานะออเดอร์ --}}
      <div style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:0.75rem; margin-top:1.25rem; padding-top:1rem; border-top:1px solid #eee;">
        <div style="display:flex; flex-wrap:wrap; gap:0.5rem; align-items:center; flex:1;">
          <span style="font-weight:600; font-size:0.85rem; color:#666; margin-right:0.25rem;">เปลี่ยนสถานะ:</span>

          @php
            $statuses = [
              'pending'   => ['label' => '⏳ รอดำเนินการ', 'activeBg' => '#f39c12', 'bg' => '#fef5e7', 'color' => '#d35400'],
              'confirmed' => ['label' => '✅ ยืนยันแล้ว',   'activeBg' => '#2980b9', 'bg' => '#ebf5fb', 'color' => '#1f618d'],
              'preparing' => ['label' => '👨‍🍳 กำลังเตรียม', 'activeBg' => '#8e44ad', 'bg' => '#f4ecf7', 'color' => '#6c3483'],
              'completed' => ['label' => '🎉 เสร็จแล้ว',   'activeBg' => '#27ae60', 'bg' => '#eafaf1', 'color' => '#1e8449'],
              'cancelled' => ['label' => '❌ ยกเลิก',     'activeBg' => '#e74c3c', 'bg' => '#fdedec', 'color' => '#922b21'],
            ];
          @endphp

          @foreach($statuses as $stKey => $stVal)
            <form method="POST" action="{{ route('orders.updateStatus', $order->id) }}" style="margin:0;">
              @csrf
              @method('PATCH')
              <input type="hidden" name="status" value="{{ $stKey }}">
              <button type="submit" 
                      style="padding: 0.45rem 0.85rem; border-radius: 8px; font-size: 0.83rem; font-weight: 600; font-family: inherit; transition: all 0.2s ease; cursor: pointer; border: 1.5px solid {{ $order->status === $stKey ? $stVal['activeBg'] : 'transparent' }}; background: {{ $order->status === $stKey ? $stVal['activeBg'] : $stVal['bg'] }}; color: {{ $order->status === $stKey ? '#ffffff' : $stVal['color'] }}; box-shadow: {{ $order->status === $stKey ? '0 2px 6px rgba(0,0,0,0.12)' : 'none' }}; opacity: {{ $order->status === $stKey ? '1' : '0.9' }};"
                      {{ $order->status === $stKey ? 'disabled' : '' }}>
                {{ $stVal['label'] }}
                @if($order->status === $stKey)
                  <i class="fa-solid fa-circle-check" style="margin-left:3px;"></i>
                @endif
              </button>
            </form>
          @endforeach
        </div>

        {{-- ปุ่มลบออเดอร์ --}}
        <form method="POST" action="{{ route('orders.destroy', $order->id) }}" onsubmit="return confirm('ยืนยันการลบออเดอร์นี้? ข้อมูลจะถูกลบถาวร');" style="margin:0;">
          @csrf
          @method('DELETE')
          <button type="submit" style="background:#dc3545; color:white; padding:0.45rem 0.85rem; border:none; border-radius:8px; cursor:pointer; font-size:0.85rem;" title="ลบออเดอร์">
            <i class="fa-solid fa-trash"></i> ลบ
          </button>
        </form>
      </div>

    </div>
    @empty
      <div style="text-align:center; color:#999; padding:4rem 1rem; background:#fff; border-radius:16px; border:1px dashed #ddd; margin-top:1rem;">
        <i class="fa-solid fa-box-open" style="font-size:3rem; color:#ccc; margin-bottom:1rem; display:block;"></i>
        @if(($filter ?? 'active') === 'completed')
          ยังไม่มีออเดอร์ที่เสร็จแล้ว
        @elseif(($filter ?? 'active') === 'all')
          ยังไม่มีออเดอร์ในระบบ
        @else
          ไม่มีออเดอร์ที่ต้องจัดการในขณะนี้ 🎉
        @endif
      </div>
    @endforelse

  </div>
</div>

</body>
</html>