<!DOCTYPE html>
<html lang="th">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>จัดการเมนู | บรรจงคาเฟ่</title>
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
      <li><a href="/dashboard/products" class="active">จัดการเมนู</a></li>
      <?php if(auth()->user()->role === 'admin'): ?>
        <li><a href="/dashboard/orders">จัดการออเดอร์</a></li>
      <?php endif; ?>
      <li><a href="/">หน้าเว็บ</a></li>
    </ul>
    <form method="POST" action="<?php echo e(route('logout')); ?>" style="margin:0">
      <?php echo csrf_field(); ?>
      <button type="submit" class="btn-nav">ออกจากระบบ</button>
    </form>
  </div>
</nav>

<div style="padding: 120px 2rem 2rem">
  <div class="container">

    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:2rem">
      <h2>จัดการเมนู</h2>
      <a href="/dashboard/products/create" class="btn btn-primary">
        <i class="fa-solid fa-plus"></i> เพิ่มเมนูใหม่
      </a>
    </div>

    <?php if(session('success')): ?>
      <div style="background:#d4edda;color:#155724;padding:1rem;border-radius:8px;margin-bottom:1rem">
        <?php echo e(session('success')); ?>

      </div>
    <?php endif; ?>

    <div style="overflow-x:auto">
      <table style="width:100%;border-collapse:collapse;background:#fff;border-radius:12px;overflow:hidden">
        <thead style="background:#7D8F69;color:#fff">
          <tr>
            <th style="padding:1rem;text-align:left">#</th>
            <th style="padding:1rem;text-align:left">ชื่อเมนู</th>
            <th style="padding:1rem;text-align:left">หมวดหมู่</th>
            <th style="padding:1rem;text-align:left">ราคา</th>
            <th style="padding:1rem;text-align:left">สถานะ</th>
            <th style="padding:1rem;text-align:left">จัดการ</th>
          </tr>
        </thead>
        <tbody>
          <?php $__empty_1 = true; $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
          <tr style="border-bottom:1px solid #eee">
            <td style="padding:1rem"><?php echo e($product->id); ?></td>
            <td style="padding:1rem"><?php echo e($product->name); ?></td>
            <td style="padding:1rem"><?php echo e($product->category); ?></td>
            <td style="padding:1rem">฿<?php echo e(number_format($product->price, 2)); ?></td>
            <td style="padding:1rem">
              <?php if($product->is_available): ?>
                <span style="color:#27ae60">✅ พร้อมขาย</span>
              <?php else: ?>
                <span style="color:#e74c3c">❌ หยุดขาย</span>
              <?php endif; ?>
            </td>
            <td style="padding:1rem">
              <?php if(auth()->user()->role === 'admin'): ?>
                <a href="/dashboard/products/<?php echo e($product->id); ?>/edit" 
                   style="background:#3498db;color:#fff;padding:.4rem .8rem;border-radius:6px;text-decoration:none;margin-right:.5rem">
                  แก้ไข
                </a>
              <?php endif; ?>
              <form method="POST" action="/dashboard/products/<?php echo e($product->id); ?>" style="display:inline">
                <?php echo csrf_field(); ?>
                <?php echo method_field('DELETE'); ?>
                <button type="submit" 
                        style="background:#e74c3c;color:#fff;padding:.4rem .8rem;border-radius:6px;border:none;cursor:pointer"
                        onclick="return confirm('ลบเมนูนี้?')">
                  ลบ
                </button>
              </form>
            </td>
          </tr>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
          <tr>
            <td colspan="6" style="padding:2rem;text-align:center;color:#999">ยังไม่มีเมนู</td>
          </tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>

  </div>
</div>

</body>
</html><?php /**PATH /var/www/html/resources/views/dashboard/products/index.blade.php ENDPATH**/ ?>