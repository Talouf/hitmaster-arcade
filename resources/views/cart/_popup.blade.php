@if($cartItems->isEmpty())
    <p>Your cart is empty.</p>
@else
    <table class="table-auto w-full">
        <thead>
            <tr>
                <th class="px-4 py-2">Product</th>
                <th class="px-4 py-2">Quantity</th>
                <th class="px-4 py-2">Price</th>
                <th class="px-4 py-2">Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($cartItems as $item)
            <tr>
                <td class="border px-4 py-2">{{ $item->product->name }}</td>
                <td class="border px-4 py-2">{{ $item->quantity }}</td>
                <td class="border px-4 py-2">${{ $item->price }}</td>
                <td class="border px-4 py-2">${{ $item->quantity * $item->price }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
@endif
