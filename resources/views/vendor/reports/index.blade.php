@extends('layouts.app')
@section('title','Reports')

@section('content')
<div class="my-4 d-flex justify-content-between align-items-center">
  <h3>Reports</h3>
  <div>
    <a href="{{ route('vendor.reports') }}" class="btn btn-outline-secondary">Refresh</a>
  </div>
</div>

<div class="card p-3">
  <h5>Sales Summary</h5>
  <table class="table table-sm">
    <thead><tr><th>Period</th><th>Orders</th><th>Sales</th><th>Avg Order</th></tr></thead>
    <tbody>
      <tr><td>Today</td><td>{{ $summary['today']['orders'] ?? 0 }}</td><td>₹{{ number_format($summary['today']['sales'] ?? 0,2) }}</td><td>₹{{ number_format($summary['today']['avg'] ?? 0,2) }}</td></tr>
      <tr><td>This Month</td><td>{{ $summary['month']['orders'] ?? 0 }}</td><td>₹{{ number_format($summary['month']['sales'] ?? 0,2) }}</td><td>₹{{ number_format($summary['month']['avg'] ?? 0,2) }}</td></tr>
      <tr><td>Last 12 Months</td><td>{{ $summary['year']['orders'] ?? 0 }}</td><td>₹{{ number_format($summary['year']['sales'] ?? 0,2) }}</td><td>₹{{ number_format($summary['year']['avg'] ?? 0,2) }}</td></tr>
    </tbody>
  </table>
</div>

<div class="mt-3">
  <h5>Top Products</h5>
  <ul>
    @foreach($top_products ?? [] as $tp)
      <li>{{ $tp->name }} — {{ $tp->total_sold ?? 0 }} units (₹{{ number_format($tp->total_sales ?? 0,2) }})</li>
    @endforeach
    @if(empty($top_products) || count($top_products)===0)
      <li>No data yet.</li>
    @endif
  </ul>
</div>
@endsection
