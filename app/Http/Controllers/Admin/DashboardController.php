<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $revenueThisMonth = Order::where('status', 'completed')->whereYear('created_at', now()->year)->whereMonth('created_at', now()->month)->sum('total_amount');
        $revenueLastMonth = Order::where('status', 'completed')->whereYear('created_at', now()->subMonth()->year)->whereMonth('created_at', now()->subMonth()->month)->sum('total_amount');
        $revenueComparison = $revenueLastMonth > 0 ? (($revenueThisMonth - $revenueLastMonth) / $revenueLastMonth) * 100 : 100;

        $stats = [
            'revenue_month' => Order::where('status', 'completed')->whereMonth('created_at', now()->month)->sum('total_amount'),
            'orders_month' => Order::whereMonth('created_at', now()->month)->count(), // <-- Data ini sudah ada
            'new_customers_month' => User::where('role', 'customer')->whereMonth('created_at', now()->month)->count(),
            'total_revenue' => $revenueThisMonth,
            'pending_orders' => Order::whereIn('status', ['pending_dealer_acceptance', 'processing'])->count(),
            'revenue_comparison' => $revenueComparison
        ];

        $salesData = Order::where('created_at', '>=', now()->subDays(30))->groupBy('date')->orderBy('date', 'ASC')->get([DB::raw('DATE(created_at) as date'), DB::raw('SUM(total_amount) as total')]);
        $chartData = ['labels' => $salesData->pluck('date')->map(fn($date) => \Carbon\Carbon::parse($date)->format('d M')), 'values' => $salesData->pluck('total')];
        $recentCustomers = User::where('role', 'customer')->latest()->take(5)->get();

        return view('admin.dashboard', compact('stats', 'chartData', 'recentCustomers'));
    }
}
