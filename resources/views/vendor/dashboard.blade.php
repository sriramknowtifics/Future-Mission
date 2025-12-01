@extends('layouts.layoutMaster')

@section('title', 'Vendor Dashboard')

@section('content')
  <div class="container py-4">
    <h2>Vendor Dashboard</h2>

    <p class="text-muted">Welcome, {{ auth()->user()->name }}!</p>

    <div class="row g-3 mt-4">
      <div class="col-md-3">
        <a href="{{ route('vendor.products.index') }}" class="card p-3 shadow-sm d-block text-decoration-none">
          <h5>My Products</h5>
          <p>Manage your product catalogue</p>
        </a>
      </div>

      <div class="col-md-3">
        <a href="{{ route('vendor.products.create') }}" class="card p-3 shadow-sm d-block text-decoration-none">
          <h5>Add Product / Service</h5>
          <p>Create a new listing</p>
        </a>
      </div>

      <div class="col-md-3">
        <a href="#" class="card p-3 shadow-sm d-block text-decoration-none">
          <h5>Orders</h5>
          <p>View customer orders</p>
        </a>
      </div>
    </div>
  </div>
@endsection
