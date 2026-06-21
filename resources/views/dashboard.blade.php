<!DOCTYPE html>
<html lang="th">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Dashboard | บรรจงคาเฟ่</title>
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
      <li><a href="/dashboard">Dashboard</a></li>
      <li><a href="/dashboard/products">จัดการเมนู</a></li>
      @if(auth()->user()->role === 'admin')
        <li><a href="/dashboard/orders">จัดการออเดอร์</a></li>
      @endif
      <li><a href="/">หน้าเว็บ</a></li>
    </ul>
    <form method="POST" action="{{ route('logout') }}" style="margin:0">
      @csrf
      <button type="submit" class="btn-nav">ออกจากระบบ</button>
    </form>
  </div>
</nav>

<div style="padding: 120px 2rem 2rem">
  <div class="container">

    {{-- Welcome --}}
    <h2 style="margin-bottom:2rem">
      สวัสดี, {{ auth()->user()->name }} 
      <span style="font-size:1rem;color:#7D8F69">({{ auth()->user()->role }})</span>
    </h2>

    {{-- Stats --}}
    <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(200px,1fr));gap:1.5rem;margin-bottom:2rem">
      <div class="contact-card" style="text-align:center">
        <div style="font-size:2.5rem;color:#7D8F69"><i class="fa-solid fa-box"></i></div>
        <div style="font-size:2rem;font-weight:700">{{ $totalOrders }}</div>
        <div>ออเดอร์ทั้งหมด</div>
      </div>
      <div class="contact-card" style="text-align:center">
        <div style="font-size:2.5rem;color:#e67e22"><i class="fa-solid fa-clock"></i></div>
        <div style="font-size:2rem;font-weight:700">{{ $pendingOrders }}</div>
        <div>ออเดอร์รอดำเนินการ</div>
      </div>
      <div class="contact-card" style="text-align:center">
        <div style="font-size:2.5rem;color:#3498db"><i class="fa-solid fa-mug-hot"></i></div>
        <div style="font-size:2rem;font-weight:700">{{ $totalProducts }}</div>
        <div>เมนูทั้งหมด</div>
      </div>
      <div class="contact-card" style="text-align:center">
        <div style="font-size:2.5rem;color:#9b59b6"><i class="fa-solid fa-users"></i></div>
        <div style="font-size:2rem;font-weight:700">{{ $totalUsers }}</div>
        <div>ผู้ใช้ทั้งหมด</div>
      </div>
    </div>

    {{-- Quick Links --}}
    <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(200px,1fr));gap:1rem">
      <a href="/dashboard/products/create" class="btn btn-primary" style="text-align:center">
        <i class="fa-solid fa-plus"></i> เพิ่มเมนูใหม่
      </a>
      @if(auth()->user()->role === 'admin')
      <a href="/dashboard/orders" class="btn btn-glass" style="text-align:center">
        <i class="fa-solid fa-list"></i> ดูออเดอร์ทั้งหมด
      </a>
      @endif
    </div>

  </div>
</div>

</body>
</html>