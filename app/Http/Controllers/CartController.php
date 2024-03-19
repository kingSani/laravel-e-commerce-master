<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderProduct;
use Auth;
use Mail;

class CartController extends Controller
{
    
    public function index() {
        $price = 0;
        $found = false;
        $cart_items = Cart::where('user_id', Auth()->user()->id)->orderBy('updated_at', 'desc')->get();

        $cartUpdated = false;
        foreach ($cart_items as $item) {
            $price += $item->product->price * $item->quantity;
            if ($item->product->out_of_stock == 1) {
                $item->delete();
                $cartUpdated = true;
            }
        }

        if ($cartUpdated) {
            return redirect()->route('cart')->with('message', 'Your cart has been updated');
        }

        return view('cart.index', [ 
            'items' => $cart_items, 
            'found' => $found, 
            'total_price' => $price 
        ]);
    }
    
    public function show() {
        $price = 0;
        $cart_items = Cart::where('user_id', Auth()->user()->id)->orderBy('updated_at', 'desc')->get();

        $cartUpdated = false;
        foreach ($cart_items as $item) {
            $price += $item->product->price * $item->quantity;
            if ($item->product->out_of_stock == 1) {
                $item->delete();
                $cartUpdated = true;
            }
        }

        if ($cartUpdated) {
            return redirect()->route('cart')->with('message', 'Your cart has been updated');
        }

        if ($price == 0) {
            return redirect()->route('products')->with('warning', 'Error checking out. Your cart is empty');
        }

        return view('cart.checkout', [ 
            'items' => $cart_items, 
            'total_price' => $price 
        ]);
    }

    public function store(Request $request) {
        $price = 0;
        $cart_items = Cart::where('user_id', Auth()->user()->id)->orderBy('updated_at', 'desc')->get();

        foreach ($cart_items as $item) {
            $price += $item->product->price * $item->quantity;
        }
        
        $order = new Order;
        $order->user_id = Auth()->user()->id;
        $order->address = $request->address;
        $order->total_price = $price;
        $order->save();

        $order = Order::where('user_id', Auth()->user()->id)->orderBy('updated_at', 'desc')->first();

        foreach ($cart_items as $item) {
            $orderProduct = new OrderProduct;
            $orderProduct->order_id = $order->id;
            $orderProduct->product_id = $item->product_id;
            $orderProduct->name = $item->product->name;
            $orderProduct->color = $item->product->color;
            $orderProduct->size = $item->product->size;
            $orderProduct->type = $item->product->type;
            $orderProduct->price = $item->product->price;
            $orderProduct->image = $item->product->image;
            $orderProduct->quantity = $item->quantity;
            $orderProduct->save();

            $item->delete();
        }

        $user = Auth()->user();

        $data = array(
            'name'=> $user->name,
            'content'=> "Your order has been placed successfully."
        );
        
        Mail::send('mail.order', $data, function($message) use ($user) {
            $message->to($user->email, $user->name)->subject
                ('Order confirmed');
            $message->from('xyz@gmail.com','K-Clothing Administrator');
        });

        return redirect()->route('profile')->with('message', 'Order Placed Successfully');
    }
}
