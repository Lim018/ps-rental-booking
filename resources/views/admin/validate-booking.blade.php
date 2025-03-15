@extends('layouts.app')

@section('title', 'Validate Booking')

@section('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/validate-booking.css') }}">
@endsection

@section('scripts')
    <script src="{{ asset('assets/js/validate-booking.js') }}" defer></script>
@endsection

@section('content')
    <div class="container">
        <div class="page-header">
            <h1 class="page-title">Validate Booking</h1>
        </div>

        <div class="validate-booking-container">
            <div class="validate-booking-card">
                <div class="validate-booking-tabs">
                    <button class="tab-btn active" data-tab="scan">Scan QR Code</button>
                    <button class="tab-btn" data-tab="manual">Manual Entry</button>
                </div>

                <div class="tab-content active" id="scan-tab">
                    <div class="qr-scanner-container">
                        <div id="qr-reader"></div>
                        <div id="qr-reader-results"></div>
                    </div>
                </div>

                <div class="tab-content" id="manual-tab">
                    <form action="{{ route('admin.validate-booking') }}" method="POST" class="validate-booking-form">
                        @csrf
                        <div class="form-group">
                            <label for="booking_id" class="form-label">Booking ID</label>
                            <input type="text" id="booking_id" name="booking_id" class="form-control" required placeholder="Enter booking ID">
                        </div>
                        <button type="submit" class="btn btn-primary btn-block">Validate Booking</button>
                    </form>
                </div>
            </div>

            @if(isset($booking))
                <div class="booking-result">
                    <div class="booking-details-card">
                        <div class="booking-header">
                            <div class="booking-id">Booking #{{ $booking->id }}</div>
                            <div class="booking-status">
                                <span class="status-badge status-{{ strtolower($booking->status) }}">{{ $booking->status }}</span>
                            </div>
                        </div>

                        <div class="booking-validation-status">
                            @if($booking->status != 'Paid')
                                <div class="validation-error">
                                    <div class="error-icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <circle cx="12" cy="12" r="10"></circle>
                                            <line x1="15" y1="9" x2="9" y2="15"></line>
                                            <line x1="9" y1="9" x2="15" y2="15"></line>
                                        </svg>
                                    </div>
                                    <div class="error-message">
                                        <h3>Cannot Validate</h3>
                                        <p>This booking has not been paid yet or has been cancelled.</p>
                                    </div>
                                </div>
                            @elseif($booking->is_used)
                                <div class="validation-warning">
                                    <div class="warning-icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <circle cx="12" cy="12" r="10"></circle>
                                            <line x1="12" y1="8" x2="12" y2="12"></line>
                                            <line x1="12" y1="16" x2="12.01" y2="16"></line>
                                        </svg>
                                    </div>
                                    <div class="warning-message">
                                        <h3>Already Used</h3>
                                        <p>This booking has already been used on {{ $booking->used_at->format('F j, Y \a\t g:i A') }}.</p>
                                    </div>
                                </div>
                            @else
                                <div class="validation-success">
                                    <div class="success-icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                                            <polyline points="22 4 12 14.01 9 11.01"></polyline>
                                        </svg>
                                    </div>
                                    <div class="success-message">
                                        <h3>Valid Booking</h3>
                                        <p>This booking is valid and ready to be used.</p>
                                        <form action="{{ route('admin.mark-as-used', $booking->id) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit" class="btn btn-primary">Mark as Used</button>
                                        </form>
                                    </div>
                                </div>
                            @endif
                        </div>

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
                                        <div class="info-label">Email:</div>
                                        <div class="info-value">{{ $booking->user_email }}</div>
                                    </div>
                                    <div class="info-item">
                                        <div class="info-label">Phone:</div>
                                        <div class="info-value">{{ $booking->user_phone }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection

