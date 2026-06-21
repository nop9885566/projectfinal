<div class="menu-card" data-reveal>
  <div class="menu-card-img" style="display:flex; align-items:center; justify-content:center; height:180px; overflow:hidden; background:var(--cream); border-bottom:1px solid var(--beige)">
    @if($product->image)
      <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" style="width:100%; height:100%; object-fit:cover;">
    @else
      @php
        $emoji = '☕';
        if ($product->category === 'noncoffee') $emoji = '🧋';
        elseif ($product->category === 'bakery') $emoji = '🥐';
        elseif ($product->category === 'food') $emoji = '🍽️';
      @endphp
      <span style="font-size: 3.5rem;">{{ $emoji }}</span>
    @endif
  </div>
  <div class="menu-body">
    <h3>{{ $product->name }}</h3>
    <p>{{ $product->description }}</p>
    <div class="menu-footer">
      <span class="price">฿{{ number_format($product->price, 0) }}</span>
      <button class="btn-add" 
              onclick='openOrderModal(@json([
                  "id" => $product->id,
                  "name" => $product->name,
                  "price" => (float)$product->price,
                  "category" => $product->category,
                  "image" => $product->image ? asset("storage/" . $product->image) : null
              ]))' 
              aria-label="เพิ่มลงตะกร้า">+</button>
    </div>
  </div>
</div>
