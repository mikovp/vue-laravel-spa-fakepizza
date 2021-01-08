<?php

namespace App\Http\Controllers;

use App\Models\Currency;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {

        $id = Auth::user()->id;
        $orders = Order::with('product.price.currency')->where('user_id',$id)->get();
        $currencies = Currency::all();

        $curr = [];
        foreach ($currencies as $currency){
            $curr += [$currency->id => $currency->name ];
        }

        return view('home',[
            'orders'=>$orders,
            'currency'=>$curr
        ]);
    }
}
