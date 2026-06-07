<!DOCTYPE html>
<html lang="th">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>เมนู | บรรจงคาเฟ่</title>
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link href="https://fonts.googleapis.com/css2?family=Prompt:wght@300;400;500;600;700&family=Kanit:wght@300;400;500;600&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
  <link rel="stylesheet" href="{{ asset('css/cafe.css') }}" />
</head>
<body>

{{-- NAVBAR --}}
<nav id="navbar" class="scrolled">
  <div class="nav-wrap">
    <a href="/" class="nav-logo">
      <i class="fa-solid fa-mug-hot"></i> บรรจงคาเฟ่
    </a>
    <ul class="nav-links" id="navLinks">
      <li><a href="/">หน้าแรก</a></li>
      <li><a href="/menu" class="active">เมนู</a></li>
      <li><a href="/gallery">แกลเลอรี</a></li>
    </ul>
    <button class="hamburger" id="hamburger" aria-label="toggle menu">
      <span></span><span></span><span></span>
    </button>
  </div>
</nav>

{{-- MENU --}}
<section id="menu" class="section" style="padding-top:120px">
  <div class="container">
    <div class="sec-header" data-reveal>
      <div class="sec-tag">เมนูของเรา</div>
      <h2 class="sec-title">ดื่มด่ำกับทุกรสชาติ</h2>
      <p class="sec-desc">คัดสรรวัตถุดิบคุณภาพ ชงด้วยความใส่ใจ</p>
    </div>

    <div class="menu-tabs" data-reveal>
      <button class="tab-btn active" onclick="switchTab('coffee', this)">☕ Coffee</button>
      <button class="tab-btn" onclick="switchTab('noncoffee', this)">🧋 Non-Coffee</button>
      <button class="tab-btn" onclick="switchTab('bakery', this)">🥐 Bakery</button>
      <button class="tab-btn" onclick="switchTab('food', this)">🍽️ Food</button>
    </div>

    {{-- Coffee --}}
    <div class="menu-grid active" id="tab-coffee">
      @php $coffeeItems = [
        ['emoji'=>'☕','name'=>'Signature Latte',  'desc'=>'ลาเต้สูตรพิเศษของร้าน นุ่มละมุน หอมกลิ่นนม',  'price'=>'฿75', 'badge'=>'ยอดนิยม','new'=>false],
        ['emoji'=>'☕','name'=>'Cold Brew',         'desc'=>'กาแฟสกัดเย็น 18 ชั่วโมง เข้มข้น สดชื่น',       'price'=>'฿85', 'badge'=>'',        'new'=>false],
        ['emoji'=>'☕','name'=>'Double Espresso',   'desc'=>'เอสเปรสโซ่คู่ เข้มข้น ตื่นตัวได้ทันที',          'price'=>'฿65', 'badge'=>'',        'new'=>false],
        ['emoji'=>'☕','name'=>'Caramel Macchiato', 'desc'=>'คาราเมลหอมหวาน ผสมลาเต้ ราดซอสคาราเมล',        'price'=>'฿90', 'badge'=>'ใหม่',   'new'=>true],
      ] @endphp
      @foreach($coffeeItems as $item)
        @include('partials.menu-card', $item)
      @endforeach
    </div>

    {{-- Non-Coffee --}}
    <div class="menu-grid" id="tab-noncoffee">
      @php $ncItems = [
        ['emoji'=>'🧋','name'=>'Matcha Latte', 'desc'=>'ชาเขียวญี่ปุ่นแท้ ผสมนมสดสูตรเข้มข้น',    'price'=>'฿80', 'badge'=>'ยอดนิยม','new'=>false],
        ['emoji'=>'🧋','name'=>'ชาไทยนมสด',   'desc'=>'ชาไทยสูตรต้นตำรับ หอมเครื่องเทศ หวานมัน', 'price'=>'฿65', 'badge'=>'',        'new'=>false],
        ['emoji'=>'🥤','name'=>'Fruit Soda',   'desc'=>'โซดาผลไม้สดสดชื่น หลายรสชาติให้เลือก',     'price'=>'฿70', 'badge'=>'',        'new'=>false],
        ['emoji'=>'🍫','name'=>'Hot Chocolate','desc'=>'ช็อกโกแลตเบลเยี่ยมแท้ เข้มข้น หอมหวาน',    'price'=>'฿75', 'badge'=>'',        'new'=>false],
      ] @endphp
      @foreach($ncItems as $item)
        @include('partials.menu-card', $item)
      @endforeach
    </div>

    {{-- Bakery --}}
    <div class="menu-grid" id="tab-bakery">
      @php $bakeryItems = [
        ['emoji'=>'🥐','name'=>'Butter Croissant','desc'=>'ครัวซองค์เนยแท้ อบสด กรอบนอก นุ่มใน', 'price'=>'฿55', 'badge'=>'ยอดนิยม','new'=>false],
        ['emoji'=>'🧁','name'=>'Banana Muffin',   'desc'=>'มัฟฟินกล้วยหอม นุ่ม หอมหวาน',          'price'=>'฿45', 'badge'=>'',        'new'=>false],
        ['emoji'=>'🍞','name'=>'Classic Scones',  'desc'=>'สโคนสูตรอังกฤษ เสิร์ฟพร้อมแยมและครีม', 'price'=>'฿60', 'badge'=>'',        'new'=>false],
        ['emoji'=>'🌀','name'=>'Cinnamon Roll',   'desc'=>'ซินนาบอนสูตรพิเศษ อบสด หอมอบเชย',      'price'=>'฿65', 'badge'=>'ใหม่',   'new'=>true],
      ] @endphp
      @foreach($bakeryItems as $item)
        @include('partials.menu-card', $item)
      @endforeach
    </div>

    {{-- Food --}}
    <div class="menu-grid" id="tab-food">
      @php $foodItems = [
        ['emoji'=>'🍳','name'=>'Brunch Set',       'desc'=>'ไข่ ขนมปัง เบคอน สลัด ครบในจานเดียว',             'price'=>'฿150','badge'=>'แนะนำ','new'=>false],
        ['emoji'=>'🥪','name'=>'Club Sandwich',    'desc'=>'แซนวิชหน้าไก่ ชีส มะเขือเทศ เสิร์ฟพร้อมมันฝรั่ง','price'=>'฿120','badge'=>'',     'new'=>false],
        ['emoji'=>'🍝','name'=>'Creamy Pasta',     'desc'=>'พาสต้าซอสครีม ไก่ย่าง เห็ด หอมกรุ่น',             'price'=>'฿140','badge'=>'',     'new'=>false],
        ['emoji'=>'🍚','name'=>'ข้าวหน้าไก่ย่าง','desc'=>'ข้าวหน้าไก่ย่างสมุนไพร ราดซอสพิเศษ เสิร์ฟร้อน',   'price'=>'฿110','badge'=>'',     'new'=>false],
      ] @endphp
      @foreach($foodItems as $item)
        @include('partials.menu-card', $item)
      @endforeach
    </div>
  </div>
</section>

{{-- FOOTER --}}
<footer>
  <div class="container">
    <div class="footer-bottom">
      <p>© 2026 บรรจงคาเฟ่ (Barjong Cafe). All Rights Reserved.</p>
    </div>
  </div>
</footer>

<script>
function switchTab(id, btn) {
  document.querySelectorAll('.menu-grid').forEach(g => g.classList.remove('active'));
  document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
  const grid = document.getElementById('tab-' + id);
  grid.classList.add('active');
  grid.style.opacity = '0';
  btn.classList.add('active');
  requestAnimationFrame(() => { grid.style.transition = 'opacity .4s ease'; grid.style.opacity = '1'; });
}

const hamburger = document.getElementById('hamburger');
const navLinks  = document.getElementById('navLinks');
hamburger.addEventListener('click', () => {
  hamburger.classList.toggle('open');
  navLinks.classList.toggle('open');
});
</script>

</body>
</html>