<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\Admin\ReviewManagementController;
use App\Http\Controllers\CatalogController;
use App\Http\Controllers\Admin\ProductManagementController;
use App\Http\Controllers\Admin\ProductCategoryController;
use App\Http\Controllers\PromotionController;
use App\Http\Controllers\Admin\PromotionManagementController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\QrController;
use App\Http\Controllers\SeoController;
use App\Http\Controllers\Admin\AccountController;

Route::get('/', [HomeController::class, 'index'])->name('home'); // sementara, nanti jadi homepage

Route::get('/ulasan', [ReviewController::class, 'create'])->name('review.create');
Route::post('/ulasan', [ReviewController::class, 'store'])
    ->middleware('throttle:5,1')
    ->name('review.store');
Route::get('/ulasan/berhasil', [ReviewController::class, 'success'])->name('review.success');
Route::get('/riwayat', [ReviewController::class, 'history'])
    ->middleware('throttle:20,1')
    ->name('review.history');

    Route::get('/produk', [CatalogController::class, 'index'])->name('catalog.index');

    Route::get('/promo', [PromotionController::class, 'index'])->name('promo.index');

    Route::view('/tentang', 'about')->name('about');

    Route::get('/sitemap.xml', [SeoController::class, 'sitemap']);
Route::get('/robots.txt', [SeoController::class, 'robots']);




    Route::middleware('auth')->get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::middleware('auth')->prefix('admin')->name('admin.')->group(function () {
        Route::redirect('/', '/dashboard');
Route::get('/qr', [QrController::class, 'index'])->name('qr');
        Route::resource('produk', ProductManagementController::class)
    ->except('show')
    ->parameters(['produk' => 'product'])
    ->names('products');
Route::patch('/produk/{product}/toggle', [ProductManagementController::class, 'toggle'])->name('products.toggle');

Route::get('/kategori', [ProductCategoryController::class, 'index'])->name('categories.index');
Route::post('/kategori', [ProductCategoryController::class, 'store'])->name('categories.store');
Route::delete('/kategori/{category}', [ProductCategoryController::class, 'destroy'])->name('categories.destroy');
Route::resource('promo', PromotionManagementController::class)
    ->parameters(['promo' => 'promotion'])
    ->names('promotions');
Route::patch('/promo/{promotion}/toggle', [PromotionManagementController::class, 'toggle'])->name('promotions.toggle');
    Route::get('/ulasan', [ReviewManagementController::class, 'index'])->name('reviews.index');
    Route::get('/ulasan/{review}', [ReviewManagementController::class, 'show'])->name('reviews.show');
    Route::post('/ulasan/{review}/balas', [ReviewManagementController::class, 'reply'])->name('reviews.reply');
    Route::patch('/ulasan/{review}/status', [ReviewManagementController::class, 'updateStatus'])->name('reviews.status');
    Route::delete('/ulasan/{review}', [ReviewManagementController::class, 'destroy'])->name('reviews.destroy');

    Route::get('/pengaturan/usaha', [SettingController::class, 'usaha'])->name('settings.usaha');
Route::put('/pengaturan/usaha', [SettingController::class, 'updateUsaha'])->name('settings.usaha.update');

Route::get('/pengaturan/homepage', [SettingController::class, 'homepage'])->name('settings.homepage');
Route::put('/pengaturan/homepage', [SettingController::class, 'updateHomepage'])->name('settings.homepage.update');

Route::get('/pengaturan/branding', [SettingController::class, 'branding'])->name('settings.branding');
Route::put('/pengaturan/branding', [SettingController::class, 'updateBranding'])->name('settings.branding.update');

Route::get('/akun', [AccountController::class, 'edit'])->name('account');
Route::put('/akun/profil', [AccountController::class, 'updateProfile'])->name('account.profile');
Route::put('/akun/password', [AccountController::class, 'updatePassword'])->name('account.password');
});

require __DIR__.'/auth.php';
