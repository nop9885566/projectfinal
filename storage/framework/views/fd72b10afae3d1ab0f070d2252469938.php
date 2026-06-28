<nav id="navbar" class="<?php echo e(request()->is('/') ? '' : 'scrolled'); ?>">
  <div class="nav-wrap">
    <a href="/" class="nav-logo">
      <i class="fa-solid fa-mug-hot"></i> บรรจงคาเฟ่
    </a>
    <ul class="nav-links" id="navLinks">
      <?php if(!request()->is('dashboard*')): ?>
        
        <li><a href="/" class="<?php echo e(request()->is('/') ? 'active' : ''); ?>">หน้าแรก</a></li>
        <?php if(request()->is('/')): ?>
          <li><a href="#about">เกี่ยวกับเรา</a></li>
        <?php endif; ?>
        <li><a href="/menu" class="<?php echo e(request()->is('menu') ? 'active' : ''); ?>">เมนู</a></li>
        <?php if(!request()->is('/')): ?>
          <li><a href="/gallery" class="<?php echo e(request()->is('gallery') ? 'active' : ''); ?>">แกลเลอรี</a></li>
        <?php endif; ?>
        <?php if(request()->is('/')): ?>
          <li><a href="#contact">ติดต่อ</a></li>
        <?php endif; ?>
        <?php if(auth()->guard()->check()): ?>
          <li><a href="/orders" class="<?php echo e(request()->is('orders') ? 'active' : ''); ?>">ออเดอร์ของฉัน</a></li>
          <?php if(auth()->user()->role === 'admin' || auth()->user()->role === 'staff'): ?>
            <li><a href="/dashboard">Dashboard</a></li>
          <?php endif; ?>
        <?php endif; ?>
      <?php else: ?>
        
        <li><a href="/dashboard" class="<?php echo e(request()->is('dashboard') ? 'active' : ''); ?>">Dashboard</a></li>
        <?php if(auth()->user()->role === 'admin' || auth()->user()->role === 'staff'): ?>
          <li><a href="/dashboard/products" class="<?php echo e(request()->is('dashboard/products*') ? 'active' : ''); ?>">จัดการเมนู</a></li>
        <?php endif; ?>
        <?php if(auth()->user()->role === 'admin'): ?>
          <li><a href="/dashboard/orders" class="<?php echo e(request()->is('dashboard/orders*') ? 'active' : ''); ?>">จัดการออเดอร์</a></li>
        <?php endif; ?>
        <li><a href="/">หน้าเว็บ</a></li>
      <?php endif; ?>
    </ul>
    
    <div style="display:flex; align-items:center; gap:8px;">
      <?php if(request()->is('/')): ?>
        <a href="/menu" class="btn-nav" style="margin-right:4px">สั่งซื้อ</a>
      <?php endif; ?>
      <?php if(auth()->guard()->check()): ?>
        <form method="POST" action="<?php echo e(route('logout')); ?>" style="margin:0">
          <?php echo csrf_field(); ?>
          <button type="submit" class="btn-nav" style="background:var(--brown); border:none; cursor:pointer">ออกจากระบบ</button>
        </form>
      <?php else: ?>
        <a href="/login" class="btn-nav">เข้าสู่ระบบ</a>
      <?php endif; ?>
    </div>

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
<?php /**PATH /var/www/html/resources/views/components/navbar.blade.php ENDPATH**/ ?>