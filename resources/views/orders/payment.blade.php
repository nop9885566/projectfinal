<!DOCTYPE html>
<html lang="th">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>ชำระเงินออเดอร์ #{{ $order->id }} | บรรจงคาเฟ่</title>
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link href="https://fonts.googleapis.com/css2?family=Prompt:wght@300;400;500;600;700&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
  <link rel="stylesheet" href="{{ asset('css/cafe.css') }}" />
  <style>
    body { background: var(--cream); font-family: 'Prompt', sans-serif; }
    .payment-container { max-width: 500px; margin: 4rem auto; padding: 2.5rem; background: #fff; border-radius: 20px; box-shadow: 0 10px 30px rgba(0,0,0,0.04); text-align: center; border: 1px solid #f1eeeb; }
    .qr-box { border: 2px dashed #d1c8c1; border-radius: 12px; padding: 1.5rem; margin: 1.5rem 0; display: inline-block; background: #faf9f6; }
    .qr-box img { max-width: 220px; border-radius: 8px; }
    .total-price { font-size: 2.2rem; color: var(--green-dark); font-weight: 700; margin: 1rem 0; }
    .upload-box { margin-top: 2rem; text-align: left; }
    .upload-box label { display: block; font-weight: 600; color: var(--brown-dark); margin-bottom: 0.5rem; }
    .upload-box input[type="file"] { width: 100%; padding: 0.8rem; border: 1.5px solid var(--beige); border-radius: 10px; background: #fdfdfb; cursor: pointer; }
    .upload-box input[type="file"]::file-selector-button { background: var(--cream); border: 1px solid var(--beige); padding: 0.4rem 1rem; border-radius: 6px; cursor: pointer; margin-right: 1rem; color: var(--brown-dark); font-family: 'Prompt'; }
  </style>
</head>
<body>

<div class="payment-container">
  <div style="font-size: 3rem; color: var(--green); margin-bottom: 1rem;">
    <i class="fa-solid fa-qrcode"></i>
  </div>
  <h2 style="color: var(--brown-dark); font-weight: 700;">ชำระเงินออเดอร์ #{{ $order->id }}</h2>
  <p style="color: var(--text-light); margin-top: 0.5rem;">กรุณาสแกน QR Code ด้านล่างเพื่อชำระเงิน</p>

  <div class="qr-box">
    <!-- PromptPay QR Code via promptpay.io API -->
    <img src="https://promptpay.io/0888888888/{{ $order->total_price }}.png" alt="PromptPay QR">
    <div style="margin-top: 1rem; color: var(--text-muted); font-size: 0.95rem;">
      <strong>พร้อมเพย์: 088-888-8888</strong><br>
      (บจก. บรรจง คาเฟ่)
    </div>
  </div>

  <div class="total-price">
    ยอดชำระ: ฿{{ number_format($order->total_price, 2) }}
  </div>

  <form action="{{ route('orders.uploadSlip', $order->id) }}" method="POST" enctype="multipart/form-data" class="upload-box">
    @csrf
    <label for="slip_image"><i class="fa-solid fa-receipt"></i> แนบหลักฐานการโอนเงิน (สลิป)</label>
    <input type="file" name="slip_image" id="slip_image" accept="image/*" required>
    
    @error('slip_image')
      <div style="color: #e74c3c; font-size: 0.85rem; margin-top: 0.5rem;"><i class="fa-solid fa-circle-exclamation"></i> {{ $message }}</div>
    @enderror

    <button type="submit" class="btn btn-primary" style="width: 100%; justify-content: center; margin-top: 1.5rem; font-size: 1.1rem; padding: 1rem; border-radius: 12px; font-weight: 600;">
      ยืนยันการชำระเงิน
    </button>
  </form>

  <div style="margin-top: 2rem;">
    <a href="/menu" style="color: var(--text-light); text-decoration: none; font-size: 0.9rem; transition: color 0.2s;" onmouseover="this.style.color='var(--brown-dark)'" onmouseout="this.style.color='var(--text-light)'"><i class="fa-solid fa-arrow-left"></i> กลับไปหน้าเมนู (ชำระภายหลัง)</a>
  </div>
</div>

</body>
</html>
