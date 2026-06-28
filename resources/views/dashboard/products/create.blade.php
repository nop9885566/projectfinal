<!DOCTYPE html>
<html lang="th">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>เพิ่มเมนู | บรรจงคาเฟ่</title>
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
      <li><a href="/dashboard/products" class="active">จัดการเมนู</a></li>
      <li><a href="/dashboard/orders">จัดการออเดอร์</a></li>
      <li><a href="/">หน้าเว็บ</a></li>
    </ul>
    <form method="POST" action="{{ route('logout') }}" style="margin:0">
      @csrf
      <button type="submit" class="btn-nav">ออกจากระบบ</button>
    </form>
    <button class="hamburger" id="hamburger" aria-label="toggle menu">
      <span></span><span></span><span></span>
    </button>
  </div>
</nav>

<div style="padding: 120px 2rem 2rem">
  <div class="container" style="max-width:600px">

    <div style="display:flex;align-items:center;gap:1rem;margin-bottom:2rem">
      <a href="/dashboard/products" style="color:#7D8F69"><i class="fa-solid fa-arrow-left"></i> กลับ</a>
      <h2 style="margin:0">เพิ่มเมนูใหม่</h2>
    </div>

    @if($errors->any())
      <div style="background:#f8d7da;color:#721c24;padding:1rem;border-radius:8px;margin-bottom:1rem">
        @foreach($errors->all() as $error)
          <div>{{ $error }}</div>
        @endforeach
      </div>
    @endif

    <div class="contact-card">
      <form method="POST" action="/dashboard/products" enctype="multipart/form-data">
        @csrf

        <div style="margin-bottom:1rem">
          <label style="display:block;margin-bottom:.5rem;font-weight:500">ชื่อเมนู *</label>
          <input type="text" name="name" value="{{ old('name') }}"
                 style="width:100%;padding:.8rem;border:1px solid #ddd;border-radius:8px;font-family:inherit"
                 required />
        </div>

        <div style="margin-bottom:1rem">
          <label style="display:block;margin-bottom:.5rem;font-weight:500">หมวดหมู่ *</label>
          <select name="category"
                  style="width:100%;padding:.8rem;border:1px solid #ddd;border-radius:8px;font-family:inherit">
            <option value="coffee"    {{ old('category')=='coffee'    ? 'selected' : '' }}>☕ Coffee</option>
            <option value="noncoffee" {{ old('category')=='noncoffee' ? 'selected' : '' }}>🧋 Non-Coffee</option>
            <option value="bakery"    {{ old('category')=='bakery'    ? 'selected' : '' }}>🥐 Bakery</option>
            <option value="food"      {{ old('category')=='food'      ? 'selected' : '' }}>🍽️ Food</option>
          </select>
        </div>

        <div style="margin-bottom:1rem">
          <label style="display:block;margin-bottom:.5rem;font-weight:500">รายละเอียด</label>
          <textarea name="description" rows="3"
                    style="width:100%;padding:.8rem;border:1px solid #ddd;border-radius:8px;font-family:inherit">{{ old('description') }}</textarea>
        </div>

        <div style="margin-bottom:1rem">
          <label style="display:block;margin-bottom:.5rem;font-weight:500">ราคา (บาท) *</label>
          <input type="number" name="price" value="{{ old('price') }}" min="0" step="0.01"
                 style="width:100%;padding:.8rem;border:1px solid #ddd;border-radius:8px;font-family:inherit"
                 required />
        </div>

        <div style="margin-bottom:1rem">
          <label style="display:block;margin-bottom:.5rem;font-weight:500">รูปภาพ</label>
          <input type="file" name="image" accept="image/*"
                 style="width:100%;padding:.8rem;border:1px solid #ddd;border-radius:8px;font-family:inherit" />
        </div>

        <div style="margin-bottom:1.5rem">
          <label style="display:flex;align-items:center;gap:.5rem;cursor:pointer">
            <input type="checkbox" name="is_available" value="1" 
                   {{ old('is_available', '1') ? 'checked' : '' }} />
            <span>พร้อมขาย</span>
          </label>
        </div>

        <button type="submit" class="btn btn-primary" style="width:100%">
          <i class="fa-solid fa-plus"></i> เพิ่มเมนู
        </button>

      </form>
    </div>

  </div>
</div>

<script>
  const hamburger = document.getElementById('hamburger');
  const navLinks  = document.getElementById('navLinks');
  if (hamburger && navLinks) {
    hamburger.addEventListener('click', () => {
      hamburger.classList.toggle('open');
      navLinks.classList.toggle('open');
    });
  }
</script>
</body>
</html>