<div class="menu-card" data-reveal>
  <div class="menu-card-img">
    {{ $emoji }}
    @if(!empty($badge))
      <span class="menu-badge {{ isset($new) && $new ? 'new' : '' }}">{{ $badge }}</span>
    @endif
  </div>
  <div class="menu-body">
    <h3>{{ $name }}</h3>
    <p>{{ $desc }}</p>
    <div class="menu-footer">
      <span class="price">{{ $price }}</span>
      <button class="btn-add" onclick="addToCart()" aria-label="เพิ่มลงตะกร้า">+</button>
    </div>
  </div>
</div>
