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
    <input type="number" min="1" step="1" inputmode="numeric"
           class="qty-input" name="qty" value="{{ $item->quantity }}">

    <div class="button-wrapper-action">
        <button type="button" class="inc-btn"><i class="fa-regular fa-chevron-up"></i></button>
        <button type="button" class="dec-btn"><i class="fa-regular fa-chevron-down"></i></button>
        <button type="submit" class="update-btn">✔</button>
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
/* ================================
   PREMIUM SHOPIFY-LEVEL CART LIST
================================== */

.cart-glass {
    background: linear-gradient(
        135deg,
        rgba(255,255,255,0.35),
        rgba(255,255,255,0.55)
    );
    backdrop-filter: blur(18px);
    -webkit-backdrop-filter: blur(18px);
    border-radius: 22px;
    padding: 22px;
    border: 1px solid rgba(255,255,255,0.35);
    box-shadow: 0 10px 35px rgba(0,0,0,0.08);
    display: grid;
    grid-template-columns: 2.4fr 1fr 1fr 1fr;
    gap: 18px;
    align-items:center;
    transition: all .25s ease;
}

.cart-glass:hover {
    transform: translateY(-6px);
    box-shadow: 0 18px 45px rgba(0,0,0,0.15);
}

/* PRODUCT LEFT BLOCK */
.product-main-cart {
    display:flex;
    gap:16px;
    align-items:center;
}

.product-main-cart .thumbnail {
    width: 80px;
    height: 80px;
    border-radius:14px;
    overflow:hidden;
    background:#fff;
    display:flex;
    align-items:center;
    justify-content:center;
}

.product-main-cart .thumbnail img {
    width:100%;
    height:100%;
    object-fit:contain;
}

.product-main-cart .information {
    display:flex;
    flex-direction:column;
    gap:3px;
}

.product-main-cart .title {
    margin:0;
    font-size:16px;
    font-weight:700;
    color:#1e293b;
}

.product-main-cart span {
    color:#64748b;
    font-size:13px;
}

/* PRICE */
.cart-price {
    font-weight:700;
    font-size:17px;
    color:#e67e22;
}

/* SUBTOTAL */
.cart-subtotal-price {
    font-weight:700;
    font-size:18px;
    color:#c2410c;
}

/* QUANTITY AREA */
/* IMPROVED PREMIUM QUANTITY BOX */
.quantity-edit {
    display: flex;
    align-items: center;
    background: #f8fafc;
    border-radius: 12px;
    padding: 4px 6px;
    border: 2px solid #e2e8f0;
    width: 140px;                 /* Wider for visibility */
    height: 48px;                 /* Taller for premium feel */
    gap: 6px;
}

/* Number field */
.qty-input {
    width: 55px;                  /* Bigger number area */
    height: 100%;
    border: none;
    text-align: center;
    font-size: 18px;
    font-weight: 700;
    color: #1e293b;              /* Darker visible number */
    background: transparent;
    padding: 0;
}

/* Button vertical group */
.button-wrapper-action {
    display: flex;
    flex-direction: column;
    gap: 4px;
}

/* + / – buttons */
.button-wrapper-action button {
    background: #ffffff;
    border: 1px solid #e2e8f0;
    width: 32px;
    height: 20px;
    border-radius: 6px;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: .2s;
}

.button-wrapper-action button:hover {
    background: #f1f5f9;
}

/* Update button */
.update-btn {
    margin-top: 4px !important;
    background: #10b981 !important;
    color: #fff !important;
    font-size: 12px !important;
    font-weight: 700;
    height: 22px;
    border-radius: 6px !important;
    transition: .2s ease;
}

.update-btn:hover {
    background: #059669 !important;
}



/* CLOSE BUTTON */
.product-main-cart .close {
    position:absolute;
    top:-4px;
    left:-6px;
    font-size:14px;
    color:#b91c1c;
    cursor:pointer;
}

/* ============= RESPONSIVE BREAKPOINTS ============= */

@media (max-width: 992px) {
    .cart-glass {
        grid-template-columns: 1fr 1fr;
        grid-template-rows: auto auto;
    }
}

@media (max-width: 768px) {
    .cart-glass {
        grid-template-columns: 1fr;
        padding:18px;
    }
    .cart-price,
    .cart-subtotal-price {
        font-size:16px;
    }
    .product-main-cart {
        justify-content:flex-start;
    }
}

@media (max-width: 480px) {
    .product-main-cart .thumbnail {
        width:70px;
        height:70px;
    }
    .quantity-edit {
        width:100px;
    }
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
document.addEventListener("click", function (e) {
    const incBtn = e.target.closest(".inc-btn");
    const decBtn = e.target.closest(".dec-btn");
    const updateBtn = e.target.closest(".update-btn");

    // Increase Quantity
    if (incBtn) {
        const input = incBtn.closest(".quantity-edit").querySelector(".qty-input");
        input.value = Number(input.value) + 1;
    }

    // Decrease Quantity
    if (decBtn) {
        const input = decBtn.closest(".quantity-edit").querySelector(".qty-input");
        input.value = Math.max(1, Number(input.value) - 1);
    }

    // Update Form Submit
    if (updateBtn) {
        updateBtn.closest("form").submit();
    }
});

</script>
@endpush
@endsection
