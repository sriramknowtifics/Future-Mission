@extends('layouts.layoutMaster')
@section('title', 'Pending Products')

@section('content')

<div class="d-flex justify-content-between align-items-center my-4">
    <h3 class="fw-bold">Pending Product Approvals</h3>

    <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary">
        <i class="fa fa-list"></i> View All Products
    </a>
</div>

<div class="card shadow-sm">
    <div class="card-body p-0">

        <table class="table table-hover table-striped mb-0 align-middle">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Image</th>
                    <th>Product</th>
                    <th>Vendor</th>
                    <th>Price</th>
                    <th>Category</th>
                    <th>Brand</th>
                    <th>Submitted</th>
                    <th width="200">Actions</th>
                </tr>
            </thead>

            <tbody>

                @forelse ($products as $p)

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

                    {{-- VENDOR --}}
                    <td>
                        {{ $p->vendor->shop_name ?? $p->vendor->user->name ?? '—' }}
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

                    {{-- CATEGORY --}}
                    <td>{{ $p->category->name ?? '—' }}</td>

                    {{-- BRAND --}}
                    <td>{{ $p->brand->name ?? '—' }}</td>

                    {{-- DATE --}}
                    <td>{{ $p->created_at->diffForHumans() }}</td>

                    {{-- ACTION BUTTONS --}}
                    <td>

                        {{-- APPROVE --}}
                        <form 
                            action="{{ route('admin.products.approve', $p->id) }}" 
                            method="POST"
                            class="d-inline">
                            @csrf
                            <button class="btn btn-sm btn-success">
                                <i class="fa fa-check"></i> Approve
                            </button>
                        </form>

                        {{-- REJECT --}}
                        <form 
                            action="{{ route('admin.products.reject', $p->id) }}" 
                            method="POST"
                            class="d-inline">
                            @csrf
                            <button 
                                class="btn btn-sm btn-danger"
                                onclick="return confirm('Reject this product?');">
                                <i class="fa fa-times"></i> Reject
                            </button>
                        </form>

                    </td>

                </tr>

                @empty
                <tr>
                    <td colspan="9" class="text-center py-4">
                        <img src="{{ asset('assets/images/empty-cart.png') }}" 
                             width="120" class="mb-3">
                        <h5>No pending products.</h5>
                    </td>
                </tr>
                @endforelse

            </tbody>

        </table>

    </div>
</div>

{{-- Pagination --}}
<div class="mt-3">
    {{ $products->links() }}
</div>

@endsection
