{{-- resources/views/components/site-header.blade.php --}}
<header class="site-header header-style-two bg-primary-header">

    {{-- ====================================================== --}}
    {{-- 1. TOP BAR (discount / countdown)                     --}}
    {{-- ====================================================== --}}
    <div class="header-top-area">
        <div class="container">
            <div class="bwtween-area-header-top">

                {{-- left side – discount text --}}
                <p class="disc">
                    <strong>Flat 30% OFF</strong> on first order! Use code <a href="#">FIRST30</a>
                </p>

                {{-- right side – countdown timer --}}
                <div id="countdown-1">
                    <div class="single"><span class="count" id="days">00</span><span class="timer">Days</span></div>
                    <div class="single"><span class="count" id="hours">00</span><span class="timer">Hours</span></div>
                    <div class="single"><span class="count" id="minutes">00</span><span class="timer">Minutes</span></div>
                    <div class="single"><span class="count" id="seconds">00</span><span class="timer">Seconds</span></div>
                </div>

            </div>
        </div>
    </div>

    {{-- ====================================================== --}}
    {{-- 2. MIDDLE BAR – Logo + Search + Category + Actions    --}}
    {{-- ====================================================== --}}
    <div class="search-header-area-main">
        <div class="container">
            <div class="logo-search-category-wrapper">

                {{-- Logo --}}
                <a class="brand" href="{{ route('home') }}">
                    <img src="{{ asset('assets/images/logo.png') }}" alt="Future Mission" height="50">
                </a>

                {{-- Category + Search (desktop) --}}
                <div class="category-search-wrapper d-none d-lg-flex">

                    {{-- Category dropdown button --}}
                    <div class="category-btn category-hover-header">
                        <i class="fas fa-bars"></i>
                        <span>All Categories</span>
                        <i class="fas fa-chevron-down ml-auto"></i>

                        {{-- Category submenu (hidden until hover) --}}
                        <ul class="category-sub-menu">
                            @foreach(\App\Models\Category::take(8)->get() as $cat)
                                <li>
                                    <a href="{{ route('shop.index', ['category' => $cat->slug]) }}">
                                        <img src="{{ $cat->icon ?? asset('assets/images/cat-placeholder.png') }}" alt="">
                                        <span>{{ $cat->name }}</span>
                                        <i class="fas fa-angle-right"></i>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>

                    {{-- Search input --}}
                    <div class="search-header">
                        <form action="{{ route('shop.index') }}" method="GET">
                            <input type="text" name="q" placeholder="Search for products..." value="{{ request('q') }}">
                            <button type="submit" class="rts-btn btn-primary">Search</button>
                        </form>
                    </div>
                </div>

                {{-- Right side icons (account / wishlist / cart) --}}
                <div class="accont-wishlist-cart-area-header">

                    {{-- Account --}}
                    @auth
                        <a href="{{ route('account.dashboard') }}" class="btn-border-only">
                            <i class="far fa-user"></i>
                            <span class="text d-none d-xl-inline">My Account</span>
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="btn-border-only">
                            <i class="far fa-user"></i>
                            <span class="text d-none d-xl-inline">Login</span>
                        </a>
                    @endauth

                    {{-- Wishlist (optional) --}}
                    <a href="#" class="wishlist">
                        <i class="far fa-heart"></i>
                        <span class="number">{{ auth()->check() ? auth()->user()->wishlist()->count() : 0 }}</span>
                    </a>

                    {{-- Cart mini‑view --}}
                    <div class="cart category-hover-header">
                        <i class="fas fa-shopping-cart"></i>
                        <span class="number">{{ session('cart') ? count(session('cart')) : 0 }}</span>

                        {{-- Mini‑cart dropdown --}}
                        <div class="category-sub-menu card-number-show">
                            @if(session('cart') && count(session('cart')) > 0)
                                @foreach(session('cart') as $id => $item)
                                    <div class="cart-item-1 {{ $loop->first ? '' : 'border-top' }}">
                                        <div class="img-name">
                                            <img src="{{ $item['image'] }}" alt="" class="thumbanil">
                                            <div class="details">
                                                <div class="title">{{ $item['name'] }}</div>
                                                <div class="number">
                                                    <span>{{ $item['quantity'] }} × </span>
                                                    <span>₹{{ number_format($item['price'], 2) }}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <a href="{{ route('cart.remove', $id) }}" class="close-c1">
                                            <i class="fas fa-times"></i>
                                        </a>
                                    </div>
                                @endforeach

                                <div class="sub-total-cart-balance">
                                    <div class="top">
                                        <span>Subtotal:</span>
                                        <strong>₹{{ number_format(cart_total(), 2) }}</strong>
                                    </div>

                                    <div class="button-wrapper">
                                        <a href="{{ route('cart.index') }}" class="rts-btn btn-primary">View Cart</a>
                                        <a href="{{ route('checkout.index') }}" class="rts-btn border-only">Checkout</a>
                                    </div>
                                </div>
                            @else
                                <p class="text-center py-4">Your cart is empty</p>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- Mobile‑only actions (search icon, menu toggle) --}}
                <div class="actions-area d-flex d-lg-none">
                    <div class="search-toggle"><i class="fas fa-search"></i></div>
                    <div class="menu-toggle"><i class="fas fa-bars"></i></div>
                </div>

            </div>
        </div>
    </div>

    {{-- ====================================================== --}}
    {{-- 3. MAIN NAVIGATION (sticky)                           --}}
    {{-- ====================================================== --}}
    <div class="rts-header-nav-area-one header--sticky">
        <div class="container">
            <div class="nav-and-btn-wrapper">

                {{-- Left – Main menu --}}
                <nav class="nav-area">
                    <ul>
                        <li><a href="{{ route('home') }}" class="{{ request()->is('/') ? 'active' : '' }}">Home</a></li>
                        <li><a href="{{ route('shop.index') }}" class="{{ request()->is('shop*') ? 'active' : '' }}">Shop</a></li>
                        <li><a href="{{ route('about') }}">About</a></li>
                        <li><a href="{{ route('contact') }}">Contact</a></li>

                        @role('vendor')
                            <li><a href="{{ route('vendor.products.index') }}">Vendor Dashboard</a></li>
                        @endrole
                    </ul>
                </nav>

                {{-- Right – optional CTA button --}}
                <div class="right-btn-area">
                    <a href="#" class="btn-narrow">Become a Seller</a>
                    <a href="#" class="btn-primary">
                        Hot Deal
                        <span>30% OFF</span>
                    </a>
                </div>
            </div>
        </div>
    </div>

    {{-- ====================================================== --}}
    {{-- 4. MOBILE ONLY SEARCH (toggled by icon)               --}}
    {{-- ====================================================== --}}
    <div class="mobile-search-wrapper d-lg-none">
        <form action="{{ route('shop.index') }}" method="GET" class="search-form">
            <input type="text" name="q" placeholder="Search products..." value="{{ request('q') }}">
            <button type="submit"><i class="fas fa-search"></i></button>
        </form>
    </div>

</header>

{{-- ========================================================== --}}
{{-- 5. SIMPLE COUNTDOWN JS (you can move to a separate file)   --}}
{{-- ========================================================== --}}
@push('scripts')
<script>
    // Countdown to a fixed date (replace with your promotion end date)
    const countDownDate = new Date("{{ now()->addDays(7)->format('M d, Y 00:00:00') }}").getTime();

    const x = setInterval(function() {
        const now = new Date().getTime();
        const distance = countDownDate - now;

        const days    = Math.floor(distance / (1000 * 60 * 60 * 24));
        const hours   = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        const seconds = Math.floor((distance % (1000 * 60)) / 1000);

        document.getElementById("days").innerHTML    = days < 10 ? "0"+days : days;
        document.getElementById("hours").innerHTML   = hours < 10 ? "0"+hours : hours;
        document.getElementById("minutes").innerHTML = minutes < 10 ? "0"+minutes : minutes;
        document.getElementById("seconds").innerHTML = seconds < 10 ? "0"+seconds : seconds;

        if (distance < 0) {
            clearInterval(x);
            document.querySelector('#countdown-1').innerHTML = "<span>EXPIRED</span>";
        }
    }, 1000);
</script>
@endpush
