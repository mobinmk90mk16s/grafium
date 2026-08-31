<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\AdminLoginController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\CalendarController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\ProfileController;

// ============================================================
// 📌 صفحات عمومی
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
// 🔐 لاگین کاربران عادی
// ============================================================

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// ============================================================
// 👤 پنل کاربری عادی
// ============================================================

Route::middleware(['auth'])->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::prefix('reservations')->name('reservations.')->group(function () {
        Route::get('/', [ReservationController::class, 'index'])->name('index');
        Route::get('/create', [ReservationController::class, 'create'])->name('create');
        Route::post('/store', [ReservationController::class, 'store'])->name('store');
        Route::get('/{id}', [ReservationController::class, 'show'])->name('show');
        Route::put('/{id}/cancel', [ReservationController::class, 'cancel'])->name('cancel');
        Route::delete('/{id}', [ReservationController::class, 'destroy'])->name('destroy');
    });

    Route::prefix('invoices')->name('invoices.')->group(function () {
        Route::get('/', [InvoiceController::class, 'index'])->name('index');
        Route::get('/{id}', [InvoiceController::class, 'show'])->name('show');
        Route::get('/{id}/download', [InvoiceController::class, 'download'])->name('download');
        Route::post('/{id}/pay', [InvoiceController::class, 'pay'])->name('pay');
    });

    Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('/', [ProfileController::class, 'edit'])->name('edit');
        Route::put('/', [ProfileController::class, 'update'])->name('update');
        Route::put('/password', [ProfileController::class, 'updatePassword'])->name('password');
    });

});

// ============================================================
// 🔐 لاگین ادمین
// ============================================================

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/login', [AdminLoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AdminLoginController::class, 'login']);
    Route::post('/logout', [AdminLoginController::class, 'logout'])->name('logout');
});

// ============================================================
// 🛡️ پنل ادمین
// ============================================================

Route::prefix('admin')->name('admin.')->middleware(['auth:admin'])->group(function () {

    // ===== اصلی =====
    Route::get('/', function () {
        return redirect()->route('admin.dashboard');
    });

    Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');

    // ===== مدیریت مدیران =====
    Route::prefix('admins')->name('admins.')->group(function () {
        Route::get('/', [AdminController::class, 'adminsList'])->name('index');
        Route::get('/create', [AdminController::class, 'create'])->name('create');
        Route::post('/', [AdminController::class, 'store'])->name('store');
        Route::get('/{id}', [AdminController::class, 'show'])->name('show');
        Route::get('/{id}/edit', [AdminController::class, 'edit'])->name('edit');
        Route::put('/{id}', [AdminController::class, 'update'])->name('update');
        Route::delete('/{id}', [AdminController::class, 'destroy'])->name('destroy');
    });

    // ===== مدیریت کاربران =====
    Route::prefix('users')->name('users.')->group(function () {
        Route::get('/', [AdminController::class, 'users'])->name('index');
        Route::get('/{id}', [AdminController::class, 'userShow'])->name('show');
        Route::put('/{id}/block', [AdminController::class, 'blockUser'])->name('block');
        Route::put('/{id}/unblock', [AdminController::class, 'unblockUser'])->name('unblock');
        Route::delete('/{id}', [AdminController::class, 'deleteUser'])->name('destroy');
    });

    // ===== مدیریت میزها =====
    Route::prefix('desks')->name('desks.')->group(function () {
        Route::get('/', [AdminController::class, 'desks'])->name('index');
        Route::get('/create', [AdminController::class, 'deskCreate'])->name('create');
        Route::post('/store', [AdminController::class, 'deskStore'])->name('store');
        Route::get('/{id}/edit', [AdminController::class, 'deskEdit'])->name('edit');
        Route::put('/{id}', [AdminController::class, 'deskUpdate'])->name('update');
        Route::delete('/{id}', [AdminController::class, 'deskDestroy'])->name('destroy');
    });

    // ===== مدیریت رزروها =====
    Route::prefix('reservations')->name('reservations.')->group(function () {
        Route::get('/', [AdminController::class, 'reservations'])->name('index');
        Route::put('/{id}/status', [AdminController::class, 'updateReservationStatus'])->name('status');
        Route::delete('/{id}', [AdminController::class, 'deleteReservation'])->name('destroy');
    });

    // ===== مدیریت فاکتورها =====
    Route::prefix('invoices')->name('invoices.')->group(function () {
        Route::get('/', [AdminController::class, 'invoices'])->name('index');
        Route::put('/{id}/status', [AdminController::class, 'updateInvoiceStatus'])->name('status');
        Route::delete('/{id}', [AdminController::class, 'deleteInvoice'])->name('destroy');
    });

    // ============================================================
    // 🗓️ تقویم (Calendar)
    // ============================================================
    Route::prefix('calendar')->name('calendar.')->group(function () {

        // صفحه اصلی تقویم
        Route::get('/', [CalendarController::class, 'index'])->name('index');

        // API دریافت رویدادهای ماه
        Route::get('/api/month', [CalendarController::class, 'getMonthEvents'])->name('api.month');

        // API دریافت رویدادهای روز
        Route::get('/api/day', [CalendarController::class, 'getDayEvents'])->name('api.day');

        // CRUD رویدادها
        Route::post('/store', [CalendarController::class, 'store'])->name('store');

        // افزودن ماه کامل
        Route::post('/store-month', [CalendarController::class, 'storeMonth'])->name('store-month');

        // ویرایش
        Route::get('/{id}/edit', [CalendarController::class, 'edit'])->name('edit');

        // به‌روزرسانی
        Route::put('/{id}', [CalendarController::class, 'update'])->name('update');

        // حذف (تبدیل به عادی)
        Route::delete('/{id}', [CalendarController::class, 'destroy'])->name('destroy');

        // حذف فیزیکی
        Route::delete('/{id}/force', [CalendarController::class, 'forceDelete'])->name('force-delete');

        // تغییر وضعیت تعطیلی
        Route::post('/{id}/toggle-holiday', [CalendarController::class, 'toggleHoliday'])->name('toggle-holiday');

    });

});

// ============================================================
// مسیر جایگزین برای تقویم
// ============================================================
Route::get('/admin/calendar', [CalendarController::class, 'index'])
    ->name('admin.calendar')
    ->middleware(['auth:admin']);