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
    <div class="loader-text">Banchong Cafe</div>
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
      <li><a href="#contact">ติดต่อ</a></li>
    </ul>
    <a href="/register" class="btn-nav" style="margin-right:4px">สมัครสมาชิก</a>
    <a href="/login" class="btn-nav">เข้าสู่ระบบ</a>
    <button class="hamburger" id="hamburger" aria-label="toggle menu">
      <span></span><span></span><span></span>
    </button>
  </div>
</nav>

{{-- ===== HERO ===== --}}
<section id="home">
  <div class="hero-bg" style="background-image: url('{{ asset('images/welcom1.jpg') }}'); background-size:cover; background-position:center"></div>
  <div class="hero-overlay"></div>
  <div class="hero-content">
    <div class="hero-badge">🌿 เปิดทุกวัน 09:00 – 17:00 น. หยุดวันเสาร์</div>
    <h1>
      <span class="hero-title-th">บรรจงคาเฟ่</span>
      <span class="hero-title-en">BANCHONG CAFE</span>
    </h1>
    <p class="hero-sub">กาแฟดี · บรรยากาศธรรมชาติ · พื้นที่แห่งการพักผ่อน</p>
    <div class="hero-btns">
      <a href="/menu" class="btn btn-primary"><i class="fa-solid fa-mug-hot"></i> ดูเมนู</a>
      <a href="#contact" class="btn btn-glass"><i class="fa-solid fa-location-dot"></i> ติดต่อเรา</a>
    </div>    
  </div>
  <a href="#about" class="scroll-dot"></a>
</section>

{{-- ===== ABOUT ===== --}}
<section id="about" class="section">
  <div class="container">
    <div class="about-grid">
      <div class="about-imgs" data-reveal>
        <div class="about-main">
          <img src="{{ asset('images/about-main.jpg') }}" style="width:100%;height:100%;object-fit:cover;border-radius:16px">
        </div>
        <div class="about-float">
          <div class="about-float-img">
            <img src="{{ asset('images/about-two.jpg') }}" style="width:100%;height:100%;object-fit:cover;border-radius:16px">
          </div>
          <div class="about-float-info">
            <span style="font-size:1.6rem">🌿</span>
            <div>
              <strong>วิวธรรมชาติ</strong>
              <small>ทุ่งนา</small>
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
            <div class="feature-icon">🍽️</div>
            <div><strong>เมนูหลากหลาย</strong><span>กาแฟ เครื่องดื่ม เบเกอรี่</span></div>
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
      <p class="sec-desc">ยินดีต้อนรับทุกวัน</p>
    </div>
    <div class="contact-grid">
      <div data-reveal>
        <div class="contact-card">
          <div class="contact-item">
            <div class="contact-ic">📍</div>
            <div>
              <strong>ที่อยู่</strong>
              <p>122/10 ปากทางสลวงซอย 3 ตำบลขี้เหล็ก<br>อำเภอแม่ริม จังหวัดเชียงใหม่ 50180</p>
            </div>
          </div>
          <div class="contact-item">
            <div class="contact-ic">🕐</div>
            <div>
              <strong>เวลาเปิด-ปิด</strong>
              <p>จันทร์ – อาทิตย์: 09:00 – 17:00 น.<br>ปิดวันเสาร์</p>
            </div>
          </div>
          <div class="contact-item">
            <div class="contact-ic">📞</div>
            <div>
              <strong>โทรศัพท์</strong>
              <a href="tel:+66637916165">063-791-6165</a>
            </div>
          </div>
        </div>
        <div class="socials">
          <a href="https://www.facebook.com/banchongcafe" class="social-btn fb"><i class="fa-brands fa-facebook-f"></i> Barjong Cafe (Facebook)</a>          
          <a href="https://www.instagram.com/banchong.cafe/" class="social-btn ig"><i class="fa-brands fa-instagram"></i> @barjong.cafe (Instagram)</a>
        </div>
      </div>
      <div data-reveal style="transition-delay:.15s">
        <div class="map-box">
          <iframe
            src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d213.34812649846685!2d98.9419983!3d19.014536!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x30da17f3e0a30d0b%3A0x4717c8c785505a09!2sBanchong%20cafe!5e1!3m2!1sth!2sth!4v1781681253758!5m2!1sth!2sth"
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
          <a href="https://www.facebook.com/banchongcafe" aria-label="Facebook"><i class="fa-brands fa-facebook-f"></i></a>
          <a href="https://www.instagram.com/banchong.cafe/" aria-label="Instagram"><i class="fa-brands fa-instagram"></i></a>
        </div>
      </div>
      <div>
        <h4>เมนูลัด</h4>
        <ul>
          <li><a href="/">หน้าแรก</a></li>
          <li><a href="#about">เกี่ยวกับเรา</a></li>
          <li><a href="/menu">เมนู</a></li>
          <li><a href="#contact">ติดต่อ</a></li>
        </ul>
      </div>
      <div>
        <h4>บริการ</h4>
        <ul>
          <li><a href="#">Dine-in</a></li>
          <li><a href="#">Take Away</a></li>
          <li><a href="#">Delivery</a></li>
        </ul>
      </div>
      <div>
        <h4>เวลาเปิดทำการ</h4>
        <div class="hours-row"><span>จ–อา</span><span>09:00 – 17:00</span></div>
        <div class="hours-row"><span>ส</span><span>ปิด</span></div>
      </div>
    </div>
    <div class="footer-bottom">
      <p>© 2026 บรรจงคาเฟ่ (Barjong Cafe). All Rights Reserved.</p>
      <p>Designed with ❤️ for coffee lovers</p>
    </div>
  </div>
</footer>



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