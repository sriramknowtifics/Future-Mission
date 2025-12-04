@php
use App\Models\CartItem;

// Fetch all active cart items for logged-in user
$cartItems = auth()->check()
    ? CartItem::with('product.images')
        ->where('user_id', auth()->id())
        ->where('status', 'active')
        ->get()
    : collect([]);

// Count total items
$cartCount = $cartItems->sum('quantity');

// Calculate subtotal
$cartSubtotal = $cartItems->sum(function ($item) {
    return ($item->price ?? 0) * ($item->quantity ?? 1);
});

// Format subtotal
$cartSubtotalFormatted = number_format($cartSubtotal, 2);
@endphp


<div class="rts-header-one-area-one">
          <div class="header-top-area">
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
          <div class="bwtween-area-header-top">
            <div class="discount-area">
              <p class="disc">
                <strong>FREE delivery & 40% Discount</strong> for next 3 orders! Place your 1st order in.
              </p>
              <div class="countdown">
                <div id="countdown-1">
                  <div class="single"><span class="count" id="days">00</span><span class="timer">Days</span></div>
                  <div class="single"><span class="count" id="hours">00</span><span class="timer">Hours</span></div>
                  <div class="single"><span class="count" id="minutes">00</span><span class="timer">Minutes</span></div>
                  <div class="single"><span class="count" id="seconds">00</span><span class="timer">Seconds</span></div>
                </div>
              </div>
            </div>
            <div class="contact-number-area">
              <p>Need help? Call Us:
                <a href="tel:+258326821485">+973 35549994</a>
              </p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>


      <div class="header-mid-one-wrapper">
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
          <div class="header-mid-wrapper-between">
            <div class="nav-sm-left">
                <ul class="nav-h_top">
                <li><a href="{{ route('about') }}">About Us</a></li>
                @auth
                  <li><a href="{{ route('account.dashboard') }}">Dashboard</a></li>
                @else
                  <li><a href="{{ route('login') }}">Login</a></li>
                @endauth
              </ul>
              <p class="para">We deliver to your everyday from 7:00 to 22:00</p>
            </div>
            <div class="nav-sm-left">
              <ul class="nav-h_top language">
                <li class="category-hover-header language-hover">
                  <a href="#">English</a>
                  <ul class="category-sub-menu">
                    <li><a href="#" class="menu-item"><span>Italian</span></a></li>
                    <li><a href="#" class="menu-item"><span>Russian</span></a></li>
                    <li><a href="#" class="menu-item"><span>Chinese</span></a></li>
                  </ul>
                </li>
                <li class="category-hover-header language-hover">
                  <a href="#">BHD</a>
                  <ul class="category-sub-menu">
                    <li><a href="#" class="menu-item"><span>USD</span></a></li>
                    <li><a href="#" class="menu-item"><span>Rupee</span></a></li>
                    <li><a href="#" class="menu-item"><span>Euro</span></a></li>
                  </ul>
                </li>
                
                @auth
                  <a class="dropdown-item" href="{{ route('logout') }}"
                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="icon-base"></i><span>Logout</span>
                  </a>
                  </li>
                  <form method="POST" id="logout-form" action="{{ route('logout') }}">
                    @csrf
                  </form>
                @else
                  <li><a href="{{ route('login') }}">Login</a></li>
                @endauth
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="search-header-area-main">
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
          <div class="logo-search-category-wrapper">
            {{-- Logo --}}
            <a href="{{ route('home') }}" class="logo-area">
              <img src="{{ asset('assets/images/logo.png') }}" alt="Future Mission" class="logo" height="50">
            </a>

            {{-- Category + Search --}}
            <div class="category-search-wrapper d-none d-lg-flex">
              <div class="category-btn category-hover-header">
                <i class="fas fa-bars"></i>
                <span>All Categories</span>
                 <ul class="category-sub-menu">
              @foreach(\App\Models\Category::take(8)->get() as $cat)
                <li>
                  <a href="{{ route('shop.index', ['category' => $cat->id]) }}">
                    <img src="{{ asset('storage/'.$cat->icon) ?? asset('assets/images/cat-placeholder.png') }}" width="20" alt="">
                    {{ $cat->name }}
                  </a>
                </li>
              @endforeach
            </ul>
              </div>

              <form action="{{ route('shop.index') }}" method="GET" class="search-header">
                <input type="text" name="q" placeholder="Search for products, categories or brands" value="{{ request('q') }}" required>
                <a href="#" class="rts-btn btn-primary radious-sm with-icon">
                  <div class="btn-text">Search</div>
                  <div class="arrow-icon"><i class="fa-light fa-magnifying-glass"></i></div>
                  <div class="arrow-icon"><i class="fa-light fa-magnifying-glass"></i></div>
                </a>
              </form>
            </div>

            {{-- Actions (Mobile) --}}
            <div class="actions-area d-flex d-lg-none">
              <div class="search-btn" id="searchs">
                <svg width="17" height="16" viewBox="0 0 17 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path d="M15.75 14.7188L11.5625 10.5312C12.4688 9.4375 12.9688 8.03125 12.9688 6.5C12.9688 2.9375 10.0312 0 6.46875 0C2.875 0 0 2.9375 0 6.5C0 10.0938 2.90625 13 6.46875 13C7.96875 13 9.375 12.5 10.5 11.5938L14.6875 15.7812C14.8438 15.9375 15.0312 16 15.25 16C15.4375 16 15.625 15.9375 15.75 15.7812C16.0625 15.5 16.0625 15.0312 15.75 14.7188ZM1.5 6.5C1.5 3.75 3.71875 1.5 6.5 1.5C9.25 1.5 11.5 3.75 11.5 6.5C11.5 9.28125 9.25 11.5 6.5 11.5C3.71875 11.5 1.5 9.28125 1.5 6.5Z" fill="#1F1F25"></path>
                </svg>
              </div>
              <div class="menu-btn" id="menu-btn">
                <svg width="20" height="16" viewBox="0 0 20 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <rect y="14" width="20" height="2" fill="#1F1F25"></rect>
                  <rect y="7" width="20" height="2" fill="#1F1F25"></rect>
                  <rect width="20" height="2" fill="#1F1F25"></rect>
                </svg>
              </div>
            </div>

            {{-- Account, Wishlist, Cart --}}
            <div class="accont-wishlist-cart-area-header">
                
              @auth
                <a href="{{ route('account.dashboard') }}" class="btn-border-only account">
                  <i class="fa-light fa-user"></i>
                  <span>Dashboard</span>
                </a>
                <a href="{{ route('wishlist.index') }}" class="btn-border-only account">
                  <i class="fa-light fa-user"></i>
                  <span>Wishlist</span>
                </a>
              @else
                <a href="{{ route('login') }}" class="btn-border-only account">
                  <i class="fa-light fa-user"></i>
                  <span>Login</span>
                </a>
                <a href="{{ route('register') }}" class="btn-border-only account">
                  <i class="fa-light fa-user"></i>
                  <span>Register</span>
                </a>
              @endauth

      

              <div class="btn-border-only cart category-hover-header">
                <i class="fa-sharp fa-regular fa-cart-shopping"></i>
                <span class="text">My Cart</span>
                <span class="number">{{ $cartCount }}</span>
                
                <a href="{{ route('cart.index') }}" class="over_link"></a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>


    
          <div class="rts-header-nav-area-one header--sticky">
              <div class="container">
                  <div class="row">
                      <div class="col-lg-12">
                          <div class="nav-and-btn-wrapper">
                            <div class="nav-area">
                <nav>
                  <ul class="parent-nav">

                    <!-- Home -->
                    <li class="parent">
                      <a class="nav-link {{ request()->is('/') ? 'active' : '' }}" href="{{ route('home') }}">Home</a>
                    </li>

                    <!-- Shop -->
                    <li class="parent">
                      <a class="{{ request()->routeIs('shop.*') ? 'active' : '' }}"
                        href="{{ route('shop.index') }}">Shop</a>
                    </li>

                    <!-- Service -->
                    <li class="parent">
                      <a class="{{ request()->routeIs('service.*') ? 'active' : '' }}"
                        href="{{ route('service.index') }}">Service</a>
                    </li>

                    <!-- About -->
                    <li class="parent">
                      <a class="{{ request()->routeIs('about') ? 'active' : '' }}"
                        href="{{ route('about') }}">About</a>
                    </li>

                    <!-- Contact -->
                    <li class="parent">
                      <a class="{{ request()->routeIs('contact') ? 'active' : '' }}"
                        href="{{route('contact')}}">Contact</a>
                    </li>

              

                  </ul>
                </nav>
              </div>
                            <!-- button-area -->
                            <div class="right-btn-area">
                              <!-- <a href="{{ route('register') }}" class="btn-narrow">Become a Seller</a> -->
                                <a href="#" class="btn-narrow"></a>
                                <button class="rts-btn btn-primary">
                                    Become a Seller
                                    <span ><a href="{{ route('register.vendor') }}" style="color:var(--primary-color)">Sign up</a></span>
                                </button>
                            </div>
                            <!-- button-area end -->
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="logo-search-category-wrapper after-md-device-header">
                            <a href="{{ route('home') }}" class="logo-area">
                              <img src="{{ asset('assets/images/logo.png') }}" alt="Future Mission" class="logo" height="50">
                            </a>
                            <div class="category-search-wrapper">
                                <div class="category-btn category-hover-header">
                                    <img class="parent" src="assets/images/icons/bar-1.svg" alt="icons">
                                    <span>Categories</span>
                                    <ul class="category-sub-menu">
                                      @foreach(\App\Models\Category::take(8)->get() as $cat)
                                        <li>
                                            <a href="{{ route('shop.index', ['category' => $cat->id]) }}" class="menu-item">
                                              
                                                <img src="{{  asset('storage/' . $cat->icon)?? asset('assets/images/cat-placeholder.png') }}" alt="icons">
                                                <span>{{$cat->name}}</span>
                                                <!-- <i class="fa-regular fa-plus"></i> -->
                                            </a>
                                        </li>
                                        @endforeach
                                    </ul>
                                </div>
                                  <form action="{{ route('shop.index') }}" method="GET" class="search-header">
                                    <input type="text" name="q" placeholder="Search for products, categories or brands" value="{{ request('q') }}" required>

                                    <button class="rts-btn btn-primary radious-sm with-icon">
                                        <span class="btn-text">
                                        Search
                                    </span>
                                        <span class="arrow-icon">
                                        <i class="fa-light fa-magnifying-glass"></i>
                                    </span>
                                        <span class="arrow-icon">
                                        <i class="fa-light fa-magnifying-glass"></i>
                                    </span>
                                    </button>
                                </form>
                            </div>
                            <div class="main-wrapper-action-2 d-flex">
                                <div class="accont-wishlist-cart-area-header">
                                    @auth
                                  <a href="{{ route('account.dashboard') }}" class="btn-border-only account">
                                    <i class="fa-light fa-user"></i>
                                    <span>Dashboard</span>
                                  </a>
                                  <a href="{{ route('wishlist.index') }}" class="btn-border-only account">
                                    <i class="fa-light fa-user"></i>
                                    <span>Wishlist</span>
                                  </a>
                                @else
                                  <a href="{{ route('login') }}" class="btn-border-only account">
                                    <i class="fa-light fa-user"></i>
                                    <span>Login</span>
                                  </a>
                                  <a href="{{ route('register') }}" class="btn-border-only account">
                                    <i class="fa-light fa-user"></i>
                                    <span>Register</span>
                                  </a>
                                @endauth


                            <div class="btn-border-only cart category-hover-header">
                              <i class="fa-sharp fa-regular fa-cart-shopping"></i>
                              <span class="text">My Cart</span>
                              <span class="number">{{ $cartCount }}</span>

                              <div class="category-sub-menu card-number-show">
                                <h5 class="shopping-cart-number">Shopping Cart ({{ $cartCount }})</h5>
                                @if (session('cart') && count(session('cart')) > 0)
                                  @foreach (session('cart') as $id => $item)
                                    <div class="cart-item-1 {{ $loop->first ? 'border-top' : '' }}">
                                      <div class="img-name">
                                        <div class="thumbanil">
                                          <img src="{{ $item['image'] ?? asset('assets/images/placeholder.png') }}" alt="{{ $item['name'] }}">
                                        </div>
                                        <div class="details">
                                          <a href="#">
                                            <h5 class="title">{{ $item['name'] }}</h5>
                                          </a>
                                          <div class="number">
                                            {{ $item['quantity'] ?? 1 }} <i class="fa-regular fa-x"></i>
                                            <span>₹{{ number_format($item['price'], 2) }}</span>
                                          </div>
                                        </div>
                                      </div>
                                      <div class="close-c1">
                                        <a href="{{ route('cart.remove', $id) }}"><i class="fa-regular fa-x"></i></a>
                                      </div>
                                    </div>
                                  @endforeach

                                  <div class="sub-total-cart-balance">
                                    <div class="bottom-content-deals mt--10">
                                      <div class="top">
                                        <span>Sub Total:</span>
                                        <span class="number-c">₹{{ $cartSubtotalFormatted }}</span>
                                      </div>
                                      <div class="single-progress-area-incard">
                                        <div class="progress">
                                          <div class="progress-bar wow fadeInLeft" role="progressbar" style="width:  aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                      </div>
                                      <p>Spend More <span></span> to reach <span>Free Shipping</span></p>
                                    </div>
                                    <div class="button-wrapper d-flex align-items-center justify-content-between">
                                      <a href="{{ route('cart.index') }}" class="rts-btn btn-primary">View Cart</a>
                                      <a href="{{ route('checkout.index') }}" class="rts-btn btn-primary border-only">CheckOut</a>
                                    </div>
                                  </div>
                                @else
                                  <p class="text-center py-4">Your cart is empty</p>
                                @endif
                              </div>
                              <a href="{{ route('cart.index') }}" class="over_link"></a>
                            </div>
                                </div>
                                <div class="actions-area">
                                    <div class="search-btn" id="search">

                                        <svg width="17" height="16" viewBox="0 0 17 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M15.75 14.7188L11.5625 10.5312C12.4688 9.4375 12.9688 8.03125 12.9688 6.5C12.9688 2.9375 10.0312 0 6.46875 0C2.875 0 0 2.9375 0 6.5C0 10.0938 2.90625 13 6.46875 13C7.96875 13 9.375 12.5 10.5 11.5938L14.6875 15.7812C14.8438 15.9375 15.0312 16 15.25 16C15.4375 16 15.625 15.9375 15.75 15.7812C16.0625 15.5 16.0625 15.0312 15.75 14.7188ZM1.5 6.5C1.5 3.75 3.71875 1.5 6.5 1.5C9.25 1.5 11.5 3.75 11.5 6.5C11.5 9.28125 9.25 11.5 6.5 11.5C3.71875 11.5 1.5 9.28125 1.5 6.5Z" fill="#1F1F25"></path>
                                        </svg>

                                    </div>
                                    <div class="menu-btn">

                                        <svg width="20" height="16" viewBox="0 0 20 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <rect y="14" width="20" height="2" fill="#1F1F25"></rect>
                                            <rect y="7" width="20" height="2" fill="#1F1F25"></rect>
                                            <rect width="20" height="2" fill="#1F1F25"></rect>
                                        </svg>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- rts header area end -->

    <!-- rts header area start -->
    <!-- header style two -->
    <div id="side-bar" class="side-bar header-two">
        <button class="close-icon-menu"><i class="far fa-times"></i></button>


        <form action="#" class="search-input-area-menu mt--30">
            <input type="text" placeholder="Search..." required>
            <button><i class="fa-light fa-magnifying-glass"></i></button>
        </form>

        <div class="mobile-menu-nav-area tab-nav-btn mt--20">

            <nav>
                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                    <button class="nav-link active" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home" type="button" role="tab" aria-controls="nav-home" aria-selected="true">Menu</button>
                    <button class="nav-link" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile" type="button" role="tab" aria-controls="nav-profile" aria-selected="false">Category</button>
                </div>
            </nav>

            <div class="tab-content" id="nav-tabContent">
                <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab" tabindex="0">
                    <!-- mobile menu area start -->
                    <div class="mobile-menu-main">
                        <nav class="nav-main mainmenu-nav mt--30">
                            <ul class="mainmenu metismenu" id="mobile-menu-active">
                                <li >
                                    <a href="#" class="main">Home</a>
                                </li>
                                <li>
                                    <a href="about.html" class="main">About</a>
                                </li>
                                <!-- <li class="has-droupdown"> -->
                                  <li>
                                    <a href="#" class="main">Services</a>
                                    <!-- <ul class="submenu mm-collapse">
                                        <li><a class="mobile-menu-link" href="about.html">About</a></li>
                                        <li><a class="mobile-menu-link" href="faq.html">Faq's</a></li>
                                        <li><a class="mobile-menu-link" href="invoice.html">Invoice</a></li>
                                        <li><a class="mobile-menu-link" href="contact.html">Contact</a></li>
                                        <li><a class="mobile-menu-link" href="register.html">Register</a></li>
                                        <li><a class="mobile-menu-link" href="login.html">Login</a></li>
                                        <li><a class="mobile-menu-link" href="privacy-policy.html">Privacy Policy</a></li>
                                        <li><a class="mobile-menu-link" href="cookies-policy.html">Cookies Policy</a></li>
                                        <li><a class="mobile-menu-link" href="terms-condition.html">Terms Condition</a></li>
                                        <li><a class="mobile-menu-link" href="404.html">Error Page</a></li>
                                    </ul> -->
                                </li>
                                <li >
                                    <a href="#" class="main">Shop</a>
                    
                                </li>
                      
                                <li>
                                    <a href="{{route('contact')}}" class="main">Contact Us</a>
                                </li>
                            </ul>
                        </nav>

                    </div>
                    <!-- mobile menu area end -->
                </div>
                <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab" tabindex="0">
                    <div class="category-btn category-hover-header menu-category">
                        <ul class="category-sub-menu" id="category-active-menu">
                            @foreach(\App\Models\Category::take(8)->get() as $cat)

                            <!-- <li>
                                <a href="#" class="menu-item">
                                    <img src="assets/images/icons/01.svg" alt="icons">
                                    <span>Breakfast &amp; Dairy</span>
                                    <i class="fa-regular fa-plus"></i>
                                </a>
                            </li> -->
                            <li>
                              <a href="{{ route('shop.index', ['category' => $cat->id]) }}">
                                <img src="{{ $cat->icon ?? asset('assets/images/cat-placeholder.png') }}" width="20" alt="">
                                {{ $cat->name }}
                              </a>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>

        </div>

        <!-- button area wrapper start -->
        <div class="button-area-main-wrapper-menuy-sidebar mt--50">
            <div class="contact-area">
                <div class="phone">
                    <i class="fa-light fa-headset"></i>
                    <a href="#">+91 9080010758</a>
                </div>
                <div class="phone">
                    <i class="fa-light fa-envelope"></i>
                    <a href="#">+91 9080010758</a>
                </div>
            </div>
            <div class="buton-area-bottom">
                <a href="login.html" class="rts-btn btn-primary">Sign In</a>
                <a href="register.html" class="rts-btn btn-primary">Sign Up</a>
            </div>
        </div>
        <!-- button area wrapper end -->

</div>


@push('scripts')
    <!-- plugins js -->
    <script defer src="assets/js/plugins.js"></script>

    <!-- custom js -->
    <script defer src="assets/js/main.js"></script>
    <!-- header style two End -->
<script>
    const countDownDate = new Date("{{ now()->addDays(7)->format('M d, Y 00:00:00') }}").getTime();
    const x = setInterval(function() {
      const now = new Date().getTime();
      const distance = countDownDate - now;

      const days = Math.floor(distance / (1000 * 60 * 60 * 24));
      const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
      const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
      const seconds = Math.floor((distance % (1000 * 60)) / 1000);

      document.getElementById("days").innerHTML = days < 10 ? "0" + days : days;
      document.getElementById("hours").innerHTML = hours < 10 ? "0" + hours : hours;
      document.getElementById("minutes").innerHTML = minutes < 10 ? "0" + minutes : minutes;
      document.getElementById("seconds").innerHTML = seconds < 10 ? "0" + seconds : seconds;

      if (distance < 0) {
        clearInterval(x);
        document.querySelector('#countdown-1').innerHTML = "<span>EXPIRED</span>";
      }
    }, 1000);
  </script>
@endpush