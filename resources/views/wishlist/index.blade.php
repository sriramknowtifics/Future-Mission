@extends('layouts.theme')
@section('title','Wishlist')
@section('content')

<div class="section-seperator bg_light-1">
    <div class="container">
        <hr class="section-seperator">
    </div>
</div>

<div class="container py-5">

    <h2 class="mb-4 fw-bold">Your Wishlist ❤️</h2>

    {{-- Empty Wishlist --}}
    @if($wishlist->isEmpty())
        <div class="text-center py-5">
            <img src="/assets/images/empty-cart.png" style="max-width: 250px; opacity:0.9;">
            <h3 class="mt-3">Your Wishlist is Empty</h3>
            <p class="text-muted">Browse products and add them to your wishlist!</p>

            <a href="{{ route('shop.index') }}" class="rts-btn btn-primary mt-3">
                Continue Shopping
            </a>
        </div>
    @else

    {{-- Wishlist Items --}}
    <div class="row gy-4">

        @foreach($wishlist as $item)
            @php
                $p = $item->product;
                $img = $p->images->first()
                        ? asset('storage/'.$p->images->first()->path)
                        : asset('assets/images/placeholder.png');
            @endphp

            <div class="col-md-4 col-lg-3">

                <div class="wishlist-card glass-card shadow-sm">

                    <!-- Top Image -->
                    <div class="wishlist-image-wrapper">
                        <img src="{{ $img }}" class="wishlist-image" alt="{{ $p->name }}">
                    </div>

                    <!-- Content -->
                    <div class="wishlist-content p-3">

                        <h6 class="wishlist-title">{{ $p->name }}</h6>

                        <p class="wishlist-price mb-2">
                            BHD {{ number_format($p->price, 3) }}
                        </p>

                        <div class="wishlist-actions d-flex justify-content-between">

                            <!-- Add to Cart -->
                            <form action="{{ route('cart.add') }}" method="POST">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $p->id }}">
                                <input type="hidden" name="qty" value="1">

                                <button class="btn btn-sm btn-success premium-btn">
                                    <i class="fa fa-cart-plus"></i> Add
                                </button>
                            </form>

                            <!-- Remove Wishlist -->
                            <form action="{{ route('wishlist.remove', $item->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button class="remove-btn btn btn-sm btn-danger">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </form>

                        </div>

                    </div>
                </div>

            </div>
        @endforeach

    </div>
    @endif

</div>

{{-- PREMIUM WISHLIST UI CSS --}}
<style>

/* Glassmorphic Wishlist Card */
.wishlist-card {
    background: rgba(255, 255, 255, 0.45);
    backdrop-filter: blur(14px);
    border-radius: 18px;
    border: 1px solid rgba(255,255,255,0.35);
    overflow: hidden;
    transition: all .3s ease;
}

.wishlist-card:hover {
    transform: translateY(-6px);
    box-shadow: 0 18px 36px rgba(0,0,0,0.15);
}

/* Image */
.wishlist-image-wrapper {
    background: #f8f8f8;
    padding: 16px;
    display:flex;
    justify-content:center;
    align-items:center;
    height: 210px;
}

.wishlist-image {
    width: 100%;
    height: 100%;
    object-fit: contain;
}

/* Title */
.wishlist-title {
    font-size: 15px;
    font-weight: 700;
    color:#222;
    min-height: 38px;
}

/* Price */
.wishlist-price {
    color:#e85a00;
    font-weight: 700;
    font-size: 16px;
    margin-bottom: 10px;
}

/* Buttons */
.premium-btn {
    background: linear-gradient(135deg, #0f9b0f, #14cc14);
    color: #fff !important;
    border: none;
    padding: 6px 14px;
    border-radius: 8px;
    transition: .25s ease;
}

.premium-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 18px rgba(0,150,0,0.25);
}

.remove-btn {
    background: #ff4d4f;
    border:none;
    border-radius:8px;
    color:white;
    padding:6px 12px;
}

.remove-btn:hover {
    background:#d9363e;
}

</style>

@endsection
