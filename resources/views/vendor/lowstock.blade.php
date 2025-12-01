@extends('layouts.app')
@section('title','Low Stock Alerts')

@section('content')
<div class="my-4">
  <h3>Low Stock Products</h3>

  <table class="table">
    <thead><tr><th>Product</th><th>Stock</th><th>Action</th></tr></thead>
    <tbody>
      @forelse($low_stock_products as $p)
        <tr>
          <td>{{ $p->name }}</td>
          <td>{{ $p->stock }}</td>
          <td>
            <a href="{{ route('vendor.products.edit', $p->id) }}" class="btn btn-sm btn-primary">Edit</a>
          </td>
        </tr>
      @empty
        <tr><td colspan="3">No low stock alerts.</td></tr>
      @endforelse
    </tbody>
  </table>
</div>
@endsection
