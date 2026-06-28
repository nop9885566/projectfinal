<!DOCTYPE html>
<html lang="th">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>แกลเลอรี | บรรจงคาเฟ่</title>
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link href="https://fonts.googleapis.com/css2?family=Prompt:wght@300;400;500;600;700&family=Kanit:wght@300;400;500;600&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
  <link rel="stylesheet" href="<?php echo e(asset('css/cafe.css')); ?>" />
</head>
<body>


<?php echo $__env->make('components.navbar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>


<section id="gallery" class="section" style="padding-top:120px">
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


<footer>
  <div class="container">
    <div class="footer-bottom">
      <p>© 2026 บรรจงคาเฟ่ (Barjong Cafe). All Rights Reserved.</p>
    </div>
  </div>
</footer>

<script>


const revealObs = new IntersectionObserver(entries => {
  entries.forEach(e => {
    if (e.isIntersecting) { e.target.classList.add('visible'); revealObs.unobserve(e.target); }
  });
}, { threshold: 0.12 });
document.querySelectorAll('[data-reveal]').forEach(el => revealObs.observe(el));
</script>

</body>
</html><?php /**PATH /var/www/html/resources/views/gallery.blade.php ENDPATH**/ ?>