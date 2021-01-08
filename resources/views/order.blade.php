@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <div class="card">
                    <div class="card-header">
                        <h4>Order #{{$order_number}}</h4>
                    </div>
                    <div class="card-body">
                    <table class="table">
                        <thead>
                        <tr>
                            <th scope="col">Name</th>
                            <th scope="col">Amount</th>
                            <th scope="col">Price</th>
                            <th scope="col">Currency</th>
                        </tr>
                        </thead>
                        <tbody>
                    @foreach($items as $key => $item)
                        <tr>
                            <td>{{$item->name}}</td>
                            <td>{{$item->amount}}</td>
                            <td>{{$item->currency->{$currency}->value }}</td>
                            <td>{{$item->currency->{$currency}->name}}</td>
                        </tr>
                    @endforeach
                        </tbody>
                        <tr><td></td></tr>
                        <tr>
                            <td>Delivery:</td>
                            <td></td>
                            <td>{{ $delivery }}</td>
                            <td>{{ $currency_name }}</td>
                        </tr>
                        <tr><td></td><td></td><td></td><td></td></tr>
                        <tr class="table-info">
                            <td></td>
                            <td>Total:</td>
                            <td>{{ $total + $delivery }}</td>
                            <td>{{ $currency_name }}</td>
                        </tr>
                    </table>
                    </div>
                </div>
                <br/>
                    <h4>Delivery data:</h4>
                @if (!Auth::user())
                    <form action="/order" method="post">
                        @csrf
                        <input type="hidden" value="{{$order_number}}" name="order_number" />
                        <div class="form-row">
                            <div class="col-md-6 mb-3">
                                <label for="validationServer01">First name</label>
                                <input type="text" class="form-control" name="firstname" placeholder="First name"  required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="validationServer02">Last name</label>
                                <input type="text" class="form-control" name="lastname" placeholder="Last name"  required>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-md-6 mb-3">
                                <label for="validationServer03">Address</label>
                                <input type="text" class="form-control" name="address" placeholder="Address" required>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="validationServer04">Office</label>
                                <input type="text" class="form-control" name="office" placeholder="Office" required>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="validationServer05">Mobile phone</label>
                                <input type="text" class="form-control" name="mobile_phone" placeholder="Mobile phone" required>
                            </div>
                        </div>
                        <button class="btn btn-primary btn-lg" type="submit" style="float: right;">Checkout</button>
                    </form>
                @else
                        <h5>Name: </h5>{{ Auth::user()->name }}
                        <h5>Address: </h5>{{ Auth::user()->address }}
                        <h5>Mobile Phone: </h5>{{ Auth::user()->mobile_phone }}
                    <form action="/order" method="post">
                        @csrf
                        <input type="hidden" value="{{$order_number}}" name="order_number" />
                    <button class="btn btn-primary btn-lg" type="submit" style="float: right;">Checkout</button>
                    </form>
                @endif
            </div>
        </div>
    </div>
@endsection
