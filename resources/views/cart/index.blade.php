@extends('layouts.theme')
@section('title','Cart')
@section('content')
@php
$overall_total = 0;
@endphp
<div class="section-seperator bg_light-1">
    <div class="container">
      <hr class="section-seperator">
  </div>
</div>

<h3 class="my-4">Your Cart</h3>
@if($cart->isEmpty())


<div class="rts-cart-area rts-section-gap bg_light-1 w-100">
    <div class="container">
        <div class="row justify-content-center text-center w-100">

            <div class="col-lg-6 col-md-8 col-12">

                <img src="/assets/images/empty-cart.png" alt="Empty Cart"
                     style="max-width: 260px; margin-bottom: 20px; opacity: 0.9;">

                <h2 class="title mb-3">Your Cart is Empty</h2>

                <p class="mb-4" style="color:#777; font-size:16px;">
                    Looks like you haven't added anything to your cart yet.
                </p>

                <button href="{{ route('shop.index') }}" class="rts-btn btn-primary d-inline-block mx-auto">
                    Continue Shopping
</button>

            </div>

        </div>
    </div>
</div>

@else

    <div class="rts-cart-area rts-section-gap bg_light-1">
        <div class="container">
            <div class="row g-5">
                <div class="col-xl-9 col-lg-12 col-md-12 col-12 order-2 order-xl-1 order-lg-2 order-md-2 order-sm-2">
                    <div class="cart-area-main-wrapper">
                        <!-- <div class="cart-top-area-note">
                            <p>Add <span>$59.69</span> to cart and get free shipping</p>
                            <div class="bottom-content-deals mt--10">
                                <div class="single-progress-area-incard">
                                    <div class="progress">
                                        <div class="progress-bar wow fadeInLeft" role="progressbar" style="width: 80%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                            </div>
                        </div> -->
                    </div>
                    <div class="rts-cart-list-area">
                        <div class="single-cart-area-list head">
                            <div class="product-main">
                                <P>Products</P>
                            </div>
                            <div class="price">
                                <p>Price</p>
                            </div>
                            <div class="quantity">
                                <p>Quantity</p>
                            </div>
                            <div class="subtotal">
                                <p>SubTotal</p>
                            </div>
                        </div>
                        @php $total=0; @endphp
                        @foreach($cart as $item)
                        <div class="single-cart-area-list main item-parent cart-glass">

    <div class="product-main-cart">
        <form action="{{ route('cart.remove', $item['id']) }}" method="POST">
            @csrf
            @method('DELETE')
            <button type="submit" class="close section-activation" style="background:none; border:none;">
                <i class="fa-regular fa-x"></i>
            </button>
        </form>

       @php
            $p = $item->product;
            $img = $p->images->first() ? asset('storage/'.$p->images->first()->path) : asset('assets/images/placeholder.png');
        @endphp

        <div class="thumbnail">
            <img src="{{ $img }}" alt="{{ $p->name }}">
        </div>

        <div class="information">
            <h6 class="title">{{ $p->name }}</h6>
            <span>SKU: {{ $p->sku ?? 'N/A' }}</span>
        </div>

    </div>

    <div class="price">
        <p class="cart-price">BHD {{ number_format($item['price'], 3) }}</p>
    </div>

    <div class="quantity">
        <form action="{{ route('cart.update', $item['id']) }}" method="POST" class="d-inline">
            @csrf
            @method('PUT')

            <div class="quantity-edit">
                <input type="number" min="1" step="1" inputmode="numeric" class="qty-input" name="qty" value="{{ $item->quantity }}">

                <div class="button-wrapper-action">
                    <button type="button" class="dec-btn">
                        <i class="fa-regular fa-chevron-down"></i>
                    </button>

                    <button type="button" class="inc-btn">
                        <i class="fa-regular fa-chevron-up"></i>
                    </button>

                    <button type="submit" class="button update-btn"
                        style="background:#4caf50; color:white; border:none; padding:0 10px; font-size:12px;">
                        ✔
                    </button>
                </div>
            </div>
        </form>
    </div>

    <div class="subtotal">
        <p class="cart-subtotal-price">
        BHD {{ number_format($item->price * $item->quantity, 3) }}
    </p>

    </div>

</div>

                        @php $total += ($item->price * $item->quantity); @endphp
                        @endforeach
                        <div class="bottom-cupon-code-cart-area">
                            <form action="#">
                                <input type="text" placeholder="Cupon Code">
                                <button class="rts-btn btn-primary">Apply Coupon</button>
                            </form>
                            <form action="{{ route('cart.clear') }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button class="rts-btn btn-primary mr--50">Clear All</button>
                        </form>

                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-12 col-md-12 col-12 order-1 order-xl-2 order-lg-1 order-md-1 order-sm-1">
                    <div class="cart-total-area-start-right">
                        <h5 class="title">Cart Totals</h5>
                        <div class="subtotal">
                            <span>Total Items</span>
                            <h6 class="price">{{ $cart->sum('quantity') }} Items</h6>
                        </div>
                        <div class="shipping">
                            <span>Additional Options</span>
                            <ul>

                                <li>
                                    <label for="order-notes">Order Notes</label>
                                    <textarea id="order-notes" class="form-control mt-2" rows="2"
                                        placeholder="Add any special instructions for your order..."></textarea>
                                </li>


                                <li class="mt-3">
                                    <p class="note">
                                        Final shipping charges, taxes, and delivery options will be shown on the checkout page.
                                    </p>
                                </li>

                            </ul>
                        </div>

                        <div class="bottom">
                            <div class="wrapper">
                                <span>Subtotal</span>
                                <h6 class="price">BHD{{ number_format($total,3) }}</h6>
                            </div>
                            <div class="button-area">
                                <form action="{{ route('checkout.index')}}" method="GET">
                                    <button class="rts-btn btn-primary">Proceed To Checkout</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<style>
    /* ------------------------------------------
   PREMIUM GLASSMORPHIC CART APPEARANCE
------------------------------------------ */

.cart-glass {
    background: rgba(255, 255, 255, 0.28);
    backdrop-filter: blur(14px);
    -webkit-backdrop-filter: blur(14px);
    border-radius: 18px;
    padding: 20px;
    border: 1px solid rgba(255,255,255,0.40);
    box-shadow: 0 8px 32px rgba(0,0,0,0.06);
    margin-bottom: 22px;
    transition: all .3s ease;
}

.cart-glass:hover {
    transform: translateY(-6px);
    box-shadow: 0 18px 38px rgba(0,0,0,0.12);
}

.cart-price {
    font-weight: 700;
    color: #e38203;
    font-size: 16px;
}

.cart-subtotal-price {
    font-weight: 700;
    color: #b82e00;
    font-size: 17px;
}

.rts-btn.btn-primary {
    background: linear-gradient(135deg, #ffae00, #ff8c00);
    border: none;
    box-shadow: 0 6px 16px rgba(255,140,0,.25);
    transition: .3s ease;
}

.rts-btn.btn-primary:hover {
    transform: translateY(-2px);
    background: linear-gradient(135deg, #ff9a00, #ff7a00);
}

</style>
@endif
@push('scripts')
<script>
// Remove all old listeners cleanly
document.querySelectorAll(".inc-btn, .dec-btn").forEach(btn => {
    const clone = btn.cloneNode(true);
    btn.replaceWith(clone);
});

// Handle Increase
document.addEventListener("click", function(e) {
    const inc = e.target.closest(".inc-btn");
    if (!inc) return;

    const wrap = inc.closest(".quantity-edit");
    const input = wrap.querySelector(".qty-input");

    input.value = parseInt(input.value) + 1;
});

// Handle Decrease
document.addEventListener("click", function(e) {
    const dec = e.target.closest(".dec-btn");
    if (!dec) return;

    const wrap = dec.closest(".quantity-edit");
    const input = wrap.querySelector(".qty-input");

    let qty = parseInt(input.value);
    if (qty > 1) input.value = qty - 1;
});

// Update button submit handler
document.addEventListener("click", function(e) {
    const submit = e.target.closest(".update-btn");
    if (!submit) return;

    const form = submit.closest("form");
    form.submit();
});
</script>
@endpush
@endsection
