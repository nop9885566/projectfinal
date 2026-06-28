<nav id="navbar" class="{{ request()->is('/') ? '' : 'scrolled' }}">
  <div class="nav-wrap">
    <a href="/" class="nav-logo">
      <i class="fa-solid fa-mug-hot"></i> บรรจงคาเฟ่
    </a>
    <ul class="nav-links" id="navLinks">
      <li><a href="/" class="{{ request()->is('/') ? 'active' : '' }}">หน้าแรก</a></li>
      <li><a href="/menu" class="{{ request()->is('menu') ? 'active' : '' }}">เมนู</a></li>
      <li><a href="/gallery" class="{{ request()->is('gallery') ? 'active' : '' }}">แกลเลอรี</a></li>
      
      @auth
        <li><a href="/orders" class="{{ request()->is('orders') ? 'active' : '' }}">ออเดอร์ของฉัน</a></li>
        @if(auth()->user()->role === 'admin' || auth()->user()->role === 'staff')
          <li><a href="/dashboard" class="{{ request()->is('dashboard') ? 'active' : '' }}">Dashboard</a></li>
          <li><a href="/dashboard/products" class="{{ request()->is('dashboard/products*') ? 'active' : '' }}">จัดการเมนู</a></li>
          @if(auth()->user()->role === 'admin')
            <li><a href="/dashboard/orders" class="{{ request()->is('dashboard/orders*') ? 'active' : '' }}">จัดการออเดอร์</a></li>
          @endif
        @endif
      @endauth
    </ul>
    
    @auth
      <form method="POST" action="{{ route('logout') }}" style="margin:0">
        @csrf
        <button type="submit" class="btn-nav" style="background:var(--brown); border:none; cursor:pointer">ออกจากระบบ</button>
      </form>
    @else
      <a href="/login" class="btn-nav">เข้าสู่ระบบ</a>
    @endauth

    <button class="hamburger" id="hamburger" aria-label="toggle menu">
      <span></span><span></span><span></span>
    </button>
  </div>
</nav>

<script>
  document.addEventListener('DOMContentLoaded', () => {
    const navbar = document.getElementById('navbar');
    const hamburger = document.getElementById('hamburger');
    const navLinks  = document.getElementById('navLinks');
    
    // Navbar scroll effect (only on home page)
    if (navbar && window.location.pathname === '/') {
      window.addEventListener('scroll', () => {
        navbar.classList.toggle('scrolled', window.scrollY > 50);
      }, { passive: true });
    }

    // Hamburger menu logic
    if (hamburger && navLinks) {
      hamburger.addEventListener('click', () => {
        hamburger.classList.toggle('open');
        navLinks.classList.toggle('open');
        document.body.style.overflow = navLinks.classList.contains('open') ? 'hidden' : '';
      });

      // Close menu when a link is clicked
      navLinks.querySelectorAll('a').forEach(a => {
        a.addEventListener('click', () => {
          hamburger.classList.remove('open');
          navLinks.classList.remove('open');
          document.body.style.overflow = '';
        });
      });

      // Fix for resizing window from mobile to desktop
      window.addEventListener('resize', () => {
        if (window.innerWidth > 768 && navLinks.classList.contains('open')) {
          hamburger.classList.remove('open');
          navLinks.classList.remove('open');
          document.body.style.overflow = '';
        }
      });
    }
  });
</script>
