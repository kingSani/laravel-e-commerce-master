<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;

class OrderController extends Controller
{
    /**
     * Display the login view.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $orders = Order::orderBy('updated_at', 'desc')->get();

        return view('admin.orders.index', [ 
            'items' => $orders, 
        ]);
    }

    public function show($id) {
        $order = Order::find($id);
        if (!$order) {
            return redirect()->back()->with('warning', 'Invalid order selected');
        }

        return view('admin.orders.show', [ 'order' => $order ]);
    }

}
