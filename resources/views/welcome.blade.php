@extends('layouts.app')

@section('title', 'Home')

@section('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/home.css') }}">
@endsection

@section('scripts')
    <script src="{{ asset('assets/js/home.js') }}" defer></script>
@endsection

@section('content')
    <section class="hero">
        <div class="container">
            <div class="hero-content">
                <h1 class="hero-title">Book Your PlayStation Session</h1>
                <p class="hero-subtitle">Experience gaming like never before with our premium PlayStation rental service.</p>
                <div class="hero-buttons">
                    <a href="{{ route('booking.create') }}" class="btn btn-secondary btn-lg">Book Now</a>
                    <a href="#pricing" class="btn btn-outline btn-lg">View Pricing</a>
                </div>
            </div>
        </div>
    </section>

    <section class="how-it-works">
        <div class="container">
            <h2 class="section-title">How It Works</h2>
            <p class="section-subtitle">Follow these simple steps to book your PlayStation session</p>
            
            <div class="steps">
                <div class="step animate-on-scroll">
                    <div class="step-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                            <line x1="16" y1="2" x2="16" y2="6"></line>
                            <line x1="8" y1="2" x2="8" y2="6"></line>
                            <line x1="3" y1="10" x2="21" y2="10"></line>
                        </svg>
                    </div>
                    <h3 class="step-title">Select Date & Time</h3>
                    <p class="step-description">Choose your preferred date and session time from our calendar</p>
                </div>
                
                <div class="step animate-on-scroll">
                    <div class="step-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M6 9l6 6 6-6"></path>
                        </svg>
                    </div>
                    <h3 class="step-title">Choose Console</h3>
                    <p class="step-description">Select between PS4 (Rp 30,000) or PS5 (Rp 40,000)</p>
                </div>
                
                <div class="step animate-on-scroll">
                    <div class="step-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="1" y="4" width="22" height="16" rx="2" ry="2"></rect>
                            <line x1="1" y1="10" x2="23" y2="10"></line>
                        </svg>
                    </div>
                    <h3 class="step-title">Complete Payment</h3>
                    <p class="step-description">Pay securely through Midtrans payment gateway</p>
                </div>
                
                <div class="step animate-on-scroll">
                    <div class="step-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                            <polyline points="22 4 12 14.01 9 11.01"></polyline>
                        </svg>
                    </div>
                    <h3 class="step-title">Enjoy Your Session</h3>
                    <p class="step-description">Receive confirmation and arrive at your scheduled time</p>
                </div>
            </div>
        </div>
    </section>

    <section class="services" id="pricing">
        <div class="container">
            <h2 class="section-title">Our Services</h2>
            <p class="section-subtitle">Choose your preferred gaming experience</p>
            
            <div class="service-cards">
                <div class="service-card animate-on-scroll">
                    <div class="service-header">
                        <h3 class="service-title">PlayStation 4</h3>
                        <div class="service-price">Rp 30,000 <span>per session</span></div>
                        <p>Standard gaming experience with a wide library of games</p>
                    </div>
                    <div class="service-features">
                        <ul class="feature-list">
                            <li class="feature-item">
                                <span class="feature-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                                        <polyline points="22 4 12 14.01 9 11.01"></polyline>
                                    </svg>
                                </span>
                                2-hour gaming session
                            </li>
                            <li class="feature-item">
                                <span class="feature-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                                        <polyline points="22 4 12 14.01 9 11.01"></polyline>
                                    </svg>
                                </span>
                                Access to 50+ games
                            </li>
                            <li class="feature-item">
                                <span class="feature-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                                        <polyline points="22 4 12 14.01 9 11.01"></polyline>
                                    </svg>
                                </span>
                                2 controllers included
                            </li>
                            <li class="feature-item">
                                <span class="feature-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                                        <polyline points="22 4 12 14.01 9 11.01"></polyline>
                                    </svg>
                                </span>
                                Comfortable seating
                            </li>
                        </ul>
                    </div>
                    <div class="service-footer">
                        <a href="{{ route('booking.create') }}" class="btn btn-primary btn-block">Book PS4 Now</a>
                    </div>
                </div>
                
                <div class="service-card featured animate-on-scroll">
                    <div class="service-header">
                        <h3 class="service-title">PlayStation 5</h3>
                        <div class="service-price">Rp 40,000 <span>per session</span></div>
                        <p>Next-gen gaming with faster loading and enhanced graphics</p>
                    </div>
                    <div class="service-features">
                        <ul class="feature-list">
                            <li class="feature-item">
                                <span class="feature-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                                        <polyline points="22 4 12 14.01 9 11.01"></polyline>
                                    </svg>
                                </span>
                                2-hour gaming session
                            </li>
                            <li class="feature-item">
                                <span class="feature-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                                        <polyline points="22 4 12 14.01 9 11.01"></polyline>
                                    </svg>
                                </span>
                                Access to 70+ games
                            </li>
                            <li class="feature-item">
                                <span class="feature-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                                        <polyline points="22 4 12 14.01 9 11.01"></polyline>
                                    </svg>
                                </span>
                                2 DualSense controllers
                            </li>
                            <li class="feature-item">
                                <span class="feature-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                                        <polyline points="22 4 12 14.01 9 11.01"></polyline>
                                    </svg>
                                </span>
                                Comfortable seating
                            </li>
                            <li class="feature-item">
                                <span class="feature-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                                        <polyline points="22 4 12 14.01 9 11.01"></polyline>
                                    </svg>
                                </span>
                                4K Ultra HD display
                            </li>
                        </ul>
                    </div>
                    <div class="service-footer">
                        <a href="{{ route('booking.create') }}" class="btn btn-primary btn-block">Book PS5 Now</a>
                    </div>
                </div>
            </div>
            
            <div class="pricing-note">
                <div class="note-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="12" r="10"></circle>
                        <line x1="12" y1="8" x2="12" y2="12"></line>
                        <line x1="12" y1="16" x2="12.01" y2="16"></line>
                    </svg>
                </div>
                <p>Weekend surcharge (20%) applies for bookings on Saturday and Sunday</p>
            </div>
        </div>
    </section>
    <section class="testimonials">
        <div class="container">
            <h2 class="section-title">What Our Customers Say</h2>
            <p class="section-subtitle">Hear from our satisfied gamers</p>
            
            <div class="testimonial-slider">
                <div class="testimonial-item">
                    <div class="testimonial-content">
                        "The PlayStation 5 rental was amazing! The graphics were incredible and the controllers felt great. Will definitely be coming back for more sessions!"
                    </div>
                    <div class="testimonial-author">
                        <div class="author-avatar">
                            <img src="{{ asset('assets/img/avatar-1.jpg') }}" alt="John Doe">
                        </div>
                        <div class="author-info">
                            <div class="author-name">John Doe</div>
                            <div class="author-title">Regular Customer</div>
                        </div>
                    </div>
                </div>
                
                <div class="testimonial-item">
                    <div class="testimonial-content">
                        "Great service and friendly staff. The booking process was simple and the gaming setup was comfortable. Perfect for a gaming session with friends!"
                    </div>
                    <div class="testimonial-author">
                        <div class="author-avatar">
                            <img src="{{ asset('assets/img/avatar-2.jpg') }}" alt="Sarah Johnson">
                        </div>
                        <div class="author-info">
                            <div class="author-name">Sarah Johnson</div>
                            <div class="author-title">Gaming Enthusiast</div>
                        </div>
                    </div>
                </div>
                
                <div class="testimonial-item">
                    <div class="testimonial-content">
                        "I brought my kids here for a gaming session and they had a blast! The variety of games available was impressive and the staff was very helpful."
                    </div>
                    <div class="testimonial-author">
                        <div class="author-avatar">
                            <img src="{{ asset('assets/img/avatar-3.jpg') }}" alt="Michael Brown">
                        </div>
                        <div class="author-info">
                            <div class="author-name">Michael Brown</div>
                            <div class="author-title">Parent</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="cta">
        <div class="container">
            <h2 class="cta-title">Ready to Start Gaming?</h2>
            <p class="cta-description">Book your PlayStation session now and experience gaming like never before. No need to invest in expensive consoles - just pay for what you use!</p>
            <a href="{{ route('booking.create') }}" class="cta-button">Book Your Session Now</a>
        </div>
    </section>
    <section class="about" id="about">
        <div class="container">
            <h2 class="section-title">About PS Rental</h2>
            <p class="section-subtitle">Your premium PlayStation rental service</p>
            
            <div class="about-content">
                <div class="about-image">
                    <img src="{{ asset('https://i.pinimg.com/736x/a6/11/86/a611865b23a4eb68bcf67099ff83def9.jpg') }}" alt="PS Rental Gaming Setup" onerror="this.src='https://via.placeholder.com/600x400'">
                </div>
                <div class="about-text">
                    <p>PS Rental was founded with a simple mission: to make premium gaming accessible to everyone. We understand that not everyone can afford to purchase the latest PlayStation consoles and games, which is why we offer affordable rental services.</p>
                    <p>Our gaming stations are equipped with the latest PlayStation consoles, a wide selection of popular games, comfortable seating, and high-quality displays. Whether you're a casual gamer looking to try out the latest releases or a dedicated gamer wanting to experience next-gen gaming without the investment, we've got you covered.</p>
                    <p>Located in the heart of Jakarta, our facility is easily accessible and designed to provide the ultimate gaming experience. Our friendly staff is always ready to assist you and ensure that your gaming session is enjoyable and hassle-free.</p>
                    <a href="#contact" class="btn btn-primary">Contact Us</a>
                </div>
            </div>
        </div>
    </section>
    <section class="contact" id="contact">
        <div class="container">
            <h2 class="section-title">Contact Us</h2>
            <p class="section-subtitle">Get in touch with our team</p>
            
            <div class="contact-content">
                <div class="contact-info">
                    <div class="contact-item">
                        <div class="contact-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                                <circle cx="12" cy="10" r="3"></circle>
                            </svg>
                        </div>
                        <div class="contact-text">
                            <h3>Address</h3>
                            <p>123 Gaming Street, Jakarta, Indonesia</p>
                        </div>
                    </div>
                    
                    <div class="contact-item">
                        <div class="contact-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path>
                            </svg>
                        </div>
                        <div class="contact-text">
                            <h3>Phone</h3>
                            <p>(021) 123-4567</p>
                        </div>
                    </div>
                    
                    <div class="contact-item">
                        <div class="contact-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
                                <polyline points="22,6 12,13 2,6"></polyline>
                            </svg>
                        </div>
                        <div class="contact-text">
                            <h3>Email</h3>
                            <p>info@psrental.com</p>
                        </div>
                    </div>
                    
                    <div class="contact-item">
                        <div class="contact-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="12" cy="12" r="10"></circle>
                                <polyline points="12 6 12 12 16 14"></polyline>
                            </svg>
                        </div>
                        <div class="contact-text">
                            <h3>Opening Hours</h3>
                            <p>Monday - Sunday: 10:00 AM - 10:00 PM</p>
                        </div>
                    </div>
                </div>
                
                <div class="contact-form-container">
                    <form class="contact-form" action="#" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" id="name" name="name" class="form-control" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" id="email" name="email" class="form-control" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="subject" class="form-label">Subject</label>
                            <input type="text" id="subject" name="subject" class="form-control" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="message" class="form-label">Message</label>
                            <textarea id="message" name="message" class="form-control" rows="5" required></textarea>
                        </div>
                        
                        <button type="submit" class="btn btn-primary btn-block">Send Message</button>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection
