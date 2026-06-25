<!DOCTYPE html>
<html lang="th">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>ออเดอร์ของฉัน | บรรจงคาเฟ่</title>
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link href="https://fonts.googleapis.com/css2?family=Prompt:wght@300;400;500;600;700&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
  <link rel="stylesheet" href="<?php echo e(asset('css/cafe.css')); ?>" />
</head>
<body>

<nav id="navbar" class="scrolled">
  <div class="nav-wrap">
    <a href="/" class="nav-logo">
      <i class="fa-solid fa-mug-hot"></i> บรรจงคาเฟ่
    </a>
    <ul class="nav-links" id="navLinks">
      <li><a href="/">หน้าแรก</a></li>
      <li><a href="/menu">เมนู</a></li>
      <li><a href="/gallery">แกลเลอรี</a></li>
      <li><a href="/orders" class="active">ออเดอร์ของฉัน</a></li>
    </ul>
    <form method="POST" action="<?php echo e(route('logout')); ?>" style="margin:0">
      <?php echo csrf_field(); ?>
      <button type="submit" class="btn-nav">ออกจากระบบ</button>
    </form>
  </div>
</nav>

<div style="padding: 120px 2rem 2rem">
  <div class="container">

    <h2 style="margin-bottom:2rem">ออเดอร์ของฉัน</h2>

    <?php $__empty_1 = true; $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
    <div class="contact-card" style="margin-bottom:1.5rem">
      <div style="display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:1rem">
        <div>
          <strong>ออเดอร์ #<?php echo e($order->id); ?></strong>
          <span style="margin-left:1rem;color:#999;font-size:.9rem">
            <?php echo e($order->created_at->format('d/m/Y H:i')); ?>

          </span>
        </div>
        <div>
          <?php
            $statusMap = [
              'pending'   => ['label' => 'รอดำเนินการ', 'color' => '#e67e22'],
              'confirmed' => ['label' => 'ยืนยันแล้ว',  'color' => '#3498db'],
              'preparing' => ['label' => 'กำลังเตรียม', 'color' => '#9b59b6'],
              'completed' => ['label' => 'เสร็จแล้ว',   'color' => '#27ae60'],
              'cancelled' => ['label' => 'ยกเลิก',       'color' => '#e74c3c'],
            ];
            $s = $statusMap[$order->status];
          ?>
          <span style="background:<?php echo e($s['color']); ?>;color:#fff;padding:.3rem .8rem;border-radius:20px;font-size:.85rem">
            <?php echo e($s['label']); ?>

          </span>
        </div>
        <strong style="color:#7D8F69">฿<?php echo e(number_format($order->total_price, 2)); ?></strong>
      </div>

      
      <div style="margin-top:1rem;border-top:1px solid #eee;padding-top:1rem">
        <?php $__currentLoopData = $order->orderItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <div style="display:flex;justify-content:space-between;align-items:flex-start;padding:.4rem 0;border-bottom:1px dashed #f5f5f5">
            <div>
              <span style="font-weight:600"><?php echo e($item->product->name); ?> x<?php echo e($item->quantity); ?></span>
              <?php if($item->options): ?>
                <div style="font-size:0.8rem;color:#7d8f69;margin-top:2px">✨ ตัวเลือก: <?php echo e($item->options); ?></div>
              <?php endif; ?>
            </div>
            <strong style="color:var(--text-light)">฿<?php echo e(number_format($item->price * $item->quantity, 2)); ?></strong>
          </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php if($order->note): ?>
          <div style="margin-top:.5rem;color:#999;font-size:.9rem">📝 หมายเหตุ: <?php echo e($order->note); ?></div>
        <?php endif; ?>
      </div>
    </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
      <div style="text-align:center;color:#999;padding:3rem">
        <div style="font-size:3rem">🛒</div>
        <p>ยังไม่มีออเดอร์</p>
        <a href="/menu" class="btn btn-primary">สั่งอาหารเลย</a>
      </div>
    <?php endif; ?>

  </div>
</div>

</body>
</html><?php /**PATH /var/www/html/resources/views/orders/index.blade.php ENDPATH**/ ?>