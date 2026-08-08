<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\BookingController;
use App\Http\Controllers\Admin\RoomTypeController;
use App\Http\Controllers\Admin\RoomController;
use App\Http\Controllers\Admin\GuestController;
use App\Http\Controllers\Admin\StaffController;
use App\Http\Controllers\Admin\BlogController;
use App\Http\Controllers\Admin\ReviewController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\ResetPasswordController;

Route::get('/', [PageController::class, 'home'])->name('home');
Route::get('/about', [PageController::class, 'about'])->name('about');
Route::get('/rooms', [PageController::class, 'rooms'])->name('rooms');
Route::get('/blog', [PageController::class, 'blog'])->name('blog');
Route::get('/blog/{slug}', [PageController::class, 'blogDetails'])->name('blog.details');
Route::get('/contact', [PageController::class, 'showContactForm'])->name('contact');
Route::post('/contact', [PageController::class, 'submitContactForm'])->name('contact.submit');
Route::get('/rooms/{slug}', [PageController::class, 'roomDetails'])->name('room.details');
Route::post('/rooms/{slug}/reviews', [PageController::class, 'submitReview'])->name('room.review.submit');
Route::get('/room_details/{slug}', fn ($slug) => redirect()->route('room.details', $slug));

// Forgot password routes (generic for any user)
Route::get('forgot-password', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');

// Reset password routes
Route::get('reset-password/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('reset-password', [ResetPasswordController::class, 'reset'])->name('password.update');

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
Route::post('/register', [AuthController::class, 'register'])->name('register.submit');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/gallery', [PageController::class, 'gallery'])->name('gallery');

Route::middleware(['auth'])->group(function () {
    Route::post('/booking', [BookController::class, 'store'])->name('booking.submit');
    Route::get('/profile', [PageController::class, 'profile'])->name('profile.index');
    Route::put('/profile', [PageController::class, 'updateProfile'])->name('profile.update');
});

//Admin logn routes
Route::prefix('admin')->as('admin.')->group(function (){
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
    Route::get('/forgot-password', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
    Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
    Route::get('/reset-password/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
    Route::post('/reset-password', [ResetPasswordController::class, 'reset'])->name('password.update');
});

Route::prefix('admin')->as('admin.')->middleware(['auth'])->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');
    Route::get('/message', [DashboardController::class, 'message'])->name('message.index');
    Route::get('/message/{contact}', [DashboardController::class, 'messageShow'])->name('message.show');
    Route::get('/message/{contact}/edit', [DashboardController::class, 'messageEdit'])->name('message.edit');
    Route::put('/message/{contact}', [DashboardController::class, 'messageUpdate'])->name('message.update');
    Route::delete('/message/{contact}', [DashboardController::class, 'messageDestroy'])->name('message.destroy');

    Route::get('/gallery', [DashboardController::class, 'galleryIndex'])->name('gallery.index');
    Route::get('/gallery/create', [DashboardController::class, 'galleryCreate'])->name('gallery.create');
    Route::post('/gallery/store', [DashboardController::class, 'galleryStore'])->name('gallery.store');
    Route::get('/gallery/{gallery}/edit', [DashboardController::class, 'galleryEdit'])->name('gallery.edit');
    Route::put('/gallery/{gallery}', [DashboardController::class, 'galleryUpdate'])->name('gallery.update');
    Route::delete('/gallery/{gallery}', [DashboardController::class, 'galleryDestroy'])->name('gallery.destroy');

    Route::get('/booking/approve/{id}/{model?}', [BookingController::class, 'approve'])->name('booking.approve');
    Route::get('/booking/reject/{id}/{model?}', [BookingController::class, 'reject'])->name('booking.reject');
    Route::get('/booking/complete/{id}/{model?}', [BookingController::class, 'complete'])->name('booking.complete');

    Route::resource('booking', BookingController::class);

    Route::resource('room-types', RoomTypeController::class);
    Route::delete('room-type-images/{image}', [RoomTypeController::class, 'destroyImage'])->name('room-type-images.destroy');

    Route::resource('rooms', RoomController::class);
    Route::delete('room-images/{image}', [RoomController::class, 'destroyImage'])->name('room-images.destroy');

    Route::resource('blogs', BlogController::class);

    Route::resource('guest', GuestController::class);
    Route::resource('staff', StaffController::class);

    Route::post('reviews/{review}/approve', [ReviewController::class, 'approve'])->name('reviews.approve');
    Route::resource('reviews', ReviewController::class)->only(['index', 'show', 'destroy']);
});