<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Cart;
use Auth;

class ProductController extends Controller
{
    //
    public function index() {
        // $products = Product::orderBy('updated_at', 'desc')->get();

        // caching products for 5 seconds to improve performance
        $products = cache()->remember("all-products", 5, function () {
            return Product::orderBy('updated_at', 'desc')->paginate(16);
        });
        
        return view('products.index', [ 'products'=> $products ]);
    }

    public function show($id) {
        $product = Product::find($id);
        if (!$product) {
            return redirect()->route('products')->with('warning', 'Product not found');
        }

        if ($product->out_of_stock == 1) {
            return redirect()->route('products')->with('warning', 'Product is out of stock');
        }

        $quantity = 0;
        $found = false;
        if (Auth::check()) {
            $cart_items = Cart::where('user_id', Auth()->user()->id)->get();
            foreach ($cart_items as $item) {
                if ($item->product_id == $id) {
                    $found = true;
                    $quantity = $item->quantity;
                }
            }
        }

        return view('products.show', [ 
            'product' => $product, 
            'found' => $found, 
            'quantity' => $quantity 
        ]);
    }

    public function store($id) {
        $product = Product::find($id);
        if (!$product) {
            return redirect()->route('products')->with('warning', 'Product not found');
        }

        if ($product->out_of_stock == 1) {
            return redirect()->route('products')->with('warning', 'Product is out of stock');
        }

        $cart_items = Cart::where('user_id', Auth()->user()->id)->orderBy('updated_at', 'desc')->get();

        $found = false;

        foreach ($cart_items as $item) {
            if ($item->product_id == $id) {
                $found = true;
                $item->quantity++;
                $item->save();
            }
        }

        if (!$found) {
            $cart_item = new Cart;
            $cart_item->user_id = Auth()->user()->id;
            $cart_item->product_id = $id;
            $cart_item->quantity = 1;
            $cart_item->save();
        }

        return redirect()->back()->with('message', $found ? 'Quantity added successfully' : 'Item added to cart successfully');
    } 
    
    public function destroy($id) {
        $product = Product::find($id);
        if (!$product) {
            return redirect()->route('products')->with('warning', 'Product not found');
        }

        $cart_items = Cart::where('user_id', Auth()->user()->id)->orderBy('updated_at', 'desc')->get();

        $deleted = true;

        foreach ($cart_items as $item) {
            if ($item->product_id == $id) {
                if ($item->quantity == 1) {
                    $item->delete();
                } else {
                    $item->quantity--;
                    $deleted = false;
                    $item->save();
                }
            }
        }

        if (!$deleted) {
            return redirect()->back()->with('message', 'Item quantity reduced successfully');
        }

        return redirect()->back()->with('message', 'Item removed successfully');
    } 
}
