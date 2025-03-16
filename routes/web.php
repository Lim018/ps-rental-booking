<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\MidtransCallbackController;
use App\Http\Controllers\AdminController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

// Booking routes
Route::get('/booking', [BookingController::class, 'index'])->name('booking.index');
Route::get('/booking/create', [BookingController::class, 'create'])->name('booking.create');
Route::post('/booking', [BookingController::class, 'store'])->name('booking.store');
Route::get('/booking/{booking}', [BookingController::class, 'show'])->name('booking.show');
Route::put('/booking/{booking}/cancel', [BookingController::class, 'cancel'])->name('booking.cancel');
Route::get('/check', [BookingController::class, 'check'])->name('check');
Route::post('/find-by-phone', [BookingController::class, 'findByPhone'])->name('find-by-phone');
Route::post('/find-by-id', [BookingController::class, 'findById'])->name('find-by-id');
Route::get('/booking/{booking}/download-pdf', [BookingController::class, 'downloadPdf'])->name('booking.download-pdf');

// Checkout routes
Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
Route::get('/checkout/{booking}/process', [CheckoutController::class, 'process'])->name('checkout.process');
Route::get('/checkout/{booking}', [CheckoutController::class, 'show'])->name('checkout.show');
Route::get('/checkout/{booking}/success', [CheckoutController::class, 'success'])->name('checkout.success');
Route::get('/checkout/{booking}/failed', [CheckoutController::class, 'failed'])->name('checkout.failed');

// Midtrans callback
Route::post('/midtrans/callback', [MidtransCallbackController::class, 'handle'])->name('midtrans.callback');

// Admin routes
Route::get('/admin/validate-booking', [AdminController::class, 'validateBooking'])->name('admin.validate-booking');
Route::post('/admin/validate-booking', [AdminController::class, 'validateBookingPost']);
Route::put('/admin/mark-as-used/{booking}', [AdminController::class, 'markAsUsed'])->name('admin.mark-as-used');

