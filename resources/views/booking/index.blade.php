@extends('layouts.app')

@section('title', 'All Bookings')

@section('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/booking-list.css') }}">
@endsection

@section('scripts')
    <script src="{{ asset('assets/js/booking-list.js') }}" defer></script>
@endsection

@section('content')
    <div class="container">
        <div class="page-header">
            <h1 class="page-title">All Bookings</h1>
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

        <div class="booking-filters">
            <div class="filter-group">
                <label for="status-filter" class="filter-label">Status</label>
                <select id="status-filter" class="form-control">
                    <option value="">All Statuses</option>
                    <option value="pending">Pending</option>
                    <option value="paid">Paid</option>
                    <option value="completed">Completed</option>
                    <option value="cancelled">Cancelled</option>
                </select>
            </div>
            
            <div class="filter-group">
                <label for="date-filter" class="filter-label">Date</label>
                <input type="date" id="date-filter" class="form-control">
            </div>
            
            <div class="filter-group">
                <label for="service-filter" class="filter-label">Service</label>
                <select id="service-filter" class="form-control">
                    <option value="">All Services</option>
                    <option value="1">PlayStation 4</option>
                    <option value="2">PlayStation 5</option>
                </select>
            </div>
            
            <button id="apply-filters" class="btn btn-secondary">Apply Filters</button>
            <button id="reset-filters" class="btn btn-text">Reset</button>
        </div>

        <div class="booking-list">
            <div class="booking-list-header">
                <div class="booking-column booking-id">ID</div>
                <div class="booking-column booking-date">Date & Time</div>
                <div class="booking-column booking-service">Service</div>
                <div class="booking-column booking-customer">Customer</div>
                <div class="booking-column booking-price">Price</div>
                <div class="booking-column booking-status">Status</div>
                <div class="booking-column booking-actions">Actions</div>
            </div>
            
            @if(count($bookings) > 0)
                @foreach($bookings as $booking)
                    <div class="booking-item">
                        <div class="booking-column booking-id">{{ $booking->id }}</div>
                        <div class="booking-column booking-date">
                            <div class="booking-date-day">{{ \Carbon\Carbon::parse($booking->booking_date)->format('M d, Y') }}</div>
                            <div class="booking-date-time">{{ $booking->session_time }}</div>
                        </div>
                        <div class="booking-column booking-service">{{ $booking->service->name }}</div>
                        <div class="booking-column booking-customer">
                            <div class="customer-name">{{ $booking->user_name }}</div>
                            <div class="customer-email">{{ $booking->user_email }}</div>
                        </div>
                        <div class="booking-column booking-price">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</div>
                        <div class="booking-column booking-status">
                            <span class="status-badge status-{{ strtolower($booking->status) }}">{{ $booking->status }}</span>
                        </div>
                        <div class="booking-column booking-actions">
                            <a href="{{ route('booking.show', $booking->id) }}" class="btn btn-sm btn-outline">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="btn-icon">
                                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                    <circle cx="12" cy="12" r="3"></circle>
                                </svg>
                                View
                            </a>
                        </div>
                    </div>
                @endforeach
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
                    <h3 class="empty-state-title">No Bookings Found</h3>
                    <p class="empty-state-description">There are no bookings matching your criteria.</p>
                    <a href="{{ route('booking.create') }}" class="btn btn-primary">Create New Booking</a>
                </div>
            @endif
        </div>

        <div class="pagination">
            {{ $bookings->links() }}
        </div>
    </div>
@endsection
