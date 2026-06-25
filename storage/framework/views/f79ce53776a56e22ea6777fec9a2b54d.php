<div class="menu-card" data-reveal>
  <div class="menu-card-img" style="background:var(--cream); border-bottom:1px solid var(--beige)">
    <?php if($product->image): ?>
      <img src="<?php echo e(asset('storage/' . $product->image)); ?>" alt="<?php echo e($product->name); ?>" style="width:100%; height:100%; object-fit:contain; padding:10px;">
    <?php else: ?>
      <?php
        $emoji = '☕';
        if ($product->category === 'noncoffee') $emoji = '🧋';
        elseif ($product->category === 'bakery') $emoji = '🥐';
        elseif ($product->category === 'food') $emoji = '🍽️';
      ?>
      <span style="font-size: 3.5rem;"><?php echo e($emoji); ?></span>
    <?php endif; ?>
  </div>
  <div class="menu-body">
    <h3><?php echo e($product->name); ?></h3>
    <p><?php echo e($product->description); ?></p>
    <div class="menu-footer">
      <span class="price">฿<?php echo e(number_format($product->price, 0)); ?></span>
      <?php
        $itemData = [
            "id" => $product->id,
            "name" => $product->name,
            "price" => (float)$product->price,
            "category" => $product->category,
            "image" => $product->image ? asset("storage/" . $product->image) : null
        ];
      ?>
      <button class="btn-add" 
              onclick='openOrderModal(<?php echo json_encode($itemData, 15, 512) ?>)' 
              aria-label="เพิ่มลงตะกร้า">+</button>
    </div>
  </div>
</div>
<?php /**PATH /var/www/html/resources/views/partials/menu-card.blade.php ENDPATH**/ ?>