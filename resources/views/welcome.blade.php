<!DOCTYPE html>
<html lang="th">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="description" content="บรรจงคาเฟ่ (Barjong Cafe) — กาแฟดี บรรยากาศธรรมชาติ พื้นที่แห่งการพักผ่อน" />
  <title>บรรจงคาเฟ่ | Barjong Cafe</title>
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Prompt:wght@300;400;500;600;700&family=Kanit:wght@300;400;500;600&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
  <link rel="stylesheet" href="{{ asset('css/cafe.css') }}" />
</head>
<body>

{{-- ===== LOADER ===== --}}
<div id="loader">
  <div>
    <div class="loader-logo">B</div>
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
      <a href="#contact" class="btn btn-glass"><i class="fa-solid fa-location-dot"></i> ติดต่อเรา</a>
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
            <div><strong>วิวธรรมชาติ</strong><span>ทุ่งนา ต้นไม้ บรรยากาศเงียบสงบ</span></div>
          </div>
          <div class="feature">
            <div class="feature-icon">📸</div>
            <div><strong>มุมถ่ายรูปสวย</strong><span>จุด Instagrammable ทั่วร้าน</span></div>
          </div>
          <div class="feature">
            <div class="feature-icon"><i class="fa-solid fa-wifi"></i></div>
            <div><strong>Free Wi-Fi ความเร็วสูง</strong><span>รองรับการทำงานและเรียน</span></div>
          </div>
          <div class="feature">
            <div class="feature-icon"><i class="fa-solid fa-plug"></i></div>
            <div><strong>ปลั๊กไฟทุกโต๊ะ</strong><span>ไม่ต้องกังวลเรื่องแบตเตอรี่</span></div>
          </div>
          <div class="feature">
            <div class="feature-icon">🍽️</div>
            <div><strong>เมนูหลากหลาย</strong><span>กาแฟ เครื่องดื่ม เบเกอรี และอาหาร</span></div>
          </div>
        </div>
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