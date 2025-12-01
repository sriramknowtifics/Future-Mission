@php use Illuminate\Support\Str;@endphp

@extends('layouts.theme')
@section('title', 'Shop')
@section('body_class', 'bg-light')

@section('content')

{{-- ========================================
    BREADCRUMB
======================================== --}}
<div class="bg-white border-bottom">
    <div class="container py-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item">
                    <a href="{{ route('shop.index') }}">Shop</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    {{ $current ?? 'All Products' }}
                </li>
            </ol>
        </nav>
    </div>
</div>


{{-- ========================================
    PAGE WRAPPER
======================================== --}}
<div class="container py-4">
    <div class="row g-4">

        {{-- ========================================
            SIDEBAR (FILTERS)
        ======================================== --}}
        <aside class="col-lg-3">

            {{-- PRICE FILTER --}}
            <div class="card shadow-sm mb-4">
    <div class="card-body">
        <h5 class="fw-bold mb-3">Price Filter</h5>

        <form action="{{ route('shop.index') }}" method="GET">

            {{-- MIN PRICE --}}
            <div class="mb-3">
                <label class="form-label">Min Price</label>
                <div class="input-group">
                    <span class="input-group-text">BHD</span>
                    <input type="number" name="min_price"
                           value="{{ request('min_price',0) }}"
                           class="form-control">
                </div>
            </div>

            {{-- MAX PRICE --}}
            <div class="mb-3">
                <label class="form-label">Max Price</label>
                <div class="input-group">
                    <span class="input-group-text">BHD</span>
                    <input type="number" name="max_price"
                           value="{{ request('max_price',10000) }}"
                           class="form-control">
                </div>
            </div>

             <button class="btn btn-sm btn-primary-custom w-100">Apply</button>
        </form>
    </div>
</div>


            {{-- CATEGORY GRID --}}
            <div class="card shadow-sm mb-4">
                <div class="card-body">
                    <h5 class="fw-bold mb-3">Categories</h5>

                    <div class="row g-3">
                        @foreach($categories as $cat)
                        <div class="col-4">
                            <a href="{{ route('shop.index',['category'=>$cat->id]) }}"
                               class="text-center d-block p-2 bg-light rounded hover-shadow">
                                <img src="{{ asset('storage/'.$cat->icon) }}"
                                     class="img-fluid mb-1" style="height:40px;">
                                <div class="small text-dark fw-semibold">
                                    {{ Str::limit($cat->name,12) }}
                                </div>
                            </a>
                        </div>
                        @endforeach
                    </div>

                </div>
            </div>


            {{-- BRANDS --}}
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="fw-bold mb-3">Brands</h5>
                    <ul class="list-unstyled m-0 p-0">
                        @foreach($categories as $category)
                        <li class="mb-2">
                            <a href="{{ route('shop.index',['category'=>$category->id]) }}"
                               class="text-dark small">
                                {{ $category->name }}
                            </a>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>

        </aside>



        {{-- ========================================
            PRODUCT GRID
        ======================================== --}}
        <div class="col-lg-9">

            {{-- HEADER FILTER BAR --}}
            <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">

                <div class="text-muted small">
                    Showing <strong>{{ $products->count() }}</strong> of {{ $products->total() }}
                </div>

             

            </div>



            {{-- PRODUCT LIST --}}
            <div class="row g-4">

                @forelse($products as $product)
                    @php $img = $product->primaryImage ?? $product->images->first(); @endphp

                    <div class="col-md-4 col-sm-6">
                        <div class="card h-100 shadow-sm product-card">
                            
                            {{-- IMAGE --}}
                            <a href="{{ route('products.show',$product->id) }}">
                                <img src="{{ $img ? asset('storage/'.$img->path) : asset('assets/images/placeholder.png') }}"
                                     class="card-img-top"
                                     style="height:230px; object-fit:cover;">
                            </a>

                            <div class="card-body text-center">

                                <h6 class="fw-semibold">
                                    <a href="{{ route('products.show',$product->id) }}"
                                       class="text-dark text-decoration-none">
                                        {{ Str::limit($product->name,45) }}
                                    </a>
                                </h6>

                                <div class="small text-muted mb-1">
                                    {{ optional($product->category)->name ?? 'Uncategorized' }}
                                </div>

                                <div class="price-bhd mb-2">
                                    BHD {{ number_format($product->price,2) }}
                                </div>


                                <form action="{{ route('cart.add') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                    <input type="hidden" name="qty" value="1"> 
                                    <button class="btn btn-sm btn-primary-custom w-100">
                                        <i class="fa fa-cart-plus me-1"></i> Add to Cart
                                    </button>
                                </form>


                            </div>

                        </div>
                    </div>

                @empty

                    <div class="col-12 text-center py-5">
                        <img src="{{ asset('assets/images/empty-cart.png') }}" width="180">
                        <h5 class="mt-3 text-muted">No products found</h5>
                    </div>

                @endforelse

            </div>



            {{-- PAGINATION --}}
            <div class="mt-4">
                {{ $products->appends(request()->query())->links('pagination::bootstrap-5') }}
            </div>

        </div>

    </div>
</div>



{{-- ========================================
    CUSTOM CSS
======================================== --}}

@push('styles')
<style>
/* ---------------------------------------------------------
   GLOBAL PREMIUM VARIABLES
--------------------------------------------------------- */
:root {
    --color-primary: #FFAB1D;
    --color-secondary: #1F1F25;
    --color-body: #6E777D;
    --color-heading: #2C3C28;
    --color-white: #ffffff;
    --color-light: #f5f6fa;

    --radius-md: 12px;
    --radius-lg: 16px;

    --shadow-sm: 0 3px 12px rgba(0,0,0,0.06);
    --shadow-md: 0 8px 25px rgba(0,0,0,0.1);
    --shadow-lg: 0 15px 40px rgba(0,0,0,0.15);

    --transition: 0.3s ease;
}

/* GLOBAL BG */
body {
    background: var(--color-light) !important;
}

/* ---------------------------------------------------------
   LEFT SIDEBAR — PREMIUM LOOK
--------------------------------------------------------- */

/* Card base */
.card {
    border-radius: var(--radius-lg) !important;
    border: none !important;
    background: #fff;
    box-shadow: var(--shadow-sm) !important;
}

/* Card titles */
.card h5 {
    font-size: 17px;
    font-weight: 700;
    color: var(--color-heading);
}

/* Sidebar input groups */
.input-group-text {
    background: #eef1f5 !important;
    border: none !important;
    font-weight: 700;
    color: #333;
}

.form-control {
    border: 1px solid #dee2e6 !important;
    padding: 10px 12px !important;
    border-radius: 10px !important;
    font-size: 14px;
    transition: var(--transition);
}

.form-control:focus {
    border-color: var(--color-primary) !important;
    box-shadow: 0 0 0 0.15rem rgba(255,171,29,0.25) !important;
}
.btn-primary-custom {
    background: linear-gradient(135deg, #FFAB1D, #FF9A00) !important;
    border: none !important;
    font-size: 15px !important;
    font-weight: 700 !important;
    padding: 10px 0 !important;
    border-radius: 12px !important;
    transition: var(--transition) !important;
}

.btn-primary-custom:hover {
    background: linear-gradient(135deg, #ff9300, #e67d00) !important;
    transform: translateY(-2px);
    box-shadow: var(--shadow-md) !important;
}

/* Category Boxes */
.category-box,
.hover-shadow {
    transition: var(--transition);
    border-radius: 14px !important;
    padding: 14px 8px;
    background: #fff;
    border: 1px solid #eee;
    box-shadow: 0 0 0 transparent;
}

.category-box:hover,
.hover-shadow:hover {
    border-color: var(--color-primary);
    background: #fff;
    transform: translateY(-4px);
    box-shadow: var(--shadow-md);
}

/* Category icon */
.category-box img,
.hover-shadow img {
    height: 45px;
    object-fit: contain;
}

/* Brand links */
.card ul li a {
    color: #4a4a4a;
    font-weight: 500;
    font-size: 14px;
}

.card ul li a:hover {
    color: var(--color-primary);
}


/* ---------------------------------------------------------
   PRODUCT CARD — PREMIUM E-COMMERCE STYLE
--------------------------------------------------------- */
.product-card {
    border: none;
    border-radius: 16px;
    overflow: hidden;
    background: #fff;
    box-shadow: var(--shadow-sm);
    transition: var(--transition);
}

.product-card:hover {
    transform: translateY(-6px);
    box-shadow: var(--shadow-lg);
}

.product-card img {
    height: 240px;
    object-fit: cover;
    transition: var(--transition);
}

.product-card:hover img {
    transform: scale(1.05);
}

/* Name */
.product-card h6 a {
    font-size: 16px !important;
    font-weight: 600;
    color: #222 !important;
}

/* Category */
.product-card .small {
    font-size: 13px !important;
}

/* Price */
.product-card .price,
.product-card .fw-bold.text-primary {
    font-size: 20px !important;
    font-weight: 700 !important;
    color: #E38304 !important; /* BHD color */
}

/* Add to Cart button — BIGGER, PREMIUM */
.product-card .btn-primary-custom {
    background: linear-gradient(135deg, #FFAB1D, #FF9A00);
    border: none !important;
    font-size: 10px !important;
    font-weight: 700 !important;
    padding: 8px 0 !important;
    border-radius: 12px !important;
    transition: var(--transition);
}

.product-card .btn-primary-custom:hover {
    background: linear-gradient(135deg, #ff9300, #e67d00);
    transform: translateY(-2px);
    box-shadow: var(--shadow-md);
}


/* ---------------------------------------------------------
   PRODUCT GRID RESPONSIVE FIXES
--------------------------------------------------------- */
@media(max-width: 992px) {
    .product-card img {
        height: 200px !important;
    }
}

@media(max-width: 768px) {
    .product-card img {
        height: 170px !important;
    }
}

@media(max-width: 576px) {
    .product-card img {
        height: 160px !important;
    }
}

/* ---------------------------------------------------------
   FILTER BAR
--------------------------------------------------------- */
.filter-bar, 
.d-flex.justify-content-between.align-items-center {
    background: #fff;
    padding: 14px 18px;
    border-radius: 14px;
    box-shadow: var(--shadow-sm);
}

.form-select-sm {
    padding: 8px 10px !important;
    border-radius: 10px !important;
    font-size: 14px !important;
}


/* ---------------------------------------------------------
   PRICE CURRENCY — BHD (Bold + Clean)
--------------------------------------------------------- */
.price-bhd {
    color: #E38304 !important;
    font-size: 20px;
    font-weight: 700;
}

</style>
@endpush


@endsection
