@extends('layouts.theme')
@section('title','Checkout')
 
@section('content')
 
{{-- ===========================
    BREADCRUMB
=========================== --}}
{{-- ===========================
   (CONTENT BETWEEN HEADER & FOOTER) — PREMIUM CHECKOUT
   Keep all logic & Blade variables unchanged
============================ --}}
 
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
 
        {{-- LEFT: ADDRESS + PAYMENT --}}
        <div class="col-lg-8">
 
            {{-- ADDRESS CARD --}}
            <div class="premium-card mb-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <h4 class="premium-title mb-0">Shipping Address</h4>
                        <small class="text-muted">Choose or add an address</small>
                    </div>
 
                    @if($addresses->isEmpty())
 
                        <div class="empty-address">
                            <div class="alert alert-info mb-3">
                                You don’t have any saved address. Add one to continue.
                            </div>
                            @include('checkout.partials.add_address_form')
                        </div>
 
                    @else
 
                        <div class="row g-3 mb-3 addresses-grid">
                            @foreach($addresses as $addr)
                            <label class="col-md-6 address-label">
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
 
                        <button class="premium-btn-sm" data-bs-toggle="collapse" data-bs-target="#addAddressCollapse">
                            + Add New Address
                        </button>
 
                        <div class="collapse mt-3" id="addAddressCollapse">
                            @include('checkout.partials.add_address_form')
                        </div>
 
                    @endif
                </div>
            </div>
 
            {{-- PAYMENT METHOD --}}
            @if(!$addresses->isEmpty())
            <div class="premium-card mb-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h4 class="premium-title mb-0">Payment Method</h4>
                        <small class="text-muted">Select how you want to pay</small>
                    </div>
 
                    <div class="payment-options modern-payment">
                        <label class="payment-option">
                            <input type="radio" name="payment_method" form="placeOrderForm"
                                   value="cod" checked hidden>
                            <div class="payment-card-option">
                                <div class="icon"><i class="fa-solid fa-truck"></i></div>
                                <div class="label">Cash on Delivery (COD)</div>
                            </div>
                        </label>
 
                        <label class="payment-option">
                            <input type="radio" name="payment_method" form="placeOrderForm"
                                   value="card" hidden>
                            <div class="payment-card-option">
                                <div class="icon"><i class="fa-solid fa-credit-card"></i></div>
                                <div class="label">Credit / Debit Card</div>
                            </div>
                        </label>
                    </div>
                </div>
            </div>
            @endif
 
        </div>
 
        {{-- RIGHT: ORDER SUMMARY --}}
        <div class="col-lg-4">
            <form id="placeOrderForm" action="{{ route('checkout.place') }}" method="POST">
                @csrf
 
                <div class="premium-card sticky-summary">
                    <div class="card-body">
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
 
                        <hr class="summary-divider">
 
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Subtotal</span>
                            <strong>BHD {{ number_format($cart->sum('total_price'),2) }}</strong>
                        </div>
 
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Shipping</span>
                            <strong>Free</strong>
                        </div>
 
                        <hr class="summary-divider">
 
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <span class="fw-bold">Total</span>
                            <strong class="text-primary">BHD {{ number_format($cart->sum('total_price'),2) }}</strong>
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
                </div>
            </form>
        </div>
 
    </div>
</div>
 
@push('styles')
<style>
/* =========================
   Premium Checkout Styles
   (override only presentation; logic unchanged)
   ========================= */
 
/* container spacing */
.checkout-container { margin-top: 28px; margin-bottom: 40px; }
 
/* premium card base */
.premium-card {
    border-radius: 12px;
    background: #ffffff;
    border: 1px solid rgba(15,23,42,0.04);
    box-shadow: 0 8px 22px rgba(15,23,42,0.04); /* very light */
}
.premium-card .card-body { padding: 20px; }
 
/* header text */
.premium-title { font-size: 16px; font-weight: 700; color: #12263a; }
 
/* Address card */
.address-card {
    border-radius: 12px;
    padding: 14px;
    border: 1px solid #e8ecf0;
    background: linear-gradient(180deg, #fff, #fbfbfb);
    transition: box-shadow .18s ease, transform .12s ease, border-color .12s ease;
}
.address-label { display:block; }
.address-card:hover {
    box-shadow: 0 12px 30px rgba(15, 23, 42, 0.05);
    transform: translateY(-4px);
    border-color: rgba(0,0,0,0.06);
}
.address-type {
    font-size: 13px;
    font-weight: 700;
    color: #e67f00; /* theme accent */
    margin-bottom: 6px;
}
.address-body { color: #425a66; line-height:1.45; font-size:14px; }
 
/* radio checked state (keeps input hidden) */
.address-radio:checked + .address-card {
    border-color: rgba(230,127,0,0.22);
    background: linear-gradient(90deg, rgba(255,159,0,0.04), #fff);
    box-shadow: 0 14px 32px rgba(230,127,0,0.06);
}
 
/* Buttons */
.premium-btn-sm {
    background: transparent;
    border: 1px dashed rgba(15,23,42,0.06);
    padding: 8px 12px;
    border-radius: 8px;
    color: #1f2937;
    font-weight:700;
}
.premium-btn-primary {
    background: linear-gradient(90deg, #ff9f00, #e67f00);
    color: #fff;
    border: none;
    padding: 12px 14px;
    border-radius: 10px;
    font-weight:800;
    box-shadow: 0 10px 26px rgba(230,127,0,0.12);
}
 
/* Payment options list */
.payment-options {
    display:flex;
    gap:12px;
    flex-wrap:wrap;
}
.payment-option { cursor:pointer; display:block; width:100%; }
.payment-card-option {
    display:flex;
    align-items:center;
    gap:12px;
    padding: 12px 14px;
    border-radius: 12px;
    border: 1px solid #e7eaed;
    transition: transform .12s ease, border-color .12s ease, box-shadow .12s ease;
    background: #fff;
}
.payment-card-option .icon {
    width:40px;
    height:40px;
    border-radius:10px;
    display:flex;
    align-items:center;
    justify-content:center;
    background: #fff6ea;
    color: #e67f00;
    font-size:16px;
    border:1px solid rgba(230,127,0,0.06);
}
.payment-card-option .label { font-weight:700; color:#0f1724; font-size:14px; }
 
/* when checked */
.payment-option input:checked + .payment-card-option,
.payment-card-option:hover {
    border-color: rgba(230,127,0,0.18);
    transform: translateY(-4px);
    box-shadow: 0 14px 28px rgba(15,23,42,0.05);
}
 
/* Cart item in summary */
.cart-item {
    display:flex;
    align-items:center;
    gap:12px;
}
.cart-thumb {
    width: 64px;
    height: 64px;
    border-radius: 8px;
    object-fit: cover;
    border: 1px solid #eef2f4;
}
.cart-info { flex:1; min-width:0; }
.cart-name { font-size:14px; font-weight:700; color: #0f1724; }
.cart-meta { font-size:13px; color:#7b8794; margin-top:4px; }
.cart-price { font-weight:800; color:#0f1724; margin-left: 8px; }
 
/* summary dividers */
.summary-divider { border: none; border-top: 1px solid rgba(15,23,42,0.04); margin: 14px 0; }
 
/* sticky summary on large screens, static on small screens */
.sticky-summary {
    position: sticky;
    top: 100px;
}
@media (max-width: 992px){
    .sticky-summary{ position: static; }
}
 
/* Responsive tweaks */
@media (max-width: 768px) {
    .addresses-grid label { width:100%; display:block; }
    .address-card { padding: 12px; }
    .cart-thumb { width:56px; height:56px; }
    .payment-card-option { padding:10px; }
}
 
/* minor polish */
.text-muted { color:#6b7280 !important; }
 
 
</style>
@endpush
@endsection