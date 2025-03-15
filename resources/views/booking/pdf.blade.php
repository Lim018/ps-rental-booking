<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Booking Confirmation - #{{ $booking->id }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 1px solid #ddd;
            padding-bottom: 20px;
        }
        .logo {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 10px;
        }
        .booking-id {
            font-size: 18px;
            color: #666;
        }
        .qr-code {
            text-align: center;
            margin: 30px 0;
        }
        .qr-code img {
            width: 200px;
            height: 200px;
        }
        .qr-code-caption {
            margin-top: 10px;
            font-size: 14px;
            color: #666;
        }
        .booking-details {
            margin-bottom: 30px;
        }
        .section-title {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 15px;
            border-bottom: 1px solid #eee;
            padding-bottom: 5px;
        }
        .detail-row {
            display: flex;
            margin-bottom: 10px;
        }
        .detail-label {
            width: 150px;
            font-weight: bold;
        }
        .detail-value {
            flex: 1;
        }
        .status {
            display: inline-block;
            padding: 5px 10px;
            border-radius: 3px;
            font-size: 12px;
            font-weight: bold;
            text-transform: uppercase;
        }
        .status-paid {
            background-color: #d1fae5;
            color: #065f46;
        }
        .footer {
            margin-top: 50px;
            text-align: center;
            font-size: 12px;
            color: #666;
            border-top: 1px solid #ddd;
            padding-top: 20px;
        }
        .instructions {
            margin: 30px 0;
            padding: 15px;
            background-color: #f8f9fa;
            border-radius: 5px;
        }
        .instructions p {
            margin: 5px 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="logo">PS Rental</div>
            <div class="booking-id">Booking #{{ $booking->id }}</div>
        </div>
        
        <div class="qr-code">
            <img src="data:image/png;base64,{{ $qrCode }}" alt="Booking QR Code">
            <div class="qr-code-caption">Present this QR code when you arrive for your session</div>
        </div>
        
        <div class="booking-details">
            <div class="section-title">Booking Information</div>
            <div class="detail-row">
                <div class="detail-label">Service:</div>
                <div class="detail-value">{{ $booking->service->name }}</div>
            </div>
            <div class="detail-row">
                <div class="detail-label">Date:</div>
                <div class="detail-value">{{ \Carbon\Carbon::parse($booking->booking_date)->format('l, F j, Y') }}</div>
            </div>
            <div class="detail-row">
                <div class="detail-label">Time:</div>
                <div class="detail-value">{{ $booking->session_time }}</div>
            </div>
            <div class="detail-row">
                <div class="detail-label">Status:</div>
                <div class="detail-value">
                    <span class="status status-{{ strtolower($booking->status) }}">{{ $booking->status }}</span>
                </div>
            </div>
        </div>
        
        <div class="booking-details">
            <div class="section-title">Customer Information</div>
            <div class="detail-row">
                <div class="detail-label">Name:</div>
                <div class="detail-value">{{ $booking->user_name }}</div>
            </div>
            <div class="detail-row">
                <div class="detail-label">Phone:</div>
                <div class="detail-value">{{ $booking->user_phone }}</div>
            </div>
        </div>
        
        <div class="booking-details">
            <div class="section-title">Payment Information</div>
            <div class="detail-row">
                <div class="detail-label">Base Price:</div>
                <div class="detail-value">Rp {{ number_format($booking->base_price, 0, ',', '.') }}</div>
            </div>
            @if($booking->weekend_surcharge > 0)
                <div class="detail-row">
                    <div class="detail-label">Weekend Surcharge:</div>
                    <div class="detail-value">Rp {{ number_format($booking->weekend_surcharge, 0, ',', '.') }}</div>
                </div>
            @endif
            <div class="detail-row">
                <div class="detail-label">Total Price:</div>
                <div class="detail-value">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</div>
            </div>
        </div>
        
        <div class="instructions">
            <div class="section-title">Instructions</div>
            <p>1. Please arrive 10 minutes before your session time.</p>
            <p>2. Bring this booking confirmation (printed or digital) with you.</p>
            <p>3. Staff will scan your QR code to validate your booking.</p>
            <p>4. Your session will end promptly at the scheduled end time.</p>
            <p>5. For cancellations, please contact us at least 24 hours in advance.</p>
        </div>
        
        <div class="footer">
            <p>PS Rental - 123 Gaming Street, Jakarta, Indonesia</p>
            <p>Phone: (021) 123-4567 | Email: info@psrental.com</p>
            <p>© {{ date('Y') }} PS Rental. All rights reserved.</p>
        </div>
    </div>
</body>
</html>

