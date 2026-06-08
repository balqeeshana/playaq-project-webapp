<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfessionalController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ChatController;

// Public Routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/supplier-partnerships', function () {
    return view('supplier-partnerships');
})->name('suppliers');

// Guest Authentication Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

// Authenticated Routes
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Customer Profile Routes
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update');

    // Instant Booking Route
    Route::get('/instant-booking', [BookingController::class, 'showInstantBookingForm'])->name('bookings.instant');

    // Chat / Message Routes
    Route::get('/chat/{receiver_id}', [ChatController::class, 'show'])->name('chat.show');
    Route::post('/chat/send', [ChatController::class, 'send'])->name('chat.send');

    // Customer Routes
    Route::get('/dashboard', [BookingController::class, 'customerDashboard'])->name('customer.dashboard');
    Route::get('/bookings/create', [BookingController::class, 'create'])->name('bookings.create');
    Route::post('/bookings', [BookingController::class, 'store'])->name('bookings.store');
    Route::get('/bookings/{id}/pay-balance', [BookingController::class, 'showPayBalanceForm'])->name('bookings.pay-balance');
    Route::post('/bookings/{id}/pay-balance', [BookingController::class, 'payBalance'])->name('bookings.pay-balance.submit');
    Route::post('/bookings/{id}/rate', [BookingController::class, 'rateBooking'])->name('bookings.rate');

    // Professional Routes
    Route::get('/pro/dashboard', [ProfessionalController::class, 'index'])->name('pro.dashboard');
    Route::post('/pro/profile/update', [ProfessionalController::class, 'updateProfile'])->name('pro.profile.update');
    Route::post('/pro/services/add', [ProfessionalController::class, 'addService'])->name('pro.services.add');
    Route::delete('/pro/services/{id}/delete', [ProfessionalController::class, 'deleteService'])->name('pro.services.delete');
    Route::post('/pro/bookings/{id}/accept', [BookingController::class, 'acceptBooking'])->name('pro.bookings.accept');
    Route::post('/pro/withdraw', [ProfessionalController::class, 'withdraw'])->name('pro.withdraw');
    Route::post('/pro/certificate/upload', [ProfessionalController::class, 'uploadCertificate'])->name('pro.certificate.upload');
});
