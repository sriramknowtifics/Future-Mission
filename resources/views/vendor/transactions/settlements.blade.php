@extends('layouts.app')
@section('title','Transaction History')

@section('content')
<div class="my-4 d-flex justify-content-between align-items-center">
  <h3>Transaction History</h3>
  <a href="{{ route('vendor.payments.index') }}" class="btn btn-outline-secondary">Back</a>
</div>

<table class="table table-sm">
  <thead><tr><th>#</th><th>Date</th><th>Type</th><th>Amount</th><th>Status</th><th>Meta</th></tr></thead>
  <tbody>
    @forelse($transactions as $t)
      <tr>
        <td>{{ $t->id }}</td>
        <td>{{ $t->created_at->format('d M Y') }}</td>
        <td>{{ ucfirst($t->type) }}</td>
        <td>₹{{ number_format($t->amount,2) }}</td>
        <td>{{ ucfirst($t->status) }}</td>
        <td>{{ json_encode($t->meta ?? []) }}</td>
      </tr>
    @empty
      <tr><td colspan="6">No transactions yet.</td></tr>
    @endforelse
  </tbody>
</table>

{{ $transactions->links() }}
@endsection
