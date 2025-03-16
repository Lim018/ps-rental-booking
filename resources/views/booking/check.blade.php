@extends('layouts.app')

@section('title', 'Check Booking')

@section('styles')
   <link rel="stylesheet" href="{{ asset('assets/css/booking-check.css') }}">
@endsection

@section('scripts')
   <script src="{{ asset('assets/js/booking-check.js') }}" defer></script>
@endsection

@section('content')
   <div class="container">
       <div class="page-header">
           <h1 class="page-title">Check Your Booking</h1>
       </div>

       <div class="booking-check-container">
           <div class="booking-check-card">
               <div class="booking-check-tabs">
                   <button class="tab-btn active" data-tab="phone">Phone Number</button>
                   <button class="tab-btn" data-tab="booking-id">Booking ID</button>
               </div>

               <div class="tab-content active" id="phone-tab">
                   <form action="{{ route('find-by-phone') }}" method="POST" class="booking-check-form">
                       @csrf
                       <div class="form-group">
                           <label for="phone" class="form-label">Phone Number</label>
                           <input type="text" id="phone" name="phone" class="form-control" required placeholder="Enter the phone number used for booking">
                       </div>
                       <button type="submit" class="btn btn-primary btn-block">Find My Bookings</button>
                   </form>
               </div>

               <div class="tab-content" id="booking-id-tab">
                   <form action="{{ route('find-by-id') }}" method="POST" class="booking-check-form">
                       @csrf
                       <div class="form-group">
                           <label for="booking_id" class="form-label">Booking ID</label>
                           <input type="text" id="booking_id" name="booking_id" class="form-control" required placeholder="Enter your booking ID">
                       </div>
                       <button type="submit" class="btn btn-primary btn-block">Find My Booking</button>
                   </form>
               </div>
           </div>

           @if(isset($bookings) && count($bookings) > 0)
               <div class="booking-results">
                   <h2 class="results-title">Your Bookings</h2>
                   <div class="booking-cards">
                       @foreach($bookings as $booking)
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
                                   @if($booking->status == 'Paid')
                                       <div class="booking-validation">
                                           <div class="booking-icon">
                                               <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                   <path d="M21 10V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l2-1.14"></path>
                                                   <path d="M16.5 9.4L7.55 4.24"></path>
                                                   <polyline points="3.29 7 12 12 20.71 7"></polyline>
                                                   <line x1="12" y1="22" x2="12" y2="12"></line>
                                                   <circle cx="18.5" cy="15.5" r="2.5"></circle>
                                                   <path d="M20.27 17.27L22 19"></path>
                                               </svg>
                                           </div>
                                           <div class="booking-info">
                                               <div class="booking-validation-label">Validation Status</div>
                                               <div class="booking-validation-value">
                                                   <span class="status-badge status-{{ $booking->is_used ? 'used' : 'unused' }}">
                                                       {{ $booking->is_used ? 'Used' : 'Not Used Yet' }}
                                                   </span>
                                               </div>
                                           </div>
                                       </div>
                                   @endif
                               </div>
                               <div class="booking-card-footer">
                                   <a href="{{ route('booking.show', $booking->id) }}" class="btn btn-primary btn-block">View Details</a>
                               </div>
                           </div>
                       @endforeach
                   </div>
               </div>
           @elseif(isset($bookings))
               <div class="booking-results empty">
                   <div class="empty-state">
                       <div class="empty-state-icon">
                           <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                               <circle cx="12" cy="12" r="10"></circle>
                               <line x1="12" y1="8" x2="12" y2="12"></line>
                               <line x1="12" y1="16" x2="12.01" y2="16"></line>
                           </svg>
                       </div>
                       <h3 class="empty-state-title">No Bookings Found</h3>
                       <p class="empty-state-description">We couldn't find any bookings with the provided information.</p>
                       <a href="{{ route('booking.create') }}" class="btn btn-primary">Book Now</a>
                   </div>
               </div>
           @endif
       </div>
   </div>
@endsection

