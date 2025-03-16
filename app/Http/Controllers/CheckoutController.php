<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Service;
use Illuminate\Http\Request;
use Midtrans\Config;
use Midtrans\Snap;

class CheckoutController extends Controller
{
    public function __construct()
    {
        Config::$serverKey = config('services.midtrans.server_key');
        Config::$isProduction = config('services.midtrans.is_production');
        Config::$isSanitized = config('services.midtrans.is_sanitized');
        Config::$is3ds = config('services.midtrans.is_3ds');
    }

    public function process(Request $request, $bookingId)
    {
        $booking = Booking::findOrFail($bookingId);
        
        // Set booking status to pending if it's not already
        if ($booking->status !== 'Pending') {
            $booking->status = 'Pending';
            $booking->save();
        }

        $params = [
            'transaction_details' => [
                'order_id' => $booking->id, 
                'gross_amount' => (int)$booking->total_price,
            ],
            'customer_details' => [
                'first_name' => "it",
                'email' => "it@gmail.com",
                'phone' => $booking->user_phone,
            ],
            'item_details' => [
                [
                    'id' => $booking->service_id,
                    'price' => (int)$booking->total_price,
                    'quantity' => 1,
                    'name' => $booking->service->name . ' (' . $booking->session_time . ')',
                ],
            ],
        ];

        $snapToken = Snap::getSnapToken($params);

        $booking->payment_token = $snapToken;
        $booking->save();

        return redirect()->route('checkout.show', ['booking' => $booking->id]);
    }

    public function show($id)
    {
        $booking = Booking::with('service')->findOrFail($id);
        return view('checkout.show', compact('booking'));
    }

    public function success($id)
    {
        $booking = Booking::findOrFail($id);
        $booking->status = 'Paid';
        $booking->save();

        // Generate PDF and send SMS with download link
        app(BookingController::class)->generateAndSendPDF($booking);

        return view('checkout.success', compact('booking'));
    }

    public function failed($id)
    {
        $booking = Booking::findOrFail($id);
        $booking->status = 'Cancelled';
        $booking->save();

        return view('checkout.failed', compact('booking'));
    }

    public function index()
    {
        $bookings = Booking::with('service')
            ->where('status', 'Pending')
            ->orderBy('created_at', 'desc')
            ->get();
            
        $total = $bookings->sum('total_price');
        
        return view('checkout.index', compact('bookings', 'total'));
    }
}

