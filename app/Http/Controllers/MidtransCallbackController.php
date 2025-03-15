<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;
use Midtrans\Notification;

class MidtransCallbackController extends Controller
{
    public function handle(Request $request)
    {
        try {
            $notification = new Notification();
            
            $orderId = $notification->order_id;
            $statusCode = $notification->status_code;
            $transactionStatus = $notification->transaction_status;
            $fraudStatus = $notification->fraud_status;
            
            // Extract booking ID from order ID (PS-{id})
            $bookingId = substr($orderId, 3);
            $booking = Booking::findOrFail($bookingId);
            
            if ($transactionStatus == 'capture') {
                if ($fraudStatus == 'challenge') {
                    $booking->status = 'pending';
                } else if ($fraudStatus == 'accept') {
                    $booking->status = 'paid';
                }
            } else if ($transactionStatus == 'settlement') {
                $booking->status = 'paid';
            } else if ($transactionStatus == 'cancel' || $transactionStatus == 'deny' || $transactionStatus == 'expire') {
                $booking->status = 'cancelled';
            } else if ($transactionStatus == 'pending') {
                $booking->status = 'pending';
            }
            
            $booking->payment_id = $notification->transaction_id;
            $booking->save();
            
            return response()->json(['status' => 'success']);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}