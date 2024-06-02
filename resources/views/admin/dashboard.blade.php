<!-- resources/views/admin/dashboard.blade.php -->

@extends('layouts.app')

@section('content')
<div class="container">
    <h1>All Orders</h1>
    <table class="table">
        <thead>
            <tr>
                <th>Order ID</th>
                <th>User ID</th>
                <th>Order Date</th>
                <th>Total Price</th>
            </tr>
        </thead>
        <tbody>
            @foreach($orders as $order)
            <tr>
                <td>{{ $order->id }}</td>
                <td>{{ $order->user_id }}</td>
                <td>{{ $order->order_date }}</td>
                <td>{{ $order->total_price }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
