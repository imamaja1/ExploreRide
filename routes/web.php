<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\CustomerAuthController;
use App\Http\Controllers\Auth\AdminAuthController;
use App\Http\Controllers\Auth\DriverAuthController;
use App\Http\Controllers\Auth\GoogleSocialiteController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\CarController;
use App\Http\Controllers\Admin\DriverController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\BankController;
use App\Http\Controllers\Admin\BookingController;
use App\Http\Controllers\Admin\TourPackageController;
use App\Http\Controllers\Admin\DestinationController;
use App\Http\Controllers\Admin\DestinationCategoryController;
use App\Http\Controllers\Admin\TestimonialController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Driver\DashboardController as DriverDashboardController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\BookingController as FrontendBookingController;
use App\Http\Controllers\Frontend\TestimonialController as FrontendTestimonialController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\Frontend\SseController;

// ========== CUSTOMER AUTH ==========
Route::get('/login', [CustomerAuthController::class, 'showLogin'])->name('customer.login');
Route::post('/login', [CustomerAuthController::class, 'login'])->middleware('throttle:5,1');
Route::get('/register', [CustomerAuthController::class, 'showRegister'])->name('customer.register');
Route::post('/register', [CustomerAuthController::class, 'register'])->middleware('throttle:3,1');
Route::post('/logout', [CustomerAuthController::class, 'logout'])->name('customer.logout');

// Google OAuth
Route::get('/auth/google', [GoogleSocialiteController::class, 'redirect'])->name('customer.google.login');
Route::get('/auth/google/callback', [GoogleSocialiteController::class, 'callback']);

// ========== LANGUAGE ==========
Route::get('/lang/{locale}', [LanguageController::class, 'switch'])->name('lang.switch');

// ========== FRONTEND (CUSTOMER) ==========
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/cars', [HomeController::class, 'cars'])->name('cars');
Route::get('/packages', [HomeController::class, 'packages'])->name('packages');
Route::get('/car/{id}', [HomeController::class, 'carDetail'])->name('car.detail');
Route::get('/package/{slug}', [HomeController::class, 'packageDetail'])->name('package.detail');
Route::get('/destinasi/kategori/{category}', [HomeController::class, 'destinationsByCategory'])->name('destinations.category');
Route::get('/destinasi/{slug}', [HomeController::class, 'destinationDetail'])->name('destination.detail');

Route::post('/testimonials', [FrontendTestimonialController::class, 'store'])->name('testimonials.store')->middleware('throttle:5,1');

Route::middleware(['customer.auth'])->group(function () {
    Route::get('/booking', [FrontendBookingController::class, 'create'])->name('booking.create');
    Route::post('/booking', [FrontendBookingController::class, 'store'])->name('booking.store');
    Route::get('/booking/{id}/payment', [FrontendBookingController::class, 'payment'])->name('booking.payment');
    Route::post('/booking/{id}/payment', [FrontendBookingController::class, 'uploadPayment'])->name('booking.payment.upload');
    Route::get('/booking/{id}', [FrontendBookingController::class, 'detail'])->name('booking.detail');
    Route::get('/bookings', [FrontendBookingController::class, 'myBookings'])->name('booking.my');
});

// ========== SSE ==========
Route::middleware(['customer.auth'])->group(function () {
    Route::get('/sse/booking/{id}', [SseController::class, 'stream'])->name('sse.booking');
});

// ========== ADMIN AUTH ==========
Route::get('/admin/login', [AdminAuthController::class, 'showLogin'])->name('admin.login');
Route::post('/admin/login', [AdminAuthController::class, 'login'])->middleware('throttle:5,1');
Route::post('/admin/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');

// ========== ADMIN PANEL ==========
Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    Route::resource('cars', CarController::class);
    Route::resource('drivers', DriverController::class);
    Route::resource('services', ServiceController::class)->only(['index', 'edit', 'update']);
    Route::resource('banks', BankController::class);
    Route::resource('tour-packages', TourPackageController::class);
    Route::resource('destinations', DestinationController::class);
    Route::resource('destination-categories', DestinationCategoryController::class)->except(['show']);
    Route::post('destination-categories/{category}/toggle', [DestinationCategoryController::class, 'toggle'])->name('destination-categories.toggle');
    Route::resource('testimonials', TestimonialController::class);

    Route::get('settings', [SettingController::class, 'index'])->name('settings.index');
    Route::put('settings', [SettingController::class, 'update'])->name('settings.update');

    Route::get('bookings', [BookingController::class, 'index'])->name('bookings.index');
    Route::get('bookings/{id}', [BookingController::class, 'show'])->name('bookings.show');
    Route::post('bookings/{id}/confirm-payment', [BookingController::class, 'confirmPayment'])->name('bookings.confirm-payment');
    Route::post('bookings/{id}/assign-driver', [BookingController::class, 'assignDriver'])->name('bookings.assign-driver');
    Route::post('bookings/{id}/cancel', [BookingController::class, 'cancel'])->name('bookings.cancel');
});

// ========== DRIVER AUTH ==========
Route::get('/driver/login', [DriverAuthController::class, 'showLogin'])->name('driver.login');
Route::post('/driver/login', [DriverAuthController::class, 'login'])->middleware('throttle:5,1');
Route::post('/driver/logout', [DriverAuthController::class, 'logout'])->name('driver.logout');

// ========== DRIVER PANEL ==========
Route::prefix('driver')->name('driver.')->middleware(['auth', 'driver'])->group(function () {
    Route::get('/dashboard', [DriverDashboardController::class, 'index'])->name('dashboard');
    Route::get('/bookings', [DriverDashboardController::class, 'bookings'])->name('bookings');
    Route::post('/bookings/{id}/status', [DriverDashboardController::class, 'updateStatus'])->name('bookings.status');
});
