<!DOCTYPE html>
<html lang="th">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="description" content="บรรจงคาเฟ่ (Barjong Cafe) — กาแฟดี บรรยากาศธรรมชาติ พื้นที่แห่งการพักผ่อน" />
  <title>บรรจงคาเฟ่ | Barjong Cafe</title>

  <!-- Fonts & Icons -->
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Prompt:wght@300;400;500;600;700&family=Kanit:wght@300;400;500;600&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />

  <!-- CSS -->
  <link rel="stylesheet" href="{{ asset('css/cafe.css') }}" />
</head>
<body>

{{-- ===== LOADER ===== --}}
<div id="loader">
  <div>
    <div class="loader-logo">ยินดีต้อนรับ</div>
    <div class="loader-text">Barjong Cafe</div>
    <div class="loader-bar"><div class="loader-fill"></div></div>
  </div>
</div>

{{-- ===== NAVBAR ===== --}}
<nav id="navbar">
  <div class="nav-wrap">
    <a href="/" class="nav-logo">
      <i class="fa-solid fa-mug-hot"></i> บรรจงคาเฟ่
    </a>
    <ul class="nav-links" id="navLinks">
      <li><a href="/" class="active">หน้าแรก</a></li>
      <li><a href="#about">เกี่ยวกับเรา</a></li>
      <li><a href="/menu">เมนู</a></li>
      <li><a href="/gallery">แกลเลอรี</a></li>
      <li><a href="#contact">ติดต่อ</a></li>
    </ul>
    @auth
      <a href="/orders" class="btn-nav">ออเดอร์ของฉัน</a>
      <form method="POST" action="{{ route('logout') }}" style="margin:0">
        @csrf
        <button type="submit" class="btn-nav">ออกจากระบบ</button>
      </form>
    @else
      <a href="/login" class="btn-nav">เข้าสู่ระบบ</a>
    @endauth
    <button class="hamburger" id="hamburger" aria-label="toggle menu">
      <span></span><span></span><span></span>
    </button>
  </div>
</nav>

{{-- ===== HERO ===== --}}
<section id="home">
  <div class="hero-bg"></div>
  <div class="hero-overlay"></div>
  <div class="hero-content">
    <div class="hero-badge">🌿 เปิดทุกวัน 07:00 – 20:00 น.</div>
    <h1>
      <span class="hero-title-th">บรรจงคาเฟ่</span>
      <span class="hero-title-en">BARJONG CAFE</span>
    </h1>
    <p class="hero-sub">กาแฟดี · บรรยากาศธรรมชาติ · พื้นที่แห่งการพักผ่อน</p>
   <div class="hero-btns">
  <a href="/menu" class="btn btn-primary"><i class="fa-solid fa-mug-hot"></i> ดูเมนู</a>
  <a href="#contact" class="btn btn-glass"><i class="fa-solid fa-bag-shopping"></i> สั่งอาหาร</a>
</div>
    <div class="hero-stats">
      <div class="text-center">
        <span class="stat-num">500+</span>
        <span class="stat-lbl">รีวิวดีเยี่ยม</span>
      </div>
      <div class="stat-div"></div>
      <div class="text-center">
        <span class="stat-num">4.9</span>
        <span class="stat-lbl">คะแนนเฉลี่ย</span>
      </div>
      <div class="stat-div"></div>
      <div class="text-center">
        <span class="stat-num">50+</span>
        <span class="stat-lbl">รายการเมนู</span>
      </div>
    </div>
  </div>
  <a href="#about" class="scroll-dot"></a>
</section>

{{-- ===== ABOUT ===== --}}
<section id="about" class="section">
  <div class="container">
    <div class="about-grid">

      {{-- Images --}}
      <div class="about-imgs" data-reveal>
        <div class="about-main">🏡</div>
        <div class="about-float">
          <div class="about-float-img">🌾</div>
          <div class="about-float-info">
            <span style="font-size:1.6rem">🌿</span>
            <div>
              <strong>วิวธรรมชาติ</strong>
              <small>ทุ่งนา & ต้นไม้</small>
            </div>
          </div>
        </div>
      </div>

      {{-- Content --}}
      <div class="about-text" data-reveal style="transition-delay:.15s">
        <div class="sec-tag">เกี่ยวกับเรา</div>
        <h2 class="sec-title">พื้นที่สงบ<br><em>ท่ามกลางธรรมชาติ</em></h2>
        <p class="about-desc">
          บรรจงคาเฟ่ คือพื้นที่พักผ่อนกลางธรรมชาติ ที่เราออกแบบมาเพื่อให้คุณได้หยุดพัก ชาร์จพลัง
          และสัมผัสกับบรรยากาศอบอุ่น ท่ามกลางวิวทุ่งนาและต้นไม้สีเขียว กาแฟทุกแก้วชงด้วยใจ
          พร้อมให้คุณรู้สึกเหมือนอยู่บ้าน
        </p>
        <div class="features">
          <div class="feature">
            <div class="feature-icon">🌿</div>
            <div>
              <strong>วิวธรรมชาติ</strong>
              <span>ทุ่งนา ต้นไม้ บรรยากาศเงียบสงบ</span>
            </div>
          </div>
          <div class="feature">
            <div class="feature-icon">📸</div>
            <div>
              <strong>มุมถ่ายรูปสวย</strong>
              <span>จุด Instagrammable ทั่วร้าน</span>
            </div>
          </div>
          <div class="feature">
            <div class="feature-icon"><i class="fa-solid fa-wifi"></i></div>
            <div>
              <strong>Free Wi-Fi ความเร็วสูง</strong>
              <span>รองรับการทำงานและเรียน</span>
            </div>
          </div>
          <div class="feature">
            <div class="feature-icon"><i class="fa-solid fa-plug"></i></div>
            <div>
              <strong>ปลั๊กไฟทุกโต๊ะ</strong>
              <span>ไม่ต้องกังวลเรื่องแบตเตอรี่</span>
            </div>
          </div>
          <div class="feature">
            <div class="feature-icon">🍽️</div>
            <div>
              <strong>เมนูหลากหลาย</strong>
              <span>กาแฟ เครื่องดื่ม เบเกอรี และอาหาร</span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

{{-- ===== MENU ===== --}}
<section id="menu" class="section bg-cream">
  <div class="container">
    <div class="sec-header" data-reveal>
      <div class="sec-tag">เมนูของเรา</div>
      <h2 class="sec-title">ดื่มด่ำกับทุกรสชาติ</h2>
      <p class="sec-desc">คัดสรรวัตถุดิบคุณภาพ ชงด้วยความใส่ใจ เพื่อประสบการณ์ที่ดีที่สุด</p>
    </div>

    {{-- Tabs --}}
    <div class="menu-tabs" data-reveal>
      <button class="tab-btn active" onclick="switchTab('coffee',  this)">☕ Coffee</button>
      <button class="tab-btn"        onclick="switchTab('noncoffee',this)">🧋 Non-Coffee</button>
      <button class="tab-btn"        onclick="switchTab('bakery',  this)">🥐 Bakery</button>
      <button class="tab-btn"        onclick="switchTab('food',    this)">🍽️ Food</button>
    </div>

    {{-- Coffee --}}
    <div class="menu-grid active" id="tab-coffee">
      @php $coffeeItems = [
        ['emoji'=>'☕','name'=>'Signature Latte',  'desc'=>'ลาเต้สูตรพิเศษของร้าน นุ่มละมุน หอมกลิ่นนม',       'price'=>'฿75',  'badge'=>'ยอดนิยม','new'=>false],
        ['emoji'=>'☕','name'=>'Cold Brew',         'desc'=>'กาแฟสกัดเย็น 18 ชั่วโมง เข้มข้น สดชื่น',          'price'=>'฿85',  'badge'=>'',        'new'=>false],
        ['emoji'=>'☕','name'=>'Double Espresso',   'desc'=>'เอสเปรสโซ่คู่ เข้มข้น ตื่นตัวได้ทันที',             'price'=>'฿65',  'badge'=>'',        'new'=>false],
        ['emoji'=>'☕','name'=>'Caramel Macchiato', 'desc'=>'คาราเมลหอมหวาน ผสมลาเต้ ราดซอสคาราเมล',           'price'=>'฿90',  'badge'=>'ใหม่',   'new'=>true],
      ] @endphp
      @foreach($coffeeItems as $item)
        @include('partials.menu-card', $item)
      @endforeach
    </div>

    {{-- Non-Coffee --}}
    <div class="menu-grid" id="tab-noncoffee">
      @php $ncItems = [
        ['emoji'=>'🧋','name'=>'Matcha Latte',  'desc'=>'ชาเขียวญี่ปุ่นแท้ ผสมนมสดสูตรเข้มข้น',      'price'=>'฿80', 'badge'=>'ยอดนิยม','new'=>false],
        ['emoji'=>'🧋','name'=>'ชาไทยนมสด',    'desc'=>'ชาไทยสูตรต้นตำรับ หอมเครื่องเทศ หวานมัน',   'price'=>'฿65', 'badge'=>'',        'new'=>false],
        ['emoji'=>'🥤','name'=>'Fruit Soda',    'desc'=>'โซดาผลไม้สดสดชื่น หลายรสชาติให้เลือก',        'price'=>'฿70', 'badge'=>'',        'new'=>false],
        ['emoji'=>'🍫','name'=>'Hot Chocolate', 'desc'=>'ช็อกโกแลตเบลเยี่ยมแท้ เข้มข้น หอมหวาน',      'price'=>'฿75', 'badge'=>'',        'new'=>false],
      ] @endphp
      @foreach($ncItems as $item)
        @include('partials.menu-card', $item)
      @endforeach
    </div>

    {{-- Bakery --}}
    <div class="menu-grid" id="tab-bakery">
      @php $bakeryItems = [
        ['emoji'=>'🥐','name'=>'Butter Croissant', 'desc'=>'ครัวซองค์เนยแท้ อบสด กรอบนอก นุ่มใน',    'price'=>'฿55', 'badge'=>'ยอดนิยม','new'=>false],
        ['emoji'=>'🧁','name'=>'Banana Muffin',    'desc'=>'มัฟฟินกล้วยหอม นุ่ม หอมหวาน',             'price'=>'฿45', 'badge'=>'',        'new'=>false],
        ['emoji'=>'🍞','name'=>'Classic Scones',   'desc'=>'สโคนสูตรอังกฤษ เสิร์ฟพร้อมแยมและครีม',    'price'=>'฿60', 'badge'=>'',        'new'=>false],
        ['emoji'=>'🌀','name'=>'Cinnamon Roll',    'desc'=>'ซินนาบอนสูตรพิเศษ อบสด หอมอบเชย',         'price'=>'฿65', 'badge'=>'ใหม่',   'new'=>true],
      ] @endphp
      @foreach($bakeryItems as $item)
        @include('partials.menu-card', $item)
      @endforeach
    </div>

    {{-- Food --}}
    <div class="menu-grid" id="tab-food">
      @php $foodItems = [
        ['emoji'=>'🍳','name'=>'Brunch Set',        'desc'=>'ไข่ ขนมปัง เบคอน สลัด ครบในจานเดียว',                   'price'=>'฿150','badge'=>'แนะนำ','new'=>false],
        ['emoji'=>'🥪','name'=>'Club Sandwich',     'desc'=>'แซนวิชหน้าไก่ ชีส มะเขือเทศ เสิร์ฟพร้อมมันฝรั่ง',      'price'=>'฿120','badge'=>'',     'new'=>false],
        ['emoji'=>'🍝','name'=>'Creamy Pasta',      'desc'=>'พาสต้าซอสครีม ไก่ย่าง เห็ด หอมกรุ่น',                   'price'=>'฿140','badge'=>'',     'new'=>false],
        ['emoji'=>'🍚','name'=>'ข้าวหน้าไก่ย่าง', 'desc'=>'ข้าวหน้าไก่ย่างสมุนไพร ราดซอสพิเศษ เสิร์ฟร้อน',        'price'=>'฿110','badge'=>'',     'new'=>false],
      ] @endphp
      @foreach($foodItems as $item)
        @include('partials.menu-card', $item)
      @endforeach
    </div>
  </div>
</section>

{{-- ===== GALLERY ===== --}}
<section id="gallery" class="section">
  <div class="container">
    <div class="sec-header" data-reveal>
      <div class="sec-tag">แกลเลอรี</div>
      <h2 class="sec-title">บรรยากาศของเรา</h2>
      <p class="sec-desc">ทุกมุมมองออกแบบมาเพื่อให้คุณรู้สึกผ่อนคลาย</p>
    </div>
    <div class="masonry" data-reveal>
      <div class="masonry-item tall" style="background:linear-gradient(135deg,#3d5230,#7D8F69)">
        🏡<div class="masonry-label">บรรยากาศร้าน</div>
      </div>
      <div class="masonry-item" style="background:linear-gradient(135deg,#5C4A32,#C8B6A6)">
        ☕<div class="masonry-label">กาแฟพิเศษ</div>
      </div>
      <div class="masonry-item" style="background:linear-gradient(135deg,#92400e,#d97706)">
        🥐<div class="masonry-label">เบเกอรี่สด</div>
      </div>
      <div class="masonry-item tall" style="background:linear-gradient(135deg,#065f46,#10b981)">
        🌾<div class="masonry-label">วิวธรรมชาติ</div>
      </div>
      <div class="masonry-item" style="background:linear-gradient(135deg,#7D8F69,#a8c17b)">
        🧋<div class="masonry-label">เครื่องดื่มหลากหลาย</div>
      </div>
      <div class="masonry-item" style="background:linear-gradient(135deg,#5C4A32,#8B6F47)">
        💻<div class="masonry-label">มุมนั่งทำงาน</div>
      </div>
    </div>
  </div>
</section>

{{-- ===== PROMOTIONS ===== --}}
<section id="promotions" class="section bg-green-grad">
  <div class="container">
    <div class="sec-header" data-reveal>
      <div class="sec-tag light">โปรโมชัน</div>
      <h2 class="sec-title light">ข้อเสนอพิเศษ</h2>
      <p class="sec-desc light">อัปเดตโปรโมชันล่าสุดจากบรรจงคาเฟ่</p>
    </div>
    <div class="promo-grid">
      <div class="promo-card" data-reveal>
        <div class="promo-tag">🔥 ดีลพิเศษ</div>
        <h3>ซื้อ 2 แก้ว แถมฟรี 1</h3>
        <p>ทุกเมนูในหมวด Coffee และ Non-Coffee เฉพาะวันจันทร์–พุธ</p>
        <div class="promo-date">📅 ถึง 31 ก.ค. 2026</div>
        <a href="#menu" class="btn btn-white">ดูรายละเอียด</a>
      </div>
      <div class="promo-card" data-reveal style="transition-delay:.1s">
        <div class="promo-tag">☀️ Morning Deal</div>
        <h3>Morning Set ลด 20%</h3>
        <p>สั่ง Coffee + Bakery ก่อน 10:00 น. รับส่วนลด 20% ทันที</p>
        <div class="promo-date">📅 ถึง 30 มิ.ย. 2026</div>
        <a href="#menu" class="btn btn-white-outline">ดูรายละเอียด</a>
      </div>
      <div class="promo-card" data-reveal style="transition-delay:.2s">
        <div class="promo-tag">📱 Member Exclusive</div>
        <h3>สมาชิกใหม่รับฟรีเครื่องดื่ม</h3>
        <p>สมัครสมาชิกวันนี้ รับเครื่องดื่มฟรี 1 แก้วทันที ไม่มีเงื่อนไข</p>
        <div class="promo-date">📅 ไม่มีวันหมดอายุ</div>
        <a href="#contact" class="btn btn-white-outline">ดูรายละเอียด</a>
      </div>
    </div>
  </div>
</section>

{{-- ===== REVIEWS ===== --}}
<section id="reviews" class="section bg-cream">
  <div class="container">
    <div class="sec-header" data-reveal>
      <div class="sec-tag">รีวิวลูกค้า</div>
      <h2 class="sec-title">เสียงจากหัวใจลูกค้า</h2>
      <div class="rating-wrap">
        <span class="rating-big">4.9</span>
        <span class="rating-stars">★★★★★</span>
        <span class="rating-count">จาก 500+ รีวิว</span>
      </div>
    </div>
    <div class="reviews-track-wrap" data-reveal>
      <div class="reviews-track">
        @php $reviews = [
          ['initial'=>'ม','from'=>'#7D8F69','to'=>'#a8c17b','name'=>'มินิ สาวน้อย',       'src'=>'Google Maps', 'text'=>'มาที่นี่ครั้งแรกเลยติดใจ บรรยากาศดีมากๆ วิวทุ่งนาสวยงาม กาแฟหอมอร่อย อยากกลับมาอีกแน่นอน'],
          ['initial'=>'ต','from'=>'#C8B6A6','to'=>'#8B6F47','name'=>'ตั้ม วัยทำงาน',       'src'=>'Facebook',    'text'=>'WiFi เร็วมาก มีปลั๊กทุกโต๊ะ เหมาะมากสำหรับนั่งทำงาน กาแฟอร่อย บรรยากาศไม่วุ่นวาย ชอบมากครับ'],
          ['initial'=>'น','from'=>'#E8E2D8','to'=>'#C8B6A6','name'=>'นุ่น ครีเอทีฟ',      'src'=>'Instagram',   'text'=>'ถ่ายรูปสวยมากทุกมุม เบเกอรี่อร่อยมาก ครัวซองค์กรอบนอกนุ่มใน แนะนำให้ทุกคนมาลองจริงๆ ค่ะ'],
          ['initial'=>'ป','from'=>'#7D8F69','to'=>'#4a6b3a','name'=>'ปลา นักอ่าน',         'src'=>'Google Maps', 'text'=>'มานั่งอ่านหนังสือทุกอาทิตย์ บรรยากาศเงียบสงบ พนักงานใจดี กาแฟอร่อย น้ำเปล่าฟรีบริการด้วย'],
          ['initial'=>'ก','from'=>'#C8B6A6','to'=>'#7D8F69','name'=>'กัน แฟนพันธุ์กาแฟ', 'src'=>'Facebook',    'text'=>'Signature Latte อร่อยมากที่สุดที่เคยดื่มมา Latte art สวย บรรจงคาเฟ่คือสวรรค์ของคนชอบกาแฟ!'],
        ] @endphp
        @foreach(array_merge($reviews, $reviews) as $r)
          <div class="review-card">
            <div class="review-hdr">
              <div class="reviewer-av" style="background:linear-gradient(135deg,{{ $r['from'] }},{{ $r['to'] }})">
                {{ $r['initial'] }}
              </div>
              <div>
                <strong>{{ $r['name'] }}</strong><br>
                <small>{{ $r['src'] }}</small>
              </div>
              <div style="margin-left:auto;color:#F5A623">⭐⭐⭐⭐⭐</div>
            </div>
            <p>"{{ $r['text'] }}"</p>
          </div>
        @endforeach
      </div>
    </div>
  </div>
</section>

{{-- ===== CONTACT ===== --}}
<section id="contact" class="section">
  <div class="container">
    <div class="sec-header" data-reveal>
      <div class="sec-tag">ติดต่อเรา</div>
      <h2 class="sec-title">มาเยี่ยมเราได้เลย</h2>
      <p class="sec-desc">ยินดีต้อนรับทุกวัน ไม่มีวันหยุด</p>
    </div>
    <div class="contact-grid">
      <div data-reveal>
        <div class="contact-card">
          <div class="contact-item">
            <div class="contact-ic">📍</div>
            <div>
              <strong>ที่อยู่</strong>
              <p>123 ถนนธรรมชาติ ตำบลสวนงาม<br>อำเภอเมือง จังหวัดเชียงใหม่ 50000</p>
            </div>
          </div>
          <div class="contact-item">
            <div class="contact-ic">🕐</div>
            <div>
              <strong>เวลาเปิด-ปิด</strong>
              <p>จันทร์ – ศุกร์: 07:00 – 20:00 น.<br>เสาร์ – อาทิตย์: 07:00 – 21:00 น.</p>
            </div>
          </div>
          <div class="contact-item">
            <div class="contact-ic">📞</div>
            <div>
              <strong>โทรศัพท์</strong>
              <a href="tel:+66812345678">081-234-5678</a>
            </div>
          </div>
        </div>
        <div class="socials">
          <a href="#" class="social-btn fb"><i class="fa-brands fa-facebook-f"></i> Barjong Cafe (Facebook)</a>
          <a href="#" class="social-btn line"><i class="fa-brands fa-line"></i> @barjongcafe (LINE)</a>
          <a href="#" class="social-btn ig"><i class="fa-brands fa-instagram"></i> @barjong.cafe (Instagram)</a>
        </div>
      </div>
      <div data-reveal style="transition-delay:.15s">
        <div class="map-box">
          <iframe
            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d120282.86!2d98.9177!3d18.7883!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x30da3a73%3A0x1!2z4LmA4LiH4Liy4Lin!5e0!3m2!1sth!2sth!4v1"
            width="100%" height="360"
            style="border:0" allowfullscreen loading="lazy"
            title="แผนที่บรรจงคาเฟ่">
          </iframe>
        </div>
      </div>
    </div>
  </div>
</section>

{{-- ===== FOOTER ===== --}}
<footer>
  <div class="container">
    <div class="footer-grid">
      <div class="footer-brand">
        <div class="footer-logo"><i class="fa-solid fa-mug-hot"></i> บรรจงคาเฟ่</div>
        <p>กาแฟดี บรรยากาศธรรมชาติ<br>พื้นที่แห่งการพักผ่อน</p>
        <div class="footer-soc">
          <a href="#" aria-label="Facebook"><i class="fa-brands fa-facebook-f"></i></a>
          <a href="#" aria-label="Instagram"><i class="fa-brands fa-instagram"></i></a>
          <a href="#" aria-label="Line"><i class="fa-brands fa-line"></i></a>
          <a href="#" aria-label="TikTok"><i class="fa-brands fa-tiktok"></i></a>
        </div>
      </div>
      <div>
  <h4>เมนูลัด</h4>
  <ul>
    <li><a href="/">หน้าแรก</a></li>
    <li><a href="#about">เกี่ยวกับเรา</a></li>
    <li><a href="/menu">เมนู</a></li>
    <li><a href="/gallery">แกลเลอรี</a></li>
    <li><a href="#contact">ติดต่อ</a></li>
  </ul>
</div>
      <div>
        <h4>บริการ</h4>
        <ul>
          <li><a href="#">Dine-in</a></li>
          <li><a href="#">Take Away</a></li>
          <li><a href="#">Delivery</a></li>
          <li><a href="#">จองโต๊ะ</a></li>
          <li><a href="#">Private Event</a></li>
        </ul>
      </div>
      <div>
        <h4>เวลาเปิดทำการ</h4>
        <div class="hours-row"><span>จ–ศ</span><span>07:00 – 20:00</span></div>
        <div class="hours-row"><span>ส–อ</span><span>07:00 – 21:00</span></div>
        <div class="hours-row open-now">🟢 เปิดอยู่ตอนนี้</div>
      </div>
    </div>
    <div class="footer-bottom">
      <p>© 2026 บรรจงคาเฟ่ (Barjong Cafe). All Rights Reserved.</p>
      <p>Designed with ❤️ for coffee lovers</p>
    </div>
  </div>
</footer>

{{-- Toast --}}
<div id="toast">✅ เพิ่มลงในตะกร้าแล้ว!</div>

{{-- Back to top --}}
<button id="backToTop" onclick="window.scrollTo({top:0,behavior:'smooth'})" aria-label="back to top">
  <i class="fa-solid fa-chevron-up"></i>
</button>

<script>
/* ── Loader ── */
window.addEventListener('load', () => setTimeout(() => document.getElementById('loader').classList.add('hidden'), 2000));

/* ── Navbar scroll ── */
const navbar = document.getElementById('navbar');
const allLinks = document.querySelectorAll('.nav-links a');
window.addEventListener('scroll', () => {
  navbar.classList.toggle('scrolled', window.scrollY > 50);
  document.getElementById('backToTop').classList.toggle('visible', window.scrollY > 500);
  // Active link
  document.querySelectorAll('section[id]').forEach(sec => {
    if (window.scrollY >= sec.offsetTop - 130)
      allLinks.forEach(a => a.classList.toggle('active', a.getAttribute('href') === '#' + sec.id));
  });
}, { passive:true });

/* ── Hamburger ── */
const hamburger = document.getElementById('hamburger');
const navLinks  = document.getElementById('navLinks');
hamburger.addEventListener('click', () => {
  hamburger.classList.toggle('open');
  navLinks.classList.toggle('open');
  document.body.style.overflow = navLinks.classList.contains('open') ? 'hidden' : '';
});
navLinks.querySelectorAll('a').forEach(a => a.addEventListener('click', () => {
  hamburger.classList.remove('open');
  navLinks.classList.remove('open');
  document.body.style.overflow = '';
}));

/* ── Menu Tabs ── */
function switchTab(id, btn) {
  document.querySelectorAll('.menu-grid').forEach(g => g.classList.remove('active'));
  document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
  const grid = document.getElementById('tab-' + id);
  grid.classList.add('active');
  grid.style.opacity = '0';
  btn.classList.add('active');
  requestAnimationFrame(() => { grid.style.transition = 'opacity .4s ease'; grid.style.opacity = '1'; });
}

/* ── Smooth Scroll ── */
function smoothScroll(id) {
  const el = document.getElementById(id);
  if (!el) return;
  window.scrollTo({ top: el.offsetTop - navbar.offsetHeight, behavior: 'smooth' });
}
document.querySelectorAll('a[href^="#"]').forEach(a => {
  a.addEventListener('click', e => {
    const id = a.getAttribute('href').slice(1);
    const el = document.getElementById(id);
    if (el) { e.preventDefault(); smoothScroll(id); }
  });
});

/* ── Cart Toast ── */
let toastTimer;
function addToCart() {
  const toast = document.getElementById('toast');
  toast.classList.add('show');
  clearTimeout(toastTimer);
  toastTimer = setTimeout(() => toast.classList.remove('show'), 2500);
}

/* ── Reveal Animation ── */
const revealObs = new IntersectionObserver(entries => {
  entries.forEach(e => {
    if (e.isIntersecting) { e.target.classList.add('visible'); revealObs.unobserve(e.target); }
  });
}, { threshold: 0.12 });
document.querySelectorAll('[data-reveal]').forEach(el => revealObs.observe(el));
</script>

</body>
</html>
