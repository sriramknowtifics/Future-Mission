@extends('layouts.app')
@section('title','Order ' . $order->order_number)
@section('content')
<h3 class="my-4">Order {{ $order->order_number }}</h3>

<p>Status: <strong>{{ ucfirst($order->status) }}</strong></p>
<p>Placed on: {{ $order->created_at->format('d M Y H:i') }}</p>

<table class="table">
  <thead><tr><th>Product</th><th>Price</th><th>Qty</th><th>Subtotal</th></tr></thead>
  <tbody>
    @foreach($order->items as $it)
      <tr>
        <td>{{ $it->name }}</td>
        <td>₹{{ number_format($it->price,2) }}</td>
        <td>{{ $it->qty }}</td>
        <td>₹{{ number_format($it->subtotal,2) }}</td>
      </tr>
    @endforeach
  </tbody>
</table>

<p>Total: ₹{{ number_format($order->total_amount,2) }}</p>
@endsection
