<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\AdminLoginController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\CalendarController;
use App\Http\Controllers\Admin\BlogController as AdminBlogController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\ServiceItemController;
use App\Http\Controllers\Admin\PricingPlanController;
use App\Http\Controllers\Admin\SchedulingController;
use App\Http\Controllers\BlogController;
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

// صفحه لیست خدمات
Route::get('/services', [App\Http\Controllers\ServiceController::class, 'index'])->name('services');

// صفحه جزئیات خدمت (لیست میزها)
Route::get('/services/{id}', [App\Http\Controllers\ServiceController::class, 'show'])->name('services.show');

// صفحه رزرو (جدول شیفت‌ها)
Route::get('/services/{serviceId}/items/{itemId}', [App\Http\Controllers\ServiceController::class, 'reserve'])->name('services.reserve');

Route::get('/contact', function () {
    return view('contact');
})->name('contact');

Route::get('/invoice', function () {
    return view('invoice');
})->name('invoice');

// ============================================================
// 📝 بلاگ عمومی
// ============================================================
Route::get('/blog', [BlogController::class, 'index'])->name('blog');
Route::get('/blog/search', [BlogController::class, 'search'])->name('blog.search');
Route::get('/blog/category/{slug}', [BlogController::class, 'category'])->name('blog.category');
Route::get('/blog/{id}', [BlogController::class, 'show'])->name('blog.post');

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
    // 🗓️ تقویم
    // ============================================================
    Route::prefix('calendar')->name('calendar.')->group(function () {
        Route::get('/', [CalendarController::class, 'index'])->name('index');
        Route::get('/api/month', [CalendarController::class, 'getMonthEvents'])->name('api.month');
        Route::get('/api/day', [CalendarController::class, 'getDayEvents'])->name('api.day');
        Route::post('/store', [CalendarController::class, 'store'])->name('store');
        Route::post('/store-month', [CalendarController::class, 'storeMonth'])->name('store-month');
        Route::get('/{id}/edit', [CalendarController::class, 'edit'])->name('edit');
        Route::put('/{id}', [CalendarController::class, 'update'])->name('update');
        Route::delete('/{id}', [CalendarController::class, 'destroy'])->name('destroy');
        Route::delete('/{id}/force', [CalendarController::class, 'forceDelete'])->name('force-delete');
        Route::post('/{id}/toggle-holiday', [CalendarController::class, 'toggleHoliday'])->name('toggle-holiday');
    });

    // ============================================================
    // 📝 مدیریت بلاگ (پنل ادمین)
    // ============================================================
    Route::prefix('blog')->name('blog.')->group(function () {

        Route::get('/', [AdminBlogController::class, 'index'])->name('dashboard');
        Route::get('/dashboard', [AdminBlogController::class, 'index'])->name('dashboard.index');
        Route::get('/index', [AdminBlogController::class, 'index'])->name('index');

        Route::get('/posts', [AdminBlogController::class, 'posts'])->name('posts');
        Route::get('/create', [AdminBlogController::class, 'create'])->name('create');
        Route::post('/store', [AdminBlogController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [AdminBlogController::class, 'edit'])->name('edit');
        Route::put('/{id}', [AdminBlogController::class, 'update'])->name('update');
        Route::delete('/{id}', [AdminBlogController::class, 'destroy'])->name('destroy');
        Route::delete('/{id}/force', [AdminBlogController::class, 'forceDelete'])->name('force-delete');
        Route::post('/{id}/toggle-status', [AdminBlogController::class, 'toggleStatus'])->name('toggle-status');
        Route::post('/{id}/toggle-featured', [AdminBlogController::class, 'toggleFeatured'])->name('toggle-featured');

        Route::prefix('categories')->name('categories.')->group(function () {
            Route::get('/', [AdminBlogController::class, 'categories'])->name('index');
            Route::get('/create', [AdminBlogController::class, 'createCategory'])->name('create');
            Route::post('/store', [AdminBlogController::class, 'storeCategory'])->name('store');
            Route::get('/{id}/edit', [AdminBlogController::class, 'editCategory'])->name('edit');
            Route::put('/{id}', [AdminBlogController::class, 'updateCategory'])->name('update');
            Route::delete('/{id}', [AdminBlogController::class, 'deleteCategory'])->name('destroy');
        });

        Route::prefix('tags')->name('tags.')->group(function () {
            Route::get('/', [AdminBlogController::class, 'tags'])->name('index');
        });

        Route::prefix('comments')->name('comments.')->group(function () {
            Route::get('/', [AdminBlogController::class, 'comments'])->name('index');
            Route::post('/{id}/approve', [AdminBlogController::class, 'approveComment'])->name('approve');
            Route::post('/{id}/reject', [AdminBlogController::class, 'rejectComment'])->name('reject');
            Route::delete('/{id}', [AdminBlogController::class, 'deleteComment'])->name('destroy');
            Route::delete('/{id}/force', [AdminBlogController::class, 'forceDeleteComment'])->name('force-delete');
        });

    });

    // ============================================================
    // 🔧 مدیریت خدمات
    // ============================================================
    Route::prefix('services')->name('services.')->group(function () {
        Route::get('/', [ServiceController::class, 'index'])->name('index');
        Route::get('/{id}/edit', [ServiceController::class, 'edit'])->name('edit');
        Route::put('/{id}', [ServiceController::class, 'update'])->name('update');
        Route::post('/{id}/toggle-status', [ServiceController::class, 'toggleStatus'])->name('toggle-status');
    });

    // ============================================================
    // 📋 مدیریت آیتم‌های خدمات
    // ============================================================
    Route::prefix('service-items')->name('service-items.')->group(function () {
        Route::get('/{serviceId}', [ServiceItemController::class, 'index'])->name('index');
        Route::post('/{serviceId}/store', [ServiceItemController::class, 'store'])->name('store');
        Route::get('/{serviceId}/{id}/edit', [ServiceItemController::class, 'edit'])->name('edit');
        Route::put('/{serviceId}/{id}', [ServiceItemController::class, 'update'])->name('update');
        Route::post('/{serviceId}/{id}/toggle-status', [ServiceItemController::class, 'toggleStatus'])->name('toggle-status');
        Route::delete('/{serviceId}/{id}', [ServiceItemController::class, 'destroy'])->name('destroy');
        Route::post('/{serviceId}/reorder', [ServiceItemController::class, 'reorder'])->name('reorder');
    });

    // ============================================================
    // 💰 مدیریت قیمت‌گذاری
    // ============================================================
    Route::prefix('pricing-plans')->name('pricing-plans.')->group(function () {
        Route::get('/{serviceId}', [PricingPlanController::class, 'index'])->name('index');
        Route::post('/{serviceId}/store', [PricingPlanController::class, 'store'])->name('store');
        Route::put('/{serviceId}/{id}', [PricingPlanController::class, 'update'])->name('update');
        Route::post('/{serviceId}/{id}/toggle-status', [PricingPlanController::class, 'toggleStatus'])->name('toggle-status');
        Route::delete('/{serviceId}/{id}', [PricingPlanController::class, 'destroy'])->name('destroy');
        Route::post('/{serviceId}/{id}/set-default', [PricingPlanController::class, 'setDefault'])->name('set-default');
    });

    // ============================================================
    // 📅 مدیریت رزروها
    // ============================================================
    Route::prefix('reservations')->name('reservations.')->group(function () {
        Route::get('/', [ServiceController::class, 'reservations'])->name('index');
        Route::post('/{id}/status', [ServiceController::class, 'updateReservationStatus'])->name('status');
        Route::delete('/{id}', [ServiceController::class, 'deleteReservation'])->name('destroy');
    });

    // ============================================================
    // 🕐 مدیریت زمان‌بندی (Scheduling)
    // ============================================================
    Route::prefix('scheduling')->name('scheduling.')->group(function () {
        Route::get('/', [SchedulingController::class, 'index'])->name('index');
        Route::get('/create', [SchedulingController::class, 'create'])->name('create');
        Route::post('/store', [SchedulingController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [SchedulingController::class, 'edit'])->name('edit');
        Route::put('/{id}', [SchedulingController::class, 'update'])->name('update');
        Route::post('/{id}/toggle-status', [SchedulingController::class, 'toggleStatus'])->name('toggle-status');
        Route::delete('/{id}', [SchedulingController::class, 'destroy'])->name('destroy');
    });

});


Route::get('/admin/calendar', [CalendarController::class, 'index'])
    ->name('admin.calendar')
    ->middleware(['auth:admin']);

// Scheduling Routes (Admin)
Route::prefix('admin')->middleware(['auth:admin'])->group(function () {
    Route::get('/scheduling', [App\Http\Controllers\Admin\SchedulingController::class, 'index'])
        ->name('admin.scheduling.index');
    Route::get('/scheduling/create', [App\Http\Controllers\Admin\SchedulingController::class, 'create'])
        ->name('admin.scheduling.create');
    Route::post('/scheduling', [App\Http\Controllers\Admin\SchedulingController::class, 'store'])
        ->name('admin.scheduling.store');
    Route::get('/scheduling/{id}/edit', [App\Http\Controllers\Admin\SchedulingController::class, 'edit'])
        ->name('admin.scheduling.edit');
    Route::put('/scheduling/{id}', [App\Http\Controllers\Admin\SchedulingController::class, 'update'])
        ->name('admin.scheduling.update');
    Route::post('/scheduling/{id}/toggle-status', [App\Http\Controllers\Admin\SchedulingController::class, 'toggleStatus'])
        ->name('admin.scheduling.toggle-status');
    Route::delete('/scheduling/{id}', [App\Http\Controllers\Admin\SchedulingController::class, 'destroy'])
        ->name('admin.scheduling.destroy');
});