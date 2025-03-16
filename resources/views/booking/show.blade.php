@extends('layouts.app')

@section('title', 'Booking Details')

@section('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/booking-details.css') }}">
@endsection

@section('scripts')
    <script src="{{ asset('assets/js/booking-details.js') }}" defer></script>
@endsection

@section('content')
    <div class="container">
        <div class="page-header">
            <h1 class="page-title">Booking Details</h1>
            <div class="page-actions">
                <a href="{{ route('booking.index') }}" class="btn btn-outline">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="btn-icon">
                        <line x1="19" y1="12" x2="5" y2="12"></line>
                        <polyline points="12 19 5 12 12 5"></polyline>
                    </svg>
                    Back to Bookings
                </a>
            </div>
        </div>

        <div class="booking-details-card">
            <div class="booking-header">
                <div class="booking-id">Booking #{{ $booking->id }}</div>
                <div class="booking-status">
                    <span class="status-badge status-{{ strtolower($booking->status) }}">{{ $booking->status }}</span>
                </div>
            </div>
            
            @if($booking->status == 'Paid')
                <div class="booking-qr-code">
                    <div class="qr-code-container">
                        <img src="data:image/png;base64,{{ $qrCode }}" alt="Booking QR Code">
                    </div>
                    <div class="qr-code-info">
                        <h3>Your Booking QR Code</h3>
                        <p>Present this QR code when you arrive for your session. Staff will scan it to validate your booking.</p>
                        <div class="validation-status">
                            <span class="status-badge status-{{ $booking->is_used ? 'used' : 'unused' }}">
                                {{ $booking->is_used ? 'Used' : 'Not Used Yet' }}
                            </span>
                        </div>
                        <div class="qr-code-actions">
                            <a href="{{ route('booking.download-pdf', $booking->id) }}" class="btn btn-primary">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="btn-icon">
                                    <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                                    <polyline points="7 10 12 15 17 10"></polyline>
                                    <line x1="12" y1="15" x2="12" y2="3"></line>
                                </svg>
                                Download PDF
                            </a>
                        </div>
                    </div>
                </div>
            @endif
            
            @if($booking->status == 'Paid')
                <div class="booking-success">
                    <div class="success-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                            <polyline points="22 4 12 14.01 9 11.01"></polyline>
                        </svg>
                    </div>
                    <div class="success-message">
                        <h3>Booking Confirmed!</h3>
                        <p>Your booking has been confirmed. Please arrive 10 minutes before your session time.</p>
                    </div>
                </div>
            @elseif($booking->status == 'Pending')
                <div class="booking-pending">
                    <div class="pending-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="12" r="10"></circle>
                            <polyline points="12 6 12 12 16 14"></polyline>
                        </svg>
                    </div>
                    <div class="pending-message">
                        <h3>Payment Pending</h3>
                        <p>Your booking is awaiting payment. Please complete the payment to confirm your booking.</p>
                        <a href="{{ $booking->payment_url }}" class="btn btn-primary">Complete Payment</a>
                    </div>
                </div>
            @elseif($booking->status == 'Cancelled')
                <div class="booking-cancelled">
                    <div class="cancelled-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="12" r="10"></circle>
                            <line x1="15" y1="9" x2="9" y2="15"></line>
                            <line x1="9" y1="9" x2="15" y2="15"></line>
                        </svg>
                    </div>
                    <div class="cancelled-message">
                        <h3>Booking Cancelled</h3>
                        <p>This booking has been cancelled. If you have any questions, please contact our support team.</p>
                    </div>
                </div>
            @endif
            
            <div class="booking-sections">
                <div class="booking-section">
                    <h3 class="section-title">Booking Information</h3>
                    <div class="booking-info">
                        <div class="info-item">
                            <div class="info-label">Service:</div>
                            <div class="info-value">{{ $booking->service->name }}</div>
                        </div>
                        <div class="info-item">
                            <div class="info-label">Date:</div>
                            <div class="info-value">{{ \Carbon\Carbon::parse($booking->booking_date)->format('l, F j, Y') }}</div>
                        </div>
                        <div class="info-item">
                            <div class="info-label">Time:</div>
                            <div class="info-value">{{ $booking->session_time }}</div>
                        </div>
                        <div class="info-item">
                            <div class="info-label">Booking Date:</div>
                            <div class="info-value">{{ $booking->created_at->format('M d, Y H:i') }}</div>
                        </div>
                        @if($booking->status == 'Paid')
                            <div class="info-item">
                                <div class="info-label">Validation Status:</div>
                                <div class="info-value">
                                    <span class="status-badge status-{{ $booking->is_used ? 'used' : 'unused' }}">
                                        {{ $booking->is_used ? 'Used' : 'Not Used Yet' }}
                                    </span>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
                
                <div class="booking-section">
                    <h3 class="section-title">Customer Information</h3>
                    <div class="booking-info">
                        <div class="info-item">
                            <div class="info-label">Name:</div>
                            <div class="info-value">{{ $booking->user_name }}</div>
                        </div>
                        <div class="info-item">
                            <div class="info-label">Phone:</div>
                            <div class="info-value">{{ $booking->user_phone }}</div>
                        </div>
                        @if($booking->notes)
                            <div class="info-item">
                                <div class="info-label">Notes:</div>
                                <div class="info-value">{{ $booking->notes }}</div>
                            </div>
                        @endif
                    </div>
                </div>
                
                <div class="booking-section">
                    <h3 class="section-title">Payment Information</h3>
                    <div class="booking-info">
                        <div class="info-item">
                            <div class="info-label">Base Price:</div>
                            <div class="info-value">Rp {{ number_format($booking->base_price, 0, ',', '.') }}</div>
                        </div>
                        @if($booking->weekend_surcharge > 0)
                            <div class="info-item">
                                <div class="info-label">Weekend Surcharge (20%):</div>
                                <div class="info-value">Rp {{ number_format($booking->weekend_surcharge, 0, ',', '.') }}</div>
                            </div>
                        @endif
                        <div class="info-item total-price">
                            <div class="info-label">Total Price:</div>
                            <div class="info-value">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</div>
                        </div>
                        <div class="info-item">
                            <div class="info-label">Payment Status:</div>
                            <div class="info-value">
                                <span class="status-badge status-{{ strtolower($booking->status) }}">{{ $booking->status }}</span>
                            </div>
                        </div>
                        @if($booking->payment_id)
                            <div class="info-item">
                                <div class="info-label">Payment ID:</div>
                                <div class="info-value">{{ $booking->payment_id }}</div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            
            <div class="booking-actions">
                @if($booking->status == 'Pending')
                    <a href="{{ route('checkout.process', $booking->id) }}" class="btn btn-primary">Complete Payment</a>
                @endif
                
                @if($booking->status == 'Paid')
                    <a href="{{ route('booking.download-pdf', $booking->id) }}" class="btn btn-primary">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="btn-icon">
                            <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                            <polyline points="7 10 12 15 17 10"></polyline>
                            <line x1="12" y1="15" x2="12" y2="3"></line>
                        </svg>
                        Download PDF
                    </a>
                @endif
                
                @if($booking->status != 'Cancelled')
                    <form action="{{ route('booking.cancel', $booking->id) }}" method="POST" class="cancel-form">
                        @csrf
                        @method('PUT')
                        <button type="submit" class="btn btn-outline btn-danger" onclick="return confirm('Are you sure you want to cancel this booking?')">Cancel Booking</button>
                    </form>
                @endif
            </div>
        </div>
    </div>
@endsection

