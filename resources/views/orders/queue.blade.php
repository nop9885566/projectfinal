@extends('layouts.app')

@section('content')
<div class="container" style="max-width: 600px; margin: 0 auto; padding: 2rem 1rem;">
    <div class="card text-center" style="border-radius: 16px; overflow: hidden; border: 1px solid var(--beige); box-shadow: var(--shadow-sm);">
        <div class="card-header" style="background: var(--brown-dark); color: #fff; padding: 1.5rem;">
            <h2 style="margin: 0; font-size: 1.5rem;">กำลังดำเนินการสั่งซื้อ</h2>
            <p style="margin: 0.5rem 0 0 0; opacity: 0.8;">ออเดอร์ #{{ $order->id }}</p>
        </div>
        
        <div class="card-body" style="padding: 2.5rem 1.5rem; background: var(--cream);">
            @if(session('success'))
                <div class="alert alert-success" style="margin-bottom: 2rem; border-radius: 12px; background: #d4edda; color: #155724; border: none;">
                    {{ session('success') }}
                </div>
            @endif

            <h3 style="font-size: 4rem; color: var(--green); margin: 0 0 1rem 0;">{{ $queueCount }}</h3>
            <p style="font-size: 1.2rem; color: var(--brown-dark); font-weight: 500;">คิวที่รออยู่ข้างหน้าคุณ</p>
            
            <p style="color: var(--text-light); margin-top: 1.5rem; font-size: 0.95rem;">
                กรุณารอรับเครื่องดื่มที่หน้าร้านเมื่อถึงคิวของคุณ<br>
                ระบบกำลังเตรียมเครื่องดื่มอย่างสุดฝีมือครับ ☕
            </p>
        </div>
        
        <div class="card-footer" style="background: #fff; padding: 1.5rem; border-top: 1px solid var(--beige);">
            <a href="{{ route('home') }}" class="btn-primary" style="display: inline-block; padding: 0.8rem 2rem; border-radius: 100px; font-weight: 500; transition: all 0.2s;">
                กลับสู่หน้าหลัก
            </a>
        </div>
    </div>
</div>
@endsection
