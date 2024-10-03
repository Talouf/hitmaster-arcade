<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice #{{ $order->id }}</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .invoice-box { max-width: 800px; margin: auto; padding: 30px; border: 1px solid #eee; box-shadow: 0 0 10px rgba(0, 0, 0, .15); }
        .invoice-box table { width: 100%; line-height: inherit; text-align: left; }
        .invoice-box table td { padding: 5px; vertical-align: top; }
        .invoice-box table tr.top table td { padding-bottom: 20px; }
        .invoice-box table tr.heading td { background: #eee; border-bottom: 1px solid #ddd; font-weight: bold; }
        .invoice-box table tr.item td { border-bottom: 1px solid #eee; }
        .invoice-box table tr.total td:nth-child(2) { border-top: 2px solid #eee; font-weight: bold; }
        @media only screen and (max-width: 600px) {
            .invoice-box table tr.top table td { width: 100%; display: block; text-align: center; }
        }
    </style>
</head>
<body>
    <div class="invoice-box">
        <table cellpadding="0" cellspacing="0">
            <tr class="top">
                <td colspan="2">
                    <table>
                        <tr>
                            <td>
                                <h1>Invoice #{{ $order->id }}</h1>
                                Created: {{ $order->created_at->format('F d, Y') }}<br>
                                Due: {{ $order->created_at->addDays(30)->format('F d, Y') }}
                            </td>
                            <td style="text-align: right;">
                            <img src="{{ public_path('images/hitmaster.png') }}" style="width:100px;">
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            
            <tr class="information">
                <td colspan="2">
                    <table>
                        <tr>
                            <td>
                                Your Company Name<br>
                                123 Company Address<br>
                                City, State ZIP
                            </td>
                            <td style="text-align: right;">
                                {{ $order->user->name }}<br>
                                {{ $order->user->email }}
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            
            <tr class="heading">
                <td>Item</td>
                <td>Price</td>
            </tr>
            
            @foreach($order->orderItems as $item)
            <tr class="item">
                <td>{{ $item->product->name }} (x{{ $item->quantity }})</td>
                <td>€{{ number_format($item->price * $item->quantity, 2) }}</td>
            </tr>
            @endforeach
            
            <tr class="total">
                <td></td>
                <td>Total: €{{ number_format($order->total_price, 2) }}</td>
            </tr>
        </table>
    </div>
</body>
</html>