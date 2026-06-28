<!DOCTYPE html>
<html lang="th">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>จัดการออเดอร์ | บรรจงคาเฟ่</title>
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
      <li><a href="/dashboard">Dashboard</a></li>
      <li><a href="/dashboard/products">จัดการเมนู</a></li>
      <li><a href="/dashboard/orders" class="active">จัดการออเดอร์</a></li>
      <li><a href="/">หน้าเว็บ</a></li>
    </ul>
    <form method="POST" action="<?php echo e(route('logout')); ?>" style="margin:0">
      <?php echo csrf_field(); ?>
      <button type="submit" class="btn-nav">ออกจากระบบ</button>
    </form>
    <button class="hamburger" id="hamburger" aria-label="toggle menu">
      <span></span><span></span><span></span>
    </button>
  </div>
</nav>

<div style="padding: 120px 2rem 2rem">
  <div class="container">

    <h2 style="margin-bottom:2rem">จัดการออเดอร์</h2>

    <?php if(session('success')): ?>
      <div style="background:#d4edda;color:#155724;padding:1rem;border-radius:8px;margin-bottom:1rem">
        <?php echo e(session('success')); ?>

      </div>
    <?php endif; ?>

    <?php $__empty_1 = true; $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
    <div class="contact-card" style="margin-bottom:1.5rem">
      <div style="display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:1rem">
        <div>
          <strong>ออเดอร์ #<?php echo e($order->id); ?></strong>
          <span style="margin-left:1rem;color:#999;font-size:.9rem"><?php echo e($order->created_at->format('d/m/Y H:i')); ?></span>
        </div>
        <div>
          <?php if($order->user): ?>
            <strong><i class="fa-solid fa-user-check" style="color:#7D8F69"></i> <?php echo e($order->user->name); ?></strong>
          <?php else: ?>
            <strong><i class="fa-solid fa-user" style="color:#999"></i> <?php echo e($order->customer_name); ?></strong> (ลูกค้าทั่วไป)<br>
            <small style="color:#666"><i class="fa-solid fa-phone"></i> <?php echo e($order->customer_phone); ?></small>
          <?php endif; ?>
        </div>
        <div>
          <strong style="color:#7D8F69; font-size: 1.1rem;">฿<?php echo e(number_format($order->total_price, 2)); ?></strong>
          <div style="margin-top: 5px; font-size: 0.85rem;">
            <?php if($order->payment_status === 'pending'): ?>
              <span style="background: #fdf0d5; color: #b87c00; padding: 3px 8px; border-radius: 6px;"><i class="fa-solid fa-clock"></i> รอชำระเงิน</span>
            <?php elseif($order->payment_status === 'paid'): ?>
              <span style="background: #e3f2fd; color: #0d47a1; padding: 3px 8px; border-radius: 6px;"><i class="fa-solid fa-file-invoice-dollar"></i> โอนแล้ว</span>
            <?php elseif($order->payment_status === 'verified'): ?>
              <span style="background: #e8f5e9; color: #1b5e20; padding: 3px 8px; border-radius: 6px;"><i class="fa-solid fa-check-double"></i> ตรวจสอบแล้ว</span>
            <?php else: ?>
              <span style="background: #ffebee; color: #b71c1c; padding: 3px 8px; border-radius: 6px;"><i class="fa-solid fa-triangle-exclamation"></i> ไม่สำเร็จ</span>
            <?php endif; ?>
          </div>
          <?php if($order->slip_image): ?>
            <div style="margin-top: 6px;">
              <a href="<?php echo e(asset('storage/' . $order->slip_image)); ?>" target="_blank" style="font-size: 0.85rem; color: var(--green); text-decoration: none; border-bottom: 1px solid var(--green);"><i class="fa-solid fa-image"></i> ดูหลักฐานโอนเงิน</a>
            </div>
          <?php endif; ?>
        </div>

        
        <div style="display:flex; gap:.5rem;">
          <form method="POST" action="<?php echo e(route('orders.updateStatus', $order->id)); ?>" style="display:flex;gap:.5rem">
            <?php echo csrf_field(); ?>
            <?php echo method_field('PATCH'); ?>
            <select name="status"
                    style="padding:.5rem;border:1px solid #ddd;border-radius:8px;font-family:inherit">
              <option value="pending"    <?php echo e($order->status=='pending'    ? 'selected' : ''); ?>>⏳ รอดำเนินการ</option>
              <option value="confirmed"  <?php echo e($order->status=='confirmed'  ? 'selected' : ''); ?>>✅ ยืนยันแล้ว</option>
              <option value="preparing"  <?php echo e($order->status=='preparing'  ? 'selected' : ''); ?>>👨‍🍳 กำลังเตรียม</option>
              <option value="completed"  <?php echo e($order->status=='completed'  ? 'selected' : ''); ?>>🎉 เสร็จแล้ว</option>
              <option value="cancelled"  <?php echo e($order->status=='cancelled'  ? 'selected' : ''); ?>>❌ ยกเลิก</option>
            </select>
            <button type="submit" class="btn btn-primary" style="padding:.5rem 1rem">อัปเดต</button>
          </form>

          <form method="POST" action="<?php echo e(route('orders.destroy', $order->id)); ?>" onsubmit="return confirm('ยืนยันการลบออเดอร์นี้? ข้อมูลจะถูกลบถาวร');">
            <?php echo csrf_field(); ?>
            <?php echo method_field('DELETE'); ?>
            <button type="submit" style="background:#dc3545; color:white; padding:.5rem 1rem; border:none; border-radius:8px; cursor:pointer;" title="ลบออเดอร์"><i class="fa-solid fa-trash"></i></button>
          </form>
        </div>
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
            <strong>฿<?php echo e(number_format($item->price * $item->quantity, 2)); ?></strong>
          </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php if($order->note): ?>
          <div style="margin-top:.5rem;color:#999;font-size:.9rem">📝 หมายเหตุ: <?php echo e($order->note); ?></div>
        <?php endif; ?>
      </div>
    </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
      <div style="text-align:center;color:#999;padding:3rem">ยังไม่มีออเดอร์</div>
    <?php endif; ?>

  </div>
</div>

<script>
  const hamburger = document.getElementById('hamburger');
  const navLinks  = document.getElementById('navLinks');
  if (hamburger && navLinks) {
    hamburger.addEventListener('click', () => {
      hamburger.classList.toggle('open');
      navLinks.classList.toggle('open');
    });
  }
</script>
</body>
</html><?php /**PATH /var/www/html/resources/views/dashboard/orders/index.blade.php ENDPATH**/ ?>