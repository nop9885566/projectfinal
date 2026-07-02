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
  <style>
    /* Option Modal Styles */
    .modal-overlay {
      position: fixed;
      inset: 0;
      background: rgba(44, 44, 44, 0.4);
      backdrop-filter: blur(8px);
      z-index: 9999;
      display: flex;
      align-items: center;
      justify-content: center;
      opacity: 0;
      visibility: hidden;
      transition: all 0.3s ease;
    }
    .modal-overlay.show {
      opacity: 1;
      visibility: visible;
    }
    .modal-content {
      background: #fff;
      border-radius: 24px;
      width: 90%;
      max-width: 480px;
      overflow: hidden;
      border: 1px solid var(--beige);
      box-shadow: var(--shadow-lg);
      transform: translateY(30px);
      transition: all 0.3s ease;
    }
    .modal-overlay.show .modal-content {
      transform: translateY(0);
    }
    .modal-product-img-box {
      height: 180px;
      background: var(--cream);
      display: flex;
      align-items: center;
      justify-content: center;
      overflow: hidden;
      border-bottom: 1px solid var(--beige);
    }
    .modal-product-img-box img {
      width: 100%;
      height: 100%;
      object-fit: contain;
      padding: 10px;
    }
    .modal-body {
      padding: 1.5rem;
    }
    .option-group {
      margin-top: 1rem;
    }
    .option-group h4 {
      font-size: 0.9rem;
      font-weight: 600;
      color: var(--brown-dark);
      margin-bottom: 0.5rem;
    }
    .option-items {
      display: flex;
      flex-wrap: wrap;
      gap: 0.5rem;
    }
    .option-label {
      display: inline-flex;
      align-items: center;
      background: var(--cream);
      border: 1.5px solid var(--beige);
      padding: 0.4rem 0.9rem;
      border-radius: 100px;
      font-size: 0.8rem;
      cursor: pointer;
      transition: all 0.2s;
      color: var(--text-light);
    }
    .option-label:hover {
      border-color: var(--green);
      color: var(--green);
    }
    .option-input {
      display: none;
    }
    .option-input:checked + .option-label {
      background: var(--green);
      color: #fff;
      border-color: var(--green);
      box-shadow: var(--shadow-green);
    }

    .qty-btn {
      width: 32px;
      height: 32px;
      border-radius: 50%;
      border: 1.5px solid var(--beige);
      display: flex;
      align-items: center;
      justify-content: center;
      font-weight: bold;
      cursor: pointer;
      transition: all 0.2s;
      color: var(--brown-dark);
      background: #fff;
    }
    .qty-btn:hover {
      border-color: var(--green);
      background: var(--cream);
    }

    /* Cart Float Button */
    #cart-float-btn {
      position: fixed;
      bottom: 32px;
      right: 32px;
      width: 60px;
      height: 60px;
      border-radius: 50%;
      background: var(--green);
      color: #fff;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 1.5rem;
      cursor: pointer;
      z-index: 998;
      transition: all 0.3s;
      border: none;
    }
    #cart-float-btn:hover {
      background: var(--green-dark);
      transform: scale(1.08);
    }
    #cart-badge {
      position: absolute;
      top: -2px;
      right: -2px;
      background: #e74c3c;
      color: #fff;
      font-size: 0.75rem;
      font-weight: bold;
      width: 22px;
      height: 22px;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      border: 2px solid #fff;
    }

    /* Cart Drawer Overlay */
    .cart-drawer-overlay {
      position: fixed;
      inset: 0;
      background: rgba(44, 44, 44, 0.4);
      backdrop-filter: blur(4px);
      z-index: 9990;
      display: flex;
      justify-content: flex-end;
      opacity: 0;
      visibility: hidden;
      transition: all 0.3s ease;
    }
    .cart-drawer-overlay.show {
      opacity: 1;
      visibility: visible;
    }
    .cart-drawer-content {
      background: #fff;
      width: 100%;
      max-width: 400px;
      height: 100vh;
      box-shadow: var(--shadow-lg);
      display: flex;
      flex-direction: column;
      transform: translateX(100%);
      transition: transform 0.3s ease;
    }
    .cart-drawer-overlay.show .cart-drawer-content {
      transform: translateX(0);
    }
    .cart-header {
      padding: 1.5rem;
      border-bottom: 1px solid var(--beige);
      display: flex;
      justify-content: space-between;
      align-items: center;
    }
    .cart-header h3 {
      font-size: 1.15rem;
      font-weight: 700;
      color: var(--brown-dark);
    }
    .cart-header button {
      font-size: 1.8rem;
      color: var(--text-light);
      cursor: pointer;
    }
    #cart-items-container {
      flex: 1;
      overflow-y: auto;
      padding: 1.5rem;
    }
    .cart-item {
      display: flex;
      justify-content: space-between;
      align-items: flex-start;
      padding-bottom: 1rem;
      margin-bottom: 1rem;
      border-bottom: 1px solid #f1eeeb;
    }
    .cart-item-details h4 {
      font-size: 0.9rem;
      font-weight: 600;
      color: var(--brown-dark);
    }
    .cart-item-details p {
      font-size: 0.75rem;
      color: var(--text-muted);
      margin-top: 0.1rem;
    }
    .cart-item-right {
      text-align: right;
      display: flex;
      flex-direction: column;
      align-items: flex-end;
      gap: 0.4rem;
    }
    .cart-item-price {
      font-weight: 700;
      color: var(--green-dark);
      font-size: 0.95rem;
    }
    .cart-summary {
      padding: 1.5rem;
      border-top: 1px solid var(--beige);
      background: #fdfdfb;
    }
    .cart-total-row {
      display: flex;
      justify-content: space-between;
      font-size: 1.1rem;
      font-weight: 700;
      color: var(--brown-dark);
    }
  </style>
</head>
<body>

@include('components.navbar')

{{-- MENU --}}
<section id="menu" class="section" style="padding-top:120px; background:var(--cream); min-height:100vh">
  <div class="container">
    <div class="sec-header" data-reveal>
      <div class="sec-tag">เมนูของเรา</div>
      <h2 class="sec-title">ดื่มด่ำกับทุกรสชาติ</h2>
      <p class="sec-desc">คัดสรรวัตถุดิบคุณภาพ ชงด้วยความใส่ใจและประณีต</p>
    </div>

    <div class="menu-tabs" data-reveal>
      <button class="tab-btn active" onclick="switchTab('coffee', this)">☕ Coffee</button>
      <button class="tab-btn" onclick="switchTab('noncoffee', this)">🧋 Non-Coffee</button>
      <button class="tab-btn" onclick="switchTab('bakery', this)">🍰 Cake</button>
    </div>

    {{-- Coffee --}}
    <div class="menu-grid active" id="tab-coffee">
      @forelse($products->where('category', 'coffee') as $product)
        @include('partials.menu-card', compact('product'))
      @empty
        <div style="grid-column: 1/-1; text-align:center; color:var(--text-light); padding:3rem">ไม่มีเมนูกาแฟในขณะนี้</div>
      @endforelse
    </div>

    {{-- Non-Coffee --}}
    <div class="menu-grid" id="tab-noncoffee">
      @forelse($products->where('category', 'noncoffee') as $product)
        @include('partials.menu-card', compact('product'))
      @empty
        <div style="grid-column: 1/-1; text-align:center; color:var(--text-light); padding:3rem">ไม่มีเมนูเครื่องดื่มทั่วไปในขณะนี้</div>
      @endforelse
    </div>

    {{-- Cake --}}
    <div class="menu-grid" id="tab-bakery">
      @forelse($products->where('category', 'bakery') as $product)
        @include('partials.menu-card', compact('product'))
      @empty
        <div style="grid-column: 1/-1; text-align:center; color:var(--text-light); padding:3rem">ไม่มีเมนูเค้กในขณะนี้</div>
      @endforelse
    </div>
  </div>
</section>

{{-- OPTIONS MODAL --}}
<div id="options-modal" class="modal-overlay">
  <div class="modal-content">
    <div id="modal-product-img-box" class="modal-product-img-box">
      <!-- Emoji or Product Image -->
    </div>
    <div class="modal-body font-sans">
      <h3 id="modal-product-name" style="font-size:1.25rem; font-weight:700; color:var(--brown-dark)">ชื่อสินค้า</h3>
      <p id="modal-product-desc" style="font-size:0.8rem; color:var(--text-light); margin-top:0.25rem; margin-bottom:1rem">รายละเอียดสินค้า</p>
      
      <div id="options-form-container" style="max-height: 250px; overflow-y: auto; padding-right: 0.25rem;">
        <!-- Dynamic options based on category -->
      </div>
      
      <div style="margin-top:1.5rem; display:flex; justify-content:space-between; align-items:center; border-top:1px solid var(--beige); padding-top:1rem">
        <div>
          <span style="font-size:.8rem; color:var(--text-muted)">ราคารวม</span>
          <div id="modal-product-total-price" style="font-size:1.45rem; font-weight:700; color:var(--green-dark)">฿0</div>
        </div>
        <div style="display:flex; align-items:center; gap:.5rem">
          <button type="button" class="qty-btn" onclick="adjustModalQty(-1)">-</button>
          <span id="modal-qty" style="font-weight:600; font-size:1.1rem; width:30px; text-align:center">1</span>
          <button type="button" class="qty-btn" onclick="adjustModalQty(1)">+</button>
        </div>
      </div>
      
      <div style="margin-top:1.5rem; display:flex; gap:.5rem">
        <button type="button" class="btn" style="flex:1; justify-content:center; background:var(--beige); color:var(--brown-dark)" onclick="closeOrderModal()">ยกเลิก</button>
        <button type="button" class="btn btn-primary" style="flex:1.5; justify-content:center" onclick="addModalItemToCart()">ใส่ตะกร้า</button>
      </div>
    </div>
  </div>
</div>

{{-- FLOATING CART BUTTON --}}
<button id="cart-float-btn" class="hidden shadow-green" onclick="toggleCartDrawer(true)" aria-label="ดูตะกร้าสินค้า">
  <i class="fa-solid fa-shopping-cart"></i>
  <span id="cart-badge">0</span>
</button>

{{-- CART DRAWER OVERLAY --}}
<div id="cart-drawer" class="cart-drawer-overlay" onclick="if(event.target === this) toggleCartDrawer(false)">
  <div class="cart-drawer-content font-sans">
    <div class="cart-header">
      <h3 style="display:flex; align-items:center; gap:8px"><i class="fa-solid fa-shopping-cart" style="color:var(--green)"></i> ตะกร้าสินค้าของคุณ</h3>
      <button onclick="toggleCartDrawer(false)">&times;</button>
    </div>
    
    <div id="cart-items-container">
      <!-- Dynamic cart items -->
    </div>
    
    <div class="cart-summary">
      <div class="cart-total-row">
        <span>ราคารวมทั้งหมด:</span>
        <strong id="cart-total-price" style="color:var(--green-dark)">฿0</strong>
      </div>
      <div style="margin-top:1rem">
        <label for="cart-note" style="display:block; font-size:.8rem; color:var(--text-light); margin-bottom:.3rem">หมายเหตุถึงทางร้าน:</label>
        <textarea id="cart-note" rows="2" style="width:100%; border:1px solid var(--beige); border-radius:8px; padding:.5rem; font-family:inherit; font-size:.85rem; outline:none; resize:none" placeholder="เช่น ที่อยู่จัดส่ง,หวานน้อยพิเศษ, แยกน้ำแข็ง..."></textarea>
      </div>

      @guest
      <div style="margin-top:1rem; padding:1rem; border:1px solid var(--beige); border-radius:8px; background:#fdfdfb;">
        <p style="font-size:0.85rem; font-weight:600; color:var(--brown-dark); margin-bottom:0.5rem;"><i class="fa-solid fa-user"></i> ข้อมูลติดต่อ (ลูกค้าทั่วไป)</p>
        <input type="text" id="customer-name" placeholder="ชื่อของคุณ *" style="width:100%; border:1px solid var(--beige); border-radius:6px; padding:0.6rem; margin-bottom:0.6rem; font-family:inherit; font-size:0.85rem; outline:none;" required>
        <input type="text" id="customer-phone" placeholder="เบอร์โทรศัพท์ *" style="width:100%; border:1px solid var(--beige); border-radius:6px; padding:0.6rem; font-family:inherit; font-size:0.85rem; outline:none;" required>
      </div>
      @endguest
      
      <button class="btn btn-primary" style="width:100%; justify-content:center; margin-top:1.2rem" onclick="submitOrder()">ยืนยันการสั่งซื้อ</button>
    </div>
  </div>
</div>

{{-- HIDDEN SUBMIT FORM --}}
<form id="order-form" action="{{ route('orders.store') }}" method="POST" class="hidden">
  @csrf
</form>

{{-- TOAST NOTIFICATION --}}
<div id="toast">เพิ่มลงตะกร้าเรียบร้อย!</div>

{{-- FOOTER --}}
<footer>
  <div class="container">
    <div class="footer-bottom" style="border-top:none; padding-top:0">
      <p>© 2026 บรรจงคาเฟ่ (Banchong Cafe). All Rights Reserved.</p>
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


// JavaScript Cart & Modal System
let currentProduct = null;
let currentQty = 1;
let cart = [];

// Load cart on load
if (localStorage.getItem('cafe_cart')) {
  try {
    cart = JSON.parse(localStorage.getItem('cafe_cart'));
    updateCartUI();
  } catch(e) {
    cart = [];
  }
}

function openOrderModal(product) {
  currentProduct = product;
  currentQty = 1;
  document.getElementById('modal-product-name').innerText = product.name;
  document.getElementById('modal-product-desc').innerText = product.description || 'ไม่มีรายละเอียดเพิ่มเติมสำหรับสินค้านี้';
  
  const imgBox = document.getElementById('modal-product-img-box');
  if (product.image) {
    imgBox.innerHTML = `<img src="${product.image}" alt="${product.name}">`;
  } else {
    let emoji = '☕';
    if (product.category === 'noncoffee') emoji = '🧋';
    else if (product.category === 'bakery') emoji = '🍰';
    imgBox.innerHTML = `<span style="font-size:4rem">${emoji}</span>`;
  }
  
  const optionsContainer = document.getElementById('options-form-container');
  optionsContainer.innerHTML = '';
  
  if (product.category === 'coffee' || product.category === 'noncoffee') {
    optionsContainer.innerHTML = `
      <div class="option-group">
        <h4>ประเภทเครื่องดื่ม</h4>
        <div class="option-items">
          <input type="radio" id="type-hot" name="drink-type" value="ร้อน" class="option-input" checked onchange="calculateModalPrice()">
          <label for="type-hot" class="option-label">🔥 ร้อน</label>
          
          <input type="radio" id="type-iced" name="drink-type" value="เย็น" class="option-input" onchange="calculateModalPrice()">
          <label for="type-iced" class="option-label">❄️ เย็น</label>
        </div>
      </div>
      <div class="option-group">
        <h4>ระดับความหวาน</h4>
        <div class="option-items">
          <input type="radio" id="sweet-100" name="drink-sweet" value="หวานปกติ (100%)" class="option-input" checked>
          <label for="sweet-100" class="option-label">หวานปกติ 100%</label>
          
          <input type="radio" id="sweet-50" name="drink-sweet" value="หวานน้อย (50%)" class="option-input">
          <label for="sweet-50" class="option-label">หวานน้อย 50%</label>
          
          <input type="radio" id="sweet-0" name="drink-sweet" value="ไม่หวาน (0%)" class="option-input">
          <label for="sweet-0" class="option-label">ไม่หวาน 0%</label>
        </div>
      </div>
      <div class="option-group">
        <h4>ท็อปปิ้ง / เพิ่มเติม</h4>
        <div class="option-items">
          <input type="checkbox" id="addon-whip" value="วิปครีม (+10฿)" class="option-input" onchange="calculateModalPrice()">
          <label for="addon-whip" class="option-label">+ วิปครีม (+฿10)</label>
          
          <input type="checkbox" id="addon-shot" value="เพิ่มช็อตเอสเปรสโซ่ (+10฿)" class="option-input" onchange="calculateModalPrice()">
          <label for="addon-shot" class="option-label">+ ช็อตกาแฟ (+฿10)</label>
        </div>
      </div>
    `;
  } 
  
  document.getElementById('modal-qty').innerText = currentQty;
  calculateModalPrice();
  
  const modal = document.getElementById('options-modal');
  modal.classList.add('show');
}

function calculateModalPrice() {
  if (!currentProduct) return;
  let base = parseFloat(currentProduct.price);
  let extra = 0;
  
  if (currentProduct.category === 'coffee' || currentProduct.category === 'noncoffee') {
    if (document.getElementById('addon-whip') && document.getElementById('addon-whip').checked) extra += 15;
    if (document.getElementById('addon-shot') && document.getElementById('addon-shot').checked) extra += 15;
  } else if (currentProduct.category === 'bakery') {
    if (document.getElementById('addon-whip-bakery') && document.getElementById('addon-whip-bakery').checked) extra += 15;
    if (document.getElementById('addon-jam') && document.getElementById('addon-jam').checked) extra += 10;
  }
  
  const unitPrice = base + extra;
  const total = unitPrice * currentQty;
  document.getElementById('modal-product-total-price').innerText = '฿' + total.toLocaleString(undefined, {minimumFractionDigits: 0, maximumFractionDigits: 0});
}

function adjustModalQty(val) {
  currentQty += val;
  if (currentQty < 1) currentQty = 1;
  document.getElementById('modal-qty').innerText = currentQty;
  calculateModalPrice();
}

function closeOrderModal() {
  const modal = document.getElementById('options-modal');
  modal.classList.remove('show');
}

function addModalItemToCart() {
  let options = [];
  
  if (currentProduct.category === 'coffee' || currentProduct.category === 'noncoffee') {
    const typeRadio = document.querySelector('input[name="drink-type"]:checked');
    const sweetRadio = document.querySelector('input[name="drink-sweet"]:checked');
    if (typeRadio) options.push(typeRadio.value);
    if (sweetRadio) options.push(sweetRadio.value);
    
    ['addon-whip', 'addon-shot'].forEach(id => {
      const el = document.getElementById(id);
      if (el && el.checked) options.push(el.value);
    });
  } else if (currentProduct.category === 'bakery') {
    const serveRadio = document.querySelector('input[name="bakery-serve"]:checked');
    if (serveRadio) options.push(serveRadio.value);
    
    ['addon-whip-bakery', 'addon-jam'].forEach(id => {
      const el = document.getElementById(id);
      if (el && el.checked) options.push(el.value);
    });
  }
  
  const optionsText = options.join(', ');
  
  // Check duplicate
  const dupIndex = cart.findIndex(item => item.id === currentProduct.id && item.options === optionsText);
  if (dupIndex > -1) {
    cart[dupIndex].qty += currentQty;
  } else {
    cart.push({
      id: currentProduct.id,
      name: currentProduct.name,
      price: currentProduct.price,
      image: currentProduct.image,
      qty: currentQty,
      options: optionsText
    });
  }
  
  saveCart();
  closeOrderModal();
  updateCartUI();
  toggleCartDrawer(true);
  showToast('เพิ่มสินค้าในตะกร้าแล้ว 🛒');
}

function showToast(msg) {
  const toast = document.getElementById('toast');
  toast.innerText = msg;
  toast.classList.add('show');
  setTimeout(() => toast.classList.remove('show'), 2500);
}

function saveCart() {
  localStorage.setItem('cafe_cart', JSON.stringify(cart));
}

function toggleCartDrawer(forceShow) {
  const drawer = document.getElementById('cart-drawer');
  if (forceShow === true) {
    drawer.classList.add('show');
  } else if (forceShow === false) {
    drawer.classList.remove('show');
  } else {
    drawer.classList.toggle('show');
  }
}

function updateCartUI() {
  const container = document.getElementById('cart-items-container');
  container.innerHTML = '';
  
  let totalItems = 0;
  let totalPrice = 0;
  
  if (cart.length === 0) {
    container.innerHTML = `
      <div style="text-align:center; color:var(--text-muted); padding:4rem 1rem">
        <div style="font-size:3.5rem; margin-bottom:1rem">🛒</div>
        <p>ตะกร้าสินค้าว่างเปล่า</p>
      </div>
    `;
    document.getElementById('cart-float-btn').classList.add('hidden');
  } else {
    document.getElementById('cart-float-btn').classList.remove('hidden');
    
    cart.forEach((item, index) => {
      totalItems += item.qty;
      
      // Calculate unit price locally for preview
      let base = parseFloat(item.price);
      let extra = 0;
      if (item.options) {
        if (item.options.includes('วิปครีม')) extra += 15;
        if (item.options.includes('เพิ่มช็อต')) extra += 15;
        if (item.options.includes('เนย/แยม')) extra += 10;
      }
      
      const priceSum = (base + extra) * item.qty;
      totalPrice += priceSum;
      
      container.innerHTML += `
        <div class="cart-item">
          <div class="cart-item-details">
            <h4>${item.name}</h4>
            <p>${item.options || 'ไม่มีตัวเลือกพิเศษ'}</p>
            <div style="display:flex; align-items:center; gap:.5rem; margin-top:.5rem">
              <button class="qty-btn" style="width:24px; height:24px; font-size:.8rem" onclick="adjustCartQty(${index}, -1)">-</button>
              <span style="font-weight:600">${item.qty}</span>
              <button class="qty-btn" style="width:24px; height:24px; font-size:.8rem" onclick="adjustCartQty(${index}, 1)">+</button>
            </div>
          </div>
          <div class="cart-item-right">
            <span class="cart-item-price">฿${priceSum.toLocaleString()}</span>
            <button style="color:var(--text-muted); font-size:.78rem; margin-top:.4rem; cursor:pointer" onclick="removeFromCart(${index})">ลบออก</button>
          </div>
        </div>
      `;
    });
  }
  
  document.getElementById('cart-badge').innerText = totalItems;
  document.getElementById('cart-total-price').innerText = '฿' + totalPrice.toLocaleString(undefined, {minimumFractionDigits: 0, maximumFractionDigits: 0});
}

function adjustCartQty(index, val) {
  cart[index].qty += val;
  if (cart[index].qty < 1) {
    removeFromCart(index);
  } else {
    saveCart();
    updateCartUI();
  }
}

function removeFromCart(index) {
  cart.splice(index, 1);
  saveCart();
  updateCartUI();
}

function submitOrder() {
  if (cart.length === 0) return;
  
  // Validate guest info
  const customerNameEl = document.getElementById('customer-name');
  const customerPhoneEl = document.getElementById('customer-phone');
  
  if (customerNameEl && customerPhoneEl) {
    if (!customerNameEl.value.trim() || !customerPhoneEl.value.trim()) {
      alert('กรุณากรอกชื่อและเบอร์โทรศัพท์ให้ครบถ้วนก่อนยืนยันการสั่งซื้อ');
      return;
    }
  }
  
  const form = document.getElementById('order-form');
  // Clear any dynamic inputs from previous attempts
  form.querySelectorAll('.dynamic-input').forEach(e => e.remove());
  
  cart.forEach((item, index) => {
    // Add product ID
    const idInput = document.createElement('input');
    idInput.type = 'hidden';
    idInput.name = `items[${index}][id]`;
    idInput.value = item.id;
    idInput.className = 'dynamic-input';
    form.appendChild(idInput);
    
    // Add quantity
    const qtyInput = document.createElement('input');
    qtyInput.type = 'hidden';
    qtyInput.name = `items[${index}][qty]`;
    qtyInput.value = item.qty;
    qtyInput.className = 'dynamic-input';
    form.appendChild(qtyInput);
    
    // Add options
    const optInput = document.createElement('input');
    optInput.type = 'hidden';
    optInput.name = `items[${index}][options]`;
    optInput.value = item.options;
    optInput.className = 'dynamic-input';
    form.appendChild(optInput);
  });
  
  // Add note
  const noteInput = document.createElement('input');
  noteInput.type = 'hidden';
  noteInput.name = 'note';
  noteInput.value = document.getElementById('cart-note').value;
  noteInput.className = 'dynamic-input';
  form.appendChild(noteInput);
  
  if (customerNameEl && customerPhoneEl) {
    const nameInput = document.createElement('input');
    nameInput.type = 'hidden';
    nameInput.name = 'customer_name';
    nameInput.value = customerNameEl.value.trim();
    nameInput.className = 'dynamic-input';
    form.appendChild(nameInput);
    
    const phoneInput = document.createElement('input');
    phoneInput.type = 'hidden';
    phoneInput.name = 'customer_phone';
    phoneInput.value = customerPhoneEl.value.trim();
    phoneInput.className = 'dynamic-input';
    form.appendChild(phoneInput);
  }
  
  // Clear localStorage cart
  localStorage.removeItem('cafe_cart');
  
  form.submit();
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