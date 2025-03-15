<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class BookingController extends Controller
{
    public function index()
    {
        $services = Service::all();
        return view('booking.index', compact('services'));
    }
    
    public function create(Request $request)
    {
        $services = Service::all();
        $selectedService = $request->query('service') ? Service::where('name', $request->query('service'))->first() : null;
        
        return view('booking.create', compact('services', 'selectedService'));
    }
    
    public function store(Request $request)
    {
        $validated = $request->validate([
            'service_id' => 'required|exists:services,id',
            'booking_date' => 'required|date|after:today',
            'session_time' => 'required|string',
            'name' => 'required|string',
            'email' => 'required|email',
            'phone' => 'required|string',
        ]);
        
        // Get service details
        $service = Service::findOrFail($validated['service_id']);
        
        // Calculate price
        $bookingDate = Carbon::parse($validated['booking_date']);
        $isWeekend = $bookingDate->isWeekend();
        $basePrice = $service->price;
        $weekendSurcharge = $isWeekend ? $basePrice * 0.2 : 0;
        $totalPrice = $basePrice + $weekendSurcharge;
        
        // Create booking
        $booking = new Booking([
            'user_id' => Auth::id() ?? 1,
            'service_id' => $validated['service_id'],
            'booking_date' => $validated['booking_date'],
            'session_time' => $validated['session_time'],
            'base_price' => $basePrice,
            'weekend_surcharge' => $weekendSurcharge,
            'total_price' => $totalPrice,
            'status' => 'pending'
        ]);
        
        $booking->save();
        
        // Initialize Midtrans payment
        $orderId = 'PS-' . $booking->id;
        
        $params = [
            'transaction_details' => [
                'order_id' => $orderId,
                'gross_amount' => (int) $totalPrice,
            ],
            'customer_details' => [
                'first_name' => $validated['name'],
                'email' => $validated['email'],
                'phone' => $validated['phone'],
            ],
            'item_details' => [
                [
                    'id' => $service->id,
                    'price' => (int) $basePrice,
                    'quantity' => 1,
                    'name' => $service->name . ' Session',
                ],
            ],
        ];
        
        if ($weekendSurcharge > 0) {
            $params['item_details'][] = [
                'id' => 'weekend-surcharge',
                'price' => (int) $weekendSurcharge,
                'quantity' => 1,
                'name' => 'Weekend Surcharge',
            ];
        }
        
        try {
            // Get Snap payment page URL
            $snap = app('midtrans');
            $snapToken = $snap->getSnapToken($params);
            $snapUrl = 'https://app.sandbox.midtrans.com/snap/v2/vtweb/' . $snapToken;
            
            // Update booking with payment info
            $booking->payment_token = $snapToken;
            $booking->payment_url = $snapUrl;
            $booking->save();
            
            return redirect()->away($snapUrl);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Payment initialization failed: ' . $e->getMessage());
        }
    }
    
    public function show($id)
    {
        $booking = Booking::with('service')->findOrFail($id);
        return view('booking.show', compact('booking'));
    }
    
    public function userBookings()
    {
        $bookings = Booking::with('service')
            ->where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();
            
        return view('booking.user-bookings', compact('bookings'));
    }
}