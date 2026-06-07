<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // เช็ค role
        $user = auth()->user();

        if ($user->isCustomer()) {
            return redirect('/');
        }

        $totalOrders = Order::count();
        $pendingOrders = Order::where('status', 'pending')->count();
        $totalProducts = Product::count();
        $totalUsers = User::count();

        return view('dashboard', compact(
            'totalOrders',
            'pendingOrders',
            'totalProducts',
            'totalUsers'
        ));
    }
}