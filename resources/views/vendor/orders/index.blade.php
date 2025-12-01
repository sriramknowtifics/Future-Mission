@extends('layouts.app')
@section('title','Vendor Orders')

@section('content')
<div class="my-4 d-flex justify-content-between align-items-center">
  <h3>Orders</h3>
</div>

<table class="table table-hover">
  <thead><tr><th>Order #</th><th>Date</th><th>Customer</th><th>Status</th><th>Total</th><th>Actions</th></tr></thead>
  <tbody>
    @forelse($orders as $o)
      <tr>
        <td>{{ $o->order_number }}</td>
        <td>{{ $o->created_at->format('d M Y') }}</td>
        <td>{{ $o->user->name ?? 'Guest' }}</td>
        <td>{{ ucfirst($o->status) }}</td>
        <td>₹{{ number_format($o->total_amount,2) }}</td>
        <td>
          <a href="{{ route('vendor.orders.show', $o->id) }}" class="btn btn-sm btn-outline-primary">View</a>
        </td>
      </tr>
    @empty
      <tr><td colspan="6">No orders.</td></tr>
    @endforelse
  </tbody>
</table>

{{ $orders->links() }}
@endsection
