@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Admin Dashboard</h1>
    <h2>All Orders</h2>
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
    <a href="{{ route('admin.news.create') }}" class="btn btn-primary">Create News</a>
</div>
@endsection
