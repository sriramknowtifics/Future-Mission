@extends('layouts.theme')
@section('title','Checkout')

@section('content')

{{-- ===========================
    BREADCRUMB
=========================== --}}
<div class="rts-navigation-area-breadcrumb">
    <div class="container">
        <div class="navigator-breadcrumb-wrapper">
            <a href="{{ url('/') }}">Home</a>
            <i class="fa-solid fa-chevron-right"></i>
            <a href="{{ route('shop.index') }}">Shop</a>
            <i class="fa-solid fa-chevron-right"></i>
            <span class="current">Checkout</span>
        </div>
    </div>
</div>

<div class="container py-5 checkout-container">

    <div class="row g-4">

        {{-- =============================
            LEFT COLUMN — ADDRESS + PAYMENT
        ============================== --}}
        <div class="col-lg-8">

            {{-- =============================
                 ADDRESS SECTION
            ============================== --}}
            <div class="premium-card mb-4">
                <h4 class="premium-title mb-3">Shipping Address</h4>

                {{-- If user has NO addresses --}}
                @if($addresses->isEmpty())

                    <div class="alert alert-info">
                        You don’t have any saved address. Add one to continue.
                    </div>

                    @include('checkout.partials.add_address_form')

                @else

                    {{-- EXISTING ADDRESSES --}}
                    <div class="row g-3 mb-3">

                        @foreach($addresses as $addr)
                        <label class="col-md-6">
                            <input type="radio"
                                   name="address_id"
                                   form="placeOrderForm"
                                   value="{{ $addr->id }}"
                                   class="address-radio"
                                   @checked($loop->first) hidden>

                            <div class="address-card">
                                <div class="address-type">{{ ucfirst($addr->type) }}</div>
                                <div class="address-body">
                                    {{ $addr->address_line }} <br>
                                    {{ $addr->city }}, {{ $addr->state }} <br>
                                    {{ $addr->country }} – {{ $addr->zip_code }} <br>
                                    Phone: {{ $addr->phone }}
                                </div>
                            </div>
                        </label>
                        @endforeach
                    </div>

                    {{-- ADD NEW ADDRESS BUTTON --}}
                    <button class="premium-btn-sm" data-bs-toggle="collapse" data-bs-target="#addAddressCollapse">
                        + Add New Address
                    </button>

                    <div class="collapse mt-3" id="addAddressCollapse">
                        @include('checkout.partials.add_address_form')
                    </div>

                @endif

            </div>


            {{-- =============================
                PAYMENT SECTION
            ============================== --}}
            @if(!$addresses->isEmpty())
            <div class="premium-card mb-4">
                <h4 class="premium-title mb-3">Payment Method</h4>

                <div class="payment-options">

                    <label class="payment-option">
                        <input type="radio" name="payment_method" form="placeOrderForm"
                               value="cod" checked hidden>
                        <div class="payment-card">
                            <i class="fa-solid fa-truck"></i>
                            Cash on Delivery (COD)
                        </div>
                    </label>

                    <label class="payment-option">
                        <input type="radio" name="payment_method" form="placeOrderForm"
                               value="card" hidden>
                        <div class="payment-card">
                            <i class="fa-solid fa-credit-card"></i>
                            Credit / Debit Card
                        </div>
                    </label>

                </div>
            </div>
            @endif

        </div>



        {{-- =============================
            RIGHT COLUMN — ORDER SUMMARY
        ============================== --}}
        <div class="col-lg-4">

            <form id="placeOrderForm"
                  action="{{ route('checkout.place') }}"
                  method="POST">
                @csrf

                <div class="premium-card sticky-top">

                    <h4 class="premium-title mb-3">Order Summary</h4>

                    @foreach($cart as $item)
                    <div class="cart-item mb-3">
                        <img src="{{ asset('storage/' . ($item->product->primaryImage->path ?? $item->product->images->first()->path)) }}"
                             class="cart-thumb" alt="product">

                        <div class="cart-info">
                            <div class="cart-name">{{ $item->product->name }}</div>
                            <div class="cart-meta">
                                Qty: {{ $item->quantity }}
                            </div>
                        </div>

                        <div class="cart-price">
                            BHD {{ number_format($item->total_price,2) }}
                        </div>
                    </div>
                    @endforeach

                    <hr>

                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Subtotal</span>
                        <strong>BHD {{ number_format($cart->sum('total_price'),2) }}</strong>
                    </div>

                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Shipping</span>
                        <strong>Free</strong>
                    </div>

                    <hr>

                    <div class="d-flex justify-content-between mb-3">
                        <span class="fw-bold">Total</span>
                        <strong class="text-primary">
                            BHD {{ number_format($cart->sum('total_price'),2) }}
                        </strong>
                    </div>

                    @if(!$addresses->isEmpty())
                    <button class="premium-btn-primary w-100">
                        Place Order
                    </button>
                    @else
                    <button class="premium-btn-primary w-100" disabled>
                        Add Address To Continue
                    </button>
                    @endif

                </div>
            </form>

        </div>

    </div>
</div>



{{-- =============================
    STYLING (Premium)
============================= --}}
@push('styles')
<style>

.checkout-container { margin-top: 30px; }

.address-card {
    border: 2px solid #ddd;
    border-radius: 12px;
    padding: 15px;
    cursor: pointer;
    transition: .25s;
    background: #fff;
}
.address-card:hover {
    border-color: var(--primary);
    box-shadow: 0 8px 20px rgba(0,0,0,0.08);
}

.address-radio:checked + .address-card,
.payment-option input:checked + .payment-card {
    border-color: var(--primary);
    background: #fff9ec;
}

.address-type {
    font-size: 13px;
    font-weight: 600;
    color: var(--primary);
    margin-bottom: 4px;
}

.payment-card {
    border: 2px solid #ddd;
    padding: 12px 15px;
    border-radius: 12px;
    cursor: pointer;
    margin-bottom: 10px;
    transition: .25s;
}
.payment-card:hover {
    border-color: var(--primary);
}

.cart-item {
    display: flex;
    align-items: center;
    gap: 12px;
}
.cart-thumb {
    width: 60px;
    height: 60px;
    border-radius: 8px;
    object-fit: cover;
}
.cart-name { font-size: 14px; font-weight: 600; }
.cart-meta { font-size: 13px; color: #999; }
.cart-price { font-weight: 700; }
</style>
@endpush

@endsection
