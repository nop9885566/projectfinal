<!DOCTYPE html>
<html lang="th">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta http-equiv="refresh" content="30"> <!-- Auto refresh every 30 seconds -->
  <title>ระบบคิว | บรรจงคาเฟ่</title>
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link href="https://fonts.googleapis.com/css2?family=Prompt:wght@300;400;500;600;700&family=Kanit:wght@300;400;500;600&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
  <link rel="stylesheet" href="{{ asset('css/cafe.css') }}" />
  <style>
    body {
        font-family: 'Kanit', sans-serif;
        background-color: var(--cream, #F9F6F0);
        margin: 0;
        padding: 0;
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 100vh;
    }
    .queue-container {
        width: 100%;
        max-width: 500px;
        padding: 2rem 1.5rem;
    }
    .queue-card {
        background: #fff;
        border-radius: 20px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.05);
        overflow: hidden;
        text-align: center;
    }
    .queue-header {
        background: var(--brown-dark, #4A3B32);
        color: #fff;
        padding: 1.5rem;
    }
    .queue-header h2 {
        margin: 0;
        font-size: 1.5rem;
        font-weight: 500;
    }
    .queue-header p {
        margin: 0.5rem 0 0 0;
        opacity: 0.8;
        font-size: 0.9rem;
    }
    .queue-body {
        padding: 3rem 2rem;
    }
    .queue-number {
        font-size: 5rem;
        color: var(--green, #2A5A3B);
        font-weight: 700;
        margin: 0 0 0.5rem 0;
        line-height: 1;
    }
    .queue-text {
        font-size: 1.2rem;
        color: var(--brown-dark, #4A3B32);
        font-weight: 500;
        margin: 0;
    }
    .queue-desc {
        color: #666;
        margin-top: 2rem;
        font-size: 0.95rem;
        line-height: 1.5;
    }
    .alert-success {
        background: #d4edda;
        color: #155724;
        padding: 1rem;
        border-radius: 12px;
        margin-bottom: 2rem;
        font-size: 0.95rem;
    }
    .queue-footer {
        padding: 1.5rem;
        border-top: 1px solid #eee;
    }
    .btn-home {
        display: inline-block;
        background: var(--primary, #D4A373);
        color: #fff;
        padding: 0.8rem 2rem;
        border-radius: 100px;
        text-decoration: none;
        font-weight: 500;
        transition: all 0.3s;
    }
    .btn-home:hover {
        background: var(--brown-dark, #4A3B32);
    }
  </style>
</head>
<body>

<div class="queue-container">
    <div class="queue-card">
        <div class="queue-header">
            <h2>กำลังดำเนินการสั่งซื้อ</h2>
            <p>ออเดอร์ #{{ $order->id }}</p>
        </div>
        
        <div class="queue-body">
            @if(session('success'))
                <div class="alert-success">
                    <i class="fa-solid fa-check-circle"></i> {{ session('success') }}
                </div>
            @endif

            @php
                $statusColors = [
                    'pending' => '#f39c12',
                    'confirmed' => '#3498db',
                    'preparing' => '#9b59b6',
                    'completed' => '#2ecc71',
                    'cancelled' => '#e74c3c'
                ];
                $statusText = [
                    'pending' => 'รอยืนยันออเดอร์ / รอชำระเงิน',
                    'confirmed' => 'รับออเดอร์แล้ว / รอคิว',
                    'preparing' => 'กำลังเตรียมเครื่องดื่ม',
                    'completed' => 'เสร็จสิ้น / รับเครื่องดื่มได้เลย!',
                    'cancelled' => 'ยกเลิกออเดอร์'
                ];
                
                $currentStatusColor = $statusColors[$order->status] ?? '#666';
                $currentStatusText = $statusText[$order->status] ?? $order->status;
            @endphp

            <div style="margin: 0 0 2rem 0; padding: 1.2rem; border-radius: 12px; background: #fafafa; border: 2px solid {{ $currentStatusColor }}; text-align: center;">
                <p style="margin: 0 0 0.5rem 0; font-size: 0.95rem; color: #666;">สถานะปัจจุบันของคุณ:</p>
                <h3 style="margin: 0; color: {{ $currentStatusColor }}; font-size: 1.5rem; font-weight: 600;">
                    <i class="fa-solid fa-circle-info" style="margin-right: 5px;"></i> {{ $currentStatusText }}
                </h3>
            </div>

            @if(in_array($order->status, ['completed', 'cancelled']))
                <h3 class="queue-number" style="color: {{ $currentStatusColor }}; font-size: 3rem;">
                    @if($order->status == 'completed') รับเครื่องดื่มได้เลย! @else ยกเลิก @endif
                </h3>
                <p class="queue-text">คิวของคุณเสร็จสิ้นแล้ว</p>
            @else
                <h3 class="queue-number">{{ $queueCount }}</h3>
                <p class="queue-text">คิวที่รออยู่ข้างหน้าคุณ</p>
                <p class="queue-desc">
                    กรุณารอรับเครื่องดื่มที่หน้าร้านเมื่อถึงคิวของคุณ<br>
                    ระบบจะอัปเดตสถานะอัตโนมัติทุกๆ 30 วินาที ☕
                </p>
            @endif
        </div>
        
        <div class="queue-footer">
            <a href="{{ route('home') }}" class="btn-home">
                กลับสู่หน้าหลัก
            </a>
        </div>
    </div>
</div>

</body>
</html>
