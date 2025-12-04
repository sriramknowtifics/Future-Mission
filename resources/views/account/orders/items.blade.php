@extends('layouts.theme')

@section('title', 'Order Items')

@section('content')

<div class="premium-card">
    <h3 class="premium-title mb-3">
        Items in Order #{{ $order->order_number }}
    </h3>

    <div class="premium-table-wrapper">
        <table class="table premium-table align-middle">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Vendor</th>
                    <th>Qty</th>
                    <th>Price</th>
                    <th>Subtotal</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($items as $item)
                <tr>
                    <td>{{ $item->product->name ?? $item->name }}</td>
                    <td>{{ $item->vendor->shop_name ?? 'N/A' }}</td>
                    <td>{{ $item->qty }}</td>
                    <td>BHD {{ number_format($item->price, 2) }}</td>
                    <td>BHD {{ number_format($item->subtotal, 2) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</div>

@endsection
