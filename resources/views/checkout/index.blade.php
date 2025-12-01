@extends('layouts.theme')
@section('title','Checkout')

@section('content')

<div class="rts-navigation-area-breadcrumb">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="navigator-breadcrumb-wrapper">
                    <a href="index.html">Home</a>
                    <i class="fa-regular fa-chevron-right"></i>
                    <a class="#" href="index.html">Shop</a>
                    <i class="fa-regular fa-chevron-right"></i>
                    <a class="current" href="index.html">Checkout</a>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="section-seperator">
    <div class="container">
        <hr class="section-seperator">
    </div>
</div>
<div class="checkout-area rts-section-gap">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 pr--40 pr_md--5 pr_sm--5 order-2 order-xl-1 order-lg-2 order-md-2 order-sm-2 mt_md--30 mt_sm--30">

                    <div class="rts-billing-details-area">
                        <h3 class="title">Billing Details</h3>
                        <form action="#">
                            <div class="single-input">
                                <label for="email">Email Address*</label>
                                <input id="email" type="text" required>
                            </div>
                            <div class="half-input-wrapper">
                                <div class="single-input">
                                    <label for="f-name">First Name*</label>
                                    <input id="f-name" type="text" required>
                                </div>
                                <div class="single-input">
                                    <label for="l-name">Last Name*</label>
                                    <input id="l-name" type="text">
                                </div>
                            </div>
                            <div class="single-input">
                                <label for="comp">Company Name (Optional)*</label>
                                <input id="comp" type="text">
                            </div>
                            <div class="single-input">
                                <label for="country">Country / Region*</label>
                                <input id="country" type="text">
                            </div>
                            <div class="single-input">
                                <label for="street">Street Address*</label>
                                <input id="street" type="text" required>
                            </div>
                            <div class="single-input">
                                <label for="city">Town / City*</label>
                                <input id="city" type="text">
                            </div>
                            <div class="single-input">
                                <label for="state">State*</label>
                                <input id="state" type="text">
                            </div>
                            <div class="single-input">
                                <label for="zip">Zip Code*</label>
                                <input id="zip" type="text" required>
                            </div>
                            <div class="single-input">
                                <label for="phone">Phone*</label>
                                <input id="phone" type="text">
                            </div>
                            <div class="single-input">
                                <label for="ordernotes">Order Notes*</label>
                                <textarea id="ordernotes"></textarea>
                            </div>
                            <button class="rts-btn btn-primary">Update Cart</button>
                        </form>
                    </div>
                </div>
                <div class="col-lg-4 order-1 order-xl-2 order-lg-1 order-md-1 order-sm-1">
                    <h3 class="title-checkout">Your Order</h3>
                    <div class="right-card-sidebar-checkout">
                        <div class="top-wrapper">
                            <div class="product">
                                Products
                            </div>
                            <div class="price">
                                Price
                            </div>
                        </div>
                        @foreach($cart as $item)
                        <div class="single-shop-list">
                            <div class="left-area">
                                <a href="#" class="thumbnail">
                                    <img src="assets/images/shop/04.png" alt="">
                                </a>
                                <a href="#" class="title">
                                   {{ $item['name'] }}
                                </a>
                            </div>
                            <span class="price">₹{{ number_format($item['price'],2) }}</span>
                        </div>
                        @endforeach
                        <div class="cottom-cart-right-area">
                            <ul>
                                <li>
                                    <input type="radio" id="f-options" name="selector">
                                    <label for="f-options">Direct Bank Transfer</label>

                                    <div class="check"></div>
                                </li>
                            </ul>
                            <p class="disc mb--25">
                                Make your payment directly into our bank account. Please use your Order ID as the payment reference. Your order will not be shipped until the funds have cleared in our account.
                            </p>
                            <ul>
                                <li>
                                    <input type="radio" id="f-option" name="selector">
                                    <label for="f-option">Check Payments</label>

                                    <div class="check"></div>
                                </li>

                                <li>
                                    <input type="radio" id="s-option" name="selector">
                                    <label for="s-option">Cash On Delivery</label>

                                    <div class="check">
                                        <div class="inside"></div>
                                    </div>
                                </li>

                                <li>
                                    <input type="radio" id="t-option" name="selector">
                                    <label for="t-option">Paypal</label>

                                    <div class="check">
                                        <div class="inside"></div>
                                    </div>
                                </li>
                            </ul>
                            <p class="mb--20">Your personal data will be used to process your order, support your experience throughout this website, and for other purposes described in our privacy policy.</p>
                            <div class="single-category mb--30">
                                <input id="cat14" type="checkbox">
                                <label for="cat14"> I have read and agree terms and conditions *
                                </label>
                            </div>
                            <a href="#" class="rts-btn btn-primary">Place Order</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
