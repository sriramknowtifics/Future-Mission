@extends('layouts.app')
@section('title','Payments & Settlements')

@section('content')
<div class="my-4 d-flex justify-content-between align-items-center">
  <h3>Payments & Settlements</h3>
  <a href="{{ route('vendor.transactions') }}" class="btn btn-outline-secondary">Transaction History</a>
</div>

<div class="card p-3">
  <h5>Available Balance</h5>
  <h2>₹{{ number_format($available_balance ?? 0, 2) }}</h2>

  <div class="mt-3">
    <h6>Recent Settlements</h6>
    <table class="table table-sm">
      <thead><tr><th>Date</th><th>Type</th><th>Amount</th><th>Status</th></tr></thead>
      <tbody>
        @forelse($transactions ?? [] as $t)
          <tr>
            <td>{{ $t->created_at->format('d M Y') }}</td>
            <td>{{ ucfirst($t->type) }}</td>
            <td>₹{{ number_format($t->amount,2) }}</td>
            <td>{{ ucfirst($t->status) }}</td>
          </tr>
        @empty
          <tr><td colspan="4">No transactions</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>
@endsection
