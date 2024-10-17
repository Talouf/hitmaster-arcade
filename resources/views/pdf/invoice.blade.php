<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Facture #{{ $order->id }}</title>
    <style>
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            margin: 0;
            padding: 0;
        }

        .invoice-box {
            max-width: 800px;
            margin: auto;
            padding: 30px;
            border: 1px solid #eee;
            box-shadow: 0 0 10px rgba(0, 0, 0, .15);
            background-color: #fff;
        }

        .invoice-box table {
            width: 100%;
            line-height: inherit;
            text-align: left;
            border-collapse: collapse;
        }

        .invoice-box table td {
            padding: 5px;
            vertical-align: top;
        }

        .invoice-box table tr.top table td {
            padding-bottom: 20px;
        }

        .invoice-box table tr.heading td {
            background: #eee;
            border-bottom: 1px solid #ddd;
            font-weight: bold;
        }

        .invoice-box table tr.item td {
            border-bottom: 1px solid #eee;
        }

        .invoice-box table tr.total td:nth-child(2) {
            border-top: 2px solid #eee;
            font-weight: bold;
        }

        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 12px;
            color: #777;
        }

        .logo {
            font-size: 24px;
            font-weight: bold;
            color: #e53e3e;
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
                                <span class="logo">HitMaster Arcade</span><br>
                                123 Rue de l'Innovation<br>
                                75001 Paris, France<br>
                                Téléphone: +33 1 23 45 67 89<br>
                                Email: contact@hitmasterarcade.com
                            </td>
                            <td style="text-align: right;">
                                <h1>Facture #{{ $order->id }}</h1>
                                Date d'émission: {{ $order->created_at->format('d/m/Y') }}<br>
                                Date d'échéance: {{ $order->created_at->addDays(30)->format('d/m/Y') }}
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>

            <tr class="information">
            <td colspan="2">
                <table>
                    <tr>
                        <td style="text-align: right;">
                            <strong>Livrer à:</strong><br>
                            @if($order->shippingInfo)
                                {{ $order->shippingInfo->name }}<br>
                                {{ $order->shippingInfo->address }}<br>
                                {{ $order->shippingInfo->city }}, {{ $order->shippingInfo->zip_code }}<br>
                                @if($order->shippingInfo->state)
                                    {{ $order->shippingInfo->state }},
                                @endif
                                {{ $order->shippingInfo->country }}
                            @else
                                Adresse de livraison non disponible
                            @endif
                        </td>
                    </tr>
                </table>
            </td>
        </tr>

            <tr class="heading">
                <td>Description</td>
                <td>Montant</td>
            </tr>

            @foreach($order->orderItems as $item)
                <tr class="item">
                    <td>{{ $item->product->name }} (x{{ $item->quantity }})</td>
                    <td>{{ number_format($item->price * $item->quantity, 2, ',', ' ') }} €</td>
                </tr>
            @endforeach

            <tr class="total">
                <td></td>
                <td>Sous-total: {{ number_format($order->total_price, 2, ',', ' ') }} €</td>
            </tr>

            <tr class="tax">
                <td></td>
                <td>TVA (20%): {{ number_format($order->total_price * 0.2, 2, ',', ' ') }} €</td>
            </tr>

            <tr class="total">
                <td></td>
                <td>Total TTC: {{ number_format($order->total_price * 1.2, 2, ',', ' ') }} €</td>
            </tr>
        </table>

        <div class="footer">
            <p><strong>Informations légales</strong></p>
            <p>Numéro de TVA intracommunautaire: FR 32 123456789 | SIRET: 123 456 789 00019 | RCS Paris B 123 456 789
            </p>
            <p>SAS au capital de 50 000 € | Code APE: 4791A</p>
        </div>
    </div>
</body>

</html>