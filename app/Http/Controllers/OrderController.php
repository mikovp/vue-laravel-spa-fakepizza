<?php

namespace App\Http\Controllers;

use App\Models\Currency;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    // Different currency_id backend/frontend :(
    protected $currencies = [0 => 2, 1 => 1];

    /**
     * Display a listing of the resource.
     *
     * @return
     */
    public function index()
    {
        if (!isset($_COOKIE["items"]) and !isset($_COOKIE["currency"])) {
            return redirect('/');
        }

        $total = 0;

        // Read user COOKIES
        $items = json_decode($_COOKIE["items"]);
        $currency = $_COOKIE["currency"];
        $currency_name = Currency::find($this->currencies[$currency])->name;

        $delivery = DB::table('delivery')
            ->where('city_id', '1')
            ->where('currency_id', $this->currencies[$currency])
            ->first()->value;

        //Check on backend for price value and amount
        foreach ($items as $item) {
            if (Product::find($item->id)->price[$currency]->value != $item->currency->{$currency}->value or $item->amount < 1) {
                echo 'Incorrect price value or amount in order ';
                return redirect('/');
            };
        }

        //Sum total
        foreach ($items as $item) {
            $total += Product::find($item->id)->price[$currency]->value * $item->amount;
        }

        $order_number = sprintf("%06d", mt_rand(1, 999999));

        return view('order', [
            'items' => $items,
            'currency' => $currency,
            'delivery' => $delivery,
            'currency_name' => $currency_name,
            'total' => $total,
            'order_number' => $order_number
        ]);
    }

    /** Store order data
     *
     * @return
     */
    public function store(Request $request)
    {

        $items = json_decode($_COOKIE["items"]);
        $currency = $_COOKIE["currency"];


        if (!Auth::check()) {

            $request->validate([
                'firstname' => 'string|max:255',
                'lastname' => 'string|max:255',
                'address' => 'string|max:255',
                'office' => 'string|max:255',
                'mobile_phone' => 'string|max:25'
            ]);

            foreach ($items as $item) {
                $order = new Order;
                $order->order_number = $request->order_number;
                $order->product_id = $item->id;
                $order->amount = $item->amount;
                $order->currency_id = $this->currencies[$currency];
                $order->name = $request->firstname . ' ' . $request->lastname;
                $order->address = $request->address . ' ' . $request->office;
                $order->mobile_phone = $request->mobile_phone;
                $order->save();
            }
        }

        if (Auth::check()) {
            foreach ($items as $item) {
                $order = new Order;
                $order->order_number = $request->order_number;
                $order->user_id = Auth::user()->id;
                $order->product_id = $item->id;
                $order->amount = $item->amount;
                $order->currency_id = $this->currencies[$currency];
                $order->save();
            }
        }
        setcookie("orderok", 1, time() + 60, "/");
        return redirect('/');
    }
}
