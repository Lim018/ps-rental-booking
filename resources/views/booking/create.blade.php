@extends('layouts.app')

@section('title', 'Book Now')

@section('styles')
   <link rel="stylesheet" href="{{ asset('assets/css/booking.css') }}">
@endsection

@section('scripts')
   <script src="{{ asset('assets/js/booking.js') }}" defer></script>
@endsection

@section('content')
   <div class="container">
       <div class="booking-header">
           <h1 class="booking-title">Book Your PlayStation Session</h1>
           <p class="booking-subtitle">Follow the steps below to complete your booking</p>
       </div>

       <div class="booking-steps">
           <div class="booking-step active">
               <div class="step-number">1</div>
               <div class="step-label">Select Date & Service</div>
           </div>
           <div class="booking-step">
               <div class="step-number">2</div>
               <div class="step-label">Your Information</div>
           </div>
           <div class="booking-step">
               <div class="step-number">3</div>
               <div class="step-label">Review & Payment</div>
           </div>
       </div>

       <form id="booking-form" class="booking-form" method="POST" action="{{ route('booking.store') }}">
           @csrf
           
           <!-- Step 1: Date and Service Selection -->
           <div class="form-section" id="section-date-service">
               <h2 class="form-section-title">Select Date & Service</h2>
               
               <!-- Calendar -->
               <div class="calendar-container">
                   <div class="calendar-header">
                       <h3 class="calendar-title">Select Date</h3>
                       <div class="calendar-nav">
                           <button type="button" id="prev-month" class="calendar-nav-btn">
                               <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                   <polyline points="15 18 9 12 15 6"></polyline>
                               </svg>
                           </button>
                           <span id="month-year-display">June 2023</span>
                           <button type="button" id="next-month" class="calendar-nav-btn">
                               <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                   <polyline points="9 18 15 12 9 6"></polyline>
                               </svg>
                           </button>
                       </div>
                   </div>
                   
                   <div id="booking-calendar" class="calendar" data-month="{{ date('n') - 1 }}" data-year="{{ date('Y') }}">
                       <div class="calendar-grid"></div>
                   </div>
                   
                   <input type="hidden" id="booking_date" name="booking_date" required>
               </div>
               
               <!-- Service Selection -->
               <div class="service-options-container">
                <h3>Select Console</h3>
                <div class="service-options">
                    @foreach($services as $service)
                        <div class="service-option">
                            <input type="radio" id="service-{{ $service->id }}" name="service_id" value="{{ $service->id }}" data-price="{{ $service->price }}" class="hidden-radio" required>
                            <div class="service-option-header">
                                <div class="service-option-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <line x1="6" y1="11" x2="10" y2="11"></line>
                                        <line x1="8" y1="9" x2="8" y2="13"></line>
                                        <line x1="15" y1="12" x2="15.01" y2="12"></line>
                                        <line x1="18" y1="10" x2="18.01" y2="10"></line>
                                        <path d="M17.32 5H6.68a4 4 0 0 0-3.978 3.59c-.006.052-.01.101-.017.152C2.604 9.416 2 14.456 2 16a3 3 0 0 0 3 3c1 0 1.5-.5 2-1l1.414-1.414A2 2 0 0 1 9.828 16h4.344a2 2 0 0 1 1.414.586L17 18c.5.5 1 1 2 1a3 3 0 0 0 3-3c0-1.544-.604-6.584-.685-7.258-.007-.05-.011-.1-.017-.151A4 4 0 0 0 17.32 5z"></path>
                                    </svg>
                                </div>
                                <div class="service-option-title">{{ $service->name }}</div>
                            </div>
                            <div class="service-option-price">Rp {{ number_format($service->price, 0, ',', '.') }}</div>
                            <div class="service-option-description">{{ $service->description }}</div>
                        </div>
                    @endforeach
                </div>
            </div>
               
               <!-- Time Slot Selection -->
               <div class="time-slots-container">
                   <h3>Select Time Slot</h3>
                   <div class="time-slots">
                       @foreach($timeSlots as $slot)
                           <div class="time-slot">
                               <input type="radio" id="time-{{ $loop->index }}" name="session_time" value="{{ $slot }}" class="hidden-radio" required>
                               <div class="time-slot-time">{{ $slot }}</div>
                           </div>
                       @endforeach
                   </div>
               </div>
               
               <!-- Price Summary -->
               <div class="price-summary">
                   <h3 class="price-summary-title">Price Summary</h3>
                   <div class="price-summary-item">
                       <div class="price-summary-label">Base Price:</div>
                       <div class="price-summary-value" id="base-price">Rp 0</div>
                   </div>
                   <div class="price-summary-item" id="weekend-surcharge-container" style="display: none;">
                       <div class="price-summary-label">Weekend Surcharge (20%):</div>
                       <div class="price-summary-value" id="weekend-surcharge">Rp 0</div>
                   </div>
                   <div class="price-summary-total">
                       <div class="price-summary-label">Total:</div>
                       <div class="price-summary-value" id="total-price">Rp 0</div>
                   </div>
                   
                   <input type="hidden" id="base_price" name="base_price" value="0">
                   <input type="hidden" id="weekend_surcharge" name="weekend_surcharge" value="0">
                   <input type="hidden" id="total_price" name="total_price" value="0">
               </div>
               
               <div class="booking-nav">
                   <div></div>
                   <button type="button" class="btn btn-primary btn-next">
                       Continue to Personal Information
                       <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                           <line x1="5" y1="12" x2="19" y2="12"></line>
                           <polyline points="12 5 19 12 12 19"></polyline>
                       </svg>
                   </button>
               </div>
           </div>
           
           <!-- Step 2: Personal Information -->
           <div class="form-section" id="section-personal-info">
               <h2 class="form-section-title">Your Information</h2>
               
               <div class="form-row">
                   <div class="form-group">
                       <label for="name" class="form-label">Full Name</label>
                       <input type="text" id="name" name="name" class="form-control" required>
                   </div>
               </div>
               
               <div class="form-row">
                   <div class="form-group">
                       <label for="phone" class="form-label">Phone Number</label>
                       <input type="tel" id="phone" name="phone" class="form-control" required>
                       <small class="form-text text-muted">We'll send your booking confirmation and PDF to this number</small>
                   </div>
               </div>
               
               <div class="form-row">
                   <div class="form-group">
                       <label for="notes" class="form-label">Special Requests (Optional)</label>
                       <textarea id="notes" name="notes" class="form-control" rows="3"></textarea>
                   </div>
               </div>
               
               <div class="booking-nav">
                   <button type="button" class="btn btn-outline btn-prev">
                       <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                           <line x1="19" y1="12" x2="5" y2="12"></line>
                           <polyline points="12 19 5 12 12 5"></polyline>
                       </svg>
                       Back to Date & Service
                   </button>
                   <button type="button" class="btn btn-primary btn-next">
                       Review Booking
                       <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                           <line x1="5" y1="12" x2="19" y2="12"></line>
                           <polyline points="12 5 19 12 12 19"></polyline>
                       </svg>
                   </button>
               </div>
           </div>
           
           <!-- Step 3: Review & Payment -->
           <div class="form-section" id="section-review">
               <h2 class="form-section-title">Review & Payment</h2>
               
               <div class="booking-review">
                   <div class="review-section">
                       <h3 class="review-section-title">Booking Details</h3>
                       <div class="review-item">
                           <div class="review-label">Date:</div>
                           <div class="review-value" id="review-date"></div>
                       </div>
                       <div class="review-item">
                           <div class="review-label">Time:</div>
                           <div class="review-value" id="review-time"></div>
                       </div>
                       <div class="review-item">
                           <div class="review-label">Service:</div>
                           <div class="review-value" id="review-service"></div>
                       </div>
                   </div>
                   
                   <div class="review-section">
                       <h3 class="review-section-title">Personal Information</h3>
                       <div class="review-item">
                           <div class="review-label">Name:</div>
                           <div class="review-value" id="review-name"></div>
                       </div>
                       <div class="review-item">
                           <div class="review-label">Phone:</div>
                           <div class="review-value" id="review-phone"></div>
                       </div>
                   </div>
                   
                   <div class="review-section">
                       <h3 class="review-section-title">Price Summary</h3>
                       <div class="review-item">
                           <div class="review-label">Base Price:</div>
                           <div class="review-value" id="review-base-price"></div>
                       </div>
                       <div class="review-item" id="review-weekend-container" style="display: none;">
                           <div class="review-label">Weekend Surcharge (20%):</div>
                           <div class="review-value" id="review-weekend-surcharge"></div>
                       </div>
                       <div class="review-item review-total">
                           <div class="review-label">Total:</div>
                           <div class="review-value" id="review-total-price"></div>
                       </div>
                   </div>
               </div>
               
               <div class="payment-info">
                   <h3>Payment Information</h3>
                   <p>After submitting your booking, you will be redirected to our secure payment gateway powered by Midtrans to complete your payment.</p>
                   <p>We accept various payment methods including credit/debit cards, bank transfers, and e-wallets.</p>
                   <p>A PDF with your booking details and QR code will be sent to your phone number after payment is completed.</p>
               </div>
               
               <div class="booking-nav">
                   <button type="button" class="btn btn-outline btn-prev">
                       <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                           <line x1="19" y1="12" x2="5" y2="12"></line>
                           <polyline points="12 19 5 12 12 5"></polyline>
                       </svg>
                       Back to Personal Information
                   </button>
                   <button type="submit" class="btn btn-primary">
                       Confirm & Pay
                       <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                           <line x1="12" y1="5" x2="12" y2="19"></line>
                           <polyline points="19 12 12 19 5 12"></polyline>
                       </svg>
                   </button>
               </div>
           </div>
       </form>
   </div>
@endsection

