<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Auth;
use App\Models\Order;

class OrderController extends Controller
{
    /* Displaying success page when purchage is successed */
    public function success(){
        return view('orders.success');
    }

    /* Displaying my orders */
    public function showOrders(){ 
        $orders = Order::with('product')->whereHas('user', function($query){
            $query->where('user_id',Auth::id());
        })->get();
        return view('orders.list',compact('orders'));
    }
}
