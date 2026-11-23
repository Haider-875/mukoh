<?php

use App\Http\Controllers\Admin\AppointmentController as AdminAppointmentController;
use App\Http\Controllers\Admin\AuthController as AdminAuthController;
use App\Http\Controllers\Admin\ContentController as AdminContentController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\InquiryController as AdminInquiryController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\ServiceController as AdminServiceController;
use App\Http\Controllers\Admin\SettingsController as AdminSettingsController;
use App\Http\Controllers\Admin\TestimonialController as AdminTestimonialController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InquiryController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\TireController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public Frontend Routes
|--------------------------------------------------------------------------
*/

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/tires', [TireController::class, 'index'])->name('tires');
Route::get('/services', [ServiceController::class, 'index'])->name('services');
Route::get('/about', [PageController::class, 'about'])->name('about');
Route::get('/contact', [ContactController::class, 'index'])->name('contact');
Route::get('/privacy', [PageController::class, 'privacy'])->name('privacy');
Route::get('/privacy-policy', [PageController::class, 'privacy'])->name('privacy-policy');
Route::get('/terms', [PageController::class, 'terms'])->name('terms');
Route::get('/terms-of-service', [PageController::class, 'terms'])->name('terms-of-service');
Route::get('/sitemap.xml', [PageController::class, 'sitemap'])->name('sitemap');

// Public Form Submissions (AJAX & Standard)
Route::post('/contact/appointment', [ContactController::class, 'storeAppointment'])->name('contact.appointment');
Route::post('/inquiry/contact', [InquiryController::class, 'storeContact'])->name('inquiry.contact');
Route::post('/inquiry/quote', [InquiryController::class, 'storeQuote'])->name('inquiry.quote');

// Legacy HTML redirects for compatibility
Route::permanentRedirect('/index.html', '/');
Route::permanentRedirect('/tires.html', '/tires');
Route::permanentRedirect('/services.html', '/services');
Route::permanentRedirect('/about.html', '/about');
Route::permanentRedirect('/contact.html', '/contact');
Route::permanentRedirect('/privacy.html', '/privacy');
Route::permanentRedirect('/terms.html', '/terms');

/*
|--------------------------------------------------------------------------
| Authentication Routes
|--------------------------------------------------------------------------
*/

Route::get('/login', [AdminAuthController::class, 'showLogin'])->name('login');
Route::get('/admin/login', [AdminAuthController::class, 'showLogin'])->name('admin.login');
Route::post('/login', [AdminAuthController::class, 'login'])->name('login.submit');
Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');

/*
|--------------------------------------------------------------------------
| Admin Panel Routes (Protected by auth + admin middleware)
|--------------------------------------------------------------------------
*/

Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    // Dashboard
    Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');

    // Products Management
    Route::resource('products', AdminProductController::class)->except(['show']);
    Route::match(['post', 'patch'], 'products/{product}/toggle', [AdminProductController::class, 'toggleStatus'])->name('products.toggle');

    // Services Management
    Route::resource('services', AdminServiceController::class)->except(['show']);
    Route::match(['post', 'patch'], 'services/{service}/toggle', [AdminServiceController::class, 'toggleStatus'])->name('services.toggle');

    // Inquiries Management
    Route::get('inquiries/export', [AdminInquiryController::class, 'exportCsv'])->name('inquiries.export');
    Route::resource('inquiries', AdminInquiryController::class)->only(['index', 'show', 'destroy']);
    Route::patch('inquiries/{inquiry}/status', [AdminInquiryController::class, 'updateStatus'])->name('inquiries.status');
    Route::patch('inquiries/{inquiry}/toggle-read', [AdminInquiryController::class, 'toggleRead'])->name('inquiries.toggle-read');

    // Appointments Management
    Route::get('appointments/export', [AdminAppointmentController::class, 'exportCsv'])->name('appointments.export');
    Route::resource('appointments', AdminAppointmentController::class)->only(['index', 'show', 'destroy']);
    Route::patch('appointments/{appointment}/status', [AdminAppointmentController::class, 'updateStatus'])->name('appointments.status');
    Route::patch('appointments/{appointment}/toggle-read', [AdminAppointmentController::class, 'toggleRead'])->name('appointments.toggle-read');

    // Testimonials Management
    Route::resource('testimonials', AdminTestimonialController::class)->except(['show']);
    Route::match(['post', 'patch'], 'testimonials/{testimonial}/toggle', [AdminTestimonialController::class, 'toggleStatus'])->name('testimonials.toggle');

    // Website Content Management
    Route::get('content', [AdminContentController::class, 'index'])->name('content.index');
    Route::match(['post', 'put'], 'content', [AdminContentController::class, 'update'])->name('content.update');

    // Settings (Profile & Password)
    Route::get('settings', [AdminSettingsController::class, 'index'])->name('settings.index');
    Route::put('settings/profile', [AdminSettingsController::class, 'updateProfile'])->name('settings.profile');
    Route::put('settings/password', [AdminSettingsController::class, 'updatePassword'])->name('settings.password');
});
