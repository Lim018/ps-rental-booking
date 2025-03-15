<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\MidtransCallbackController;
use App\Http\Controllers\AdminController;

Route::get('/', function () {
    return view('welcome');
});

// Booking routes
Route::get('/booking', [BookingController::class, 'index'])->name('booking.index');
Route::get('/booking/create', [BookingController::class, 'create'])->name('booking.create');
Route::post('/booking', [BookingController::class, 'store'])->name('booking.store');
Route::get('/booking/{booking}', [BookingController::class, 'show'])->name('booking.show');
Route::put('/booking/{booking}/cancel', [BookingController::class, 'cancel'])->name('booking.cancel');

// Check booking routes
Route::get('/check', [BookingController::class, 'check'])->name('check');
Route::post('/find-by-email', [BookingController::class, 'findByEmail'])->name('find-by-email');
Route::post('/find-by-id', [BookingController::class, 'findById'])->name('find-by-id');

// Admin routes
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/validate-booking', [AdminController::class, 'validateBooking'])->name('validate-booking');
    Route::post('/validate-booking', [AdminController::class, 'validateBookingPost'])->name('validate-booking');
    Route::put('/mark-as-used/{booking}', [AdminController::class, 'markAsUsed'])->name('mark-as-used');
});

Route::get('/my-bookings', [BookingController::class, 'userBookings'])->name('bookings.user');

// Midtrans callback
Route::post('/midtrans/callback', [MidtransCallbackController::class, 'handle'])->name('midtrans.callback');

// require __DIR__.'/auth.php';