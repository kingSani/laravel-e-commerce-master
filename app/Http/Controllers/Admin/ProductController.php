<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;

class ProductController extends Controller
{

    public function index() {

        $products = Product::orderBy('updated_at', 'desc')->get();
        $add = request('add');
        if ($add != 1) {
            $add = 0;
        }

        $productId = request('id');
        $edit = 0;
        $product = null;
        if (isset($productId)) {
            $product = Product::find($productId);
            if ($product) {
                $edit = 1;
            } else {
                return redirect()->route('admin.products')->with('warning', 'Error: Product selected is invalid');
            }
        }

        return view ('admin.products', [ 
            'add' => $add, 
            'products' => $products, 
            'product' => $product,
            'edit' => $edit
        ]);
    }

    public function store(Request $request) {
        //Ensure file uploaded is of type image and less than 2mb
        $this->validate($request, [
            'product_image' => 'image|max:1999'
        ]);

        // get filename with extention
        $filenameWithExt = $request->file('product_image')->getClientOriginalName();
        
        // get just the filename
        $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
        
        // get just the file extention
        $extension = $request->file('product_image')->getClientOriginalExtension();
        
        // get name to store
        $filenameToStore = $filename.'_'.time().'.'.$extension;
        
        // store the file
        $path = $request->file('product_image')->storeAs('public/products_images', $filenameToStore);

        $product = new Product;
        $product->name = $request->name;
        $product->color = $request->color;
        $product->image = $filenameToStore;
        $product->type = $request->type;
        $product->size = $request->size;
        $product->price = $request->price;

        $product->save();
        return redirect()->route('admin.products')->with('message', 'Product added successfully');
    }

    public function update(Request $request) {
        $product = Product::find($request->id);
        if (!$product) {
            return redirect()->route('admin.products')->with('warning', 'Error: Invalid product selected');
        }

        // Ensure file uploaded is of type image and less than 2mb
        // Image can also be ignored altogether
        $this->validate($request, [
            'product_image' => 'image|nullable|max:1999'
        ]);

        if ($request->hasFile('product_image')) {
            // get filename with extention
            $filenameWithExt = $request->file('product_image')->getClientOriginalName();
            
            // get just the filename
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            
            // get just the file extention
            $extension = $request->file('product_image')->getClientOriginalExtension();
            
            // get name to store
            $filenameToStore = $filename.'_'.time().'.'.$extension;
            
            // store the file
            $path = $request->file('product_image')->storeAs('public/products_images', $filenameToStore);
        } else {
            $filenameToStore = $product->image;
        }


        $product->name = $request->name;
        $product->color = $request->color;
        $product->image = $filenameToStore;
        $product->type = $request->type;
        $product->size = $request->size;
        $product->price = $request->price;
        $product->out_of_stock = $request->stock;
        $product->save();

        return redirect()->route('admin.products')->with('message', 'Product edited successfully');
    }

    public function destroy(Request $request) {
        $product = Product::find($request->id);
        if (!$product) {
            return redirect()->route('admin.products')->with('warning', 'Error: Product selected is invalid');
        }

        $product->delete();

        return redirect()->route('admin.products')->with('message', 'Product deleted successfully');
    }
}
