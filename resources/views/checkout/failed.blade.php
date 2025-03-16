@extends('layouts.app')

@section('title', 'Payment Failed')

@section('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/booking-details.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/checkout-failed.css') }}">
@endsection

@section('content')
    <div class="container py-5">
        <div class="failed-container">
            <div class="failed-icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="10"></circle>
                    <line x1="15" y1="9" x2="9" y2="15"></line>
                    <line x1="9" y1="9" x2="15" y2="15"></line>
                </svg>
            </div>
            
            <h1 class="mb-3">Payment Failed</h1>
            <p class="text-muted mb-4">We're sorry, but your payment could not be processed at this time.</p>
            <p>Booking ID: {{ $booking->id }}</p>
            
            <div class="mt-4">
                <a href="{{ route('checkout.process', $booking->id) }}" class="btn btn-primary">Try Again</a>
                <a href="{{ route('booking.index') }}" class="btn btn-outline ml-2">Return to Bookings</a>
            </div>
        </div>
    </div>
@endsection

