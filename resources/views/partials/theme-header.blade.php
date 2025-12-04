@php
use App\Models\CartItem;
use Illuminate\Support\Str;

$cartItems = auth()->check()
    ? CartItem::with('product.images')
        ->where('user_id', auth()->id())
        ->where('status', 'active')
        ->get()
    : collect([]);

$cartCount = $cartItems->sum('quantity');
$cartSubtotal = $cartItems->sum(function ($item) {
    return ($item->price ?? 0) * ($item->quantity ?? 1);
});
$cartSubtotalFormatted = number_format($cartSubtotal, 2);
@endphp

<!-- ============================
     FM — Full Replacement Header
     Mobile-first, glass-style, responsive
     Drop-in: replace your existing header entirely
============================= -->
<header id="fmHeader" class="fm-header">

  <!-- Offer — sliding marquee on mobile / static on desktop -->
  <div class="fm-offer" id="fmOffer" aria-hidden="false">
    <div class="fm-offer-wrap">
      <div class="fm-offer-text">
        FREE delivery &amp; 40% Discount for next 3 orders! Place your 1st order in. &nbsp;
        Need help? Call: <a href="tel:+97335549994">+973 35549994</a>
      </div>
    </div>
  </div>

  <!-- Top row: logo, categories, search, actions -->
  <div class="fm-top container">
    <div class="fm-left">
      <a href="{{ route('home') }}" class="fm-logo" aria-label="Future Mission">
        <img src="{{ asset('assets/images/FM.png') }}" alt="Future Mission logo" />

      </a>

      <button id="fmBtnCats" class="fm-btn fm-btn-cat" aria-expanded="false" aria-controls="fmCatsPanel">
        <svg width="18" height="14" viewBox="0 0 18 14" fill="none" aria-hidden="true">
          <rect width="18" height="2" rx="1" fill="#101827"/><rect y="6" width="18" height="2" rx="1" fill="#101827"/><rect y="12" width="18" height="2" rx="1" fill="#101827"/>
        </svg>
        <span class="fm-btn-text">All Categories</span>
      </button>
    </div>

    <div class="fm-search-area" role="search">
      <form action="{{ route('shop.index') }}" method="GET" class="fm-search-form">
        <input name="q" type="search" class="fm-search-input" placeholder="Search for products, categories or brands" value="{{ request('q') }}" aria-label="Search products">
        <button type="submit" class="fm-search-btn" aria-label="Search">
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none" aria-hidden="true">
            <path d="M21 21l-4.35-4.35" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            <circle cx="11" cy="11" r="6" stroke="#fff" stroke-width="2"/>
          </svg>
        </button>
      </form>
    </div>

    <div class="fm-actions">
      @auth
        <a href="{{ route('account.dashboard') }}" class="fm-action" title="Dashboard">
          <i class="fa-regular fa-user" aria-hidden="true"></i>
          <span class="fm-action-label">Dashboard</span>
        </a>
      @else
        <a href="{{ route('login') }}" class="fm-action" title="Login">
          <i class="fa-regular fa-user" aria-hidden="true"></i>
          <span class="fm-action-label">Login</span>
        </a>
      @endauth

      <a href="{{ route('wishlist.index') }}" class="fm-action fm-hide-md" title="Wishlist">
        <i class="fa-regular fa-heart" aria-hidden="true"></i>
        <span class="fm-action-label">Wishlist</span>
      </a>

      <div class="fm-cart" id="fmCart">
        <a href="{{ route('cart.index') }}" id="fmCartBtn" class="fm-action fm-cart-btn" aria-haspopup="true" aria-expanded="false" title="My Cart">
          <i class="fa-sharp fa-regular fa-cart-shopping" aria-hidden="true"></i>
          <span class="fm-cart-count" id="fmCartCount">{{ $cartCount }}</span>
          <span class="fm-action-label fm-hide-md">My Cart</span>
        </a>

        <div class="fm-cart-panel" id="fmCartPanel" role="menu" aria-hidden="true">
          <div class="fm-cart-items">
            @if($cartItems->isEmpty())
              <div class="fm-empty">Your cart is empty</div>
            @else
              @foreach($cartItems as $it)
                @php
                  $p = $it->product;
                  $thumb = $p && $p->images->first() ? asset('storage/'.$p->images->first()->path) : asset('assets/images/placeholder.png');
                @endphp
                <div class="fm-cart-row">
                  <div class="fm-cart-thumb"><img src="{{ $thumb }}" alt="{{ $p->name ?? 'Product' }}"></div>
                  <div class="fm-cart-meta">
                    <div class="fm-cart-name">{{ Str::limit($p->name ?? 'Product', 40) }}</div>
                    <div class="fm-cart-qty">x{{ $it->quantity }} · BHD {{ number_format($it->price,3) }}</div>
                  </div>
                  <form action="{{ route('cart.remove', $it->id) }}" method="POST" class="fm-cart-remove">
                    @csrf @method('DELETE')
                    <button class="fm-remove-btn" aria-label="Remove item"><i class="fa-regular fa-trash-can"></i></button>
                  </form>
                </div>
              @endforeach

              <div class="fm-cart-summary">
                <div>Subtotal</div>
                <div class="fm-subtotal">BHD {{ $cartSubtotalFormatted }}</div>
              </div>

              <div class="fm-cart-actions">
                <a href="{{ route('cart.index') }}" class="fm-btn fm-btn-outline">View Cart</a>
                <a href="{{ route('checkout.index') }}" class="fm-btn fm-btn-primary">Checkout</a>
              </div>
            @endif
          </div>
        </div>
      </div>

      <!-- mobile hamburger -->
      <button id="fmHamburger" class="fm-hamburger" aria-expanded="false" aria-controls="fmMobileMenu" title="Open Menu">
        <span></span><span></span><span></span>
      </button>
    </div>
  </div>

  <!-- Secondary nav (desktop) -->
  <nav class="fm-nav container" aria-label="Primary">
    <ul>
      <li><a href="{{ route('home') }}" class="{{ request()->is('/') ? 'active' : '' }}">Home</a></li>
      <li><a href="{{ route('shop.index') }}" class="{{ request()->routeIs('shop.*') ? 'active' : '' }}">Shop</a></li>
      <li><a href="{{ route('service.index') }}" class="{{ request()->routeIs('service.*') ? 'active' : '' }}">Service</a></li>
      <li><a href="{{ route('about') }}" class="{{ request()->routeIs('about') ? 'active' : '' }}">About</a></li>
      <li><a href="{{ route('contact') }}" class="{{ request()->routeIs('contact') ? 'active' : '' }}">Contact</a></li>
    </ul>
  </nav>

  <!-- Categories panel (compact on desktop) -->
  <div id="fmCatsPanel" class="fm-cats-panel" aria-hidden="true">
    <div class="fm-cats-grid container">
      @foreach(\App\Models\Category::take(12)->get() as $cat)
        <a href="{{ route('shop.index', ['category' => $cat->id]) }}" class="fm-cat-item">
          <img src="{{ asset('storage/' . ($cat->icon ?? '')) }}" alt="{{ $cat->name }}">
          <span>{{ $cat->name }}</span>
        </a>
      @endforeach
    </div>
  </div>

  <!-- Mobile Off-canvas -->
  <div id="fmMobileMenu" class="fm-mobile-menu" aria-hidden="true">
    <div class="fm-mobile-drawer">

        <!-- PREMIUM MOBILE HEADER -->
        <div class="fm-mobile-header">
            <img src="{{ asset('assets/images/FM.png') }}" class="fm-mobile-logo" alt="FM">
            <button id="fmMobileClose" class="fm-mobile-close">&times;</button>
        </div>


      <div class="fm-mobile-links">
        <a href="{{ route('home') }}">Home</a>
        <a href="{{ route('shop.index') }}">Shop</a>
        <a href="{{ route('service.index') }}">Service</a>
        <a href="{{ route('about') }}">About</a>
        <a href="{{ route('contact') }}">Contact</a>
      </div>

      <div class="fm-mobile-actions">
        @auth
          <a href="{{ route('account.dashboard') }}">Dashboard</a>
        @else
          <a href="{{ route('login') }}">Login</a>
        @endauth
        <a href="{{ route('wishlist.index') }}">Wishlist</a>
        <a href="{{ route('cart.index') }}">Cart ({{ $cartCount }})</a>
      </div>

      <div class="fm-mobile-cats">
        <h4>Categories</h4>
        <div class="fm-mobile-cat-grid">
          @foreach(\App\Models\Category::take(12)->get() as $cat)
            <a href="{{ route('shop.index', ['category' => $cat->id]) }}" class="fm-mobile-cat">
              <img src="{{ asset('storage/' . ($cat->icon ?? '')) }}" alt="{{ $cat->name }}">
              <span>{{ $cat->name }}</span>
            </a>
          @endforeach
        </div>
      </div>
    </div>
  </div>

</header>

<!-- ============================
     Header Styles (self-contained)
============================= -->
@stack('styles')
<style>

  :root{
    --fm-accent-1: #ffae00;
    --fm-accent-2: #ff7a00;
    --fm-bg: rgba(255,255,255,0.78);
    --fm-border: rgba(15,23,42,0.06);
    --fm-text: #071224;
  }

  /* Reset small items used here */
  #fmHeader, #fmHeader * { box-sizing: border-box; }

  /* Header base */
  .fm-header{
    position: sticky;
    top:0;
    z-index:2000;
    background: linear-gradient(180deg, rgba(255,255,255,0.82), rgba(255,255,255,0.70));
    backdrop-filter: blur(10px);
    -webkit-backdrop-filter: blur(10px);
    border-bottom: 1px solid var(--fm-border);
    font-family: system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", Arial;
  }

  /* container utility (keeps layout consistent) */
  .container {
    width: calc(100% - 28px);
    max-width: 1280px;
    margin: 0 auto;
  }

  /* Offer bar */
  .fm-offer{
    display:block; /* shown on mobile via media query */
    overflow:hidden;
    background: linear-gradient(90deg, var(--fm-accent-1), var(--fm-accent-2));
    color: #071224;
    font-weight: 700;
    font-size: 14px;
    padding: 8px 0;
    border-bottom:1px solid rgba(0,0,0,0.04);
  }
  .fm-offer-wrap{ display:flex; align-items:center; width:100%; }
  .fm-offer-text{
    display:inline-block;
    white-space:nowrap;
    padding-left: 100%;
    animation: fm-marquee 12s linear infinite;
  }
  .fm-offer-text a{ color:inherit; text-decoration:underline; font-weight:800; }

  @keyframes fm-marquee{
    0%{ transform: translateX(0%); }
    100%{ transform: translateX(-100%); }
  }

  /* Top row layout */
 .fm-top{
    display:flex;
    align-items:center;
    gap: 18px;
    padding: 18px 0;           /* Increased height */
}

.fm-left{ display:flex; align-items:center; gap:12px; min-width: 140px; }

  

  /* Buttons */
  .fm-btn{
    display:inline-flex;
    align-items:center;
    gap:8px;
    padding:9px 12px;
    border-radius:10px;
    background:#fff;
    border:1px solid #eef2f6;
    box-shadow: 0 6px 18px rgba(2,6,23,0.03);
    cursor:pointer;
    font-weight:700;
    color:var(--fm-text);
  }
  .fm-btn svg{ display:block; }

  .fm-btn-cat .fm-btn-text{ display:inline-block; }

  /* Search area */
  .fm-search-area{ flex:1; display:flex; justify-content:center; }
  .fm-search-form{
    width:100%;
    max-width:920px;
    display:flex;
    gap:8px;
    align-items:center;
  }
  .fm-search-input{
    flex:1;
    padding:14px 18px;
    font-size:15px;
    border-radius:10px;
    border:1px solid #e6eef6;
    outline:none;
    background: rgba(255,255,255,0.95);
  }
  .fm-search-btn{
    height:48px;
    width:58px;
    border-radius:10px;
    border:none;
    display:flex;
    align-items:center;
    justify-content:center;
    background: linear-gradient(90deg,var(--fm-accent-1),var(--fm-accent-2));
    color: #fff;
    box-shadow: 0 6px 18px rgba(255,138,0,0.12);
    cursor:pointer;
  }
  .fm-search-btn svg{ width:18px; height:18px; }

  /* actions */
  .fm-actions{
    display:flex;
    align-items:center;
    gap:10px;
  }
  .fm-action{
    display:flex;
    align-items:center;
    gap:8px;
     padding:10px 12px;
    border-radius:8px;
    background:#fff;
    border:1px solid #eef2f6;
    box-shadow:0 6px 18px rgba(2,6,23,0.03);
    color:var(--fm-text);
    text-decoration:none;
    font-weight:600;
  }
  .fm-action .fm-action-label{ display:inline-block; font-size:12px; color:#101827; }
  .fm-hide-md{ display:inline-flex; } /* hide on medium below via media query */

  /* Cart */
  .fm-cart{ position:relative; }
  .fm-cart-btn{ position:relative; display:flex; gap:8px; align-items:center; }
  .fm-cart-count{
    position:absolute;
    top:-6px;
    right:-8px;
    background: var(--fm-accent-1);
    color:#071224;
    font-weight:800;
    border-radius:999px;
    padding:3px 7px;
    font-size:12px;
  }

  .fm-cart-panel{
    position:absolute;
    right:0;
    top:56px;
    width:360px;
    background:#fff;
    border-radius:12px;
    box-shadow: 0 10px 30px rgba(2,6,23,0.12);
    padding:12px;
    display:none;
    z-index:2100;
  }
  .fm-cart-row{ display:flex; gap:10px; align-items:center; padding:10px 6px; border-bottom:1px solid #f1f5f9; }
  .fm-cart-thumb img{ width:56px; height:56px; object-fit:contain; border-radius:8px; background:#fafafa; }
  .fm-cart-name{ font-weight:700; font-size:13px; color:#0f172a; }
  .fm-cart-qty{ color:#64748b; font-size:13px; margin-top:6px; }
  .fm-remove-btn{ background:transparent; border:none; color:#ef4444; font-size:16px; cursor:pointer; }

  .fm-cart-summary{ display:flex; justify-content:space-between; padding:10px 6px; font-weight:800; color:#0f172a; }
  .fm-cart-actions{ display:flex; gap:8px; justify-content:space-between; }

  /* nav */
  .fm-nav{ background:transparent; border-top:1px solid rgba(15,23,42,0.03); padding:8px 0; }
  .fm-nav ul{ display:flex; gap:22px; list-style:none; padding:0; margin:0; align-items:center; flex-wrap:wrap; }
  .fm-nav a{ color:#0f172a; text-decoration:none; font-weight:700; padding:6px 8px; border-radius:8px; }
  .fm-nav a.active{ color:var(--fm-accent-2); }

  /* categories panel (desktop = compact) */
  .fm-cats-panel{ display:none; padding:12px 0; border-bottom:1px solid rgba(15,23,42,0.03); background: rgba(255,255,255,0.85); backdrop-filter: blur(14px); }
  .fm-cats-grid{ display:flex; gap:12px; flex-wrap:wrap; justify-content:flex-start; align-items:center; }
  .fm-cat-item{
    display:flex;
    flex-direction:column;
    align-items:center;
    gap:8px;
    width:96px;              /* slightly compact on desktop */
    padding:10px;
    text-align:center;
    background:#fff;
    border-radius:10px;
    box-shadow:0 8px 20px rgba(2,6,23,0.04);
    text-decoration:none;
    color:#0f172a;
    border:1px solid #f3f5f7;
  }
  .fm-cat-item img{ width:44px; height:44px; object-fit:contain; }

  /* mobile off-canvas */
  .fm-mobile-menu{
    position:fixed;
    inset:0;
    display:none;
    z-index:2200;
    background: rgba(2,6,23,0.45);
  }
  .fm-mobile-drawer{
    width:320px;
    height:100%;
    background:#fff;
    padding:18px;
    overflow:auto;
  }
  .fm-mobile-close{ font-size:28px; border:none; background:none; display:block; margin-left:auto; cursor:pointer; }
  .fm-mobile-links a{ display:block; padding:10px 6px; font-weight:700; text-decoration:none; color:#101827; border-bottom:1px solid #f1f5f9; }
  .fm-mobile-actions a{ display:block; padding:10px 6px; text-decoration:none; color:#101827; font-weight:700; margin-top:6px; }
  .fm-mobile-cat-grid{ display:flex; gap:12px; flex-wrap:wrap; margin-top:8px; }
  .fm-mobile-cat{ display:flex; align-items:center; gap:8px; padding:8px; text-decoration:none; color:#111; background:#fff; border-radius:8px; border:1px solid #f1f5f9; }

  /* buttons */
  .fm-btn-outline{ background:#fff; border:1px solid #eef2f6; padding:8px 12px; border-radius:8px; text-decoration:none; color:var(--fm-text); display:inline-block; }
  .fm-btn-primary{ background: linear-gradient(90deg,var(--fm-accent-1),var(--fm-accent-2)); color:#fff; padding:8px 12px; border-radius:8px; border:none; text-decoration:none; display:inline-block; font-weight:700; }

  /* hamburger */
  .fm-hamburger{ display:none; width:46px; height:36px; border-radius:8px; background:#fff; border:1px solid #eef2f6; align-items:center; justify-content:center; flex-direction:column; gap:4px; padding:6px; }
  .fm-hamburger span{ display:block; height:3px; background:#101827; border-radius:3px; width:22px; }

  /* small adjustments */
  .fm-empty{ padding:18px; color:#6b7280; text-align:center; }

  /* ===== Responsive breakpoints ===== */
  /* Large tablets / small laptops */
  @media (max-width: 1024px){
    .container{ width: calc(100% - 24px); }
    .fm-hide-md{ display:none !important; }
    .fm-nav ul{ gap:18px; }
  }

  /* Tablet & mobile */
  @media (max-width: 820px){
 /* show sliding offer on mobile/tablet */
    .fm-top{ flex-wrap:wrap;gap:10px; align-items:center; padding:10px 0; }

    .fm-left{ min-width: 80px; width:auto;
        flex:0 0 auto;}
    .fm-search-area{ order:3; width:100%; padding:0 6px;   width:100%;
        order:3;}
    .fm-search-form{ max-width:100%; }
    .fm-actions{ order:2; margin-left:auto; gap:8px;   order:2;
        margin-left:auto; }

    .fm-nav{ display:none; }
    .fm-btn-cat .fm-btn-text{ display:none; } /* compact categories button */
    .fm-cat-item{ width:92px; padding:8px; }
    .fm-cart-panel{ width: 92vw; left:4vw; right:auto; top:56px; }
    .fm-hamburger{ display:flex; }
  }

  /* Mobile (small) */
  @media (max-width: 480px){
    .fm-logo img{ height:40px; }
    .fm-search-input{ padding:10px 12px; font-size:14px; }
    .fm-search-btn{ width:48px; height:40px; }
    .fm-offer-text{ font-size:13px; }
    .fm-cat-item img{ width:40px; height:40px; }
       .fm-cats-panel{
        padding:10px 0;
    }
    .fm-cat-item{
        width:84px;
        padding:8px;
    }
  }
/* Force FM mobile menu above EVERYTHING */
#fmMobileMenu {
    position: fixed !important;
    inset: 0 !important;
    z-index: 99999999 !important;
    display: none;
    overflow: hidden !important; /* prevents clipping inside */
    pointer-events: auto !important;
}

/* ==========================================================
  reminder: if you need deletion, you can
   FINAL MOBILE RESPONSIVENESS FIX (NO CATEGORIES ON MOBILE)
   Drop-in override — clean, stable and compatible
========================================================== */

/* 1. TOTALY HIDE CATEGORY BUTTON + CATEGORY PANEL + CAT GRID ON MOBILE */
@media (max-width: 820px) {
    #fmBtnCats,
    #fmCatsPanel,
    .fm-mobile-cats {
        display: none !important;
    }
}

/* 2. Fix header layout collapsing */
@media (max-width: 820px) {

    /* Make top header rows stack properly */
    #fmHeader .fm-top {
        display: flex !important;
        flex-wrap: wrap !important;
        align-items: center;
        justify-content: space-between;
        padding: 12px 0 !important;
    }

    /* Logo on left */
    #fmHeader .fm-left {
        flex: 0 0 auto;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    /* Hamburger and action icons on right */
    #fmHeader .fm-actions {
        flex: 0 0 auto !important;
        display: flex !important;
        gap: 10px !important;
        margin-left: auto !important;
        order: 2 !important;
    }

    /* Search bar goes full width */
    #fmHeader .fm-search-area {
        flex: 0 0 100% !important;
        width: 100% !important;
        margin-top: 10px;
        order: 3 !important;
    }
}

/* 3. Fix search bar input squeezed issue */
@media (max-width: 820px) {
    #fmHeader .fm-search-form {
        width: 100% !important;
        display: flex;
    }

    #fmHeader input[type="search"] {
        flex: 1 !important;
        width: 100% !important;
        min-width: 0 !important;
    }
}

/* 4. Fix mobile off-canvas (drawer should never be clipped) */
#fmMobileMenu {
    position: fixed !important;
    inset: 0 !important;
    background: rgba(0, 0, 0, 0.55) !important;
    z-index: 9999999 !important;
    display: none;
    overflow: hidden !important;
}

#fmMobileMenu .fm-mobile-drawer {
    position: absolute !important;
    right: 0;
    top: 0;
    width: 320px;
    height: 100vh;
    overflow-y: auto !important;
    background: #fff;
    box-shadow: -3px 0 20px rgba(0,0,0,0.15);
    z-index: 10000000 !important;
}

#fmMobileMenu {
     height: 100vh !important;

}
/* ============================================================
   PREMIUM FM MOBILE MENU DESIGN
   Safe to paste — no conflicts with your layout
============================================================ */

/* Mobile drawer top section */
.fm-mobile-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 14px 4px 18px;
    border-bottom: 1px solid rgba(0,0,0,0.06);
}

/* Logo scaling */
.fm-mobile-logo {
    height: 42px;             /* Perfect size */
    width: auto;
    object-fit: contain;
}

/* Close button */
.fm-mobile-close {
    font-size: 32px !important;
    font-weight: 300;
    color: #444 !important;
    border: none;
    background: none;
    cursor: pointer;
}

/* Main mobile links */
.fm-mobile-links a {
    display: block;
    padding: 12px 4px;
    font-weight: 600;
    font-size: 15px;
    color: #374151 !important;          /* Softer dark grey */
    border-bottom: 1px solid rgba(0,0,0,0.04);
    transition: 0.2s ease;
}

.fm-mobile-links a:hover {
    color: var(--fm-accent-2) !important;
    padding-left: 10px;
}

/* Account / Wishlist / Cart */
.fm-mobile-actions a {
    display: block;
    padding: 12px 6px;
    margin-top: 4px;
    font-size: 14px;
    color: #555 !important;
    font-weight: 600;
    transition: 0.2s ease;
}

.fm-mobile-actions a:hover {
    color: var(--fm-accent-1) !important;
    padding-left: 10px;
}

/* Categories section */
.fm-mobile-cats h4 {
    font-size: 15px;
    margin: 18px 0 10px;
    color: #444;
    font-weight: 700;
}

.fm-mobile-cat {
    background: #fafafa;
    border-radius: 10px;
    padding: 10px;
    border: 1px solid #f1f1f1;
    transition: 0.2s ease;
}

.fm-mobile-cat:hover {
    background: #fff6e5;
    border-color: var(--fm-accent-1);
    transform: translateY(-2px);
}

.fm-mobile-cat img {
    height: 36px !important;
    width: 36px !important;
    object-fit: contain;
}
/* ===========================================
   FIX LOGO SCALING FOR FM.png (desktop)
   Prevents layout from breaking
=========================================== */
.fm-logo img {
    max-height: 52px !important;   /* keeps header height stable */
    height: auto !important;
    width: auto !important;
    max-width: 180px !important;   /* limit width so it doesn't push UI */
    object-fit: contain !important;
}


/* Tablet fix */
@media (max-width: 1024px) {
    .fm-logo img {
        max-width: 150px !important;
    }
}

/* Mobile: smaller but crisp */
@media (max-width: 820px) {
    .fm-logo img {
        max-width: 130px !important;
        max-height: 40px !important;
    }
}

/* Small mobile */
@media (max-width: 480px) {
    .fm-logo img {
        max-width: 120px !important;
        max-height: 36px !important;
    }
}

</style>

@stack('scripts')
<!-- ============================
     Header Scripts (self-contained)
============================= -->
<script>
(function () {

    // ELEMENTS
    const btnCats     = document.getElementById('fmBtnCats');
    const catsPanel   = document.getElementById('fmCatsPanel');
    const cartBtn     = document.getElementById('fmCartBtn');
    const cartPanel   = document.getElementById('fmCartPanel');
    const hamburger   = document.getElementById('fmHamburger');
    const mobileMenu  = document.getElementById('fmMobileMenu');
    const mobileClose = document.getElementById('fmMobileClose');
    const offer       = document.getElementById('fmOffer');

    // ================================
    // CLOSE ALL PANELS
    // ================================
    function closeAll(except) {

        // Categories
        if (except !== "cats" && catsPanel) {
            catsPanel.style.display = "none";
            catsPanel.setAttribute("aria-hidden", "true");
            btnCats?.setAttribute("aria-expanded", "false");
        }

        // Cart
        if (except !== "cart" && cartPanel) {
            cartPanel.style.display = "none";
            cartPanel.setAttribute("aria-hidden", "true");
        }

        // Mobile menu
        if (except !== "mobile" && mobileMenu) {
            mobileMenu.style.display = "none";
            mobileMenu.setAttribute("aria-hidden", "true");
            hamburger?.setAttribute("aria-expanded", "false");
        }
    }

    // ================================
    // CATEGORY DROPDOWN (DESKTOP)
    // ================================
    btnCats?.addEventListener("click", function (e) {
        e.stopPropagation();
        const visible = catsPanel.style.display === "block";

        closeAll("cats");

        catsPanel.style.display = visible ? "none" : "block";
        btnCats.setAttribute("aria-expanded", visible ? "false" : "true");
        catsPanel.setAttribute("aria-hidden", visible ? "true" : "false");
    });

    // ================================
    // CART PANEL
    // ================================
    cartBtn?.addEventListener("click", function (e) {
        e.preventDefault();
        e.stopPropagation();

        const visible = cartPanel.style.display === "block";
        closeAll("cart");

        cartPanel.style.display = visible ? "none" : "block";
        cartPanel.setAttribute("aria-hidden", visible ? "true" : "false");
    });

    // ================================
    // CLICK OUTSIDE TO CLOSE PANELS
    // ================================
    document.addEventListener("click", function (e) {
        const target = e.target;

        if (catsPanel && !catsPanel.contains(target) && !btnCats.contains(target)) {
            catsPanel.style.display = "none";
            btnCats.setAttribute("aria-expanded", "false");
        }

        if (cartPanel && !cartPanel.contains(target) && !cartBtn.contains(target)) {
            cartPanel.style.display = "none";
        }
    });

    // ================================
    // MOBILE MENU – OPEN
    // ================================
    hamburger?.addEventListener("click", function () {
        closeAll("mobile");

        if (mobileMenu) {
            mobileMenu.style.display = "block";

            // FIX: Chrome accessibility issue — remove aria-hidden
            mobileMenu.removeAttribute("aria-hidden");

            this.setAttribute("aria-expanded", "true");
            document.body.style.overflow = "hidden"; // prevent background scrolling
        }
    });

    // ================================
    // MOBILE MENU – CLOSE
    // ================================
    mobileClose?.addEventListener("click", function () {
        if (mobileMenu) {
            mobileMenu.style.display = "none";
            mobileMenu.setAttribute("aria-hidden", "true");
            hamburger.setAttribute("aria-expanded", "false");
            document.body.style.overflow = "auto";
        }
    });

    // ESC CLOSES EVERYTHING
    document.addEventListener("keydown", function (ev) {
        if (ev.key === "Escape") closeAll();
    });

    // ON RESIZE > 820px, CLOSE MOBILE MENU
    window.addEventListener("resize", function () {
        if (window.innerWidth > 820 && mobileMenu) {
            mobileMenu.style.display = "none";
            mobileMenu.setAttribute("aria-hidden", "true");
            document.body.style.overflow = "auto";
        }
    });

    // PREVENT PANEL CLICK PROPAGATION
    [catsPanel, cartPanel, mobileMenu].forEach(el => {
        el?.addEventListener("click", e => e.stopPropagation());
    });

    // OPTIONAL – Pause sliding offer animation on hover
    if (offer) {
        const txt = offer.querySelector(".fm-offer-text");
        offer.addEventListener("mouseenter", () => txt && (txt.style.animationPlayState = "paused"));
        offer.addEventListener("mouseleave", () => txt && (txt.style.animationPlayState = "running"));
    }

})();

</script>
