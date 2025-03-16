<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;
use Midtrans\Config;
use Midtrans\Notification;
use Illuminate\Support\Facades\Log;

class MidtransCallbackController extends Controller
{
    public function __construct()
    {
        Config::$serverKey = config('services.midtrans.server_key');
        Config::$isProduction = config('services.midtrans.is_production');
        Config::$isSanitized = config('services.midtrans.is_sanitized');
        Config::$is3ds = config('services.midtrans.is_3ds');
    }

    public function handle(Request $request)
    {
        try {
            $notification = new Notification();
            
            $orderId = $notification->order_id;
            $statusCode = $notification->status_code;
            $transactionStatus = $notification->transaction_status;
            $fraudStatus = $notification->fraud_status;
            
            $booking = Booking::findOrFail($orderId);
            
            if ($transactionStatus == 'capture') {
                if ($fraudStatus == 'challenge') {
                    $booking->status = 'Pending';
                } else if ($fraudStatus == 'accept') {
                    $booking->status = 'Paid';
                    
                    // Generate PDF and send SMS with download link
                    app(BookingController::class)->generateAndSendPDF($booking);
                }
            } else if ($transactionStatus == 'settlement') {
                $booking->status = 'Paid';
                
                // Generate PDF and send SMS with download link
                app(BookingController::class)->generateAndSendPDF($booking);
            } else if ($transactionStatus == 'cancel' || $transactionStatus == 'deny' || $transactionStatus == 'expire') {
                $booking->status = 'Cancelled';
            } else if ($transactionStatus == 'pending') {
                $booking->status = 'Pending';
            }
            
            $booking->save();
            
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            Log::error('Midtrans callback error: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
}

