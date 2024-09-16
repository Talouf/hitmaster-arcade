<!DOCTYPE html>
<html>
<head>
    <title>Invoice</title>
    <style>
        /* Add your CSS styles here */
    </style>
</head>
<body>
    <h1>Invoice #{{ $order->id }}</h1>
    <p>Order Date: {{ $order->created_at->format('Y-m-d') }}</p>
    <p>Customer: {{ $order->user->name }}</p>
    
    <table>
        <thead>
            <tr>
                <th>Product</th>
                <th>Quantity</th>
                <th>Price</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($order->orderItems as $item)
            <tr>
                <td>{{ $item->product->name }}</td>
                <td>{{ $item->quantity }}</td>
                <td>${{ number_format($item->price, 2) }}</td>
                <td>${{ number_format($item->quantity * $item->price, 2) }}</td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="3">Total</td>
                <td>${{ number_format($order->total_price, 2) }}</td>
            </tr>
        </tfoot>
    </table>
</body>
</html>