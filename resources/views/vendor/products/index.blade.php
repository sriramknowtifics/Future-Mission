@extends('layouts.layoutMaster')
@section('title', 'My Products')

@section('content')

<div class="d-flex justify-content-between align-items-center my-4">
    <h3 class="fw-bold">My Products</h3>
    <div>
        <a href="{{ route('vendor.products.create') }}" class="btn btn-success">
            <i class="fa fa-plus"></i> Add Product
        </a>
        <a href="#" class="btn btn-outline-secondary">Reports</a>
    </div>
</div>

{{-- SEARCH BAR --}}
<form method="GET" class="mb-4">
    <div class="input-group">
        <input 
            type="text"
            name="q"
            class="form-control"
            placeholder="Search products..."
            value="{{ request('q') }}"
        >
        <button class="btn btn-primary">
            <i class="fa fa-search"></i> Search
        </button>
    </div>
</form>


<div class="card shadow-sm">
    <div class="card-body p-0">

        <table class="table table-hover table-striped mb-0 align-middle">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Image</th>
                    <th>Name</th>
                    <th>Price</th>
                    <th>Stock</th>
                    <th>Approval</th>
                    <th>Status</th>
                    <th width="180">Actions</th>
                </tr>
            </thead>

            <tbody>

            @forelse($products as $p)
                @php
                    $primaryImg = $p->images->where('is_primary', true)->first();
                @endphp

                <tr>
                    {{-- ID --}}
                    <td class="fw-bold">{{ $p->id }}</td>

                    {{-- PRODUCT IMAGE --}}
                    <td style="width: 80px;">
                        <img
                            src="{{ $primaryImg ? asset('storage/'.$primaryImg->path) : asset('assets/images/placeholder.png') }}"
                            class="rounded"
                            style="width:60px;height:60px;object-fit:cover;"
                            alt="product-image"
                        >
                    </td>

                    {{-- NAME --}}
                    <td class="fw-semibold">
                        {{ $p->name }}
                    </td>

                    {{-- PRICE --}}
                    <td>
                        <span class="text-success fw-bold">
                            BHD{{ number_format($p->price, 2) }}
                        </span>

                        @if ($p->offer_price)
                            <br>
                            <small class="text-muted">
                                Offer: BHD{{ number_format($p->offer_price, 2) }}
                            </small>
                        @endif
                    </td>

                    {{-- STOCK --}}
                    <td>{{ $p->stock ?? 0 }}</td>

                    {{-- APPROVAL --}}
                    <td>
                        <span class="badge
                            @if($p->approval_status === 'approved') bg-success
                            @elseif($p->approval_status === 'pending') bg-warning text-dark
                            @else bg-danger @endif">
                            {{ ucfirst($p->approval_status) }}
                        </span>
                    </td>

                    {{-- ACTIVE / INACTIVE BUTTON --}}
                    <td>
                        <form method="POST" action="{{ route('vendor.products.update', $p->id) }}">
                            @csrf @method('PUT')

                            {{-- Flip Active Status --}}
                            <input type="hidden" 
                                   name="is_active" 
                                   value="{{ $p->is_active ? 0 : 1 }}">

                            <button 
                                class="btn btn-sm {{ $p->is_active ? 'btn-success' : 'btn-secondary' }}">
                                {{ $p->is_active ? 'Active' : 'Inactive' }}
                            </button>
                        </form>
                    </td>

                    {{-- ACTIONS --}}
                    <td>

                        {{-- VIEW --}}
                        <a href="{{ route('vendor.products.show', $p->id) }}" 
                           class="btn btn-sm btn-outline-primary">
                            <i class="fa fa-eye"></i> View
                        </a>

                        {{-- EDIT --}}
                        <a href="{{ route('vendor.products.edit', $p->id) }}" 
                           class="btn btn-sm btn-primary">
                            <i class="fa fa-edit"></i> Edit
                        </a>

                        {{-- DELETE --}}
                        <form 
                            action="{{ route('vendor.products.destroy', $p->id) }}"
                            method="POST"
                            class="d-inline"
                            onsubmit="return confirm('Delete this product?');"
                        >
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-danger">
                                <i class="fa fa-trash"></i> Delete
                            </button>
                        </form>

                    </td>
                </tr>
            @empty

                <tr>
                    <td colspan="8" class="text-center py-4">
                        <img src="{{ asset('assets/images/empty-cart.png') }}" 
                             width="120" class="mb-3">
                        <h5>No products found.</h5>
                    </td>
                </tr>

            @endforelse

            </tbody>
        </table>

    </div>
</div>

{{-- PAGINATION --}}
<div class="mt-3">
    {{ $products->links() }}
</div>

@endsection
