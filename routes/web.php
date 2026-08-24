<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;

// ============================================================
// صفحات عمومی (HTML های شما به صورت Blade)
// ============================================================

Route::get('/', function () {
    return view('index');
})->name('home');

Route::get('/about', function () {
    return view('about');
})->name('about');

Route::get('/services', function () {
    return view('services');
})->name('services');

Route::get('/blog', function () {
    return view('blog');
})->name('blog');

Route::get('/blog/{id}', function ($id) {
    return view('blog-post', ['id' => $id]);
})->name('blog.post');

Route::get('/contact', function () {
    return view('contact');
})->name('contact');

Route::get('/invoice', function () {
    return view('invoice');
})->name('invoice');

// ============================================================
// لاگین و احراز هویت
// ============================================================

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// ============================================================
// داشبورد (نیاز به لاگین)
// ============================================================

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware('auth')->name('dashboard');

// ============================================================
// پنل ادمین (نیاز به لاگین + ادمین بودن)
// ============================================================

Route::get('/admin', function () {
    return view('paneladmin,logi');
})->middleware('auth')->name('admin');

// ============================================================
// API رزرو (اختیاری)
// ============================================================

Route::post('/reserve', function () {
    // منطق رزرو میز
    return response()->json(['message' => 'رزرو با موفقیت انجام شد']);
})->middleware('auth')->name('reserve');
// ===== پنل ادمین (نیاز به لاگین + ادمین بودن) =====
Route::get('/admin', function () {
    return view('paneladmin');
})->middleware(['auth'])->name('admin');
