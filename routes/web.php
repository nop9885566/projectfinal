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

Route::get('/gallery', function () {
    return view('gallery');
})->name('gallery');

// ลูกค้า Login แล้วใช้ได้
Route::middleware(['auth'])->group(function () {
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');
});

// พนักงาน + Admin (แดชบอร์ดและการจัดการเมนู)
Route::middleware(['auth', 'role:staff,admin'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('/dashboard/products', ProductController::class);
});

// Admin เท่านั้น (จัดการออเดอร์หลังบ้าน)
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/dashboard/orders', [OrderController::class, 'manage'])->name('orders.manage');
    Route::patch('/dashboard/orders/{order}', [OrderController::class, 'updateStatus'])->name('orders.updateStatus');
});

// Profile
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';