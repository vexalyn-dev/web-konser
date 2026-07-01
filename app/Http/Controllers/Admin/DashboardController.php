<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Ticket;
use App\Models\User;
use App\Services\TicketService;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __construct(
        private TicketService $ticketService
    ) {
    }

    /**
     * Show admin dashboard.
     */
    public function index(): View
    {
        // Get statistics
        $stats = $this->ticketService->getStatistics();
        $stats['total_users'] = User::count();
        $stats['total_staff'] = User::staff()->count();

        // Get chart data
        $chartData = $this->ticketService->getChartData(7);

        // Get city distribution
        $cityData = $this->ticketService->getCityDistribution(5);

        // Get recent activities
        $recentActivities = ActivityLog::with('user')
            ->latest()
            ->limit(10)
            ->get();

        // Get recent tickets
        $recentTickets = $this->ticketService->getRecentTickets(5);

        // Get today's check-ins
        $todayCheckIns = Ticket::checkedIn()
            ->whereDate('checked_in_at', today())
            ->latest('checked_in_at')
            ->limit(5)
            ->get();

        // Calculate percentages
        $checkInPercentage = $stats['total'] > 0
            ? round(($stats['checked_in'] / $stats['total']) * 100, 1)
            : 0;

        return view('admin.dashboard', compact(
            'stats',
            'chartData',
            'cityData',
            'recentActivities',
            'recentTickets',
            'todayCheckIns',
            'checkInPercentage'
        ));
    }

    /**
     * Get dashboard data via AJAX (for real-time updates).
     */
    public function data()
    {
        $stats = $this->ticketService->getStatistics();
        $stats['total_users'] = User::count();

        return response()->json([
            'success' => true,
            'data' => $stats,
        ]);
    }
}