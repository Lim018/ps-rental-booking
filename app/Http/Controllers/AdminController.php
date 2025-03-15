<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AdminController extends Controller
{
    public function validateBooking(Request $request)
    {
        $booking = null;
        
        if ($request->has('booking_id')) {
            $booking = Booking::with('service')->find($request->booking_id);
        }
        
        return view('admin.validate-booking', compact('booking'));
    }
    
    public function validateBookingPost(Request $request)
    {
        $request->validate([
            'booking_id' => 'required'
        ]);
        
        $booking = Booking::with('service')->find($request->booking_id);
        
        return view('admin.validate-booking', compact('booking'));
    }
    
    public function markAsUsed(Booking $booking)
    {
        if ($booking->status == 'Paid' && !$booking->is_used) {
            $booking->is_used = true;
            $booking->used_at = Carbon::now();
            $booking->save();
            
            return redirect()->route('admin.validate-booking', ['booking_id' => $booking->id])
                ->with('success', 'Booking has been marked as used successfully.');
        }
        
        return redirect()->route('admin.validate-booking', ['booking_id' => $booking->id])
            ->with('error', 'Unable to mark booking as used.');
    }
}