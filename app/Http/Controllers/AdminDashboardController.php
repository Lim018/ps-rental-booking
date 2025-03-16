<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Service;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AdminDashboardController extends Controller
{
    /**
     * Display the admin dashboard.
     */
    public function index()
    {
        // Get statistics for the dashboard
        $totalBookings = Booking::count();
        $totalRevenue = Booking::where('status', 'Paid')->sum('total_price');
        $ps4Bookings = Booking::whereHas('service', function($query) {
            $query->where('name', 'like', '%PlayStation 4%');
        })->count();
        $ps5Bookings = Booking::whereHas('service', function($query) {
            $query->where('name', 'like', '%PlayStation 5%');
        })->count();
        
        // Get recent bookings
        $recentBookings = Booking::with('service')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();
            
        // Get monthly revenue data for chart
        $monthlyRevenue = Booking::where('status', 'Paid')
            ->whereYear('created_at', Carbon::now()->year)
            ->select(
                DB::raw('MONTH(created_at) as month'),
                DB::raw('SUM(total_price) as revenue')
            )
            ->groupBy('month')
            ->orderBy('month')
            ->get()
            ->keyBy('month')
            ->map(function ($item) {
                return $item->revenue;
            });
            
        // Fill in missing months with zero
        for ($i = 1; $i <= 12; $i++) {
            if (!isset($monthlyRevenue[$i])) {
                $monthlyRevenue[$i] = 0;
            }
        }
        $monthlyRevenue = $monthlyRevenue->sortKeys();
        
        // Get booking status distribution
        $bookingStatusCounts = Booking::select('status', DB::raw('count(*) as count'))
            ->groupBy('status')
            ->get()
            ->pluck('count', 'status');
            
        return view('admin.dashboard', compact(
            'totalBookings', 
            'totalRevenue', 
            'ps4Bookings', 
            'ps5Bookings', 
            'recentBookings',
            'monthlyRevenue',
            'bookingStatusCounts'
        ));
    }
}

