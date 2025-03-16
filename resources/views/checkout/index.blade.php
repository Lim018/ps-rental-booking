@extends('layouts.app')

@section('title', 'Checkout')

@section('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/booking-details.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/checkout.css') }}">
@endsection

@section('content')
    <div class="container">
        <div class="page-header">
            <h1 class="page-title">Keranjang Belanja</h1>
        </div>

        <div class="row">
            <div class="col-lg-8 mb-4">
                @forelse($bookings as $booking)
                    <div class="booking-card">
                        <div class="booking-header">
                            <div class="d-flex justify-content-between align-items-center">
                                <h4>{{ $booking->service->name }}</h4>
                                <span class="status-badge status-{{ strtolower($booking->status) }}">{{ $booking->status }}</span>
                            </div>
                        </div>
                        <div class="booking-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <p><strong>Tanggal:</strong> {{ \Carbon\Carbon::parse($booking->booking_date)->format('d F Y') }}</p>
                                    <p><strong>Waktu:</strong> {{ $booking->session_time }}</p>
                                </div>
                                <div class="col-md-6">
                                    <p><strong>Nama:</strong> {{ $booking->user_name }}</p>
                                    <p><strong>Telepon:</strong> {{ $booking->user_phone }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="booking-footer">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <span class="text-muted">Harga Dasar: Rp {{ number_format($booking->base_price, 0, ',', '.') }}</span>
                                    @if($booking->weekend_surcharge > 0)
                                        <br>
                                        <span class="text-muted">Weekend Surcharge: Rp {{ number_format($booking->weekend_surcharge, 0, ',', '.') }}</span>
                                    @endif
                                </div>
                                <div>
                                    <strong>Total: Rp {{ number_format($booking->total_price, 0, ',', '.') }}</strong>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="alert alert-info">
                        Keranjang belanja Anda kosong.
                    </div>
                @endforelse
            </div>

            <div class="col-lg-4">
                <div class="price-summary">
                    <h4 class="mb-4">Ringkasan Belanja</h4>
                    
                    @foreach($bookings as $booking)
                        <div class="summary-item">
                            <span>{{ $booking->service->name }} ({{ $booking->session_time }})</span>
                            <span>Rp {{ number_format($booking->total_price, 0, ',', '.') }}</span>
                        </div>
                    @endforeach
                    
                    <div class="summary-total">
                        <span>Total</span>
                        <span>Rp {{ number_format($total, 0, ',', '.') }}</span>
                    </div>
                    
                    @if(count($bookings) > 0)
                        <a href="{{ route('checkout.process', $bookings->first()->id) }}" class="btn btn-primary w-100 mt-4">
                            Lanjutkan ke Pembayaran
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

