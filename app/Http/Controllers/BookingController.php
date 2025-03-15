<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    /**
     * Display a listing of the bookings.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $bookings = Booking::with('service')
            ->orderBy('created_at', 'desc')
            ->paginate(10);
            
        return view('booking.index', compact('bookings'));
    }

    /**
     * Show the form for creating a new booking.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $services = Service::all();
        $timeSlots = [
            '10:00 - 12:00',
            '12:00 - 14:00',
            '14:00 - 16:00',
            '16:00 - 18:00',
            '18:00 - 20:00',
            '20:00 - 22:00',
        ];
        
        return view('booking.create', compact('services', 'timeSlots'));
    }

    /**
     * Store a newly created booking in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'booking_date' => 'required|date|after_or_equal:today',
            'session_time' => 'required',
            'service_id' => 'required|exists:services,id',
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'base_price' => 'required|numeric',
            'weekend_surcharge' => 'required|numeric',
            'total_price' => 'required|numeric',
        ]);
        
        // Create booking
        $booking = new Booking();
        $booking->booking_date = $request->booking_date;
        $booking->session_time = $request->session_time;
        $booking->service_id = $request->service_id;
        $booking->user_name = $request->name;
        $booking->user_phone = $request->phone;
        $booking->base_price = $request->base_price;
        $booking->weekend_surcharge = $request->weekend_surcharge;
        $booking->total_price = $request->total_price;
        $booking->status = 'Pending';
        $booking->notes = $request->notes;
        $booking->is_used = false;
        $booking->save();
        
        // Generate payment URL (Midtrans integration)
        $paymentUrl = $this->generatePaymentUrl($booking);
        $booking->payment_url = $paymentUrl;
        $booking->save();
        
        return redirect($paymentUrl);
    }

    /**
     * Display the specified booking.
     *
     * @param  \App\Models\Booking  $booking
     * @return \Illuminate\Http\Response
     */
    public function show(Booking $booking)
    {
        $booking->load('service');
        
        // Generate QR code for the booking
        $qrCode = $this->generateQRCode($booking->id);
        
        return view('booking.show', compact('booking', 'qrCode'));
    }

    /**
     * Cancel the specified booking.
     *
     * @param  \App\Models\Booking  $booking
     * @return \Illuminate\Http\Response
     */
    public function cancel(Booking $booking)
    {
        if ($booking->status != 'Cancelled') {
            $booking->status = 'Cancelled';
            $booking->save();
            
            return redirect()->route('booking.show', $booking->id)
                ->with('success', 'Booking has been cancelled successfully.');
        }
        
        return redirect()->route('booking.show', $booking->id)
            ->with('error', 'Booking is already cancelled.');
    }

    /**
     * Show the booking check form.
     *
     * @return \Illuminate\Http\Response
     */
    public function check()
    {
        return view('booking.check');
    }

    /**
     * Find bookings by phone.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function findByPhone(Request $request)
    {
        $request->validate([
            'phone' => 'required|string'
        ]);
        
        $bookings = Booking::where('user_phone', $request->phone)
            ->with('service')
            ->orderBy('booking_date', 'desc')
            ->get();
        
        return view('booking.check', compact('bookings'));
    }

    /**
     * Find booking by ID.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function findById(Request $request)
    {
        $request->validate([
            'booking_id' => 'required'
        ]);
        
        $bookings = Booking::where('id', $request->booking_id)
            ->with('service')
            ->get();
        
        return view('booking.check', compact('bookings'));
    }

    /**
     * Handle Midtrans payment notification.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function handlePaymentNotification(Request $request)
    {
        $input = $request->all();
        
        // Verify signature (in a real implementation)
        // $this->verifySignature($input);
        
        $orderId = $input['order_id'];
        $transactionStatus = $input['transaction_status'];
        $fraudStatus = $input['fraud_status'] ?? null;
        
        $booking = Booking::find($orderId);
        
        if (!$booking) {
            return response()->json(['status' => 'error', 'message' => 'Booking not found'], 404);
        }
        
        if ($transactionStatus == 'capture') {
            if ($fraudStatus == 'challenge') {
                $booking->status = 'Pending';
            } else if ($fraudStatus == 'accept') {
                $booking->status = 'Paid';
                
                // Generate PDF and send SMS with download link
                $this->generateAndSendPDF($booking);
            }
        } else if ($transactionStatus == 'settlement') {
            $booking->status = 'Paid';
            
            // Generate PDF and send SMS with download link
            $this->generateAndSendPDF($booking);
        } else if ($transactionStatus == 'cancel' || $transactionStatus == 'deny' || $transactionStatus == 'expire') {
            $booking->status = 'Cancelled';
        } else if ($transactionStatus == 'pending') {
            $booking->status = 'Pending';
        }
        
        $booking->save();
        
        return response()->json(['status' => 'success']);
    }

    /**
     * Generate and download PDF for a booking.
     *
     * @param  \App\Models\Booking  $booking
     * @return \Illuminate\Http\Response
     */
    public function downloadPdf(Booking $booking)
    {
        $booking->load('service');
        
        // Generate QR code
        $qrCode = $this->generateQRCode($booking->id);
        
        // Generate PDF
        $pdf = PDF::loadView('booking.pdf', compact('booking', 'qrCode'));
        
        return $pdf->download('booking-' . $booking->id . '.pdf');
    }

    /**
     * Generate payment URL using Midtrans.
     *
     * @param  \App\Models\Booking  $booking
     * @return string
     */
    private function generatePaymentUrl(Booking $booking)
    {
        // In a real implementation, this would integrate with Midtrans
        // For this example, we'll just return a mock URL
        
        // For testing purposes, we'll just redirect to the booking show page
        // In a real implementation, this would be the Midtrans payment URL
        return route('booking.show', $booking->id);
    }

    /**
     * Generate QR code for a booking.
     *
     * @param  int  $bookingId
     * @return string
     */
    private function generateQRCode($bookingId)
    {
        $qrCode = QrCode::format('png')
            ->size(300)
            ->errorCorrection('H')
            ->generate($bookingId);
        
        return base64_encode($qrCode);
    }

    /**
     * Generate PDF and send SMS with download link.
     *
     * @param  \App\Models\Booking  $booking
     * @return void
     */
    private function generateAndSendPDF(Booking $booking)
    {
        // Generate QR code
        $qrCode = $this->generateQRCode($booking->id);
        
        // Generate PDF
        $pdf = PDF::loadView('booking.pdf', compact('booking', 'qrCode'));
        
        // Save PDF to storage
        $filename = 'booking-' . $booking->id . '.pdf';
        $path = 'bookings/' . $filename;
        Storage::put('public/' . $path, $pdf->output());
        
        // Generate temporary URL for download
        $downloadUrl = URL::temporarySignedRoute(
            'booking.download-pdf',
            now()->addDays(7),
            ['booking' => $booking->id]
        );
        
        // Store download URL
        $booking->pdf_url = $downloadUrl;
        $booking->save();
        
        // Send SMS with download link
        $this->sendSMS($booking->user_phone, 'Your PlayStation booking is confirmed! Download your booking details here: ' . $downloadUrl);
    }

    /**
     * Send SMS with booking details.
     *
     * @param  string  $phoneNumber
     * @param  string  $message
     * @return void
     */
    private function sendSMS($phoneNumber, $message)
    {
        // In a real implementation, this would integrate with an SMS service
        // For this example, we'll just log the message
        Log::info('SMS to ' . $phoneNumber . ': ' . $message);
    }
}

