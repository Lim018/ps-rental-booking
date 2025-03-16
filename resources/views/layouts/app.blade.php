<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'PS Rental') }} - @yield('title', 'PlayStation Rental Service')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/css/reset.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/global.css') }}">
    @yield('styles')
    <script src="{{ asset('assets/js/global.js') }}" defer></script>
    @yield('scripts')
</head>
<body>
    <div id="app">
        <header class="site-header">
            <div class="container">
                <div class="header-content">
                    <div class="logo">
                        <a href="{{ url('/') }}">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="logo-icon">
                                <circle cx="12" cy="12" r="10"></circle>
                                <polygon points="10 8 16 12 10 16 10 8"></polygon>
                            </svg>
                            <span>PS Rental</span>
                        </a>
                    </div>

                    <nav class="main-nav">
                        <ul>
                            <li class="{{ request()->is('/') ? 'active' : '' }}">
                                <a href="{{ url('/') }}">Home</a>
                            </li>
                            <li>
                                <a href="/#pricing">Pricing</a>
                            </li>
                            <li>
                                <a href="/#about">About</a>
                            </li>
                            <li>
                                <a href="/#contact">Contact</a>
                            </li>
                            <li class="{{ request()->routeIs('check') ? 'active' : '' }}">
                                <a href="{{ route('check') }}">Check Booking</a>
                            </li>
                        </ul>
                    </nav>

                    <div class="user-menu">
                        <a href="{{ route('booking.create') }}" class="btn btn-primary">Book Now</a>
                    </div>

                    <button class="mobile-menu-toggle">
                        <span></span>
                        <span></span>
                        <span></span>
                    </button>
                </div>
            </div>
        </header>

        <div class="mobile-menu">
            <div class="container">
                <nav>
                    <ul>
                        <li class="{{ request()->is('/') ? 'active' : '' }}">
                            <a href="{{ url('/') }}">Home</a>
                        </li>
                        <li>
                            <a href="/#pricing">Pricing</a>
                        </li>
                        <li>
                            <a href="/#about">About</a>
                        </li>
                        <li>
                            <a href="/#contact">Contact</a>
                        </li>
                        <li class="{{ request()->routeIs('check') ? 'active' : '' }}">
                            <a href="{{ route('check') }}">Check Booking</a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>

        @if (session('success'))
            <div class="flash-message success" id="flash-message">
                <div class="container">
                    <div class="flash-content">
                        <div class="flash-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                                <polyline points="22 4 12 14.01 9 11.01"></polyline>
                            </svg>
                        </div>
                        <div class="flash-text">{{ session('success') }}</div>
                        <button class="flash-close" onclick="document.getElementById('flash-message').style.display='none'">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <line x1="18" y1="6" x2="6" y2="18"></line>
                                <line x1="6" y1="6" x2="18" y2="18"></line>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        @endif

        @if (session('error'))
            <div class="flash-message error" id="flash-message">
                <div class="container">
                    <div class="flash-content">
                        <div class="flash-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="12" cy="12" r="10"></circle>
                                <line x1="12" y1="8" x2="12" y2="12"></line>
                                <line x1="12" y1="16" x2="12.01" y2="16"></line>
                            </svg>
                        </div>
                        <div class="flash-text">{{ session('error') }}</div>
                        <button class="flash-close" onclick="document.getElementById('flash-message').style.display='none'">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <line x1="18" y1="6" x2="6" y2="18"></line>
                                <line x1="6" y1="6" x2="18" y2="18"></line>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        @endif

        <main class="site-main">
            @yield('content')
        </main>

        <footer class="site-footer">
            <div class="container">
                <div class="footer-content">
                    <div class="footer-brand">
                        <div class="logo">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="logo-icon">
                                <circle cx="12" cy="12" r="10"></circle>
                                <polygon points="10 8 16 12 10 16 10 8"></polygon>
                            </svg>
                            <span>PS Rental</span>
                        </div>
                        <p class="footer-description">
                            Experience premium PlayStation gaming without the commitment of purchasing. Our rental service provides the latest consoles and games for your entertainment needs.
                        </p>
                        <div class="social-links">
                            <a href="#" class="social-link">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"></path>
                                </svg>
                            </a>
                            <a href="#" class="social-link">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <rect x="2" y="2" width="20" height="20" rx="5" ry="5"></rect>
                                    <path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"></path>
                                    <line x1="17.5" y1="6.5" x2="17.51" y2="6.5"></line>
                                </svg>
                            </a>
                            <a href="#" class="social-link">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M23 3a10.9 10.9 0 0 1-3.14 1.53 4.48 4.48 0 0 0-7.86 3v1A10.66 10.66 0 0 1 3 4s-4 9 5 13a11.64 11.64 0 0 1-7 2c9 5 20 0 20-11.5a4.5 4.5 0 0 0-.08-.83A7.72 7.72 0 0 0 23 3z"></path>
                                </svg>
                            </a>
                        </div>
                    </div>
                    <div class="footer-links">
                        <div class="footer-column">
                            <h3 class="footer-heading">Services</h3>
                            <ul>
                                <li><a href="#">PlayStation 4 Rental</a></li>
                                <li><a href="#">PlayStation 5 Rental</a></li>
                                <li><a href="#">Game Library</a></li>
                                <li><a href="#">Accessories</a></li>
                            </ul>
                        </div>
                        <div class="footer-column">
                            <h3 class="footer-heading">Company</h3>
                            <ul>
                                <li><a href="#">About</a></li>
                                <li><a href="#">Blog</a></li>
                                <li><a href="#">Careers</a></li>
                                <li><a href="#">Contact</a></li>
                            </ul>
                        </div>
                        <div class="footer-column">
                            <h3 class="footer-heading">Contact</h3>
                            <address>
                                123 Gaming Street<br>
                                Jakarta, Indonesia<br>
                                <a href="mailto:info@psrental.com">info@psrental.com</a><br>
                                <a href="tel:+62211234567">(021) 123-4567</a>
                            </address>
                        </div>
                    </div>
                </div>
                <div class="footer-bottom">
                    <div class="footer-legal">
                        <a href="#">Terms of Service</a>
                        <a href="#">Privacy Policy</a>
                        <a href="#">Cookie Policy</a>
                    </div>
                    <div class="footer-copyright">
                        &copy; {{ date('Y') }} PS Rental. All rights reserved.
                    </div>
                </div>
            </div>
        </footer>
    </div>
</body>
</html>
