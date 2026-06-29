<!DOCTYPE html>
<html lang="th">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>แก้ไขเมนู | บรรจงคาเฟ่</title>
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link href="https://fonts.googleapis.com/css2?family=Prompt:wght@300;400;500;600;700&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
  <link rel="stylesheet" href="{{ asset('css/cafe.css') }}" />
</head>
<body>

@include('components.navbar')

<div style="padding: 120px 2rem 2rem">
  <div class="container" style="max-width:600px">

    <div style="display:flex;align-items:center;gap:1rem;margin-bottom:2rem">
      <a href="/dashboard/products" style="color:#7D8F69"><i class="fa-solid fa-arrow-left"></i> กลับ</a>
      <h2 style="margin:0">แก้ไขเมนู</h2>
    </div>

    @if($errors->any())
      <div style="background:#f8d7da;color:#721c24;padding:1rem;border-radius:8px;margin-bottom:1rem">
        @foreach($errors->all() as $error)
          <div>{{ $error }}</div>
        @endforeach
      </div>
    @endif

    <div class="contact-card">
      <form method="POST" action="{{ route('products.update', $product->id) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div style="margin-bottom:1rem">
          <label style="display:block;margin-bottom:.5rem;font-weight:500">ชื่อเมนู *</label>
          <input type="text" name="name" value="{{ old('name', $product->name) }}"
                 style="width:100%;padding:.8rem;border:1px solid #ddd;border-radius:8px;font-family:inherit"
                 required />
        </div>

        <div style="margin-bottom:1rem">
          <label style="display:block;margin-bottom:.5rem;font-weight:500">หมวดหมู่ *</label>
          <select name="category"
                  style="width:100%;padding:.8rem;border:1px solid #ddd;border-radius:8px;font-family:inherit">
            <option value="coffee"    {{ old('category', $product->category)=='coffee'    ? 'selected' : '' }}>☕ Coffee</option>
            <option value="noncoffee" {{ old('category', $product->category)=='noncoffee' ? 'selected' : '' }}>🧋 Non-Coffee</option>
            <option value="bakery"    {{ old('category', $product->category)=='bakery'    ? 'selected' : '' }}>🥐 Bakery</option>
            
          </select>
        </div>

        <div style="margin-bottom:1rem">
          <label style="display:block;margin-bottom:.5rem;font-weight:500">รายละเอียด</label>
          <textarea name="description" rows="3"
                    style="width:100%;padding:.8rem;border:1px solid #ddd;border-radius:8px;font-family:inherit">{{ old('description', $product->description) }}</textarea>
        </div>

        <div style="margin-bottom:1rem">
          <label style="display:block;margin-bottom:.5rem;font-weight:500">ราคา (บาท) *</label>
          <input type="number" name="price" value="{{ old('price', $product->price) }}" min="0" step="0.01"
                 style="width:100%;padding:.8rem;border:1px solid #ddd;border-radius:8px;font-family:inherit"
                 required />
        </div>

        <div style="margin-bottom:1rem">
          <label style="display:block;margin-bottom:.5rem;font-weight:500">รูปภาพ</label>
          @if($product->image)
            <div style="margin-bottom:.5rem;">
              <img src="{{ asset('storage/' . $product->image) }}" alt="Current Image" style="height:100px; border-radius:8px; object-fit:contain; background:var(--cream); padding:5px;">
            </div>
          @endif
          <input type="file" name="image" accept="image/*"
                 style="width:100%;padding:.8rem;border:1px solid #ddd;border-radius:8px;font-family:inherit" />
        </div>

        <div style="margin-bottom:1.5rem">
          <label style="display:flex;align-items:center;gap:.5rem;cursor:pointer">
            <input type="checkbox" name="is_available" value="1" 
                   {{ old('is_available', $product->is_available) ? 'checked' : '' }} />
            <span>พร้อมขาย</span>
          </label>
        </div>

        <button type="submit" class="btn btn-primary" style="width:100%">
          <i class="fa-solid fa-save"></i> บันทึกการแก้ไข
        </button>

      </form>
    </div>

  </div>
</div>


</body>
</html>