<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\User;
use App\Models\Cart;
use App\Models\Chat;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Events\MessageSent;
use Auth;
use Mail;

class ApiController extends Controller
{
    //
    public function getAllProducts() {
        $products = Product::orderBy('updated_at', 'desc')->get();
        return response()->json($products);
    }

    public function searchProducts($text) {
        $products = Product::whereRaw("MATCH(size, type, color, name) AGAINST(?)", array($text))->get();
        return response()->json($products);
    }

    public function getUserCart ($id) {
        $cart_items = Cart::where('user_id', $id)->orderBy('updated_at', 'desc')->get();
        return response()->json($cart_items);
    }

    public function getUserChat ($id) {
        $messages = Chat::where('user_id', $id)->orderBy('updated_at', 'desc')->get();
        return response()->json($messages);
    }

    public function getAllCustomers () {
        // This doesnt get me chats in order
        // $users = User::where('role', 'CUSTOMER')->with('chat')->orderBy('created_at', 'desc')->get();

        $users = User::where('role', 'CUSTOMER')->orderBy('created_at', 'desc')->get();

        if (count($users) > 0) {
            foreach ($users as &$user) {
                $messages = Chat::where('user_id', $user->id)->orderBy('updated_at', 'asc')->get();
                $user->chat = $messages;
            }
        }
        
        return response()->json($users);
    }

    public function sendMessage(Request $request) {
        $message = new Chat;
        $message->user_id = $request->user_id;
        $message->sender = $request->sender;
        $message->message = $request->message;
        $message->seen = 0;

        $message->save();
        
        broadcast(new MessageSent($message))->toOthers();
        
        $user = User::find($request->user_id);

        $data = array(
            'name'=> $user->name,
            'content'=> "You have been sent a message. Please quickly review"
        );
        
        Mail::send('mail.order', $data, function($message) use ($user) {
            $message->to($user->email, $user->name)->subject
                ("You've got a message!");
            $message->from('xyz@gmail.com','Gamers-Hub Administrator');
        });
        
        return response()->json($message);
    }
}