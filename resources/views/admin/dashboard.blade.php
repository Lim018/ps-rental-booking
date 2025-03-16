@extends('layouts.admin')

@section('title', 'Admin Dashboard')

@section('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/admin-dashboard.css') }}">
@endsection

@section('content')
    <div class="dashboard-header">
        <h1 class="dashboard-title">Dashboard</h1>
        <div class="dashboard-actions">
            <div class="date-filter">
                <select id="date-range" class="form-control">
                    <option value="today">Today</option>
                    <option value="week">This Week</option>
                    <option value="month" selected>This Month</option>
                    <option value="year">This Year</option>
                    <option value="all">All Time</option>
                </select>
            </div>
        </div>
    </div>
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                    <line x1="16" y1="2" x2="16" y2="6"></line>
                    <line x1="8" y1="2" x2="8" y2="6"></line>
                    <line x1="3" y1="10" x2="21" y2="10"></line>
                </svg>
            </div>
            <div class="stat-content">
                <div class="stat-title">Total Bookings</div>
                <div class="stat-value">{{ $totalBookings }}</div>
                <div class="stat-description">All time bookings</div>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="12" y1="1" x2="12" y2="23"></line>
                    <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path>
                </svg>
            </div>
            <div class="stat-content">
                <div class="stat-title">Total Revenue</div>
                <div class="stat-value">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</div>
                <div class="stat-description">From paid bookings</div>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="6" y1="11" x2="10" y2="11"></line>
                    <line x1="8" y1="9" x2="8" y2="13"></line>
                    <line x1="15" y1="12" x2="15.01" y2="12"></line>
                    <line x1="18" y1="10" x2="18.01" y2="10"></line>
                    <path d="M17.32 5H6.68a4 4 0 0 0-3.978 3.59c-.006.052-.01.101-.017.152C2.604 9.416 2 14.456 2 16a3 3 0 0 0 3 3c1 0 1.5-.5 2-1l1.414-1.414A2 2 0 0 1 9.828 16h4.344a2 2 0 0 1 1.414.586L17 18c.5.5 1 1 2 1a3 3 0 0 0 3-3c0-1.544-.604-6.584-.685-7.258-.007-.05-.011-.1-.017-.151A4 4 0 0 0 17.32 5z"></path>
                </svg>
            </div>
            <div class="stat-content">
                <div class="stat-title">PS4 Bookings</div>
                <div class="stat-value">{{ $ps4Bookings }}</div>
                <div class="stat-description">PlayStation 4 sessions</div>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="6" y1="11" x2="10" y2="11"></line>
                    <line x1="8" y1="9" x2="8" y2="13"></line>
                    <line x1="15" y1="12" x2="15.01" y2="12"></line>
                    <line x1="18" y1="10" x2="18.01" y2="10"></line>
                    <path d="M17.32 5H6.68a4 4 0 0 0-3.978 3.59c-.006.052-.01.101-.017.152C2.604 9.416 2 14.456 2 16a3 3 0 0 0 3 3c1 0 1.5-.5 2-1l1.414-1.414A2 2 0 0 1 9.828 16h4.344a2 2 0 0 1 1.414.586L17 18c.5.5 1 1 2 1a3 3 0 0 0 3-3c0-1.544-.604-6.584-.685-7.258-.007-.05-.011-.1-.017-.151A4 4 0 0 0 17.32 5z"></path>
                </svg>
            </div>
            <div class="stat-content">
                <div class="stat-title">PS5 Bookings</div>
                <div class="stat-value">{{ $ps5Bookings }}</div>
                <div class="stat-description">PlayStation 5 sessions</div>
            </div>
        </div>
    </div>
    <div class="charts-grid">
        <div class="chart-card">
            <div class="chart-header">
                <h2 class="chart-title">Monthly Revenue</h2>
            </div>
            <div class="chart-body">
                <canvas id="revenue-chart"></canvas>
            </div>
        </div>

        <div class="chart-card">
            <div class="chart-header">
                <h2 class="chart-title">Booking Status</h2>
            </div>
            <div class="chart-body">
                <canvas id="status-chart"></canvas>
            </div>
        </div>
    </div>
    <div class="recent-bookings-card">
        <div class="card-header">
            <h2 class="card-title">Recent Bookings</h2>
            <a href="{{ route('admin.bookings.index') }}" class="btn btn-outline">View All</a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Customer</th>
                            <th>Service</th>
                            <th>Date & Time</th>
                            <th>Price</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($recentBookings as $booking)
                            <tr>
                                <td>{{ substr($booking->id, 0, 8) }}...</td>
                                <td>
                                    <div>{{ $booking->user_name }}</div>
                                    <div class="text-muted">{{ $booking->user_phone }}</div>
                                </td>
                                <td>{{ $booking->service->name }}</td>
                                <td>
                                    <div>{{ \Carbon\Carbon::parse($booking->booking_date)->format('M d, Y') }}</div>
                                    <div class="text-muted">{{ $booking->session_time }}</div>
                                </td>
                                <td>Rp {{ number_format($booking->total_price, 0, ',', '.') }}</td>
                                <td>
                                    <span class="status-badge status-{{ strtolower($booking->status) }}">
                                        {{ $booking->status }}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('booking.show', $booking->id) }}" class="btn btn-sm btn-outline">View</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Monthly Revenue Chart
            const revenueCtx = document.getElementById('revenue-chart').getContext('2d');
            const revenueChart = new Chart(revenueCtx, {
                type: 'bar',
                data: {
                    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                    datasets: [{
                        label: 'Revenue (Rp)',
                        data: [
                            {{ $monthlyRevenue[1] }},
                            {{ $monthlyRevenue[2] }},
                            {{ $monthlyRevenue[3] }},
                            {{ $monthlyRevenue[4] }},
                            {{ $monthlyRevenue[5] }},
                            {{ $monthlyRevenue[6] }},
                            {{ $monthlyRevenue[7] }},
                            {{ $monthlyRevenue[8] }},
                            {{ $monthlyRevenue[9] }},
                            {{ $monthlyRevenue[10] }},
                            {{ $monthlyRevenue[11] }},
                            {{ $monthlyRevenue[12] }}
                        ],
                        backgroundColor: 'rgba(79, 70, 229, 0.2)',
                        borderColor: 'rgba(79, 70, 229, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                callback: function(value) {
                                    return 'Rp ' + value.toLocaleString('id-ID');
                                }
                            }
                        }
                    }
                }
            });

            // Booking Status Chart
            const statusCtx = document.getElementById('status-chart').getContext('2d');
            const statusChart = new Chart(statusCtx, {
                type: 'doughnut',
                data: {
                    labels: [
                        'Pending', 
                        'Paid', 
                        'Cancelled', 
                        'Completed'
                    ],
                    datasets: [{
                        data: [
                            {{ $bookingStatusCounts['Pending'] ?? 0 }},
                            {{ $bookingStatusCounts['Paid'] ?? 0 }},
                            {{ $bookingStatusCounts['Cancelled'] ?? 0 }},
                            {{ $bookingStatusCounts['Completed'] ?? 0 }}
                        ],
                        backgroundColor: [
                            '#FCD34D', // Pending - yellow
                            '#10B981', // Paid - green
                            '#EF4444', // Cancelled - red
                            '#3B82F6'  // Completed - blue
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'bottom',
                        }
                    }
                }
            });

            // Date range filter
            document.getElementById('date-range').addEventListener('change', function() {
                // In a real implementation, this would filter the data based on the selected date range
                // For this example, we'll just log the selected value
                console.log('Selected date range:', this.value);
                // In a production environment, you would make an AJAX request to get filtered data
                // and update the charts and statistics accordingly
            });
        });
    </script>
@endsection

