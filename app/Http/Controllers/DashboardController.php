<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sale;
use App\Models\Product;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $totalSales = Sale::sum('total_sale');
        $totalSalesToday = Sale::whereDate('created_at', Carbon::today())->sum('total_sale');
        $totalSalesUser = Sale::where('user_id', Auth::id())->sum('total_sale');
        $totalSalesTodayUser = Sale::where('user_id', Auth::id())
            ->whereDate('created_at', Carbon::today())
            ->sum('total_sale');
        $quantitySalesTodayUser = Sale::where('user_id', Auth::id())
        ->whereDate('created_at', Carbon::today())
        ->count();
        $quantitySales = Sale::count();
        $recentSales = Sale::latest()->take(5)->get(); // Get the latest 5 sales
        $lowStock = Product::where('quantity', '<', 5)->get();
        return view('dashboard', compact(
            'totalSales', 
            'quantitySales', 
            'lowStock', 
            'recentSales', 
            'totalSalesToday', 
            'totalSalesUser', 
            'totalSalesTodayUser', 
            'quantitySalesTodayUser'));
    }
}
