@extends('layouts.app')

@section('title', 'Payment Successful')

@section('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/booking-details.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/checkout-success.css') }}">
@endsection

@section('content')
    <div class="container py-5">
        <div class="success-container">
            <div class="success-icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                    <polyline points="22 4 12 14.01 9 11.01"></polyline>
                </svg>
            </div>
            
            <h1 class="mb-3">Payment Successful</h1>
            <p class="text-muted">Thank you for your booking. Your payment has been processed successfully.</p>
            
            <div class="booking-details">
                <h4 class="mb-3">Booking Details</h4>
                
                <div class="detail-item">
                    <span>Booking ID:</span>
                    <span>{{ $booking->id }}</span>
                </div>
                
                <div class="detail-item">
                    <span>Service:</span>
                    <span>{{ $booking->service->name }}</span>
                </div>
                
                <div class="detail-item">
                    <span>Date:</span>
                    <span>{{ \Carbon\Carbon::parse($booking->booking_date)->format('d F Y') }}</span>
                </div>
                
                <div class="detail-item">
                    <span>Time:</span>
                    <span>{{ $booking->session_time }}</span>
                </div>
                
                <div class="detail-item">
                    <span>Total Amount:</span>
                    <span>Rp {{ number_format($booking->total_price, 0, ',', '.') }}</span>
                </div>
            </div>
            
            <p>A confirmation with booking details has been sent to your phone.</p>
            
            <div class="mt-4">
                <a href="{{ route('booking.download-pdf', $booking->id) }}" class="btn btn-primary">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-2">
                        <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                        <polyline points="7 10 12 15 17 10"></polyline>
                        <line x1="12" y1="15" x2="12" y2="3"></line>
                    </svg>
                    Download Booking PDF
                </a>
                <a href="{{ route('booking.create') }}" class="btn btn-outline ml-2">Return to Bookings</a>
            </div>
        </div>
    </div>
@endsection

