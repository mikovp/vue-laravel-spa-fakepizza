@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        {{ __('Orders History') }}
                    </div>
                    <div class="card-body">
                        <table class="table">
                            <thead>
                            <tr>
                                <th scope="col">Order#</th>
                                <th scope="col">Pizza name</th>
                                <th scope="col">Amount</th>
                                <th scope="col">Currency</th>
                                <th scope="col">Data</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($orders as $key => $order)
                                <tr>
                                    <td>{{$order->order_number}}</td>
                                    <td>{{$order->product->name}}</td>
                                    <td>{{$order->amount}}</td>
                                    <td>{{ $currency[$order->currency_id] }}</td>
                                    <td>{{$order->created_at}}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <br/>
                <h4>Delivery data:</h4>
                <br/>
                <h5>Name: </h5>{{ Auth::user()->name }}
                <h5>Address: </h5>{{ Auth::user()->address }}
                <h5>Mobile Phone: </h5>{{ Auth::user()->mobile_phone }}
            </div>
        </div>
    </div>
@endsection
