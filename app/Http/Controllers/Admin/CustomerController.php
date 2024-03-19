<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Mail;

class CustomerController extends Controller
{
    /**
     * Display the login view.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $admins = User::where('role', 'ADMIN')->orderBy('updated_at', 'desc')->get();
        $customers = User::where('role', 'CUSTOMER')->orderBy('updated_at', 'desc')->get();

        return view('admin.customer.index', [
            'customers' => $customers,
            'admins' => $admins,
        ]);
    }

    public function show($id) {
        $customer = User::find($id);
        if (!$customer) {
            return redirect()->back()->with('warning', 'Invalid user selected');
        }

        if ($customer->role == 'ADMIN') {
            return redirect()->back()->with('warning', 'Invalid user selected');
        }

        $orders = $customer->order;

        return view("admin.customer.show", [
            'customer' => $customer,
            'orders' => $orders
        ]);
    }

    public function update(Request $request) {
        $id = $request->id;
        $customer = User::find($id);
        if (!$customer) {
            return redirect()->back()->with('warning', 'Invalid user selected');
        }

        if ($customer->role == 'ADMIN') {
            return redirect()->back()->with('warning', 'Invalid Customer selected');
        }

        if (count($customer->cart) > 0) {
            return redirect()->back()->with('warning', 'Error: Customer has items in cart');
        }

        if (count($customer->order) > 0) {
            return redirect()->back()->with('warning', 'Error: Customer has already made an order');
        }

        $customer->role = 'ADMIN';
        $customer->save();

        $user = $customer->fresh();
        $data = array(
            'name'=> $user->name,
            'content'=> "You have been upgraded to Admin Role"
        );
        
        Mail::send('mail.order', $data, function($message) use ($user) {
            $message->to($user->email, $user->name)->subject
                ("Account Upgrade!");
            $message->from('xyz@gmail.com','K-Clothing Administrator');
        });
        return redirect()->route('admin.customer')->with('message', 'Customer upgraded to Admin role successfully');

    }

}
