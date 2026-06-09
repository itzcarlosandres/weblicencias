<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Order;
use App\Models\User;
use App\Models\License;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Coupon;
use App\Models\BlogPost;
use App\Models\Ticket;
use App\Models\Setting;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_revenue' => Order::where('status', 'paid')->sum('total'),
            'today_revenue' => Order::where('status', 'paid')->whereDate('created_at', today())->sum('total'),
            'total_orders' => Order::count(),
            'pending_orders' => Order::where('status', 'pending')->count(),
            'total_users' => User::count(),
            'total_products' => Product::where('is_active', true)->count(),
            'total_licenses' => License::count(),
            'available_licenses' => License::where('status', 'available')->count(),
            'open_tickets' => Ticket::where('status', 'open')->count(),
        ];

        $recentOrders = Order::with(['user', 'items.product'])
            ->latest()
            ->limit(10)
            ->get();

        $topProducts = Product::with('category')
            ->orderByDesc('sold_count')
            ->limit(5)
            ->get();

        // 30 days revenue chart data
        $chartData = [];
        $chartLabels = [];
        for ($i = 29; $i >= 0; $i--) {
            $date = now()->subDays($i)->format('Y-m-d');
            $chartLabels[] = now()->subDays($i)->format('d M');
            $chartData[] = Order::whereIn('status', ['paid', 'delivered'])
                ->whereDate('created_at', $date)
                ->sum('total');
        }

        return view('admin.dashboard', compact('stats', 'recentOrders', 'topProducts', 'chartData', 'chartLabels'));
    }
}
