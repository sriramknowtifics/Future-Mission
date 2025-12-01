@extends('layouts.app')
@section('title','Order ' . $order->order_number)

@section('content')
<div class="my-4">
  <div class="d-flex justify-content-between">
    <h3>Order {{ $order->order_number }}</h3>
    <div>
      <span class="badge badge-info">{{ ucfirst($order->status) }}</span>
    </div>
  </div>

  <div class="mt-3 row">
    <div class="col-md-6">
      <h5>Customer</h5>
      <p>{{ $order->user->name ?? 'Guest' }}<br>{{ $order->shipping_address['address'] ?? '' }}</p>
    </div>
    <div class="col-md-6 text-right">
      <h5>Totals</h5>
      <p>Subtotal: ₹{{ number_format($order->subtotal_amount,2) }}<br>
      Shipping: ₹{{ number_format($order->shipping_cost,2) }}<br>
      Tax: ₹{{ number_format($order->tax_amount,2) }}<br>
      <strong>Total: ₹{{ number_format($order->total_amount,2) }}</strong></p>
    </div>
  </div>

  <hr>
  <h5>Items</h5>
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

  <div class="mt-3">
    {{-- Actions: mark packed, shipped etc. These routes/methods should exist in your vendor order controller --}}
    <form method="POST" action="{{ route('vendor.orders.update', $order->id) }}">
      @csrf @method('PUT')
      <select name="status" class="form-control d-inline-block" style="width:auto;">
        <option value="pending" @selected($order->status=='pending')>Pending</option>
        <option value="packed" @selected($order->status=='packed')>Packed</option>
        <option value="shipped" @selected($order->status=='shipped')>Shipped</option>
        <option value="delivered" @selected($order->status=='delivered')>Delivered</option>
      </select>
      <button class="btn btn-primary">Update Status</button>
    </form>
  </div>
</div>
@endsection
