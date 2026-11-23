<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Inquiry;
use App\Models\Product;
use App\Models\Service;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $totalInquiries = Inquiry::count();
        $totalAppointments = Appointment::count();
        $totalQuotes = Inquiry::where('type', 'quote')->count();
        $totalProducts = Product::count();
        $totalServices = Service::count();

        $unreadInquiries = Inquiry::where('is_read', false)->count();
        $pendingAppointments = Appointment::where('status', 'pending')->count();

        // Recent Submissions
        $recentInquiries = Inquiry::orderBy('created_at', 'desc')->take(5)->get();
        $recentAppointments = Appointment::orderBy('created_at', 'desc')->take(5)->get();

        // Monthly statistics (past 6 months)
        $months = [];
        $monthlyInquiries = [];
        $monthlyAppointments = [];

        for ($i = 5; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $monthLabel = $date->format('M Y');
            $year = $date->year;
            $month = $date->month;

            $months[] = $monthLabel;
            $monthlyInquiries[] = Inquiry::whereYear('created_at', $year)->whereMonth('created_at', $month)->count();
            $monthlyAppointments[] = Appointment::whereYear('created_at', $year)->whereMonth('created_at', $month)->count();
        }

        return view('admin.dashboard', compact(
            'totalInquiries',
            'totalAppointments',
            'totalQuotes',
            'totalProducts',
            'totalServices',
            'unreadInquiries',
            'pendingAppointments',
            'recentInquiries',
            'recentAppointments',
            'months',
            'monthlyInquiries',
            'monthlyAppointments'
        ));
    }
}
