@extends('layouts.app')
@section('title','Vendor Dashboard')

@section('content')
<div class="vendor-dashboard my-4">
  <div class="d-flex justify-content-between align-items-center">
    <h3>Vendor Dashboard</h3>
    <a href="{{ route('vendor.products.create') }}" class="btn btn-primary">Add Product</a>
  </div>

  <div class="row mt-3">
    <div class="col-md-3">
      <div class="card p-3">
        <h6>Sales (This Month)</h6>
        <h3>₹{{ number_format($sales_this_month ?? 0, 2) }}</h3>
        <small>{{ $orders_count_this_month ?? 0 }} orders</small>
      </div>
    </div>
    <div class="col-md-3">
      <div class="card p-3">
        <h6>Pending Orders</h6>
        <h3>{{ $pending_orders ?? 0 }}</h3>
        <a href="{{ route('vendor.orders.index') }}">View Orders</a>
      </div>
    </div>
    <div class="col-md-3">
      <div class="card p-3">
        <h6>Available Balance</h6>
        <h3>₹{{ number_format($available_balance ?? 0, 2) }}</h3>
        <a href="{{ route('vendor.payments.index') }}">Payments</a>
      </div>
    </div>
    <div class="col-md-3">
      <div class="card p-3">
        <h6>Low Stock Alerts</h6>
        <h3>{{ $low_stock_count ?? 0 }}</h3>
        <a href="{{ route('vendor.lowstock') }}">View</a>
      </div>
    </div>
  </div>

  <div class="row mt-4">
    <div class="col-md-8">
      <div class="card p-3">
        <h5>Recent Orders</h5>
        <table class="table table-sm mt-2">
          <thead><tr><th>Order #</th><th>Date</th><th>Status</th><th>Total</th><th></th></tr></thead>
          <tbody>
            @foreach($recent_orders ?? [] as $order)
              <tr>
                <td>{{ $order->order_number }}</td>
                <td>{{ $order->created_at->format('d M Y') }}</td>
                <td>{{ ucfirst($order->status) }}</td>
                <td>₹{{ number_format($order->total_amount,2) }}</td>
                <td><a class="btn btn-sm btn-outline-primary" href="{{ route('vendor.orders.show', $order->id) }}">View</a></td>
              </tr>
            @endforeach
            @if(empty($recent_orders) || count($recent_orders) === 0)
              <tr><td colspan="5">No recent orders.</td></tr>
            @endif
          </tbody>
        </table>
      </div>
    </div>

    <div class="col-md-4">
      @include('vendor.notifications.index')
    </div>
  </div>
</div>
@endsection
