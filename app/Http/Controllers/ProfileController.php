<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderProduct;
use Auth;

class ProfileController extends Controller
{
    
    public function index() {
        $id = request('id');
        $order = null;
        if (isset($id)) {
            $order = Order::find($id);
            if ($order) {
                if ($order->user_id != Auth()->user()->id) {
                    return redirect()->back()->with('warning', 'Invalid order selected');
                }
            } else {
                return redirect()->back()->with('warning', 'Invalid order selected');
            }
        }

        $orders = Order::where('user_id', Auth()->user()->id)->orderBy('updated_at', 'desc')->get();

        return view('profile.index', [ 
            'items' => $orders, 
            'order' => $order
        ]);
    }
    
}
