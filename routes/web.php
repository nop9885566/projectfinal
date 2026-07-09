<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

// หน้าเว็บหลัก
Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/menu', function () {
    $products = \App\Models\Product::where('is_available', true)->get();
    return view('menu', compact('products'));
})->name('menu');


// ลูกค้า Login แล้วใช้ได้
Route::middleware(['auth'])->group(function () {
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
});

// ลูกค้าทั่วไป (ไม่ต้อง Login) ก็สั่งซื้อได้
Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');
Route::get('/orders/{order}/payment', [OrderController::class, 'payment'])->name('orders.payment');
Route::post('/orders/{order}/payment', [OrderController::class, 'uploadSlip'])->name('orders.uploadSlip');
Route::post('/orders/{order}/pay-later', [OrderController::class, 'payLater'])->name('orders.payLater');
Route::get('/orders/{order}/queue', [OrderController::class, 'queue'])->name('orders.queue');

// พนักงาน + Admin (แดชบอร์ดและการจัดการเมนู)
Route::middleware(['auth', 'role:staff,admin'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('/dashboard/products', ProductController::class);
});

// Admin เท่านั้น (จัดการออเดอร์หลังบ้าน)
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/dashboard/orders', [OrderController::class, 'manage'])->name('orders.manage');
    Route::patch('/dashboard/orders/{order}', [OrderController::class, 'updateStatus'])->name('orders.updateStatus');
    Route::delete('/dashboard/orders/{order}', [OrderController::class, 'destroy'])->name('orders.destroy');
});

// Profile
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';