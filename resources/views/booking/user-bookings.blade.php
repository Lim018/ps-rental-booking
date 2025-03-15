@extends('layouts.app')

@section('title', 'My Bookings')

@section('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/user-bookings.css') }}">
@endsection

@section('scripts')
    <script src="{{ asset('assets/js/user-bookings.js') }}" defer></script>
@endsection

@section('content')
    <div class="container">
        <div class="page-header">
            <h1 class="page-title">My Bookings</h1>
            <div class="page-actions">
                <a href="{{ route('booking.create') }}" class="btn btn-primary">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="btn-icon">
                        <line x1="12" y1="5" x2="12" y2="19"></line>
                        <line x1="5" y1="12" x2="19" y2="12"></line>
                    </svg>
                    New Booking
                </a>
            </div>
        </div>

        <div class="booking-tabs">
            <button class="tab-btn active" data-tab="upcoming">Upcoming</button>
            <button class="tab-btn" data-tab="past">Past</button>
            <button class="tab-btn" data-tab="cancelled">Cancelled</button>
        </div>

        <div class="tab-content active" id="upcoming-tab">
            @if(count($upcomingBookings) > 0)
                <div class="booking-cards">
                    @foreach($upcomingBookings as $booking)
                        <div class="booking-card">
                            <div class="booking-card-header">
                                <div class="booking-service">{{ $booking->service->name }}</div>
                                <div class="booking-status">
                                    <span class="status-badge status-{{ strtolower($booking->status) }}">{{ $booking->status }}</span>
                                </div>
                            </div>
                            <div class="booking-card-body">
                                <div class="booking-date-time">
                                    <div class="booking-icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                                            <line x1="16" y1="2" x2="16" y2="6"></line>
                                            <line x1="8" y1="2" x2="8" y2="6"></line>
                                            <line x1="3" y1="10" x2="21" y2="10"></line>
                                        </svg>
                                    </div>
                                    <div class="booking-info">
                                        <div class="booking-date">{{ \Carbon\Carbon::parse($booking->booking_date)->format('l, F j, Y') }}</div>
                                        <div class="booking-time">{{ $booking->session_time }}</div>
                                    </div>
                                </div>
                                <div class="booking-price">
                                    <div class="booking-icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <line x1="12" y1="1" x2="12" y2="23"></line>
                                            <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path>
                                        </svg>
                                    </div>
                                    <div class="booking-info">
                                        <div class="booking-price-label">Total Price</div>
                                        <div class="booking-price-value">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</div>
                                    </div>
                                </div>
                            </div>
                            <div class="booking-card-footer">
                                <a href="{{ route('booking.show', $booking->id) }}" class="btn btn-outline">View Details</a>
                                @if($booking->status == 'Pending')
                                    <a href="{{ $booking->payment_url }}" class="btn btn-primary">Complete Payment</a>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="empty-state">
                    <div class="empty-state-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                            <line x1="16" y1="2" x2="16" y2="6"></line>
                            <line x1="8" y1="2" x2="8" y2="6"></line>
                            <line x1="3" y1="10" x2="21" y2="10"></line>
                        </svg>
                    </div>
                    <h3 class="empty-state-title">No Upcoming Bookings</h3>
                    <p class="empty-state-description">You don't have any upcoming bookings.</p>
                    <a href="{{ route('booking.create') }}" class="btn btn-primary">Book a Session</a>
                </div>
            @endif
        </div>

        <div class="tab-content" id="past-tab">
            @if(count($pastBookings) > 0)
                <div class="booking-cards">
                    @foreach($pastBookings as $booking)
                        <div class="booking-card">
                            <div class="booking-card-header">
                                <div class="booking-service">{{ $booking->service->name }}</div>
                                <div class="booking-status">
                                    <span class="status-badge status-completed">Completed</span>
                                </div>
                            </div>
                            <div class="booking-card-body">
                                <div class="booking-date-time">
                                    <div class="booking-icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                                            <line x1="16" y1="2" x2="16" y2="6"></line>
                                            <line x1="8" y1="2" x2="8" y2="6"></line>
                                            <line x1="3" y1="10" x2="21" y2="10"></line>
                                        </svg>
                                    </div>
                                    <div class="booking-info">
                                        <div class="booking-date">{{ \Carbon\Carbon::parse($booking->booking_date)->format('l, F j, Y') }}</div>
                                        <div class="booking-time">{{ $booking->session_time }}</div>
                                    </div>
                                </div>
                                <div class="booking-price">
                                    <div class="booking-icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <line x1="12" y1="1" x2="12" y2="23"></line>
                                            <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path>
                                        </svg>
                                    </div>
                                    <div class="booking-info">
                                        <div class="booking-price-label">Total Price</div>
                                        <div class="booking-price-value">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</div>
                                    </div>
                                </div>
                            </div>
                            <div class="booking-card-footer">
                                <a href="{{ route('booking.show', $booking->id) }}" class="btn btn-outline">View Details</a>
                                <a href="{{ route('booking.create') }}" class="btn btn-primary">Book Again</a>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="empty-state">
                    <div class="empty-state-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                            <line x1="16" y1="2" x2="16" y2="6"></line>
                            <line x1="8" y1="2" x2="8" y2="6"></line>
                            <line x1="3" y1="10" x2="21" y2="10"></line>
                        </svg>
                    </div>
                    <h3 class="empty-state-title">No Past Bookings</h3>
                    <p class="empty-state-description">You don't have any past bookings.</p>
                    <a href="{{ route('booking.create') }}" class="btn btn-primary">Book a Session</a>
                </div>
            @endif
        </div>

        <div class="tab-content" id="cancelled-tab">
            @if(count($cancelledBookings) > 0)
                <div class="booking-cards">
                    @foreach($cancelledBookings as $booking)
                        <div class="booking-card">
                            <div class="booking-card-header">
                                <div class="booking-service">{{ $booking->service->name }}</div>
                                <div class="booking-status">
                                    <span class="status-badge status-cancelled">Cancelled</span>
                                </div>
                            </div>
                            <div class="booking-card-body">
                                <div class="booking-date-time">
                                    <div class="booking-icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                                            <line x1="16" y1="2" x2="16" y2="6"></line>
                                            <line x1="8" y1="2" x2="8" y2="6"></line>
                                            <line x1="3" y1="10" x2="21" y2="10"></line>
                                        </svg>
                                    </div>
                                    <div class="booking-info">
                                        <div class="booking-date">{{ \Carbon\Carbon::parse($booking->booking_date)->format('l, F j, Y') }}</div>
                                        <div class="booking-time">{{ $booking->session_time }}</div>
                                    </div>
                                </div>
                                <div class="booking-price">
                                    <div class="booking-icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <line x1="12" y1="1" x2="12" y2="23"></line>
                                            <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path>
                                        </svg>
                                    </div>
                                    <div class="booking-info">
                                        <div class="booking-price-label">Total Price</div>
                                        <div class="booking-price-value">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</div>
                                    </div>
                                </div>
                            </div>
                            <div class="booking-card-footer">
                                <a href="{{ route('booking.show', $booking->id) }}" class="btn btn-outline">View Details</a>
                                <a href="{{ route('booking.create') }}" class="btn btn-primary">Book Again</a>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="empty-state">
                    <div class="empty-state-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                            <line x1="16" y1="2" x2="16" y2="6"></line>
                            <line x1="8" y1="2" x2="8" y2="6"></line>
                            <line x1="3" y1="10" x2="21" y2="10"></line>
                        </svg>
                    </div>
                    <h3 class="empty-state-title">No Cancelled Bookings</h3>
                    <p class="empty-state-description">You don't have any cancelled bookings.</p>
                    <a href="{{ route('booking.create') }}" class="btn btn-primary">Book a Session</a>
                </div>
            @endif
        </div>
    </div>
@endsection

