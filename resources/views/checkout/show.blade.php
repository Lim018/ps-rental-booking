@extends('layouts.app')

@section('title', 'Checkout')

@section('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/booking-details.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/checkout-details.css') }}">
@endsection

@section('content')
    <div class="container py-5">
        <div class="checkout-container">
            <h1 class="page-title text-center mb-4">Checkout</h1>
            
            <div class="order-summary">
                <h4 class="mb-4">Order Summary</h4>
                
                <div class="summary-item">
                    <span>Service:</span>
                    <span>{{ $booking->service->name }}</span>
                </div>
                
                <div class="summary-item">
                    <span>Date:</span>
                    <span>{{ \Carbon\Carbon::parse($booking->booking_date)->format('d F Y') }}</span>
                </div>
                
                <div class="summary-item">
                    <span>Time:</span>
                    <span>{{ $booking->session_time }}</span>
                </div>
                
                <div class="summary-item">
                    <span>Base Price:</span>
                    <span>Rp {{ number_format($booking->base_price, 0, ',', '.') }}</span>
                </div>
                
                @if($booking->weekend_surcharge > 0)
                    <div class="summary-item">
                        <span>Weekend Surcharge:</span>
                        <span>Rp {{ number_format($booking->weekend_surcharge, 0, ',', '.') }}</span>
                    </div>
                @endif
                
                <div class="summary-total">
                    <span>Total:</span>
                    <span>Rp {{ number_format($booking->total_price, 0, ',', '.') }}</span>
                </div>
            </div>
            
            <div class="payment-card">
                <h4 class="mb-4">Payment</h4>
                <p>Click the button below to proceed with payment via Midtrans.</p>
                <button id="pay-button" class="mt-3">Pay Now</button>
            </div>
        </div>
    </div>

    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('services.midtrans.client_key') }}"></script>
    <script>
        const payButton = document.querySelector('#pay-button');
        payButton.addEventListener('click', function(e) {
            e.preventDefault();

            snap.pay('{{ $booking->payment_token }}', {
                onSuccess: function(result) {
                    window.location.href = '{{ route("checkout.success", $booking->id) }}';
                },
                onPending: function(result) {
                    alert('Payment pending, please complete your payment');
                },
                onError: function(result) {
                    window.location.href = '{{ route("checkout.failed", $booking->id) }}';
                },
                onClose: function() {
                    alert('You closed the payment window without completing the payment');
                }
            });
        });
    </script>
@endsection

