@extends('layouts.theme')
@section('title', $product->name ?? 'Product')
@section('body_class','shop-details shopifyish-page')

@section('content')

<!-- Fonts (swap or self-host if you prefer) -->
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700;800&family=Playfair+Display:wght@600;700&display=swap" rel="stylesheet">

<style>
:root{
  --s-bg: #ffffff;
  --muted: #64748b;
  --accent: #fb923c;         /* warm orange */
  --accent-2: #ffb63a;       /* accent gradient */
  --danger: #dc2626;
  --glass: rgba(255,255,255,0.8);
  --shadow-1: 0 8px 30px rgba(8,15,30,0.07);
  --radius-lg: 18px;
  --container-gap: 28px;
  --max-width: 1200px;
}

/* PAGE LAYOUT */
.shopifyish-container{ max-width: var(--max-width); margin: 0 auto; padding: 36px 18px; box-sizing: border-box; }
.shopifyish-row{ display:flex; gap: var(--container-gap); align-items:flex-start; }

/* LEFT: GALLERY */
.shopifyish-gallery{
  flex: 1 1 55%;
  display:flex;
  flex-direction:column;
  gap:16px;
}
.shopifyish-main-image{
  background: #fafafa;
  border-radius: 14px;
  overflow: hidden;
  position: relative;
  height: 520px;
  box-shadow: var(--shadow-1);
  display:flex;
  align-items:center;
  justify-content:center;
}
.shopifyish-main-image img{
  width:100%;
  height:100%;
  object-fit:contain;
  transition: transform .28s ease, opacity .18s ease;
  will-change: transform;
  user-select: none;
  -webkit-user-drag: none;
}
.shopifyish-thumbs{
  display:flex;
  gap:12px;
  align-items:center;
  justify-content:flex-start;
  overflow-x:auto;
  padding-bottom:6px;
}
.shopifyish-thumb{
  flex: 0 0 auto;
  width:76px;
  height:76px;
  border-radius:10px;
  overflow:hidden;
  border: 2px solid transparent;
  background:#fff;
  box-shadow: 0 6px 18px rgba(9,10,12,0.04);
  cursor:pointer;
  transition: transform .15s ease, border-color .12s ease;
  display:flex;
  align-items:center;
  justify-content:center;
}
.shopifyish-thumb img{ width:100%; height:100%; object-fit:cover; display:block; }
.shopifyish-thumb:hover{ transform: translateY(-4px); }
.shopifyish-thumb.active{ border-color: var(--accent); transform: scale(1.04); }

/* RIGHT: DETAILS - premium / Shopify-like */
.shopifyish-details{
  flex: 0 0 45%;
  background: var(--s-bg);
  border-radius: var(--radius-lg);
  box-shadow: var(--shadow-1);
  padding: 28px;
  display:flex;
  flex-direction:column;
  gap:18px;
  min-width: 320px;
}

/* Category + Rating row */
.pp-top{ display:flex; justify-content:space-between; gap:12px; align-items:center; }
.pp-category{
  font-weight:600;
  color: var(--accent);
  background: linear-gradient(180deg, rgba(251,146,60,0.12), rgba(251,146,60,0.06));
  padding:8px 14px;
  border-radius:999px;
  font-size:13px;
  display:inline-flex;
  align-items:center;
  gap:8px;
}
.pp-rating{ display:flex; gap:8px; align-items:center; color:var(--accent); font-weight:700; }
.pp-reviews{ color:var(--muted); font-weight:600; font-size:13px; }

/* Title */
.pp-title{ font-family: "Playfair Display", serif; font-size:26px; line-height:1.18; margin:0; color:#0f172a; font-weight:700; }

/* Short description (industry standard) */
.pp-short-desc{ font-family:Inter, system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", Arial; color:var(--muted); font-size:15px; line-height:1.6; margin:0; }

/* Price row */
.pp-price-row{ display:flex; align-items:center; gap:14px; }
.pp-price{ color: var(--danger); font-weight:800; font-size:28px; }
.pp-old-price{ color:#9aa0a6; font-size:15px; text-decoration:line-through; }

/* Buy area */
.pp-buy-box{ display:flex; gap:14px; align-items:center; flex-wrap:wrap; }
.pp-qty{
  display:flex; align-items:center; border:1px solid #e6edf5; border-radius:12px; overflow:hidden;
  background:#fff; min-height:44px;
}
.pp-qty .pp-qty-btn{ width:44px; height:44px; border:0; background:#f8fafc; font-size:20px; cursor:pointer; display:flex; align-items:center; justify-content:center; }
.pp-qty input{ width:64px; height:44px; border:0; text-align:center; font-weight:700; font-size:16px; }

/* Add button - premium */
.pp-add-btn{
  background: linear-gradient(135deg,var(--accent-2), #ff922b);
  color: white;
  padding:12px 18px;
  font-weight:700;
  border-radius:12px;
  border: none;
  display:inline-flex;
  align-items:center;
  gap:10px;
  cursor:pointer;
  box-shadow: 0 10px 30px rgba(255,140,50,0.12);
  transition: transform .12s ease, box-shadow .12s ease;
}
.pp-add-btn:hover{ transform: translateY(-2px); box-shadow: 0 16px 40px rgba(255,140,50,0.16); }

/* Meta list */
.pp-meta{ display:flex; flex-direction:column; gap:6px; color:var(--muted); font-size:14px; }
.pp-meta strong{ color:#0f172a; font-weight:600; }

/* Social (wishlist / share / compare) — premium)
   Make them look like modern chip buttons */
.pp-social{ display:flex; gap:10px; align-items:center; margin-top:6px; }
.pp-social .pp-chip{
  display:inline-flex; align-items:center; gap:8px; padding:10px 14px; border-radius:10px; border:1px solid #eef2ff;
  background: linear-gradient(180deg,#fff,#fbfbff);
  cursor:pointer; font-weight:600; color:#0f172a;
  transition: transform .12s ease, box-shadow .12s ease;
}
.pp-chip i{ font-size:14px; color: var(--accent); }
.pp-chip:hover{ transform: translateY(-3px); box-shadow: 0 10px 30px rgba(99,102,241,0.08); }

/* Tabs area (below details) */
.shopifyish-tabs{ margin-top:22px; background:transparent; border-radius:12px; padding: 0; }
.shopifyish-tabs .nav{ border-bottom:1px solid #edf2f7; margin-bottom:12px; }
.shopifyish-tabs .nav .nav-link{ color:#475569; padding:10px 14px; border-radius:8px 8px 0 0; }
.shopifyish-tabs .nav .nav-link.active{ color:#0f172a; font-weight:700; background:linear-gradient(180deg,#fff,#ffffff); border-bottom:3px solid var(--accent); }

/* Utility / responsive */
@media (max-width: 992px){
  .shopifyish-row{ flex-direction:column; }
  .shopifyish-gallery{ order:1; }
  .shopifyish-details{ order:2; width:100%; min-width:unset; padding:22px; }
  .shopifyish-main-image{ height:420px; }
}
@media (max-width: 576px){
  .shopifyish-main-image{ height:320px; border-radius:12px; }
  .shopifyish-thumb{ width:58px; height:58px; border-radius:8px; }
  .pp-title{ font-size:20px; }
  .pp-price{ font-size:22px; }
  .pp-category{ padding:6px 10px; font-size:12px; }
  .pp-qty input{ width:56px; }
  .pp-add-btn{ width:100%; justify-content:center; padding:12px; }
  .shopifyish-row{ gap:18px; }
  .shopifyish-container{ padding:18px; }
}

/* Keep featured products unaffected — scoping prevents styles bleeding */


/* --- Slim Glassmorphic Product Card (Option B) --- */
.product-card {
    display: flex;
    flex-direction: column;
    border-radius: 14px;
    overflow: hidden;
    position: relative;
    /* previously 320 -date , 1 dec */
    height: 420px; /* slightly slim */
    width: 100%;
    background: rgba(255,255,255,0.42);
    border: 1px solid rgba(255,255,255,0.26);
    box-shadow: 0 8px 26px rgba(18, 38, 63, 0.06);
    backdrop-filter: blur(8px);
    transition: transform .28s cubic-bezier(.2,.9,.2,1), box-shadow .28s;
}
.product-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 20px 45px rgba(18,38,63,0.12);
}

/* gradient accent border strip top */
.product-card::after{
    content: '';
    position: absolute;
    left: 0;
    right: 0;
    top: 0;
    height: 6px;
    background: var(--accent-gradient);
    border-top-left-radius: 14px;
    border-top-right-radius: 14px;
}

/* product image container */
/* FIXED — BIGGER IMAGE + BALANCED HEIGHT */
.product-image {
    /* preivously 260 1-dec */
    height: 60% !important;        /* Increase container height */
    padding: 18px !important;
    display:flex;
    align-items:center;
    justify-content:center;
    background: #f9f9f9;
    border-radius: 14px;
}

.product-image img {
    width: 100% !important;
    height: 100% !important;
    object-fit: contain !important;   /* fill without distortion */
    image-rendering: auto;
}



/* product body */
.product-body {

    padding: 12px 14px;
    display:flex;
    /* newly added 1-dec */
    height:40%;
    flex-direction:column;
    gap:6px;
    flex:1 1 auto;
}

/* title + subtitle */
.product-title {
    font-weight:700;
    color:#1f2937;
    font-size:15px;
    margin:0;
    line-height:1.25;
    display:block;
    -webkit-line-clamp:2;
    -webkit-box-orient:vertical;
    overflow:hidden;
    display:-webkit-box;
}
.product-subtitle {
    font-size:12px;
    color:#6b7280;
    margin-top:0;
}

/* small meta row */
.product-meta {
    display:flex;
    align-items:center;
    gap:8px;
    font-size:12px;
    color:#374151;
}

/* rating */
.product-rating {
    display:flex;
    gap:4px;
    align-items:center;
    color:#ffb63a;
    font-size:12px;
}

/* price row */
.price-row {
    display:flex;
    align-items:center;
    justify-content:space-between;
    gap:10px;
    margin-top:auto;
}
.product-price {
    font-weight:800;
    color:#e53e3e;
    font-size:16px;
}
.product-old-price {
    color:#9aa0a6;
    text-decoration:line-through;
    font-size:13px;
}

/* small badges and tiny description */
.badges {
    display:flex;
    gap:6px;
    align-items:center;
}
.badge {
    background: rgba(255,255,255,0.14);
    border: 1px solid rgba(255,255,255,0.06);
    padding:4px 8px;
    font-size:11px;
    border-radius:999px;
    color:#0f172a;
}

/* add to cart button (gradient) */
.premium-add-btn {
    background: var(--primary-gradient);
    color: #fff;
    border-radius: 10px;
    padding: 8px 10px;
    border: none;
    font-weight:700;
    font-size:13px;
    display:inline-flex;
    align-items:center;
    gap:8px;
    cursor:pointer;
    transition: transform .18s ease, box-shadow .18s ease;
}
.premium-add-btn:hover { transform: translateY(-2px); box-shadow:0 8px 22px rgba(118,75,162,0.18); }

/* discount pill */
.discount-pill {
    position:absolute;
    top:10px;
    left:10px;
    background: linear-gradient(90deg,#ff7a59,#ffb63a);
    color:#fff;
    padding:6px 8px;
    border-radius:12px;
    font-weight:700;
    font-size:12px;
    box-shadow:0 6px 18px rgba(255,119,89,0.12);
}

/* ensure product cards inside Swiper stretch nicely */
.second-featured-swiper .swiper-slide,
.first-featured-swiper .swiper-slide,
.mySwiper-featured-grocery .swiper-slide {
    display:flex;
    align-items:stretch;
}
.product-card .product-image,
.product-card .product-body { box-sizing:border-box; }

/* adjustments for the other small component classes already used in your file */
.single-grocery-product-one { /* keep this so older styles still safe */ }
.quantity-input { display:flex; align-items:center; gap:6px; }

/* responsive */
@media (max-width: 992px) {
    .product-card { height: 300px; }
    .product-image { flex:0 0 140px; }
    .product-image img { max-height:120px; }
}
@media (max-width: 576px) {
    .product-card { height: 340px; }
    .product-image { flex: 0 0 150px; }
}
</style>

<div class="shopifyish-container">

  <div class="rts-navigation-area-breadcrumb bg_light-1 mb-3">
    <div class="container">
      <div class="navigator-breadcrumb-wrapper">
        <a href="{{ route('home') }}">Shop</a>
        <i class="fa-regular fa-chevron-right"></i>
        <a class="current" href="{{ route('home') }}">{{ optional($product->category)->name ?? 'Appliances' }}</a>
        <i class="fa-regular fa-chevron-right"></i>
        <span class="current">{{ $product->name }}</span>
      </div>
    </div>
  </div>

  <div class="shopifyish-row">

    <!-- LEFT: Gallery -->
    <div class="shopifyish-gallery">
      <div class="shopifyish-main-image" id="shopifyishMainWrap">
        @php $firstImg = $product->images->first(); $firstSrc = $firstImg ? asset('storage/' . ltrim($firstImg->path, '/')) : asset('assets/images/placeholder.png'); @endphp
        <img id="shopifyishMainImage" src="{{ $firstSrc }}" alt="{{ $product->name }}" draggable="false" />
      </div>

      <div class="shopifyish-thumbs" id="shopifyishThumbs">
        @foreach($product->images as $img)
          @php $imgSrc = asset('storage/' . ltrim($img->path, '/')); @endphp
          <button type="button" class="shopifyish-thumb {{ $loop->first ? 'active' : '' }}" data-src="{{ $imgSrc }}" aria-label="Open image {{ $loop->iteration }}">
            <img src="{{ $imgSrc }}" alt="{{ $product->name }} thumbnail {{ $loop->iteration }}">
          </button>
        @endforeach
      </div>
    </div>

    <!-- RIGHT: Details -->
    <aside class="shopifyish-details" aria-labelledby="product-title">
      <div class="pp-top">
        <div class="pp-category">{{ optional($product->category)->name ?? "Uncategorized" }}</div>
        <div class="pp-rating">
          <i class="fa-solid fa-star" aria-hidden="true"></i>
          <span>{{ number_format($product->rating ?? 4.6, 1) }}</span>
          <span class="pp-reviews">({{ $product->reviews_count ?? 0 }} reviews)</span>
        </div>
      </div>

      <h1 id="product-title" class="pp-title">{{ $product->name }}</h1>

      <p class="pp-short-desc">{!! $product->short_description ?? \Illuminate\Support\Str::limit(strip_tags($product->description), 150) !!}</p>

      <div class="pp-price-row">
        <div>
          <div class="pp-price">BHD{{ number_format($product->price, 3) }}</div>
        </div>
        @if($product->old_price)
        <div><div class="pp-old-price">BHD{{ number_format($product->old_price, 3) }}</div></div>
        @endif
      </div>

      <div class="pp-buy-box">
        <div class="pp-qty" role="group" aria-label="Quantity">
          <button class="pp-qty-btn" type="button" id="ppMinus" aria-label="Decrease quantity">−</button>
          <input id="ppQtyInput" type="text" inputmode="numeric" pattern="[0-9]*" value="1" aria-label="Quantity">
          <button class="pp-qty-btn" type="button" id="ppPlus" aria-label="Increase quantity">+</button>
        </div>

        <form action="{{ route('cart.add') }}" method="POST" id="ppCartForm" class="pp-cart-form">
          @csrf
          <input type="hidden" name="product_id" value="{{ $product->id }}">
          <input type="hidden" name="qty" id="ppCartQty" value="1">
          <button type="submit" class="pp-add-btn" id="ppAddBtn">
            <i class="fa-solid fa-cart-shopping" aria-hidden="true"></i><span>Add to Cart</span>
          </button>
        </form>
      </div>

      <div class="pp-meta" aria-hidden="false">
        <div><strong>SKU:</strong> {{ $product->sku ?? 'N/A' }}</div>
        <div><strong>Brand:</strong> {{ optional($product->brand)->name ?? 'N/A' }}</div>
        <div><strong>Life:</strong> {{ $product->life ?? 'N/A' }}</div>
        <div><strong>Type:</strong> {{ ucfirst($product->type ?? 'N/A') }}</div>
        <div><strong>Tags:</strong>
          @if($product->tags && count($product->tags))
            @foreach($product->tags as $tag) {{ $tag->name }}@if(!$loop->last), @endif @endforeach
          @else N/A @endif
        </div>
      </div>

      <div class="pp-social" role="group" aria-label="Actions">
        <form action="{{ route('wishlist.add') }}" method="POST" style="margin:0;">
          @csrf
          <input type="hidden" name="product_id" value="{{ $product->id }}">
          <button class="pp-chip pp-wishlist" type="submit">
            <i class="fa-regular fa-heart" aria-hidden="true"></i> Wishlist
          </button>
        </form>

        <button class="pp-chip pp-share" type="button" id="ppShareBtn">
          <i class="fa-solid fa-share-nodes" aria-hidden="true"></i> Share
        </button>

        <button class="pp-chip pp-compare" type="button" id="ppCompareBtn">
          <i class="fa-solid fa-code-compare" aria-hidden="true"></i> Compare
        </button>
      </div>

    </aside>

  </div> <!-- /.shopifyish-row -->

  <!-- Tabs (kept below) -->
  <div class="shopifyish-tabs">
    <ul class="nav nav-tabs" id="productTab" role="tablist">
      <li class="nav-item"><button class="nav-link active" data-bs-toggle="tab" data-bs-target="#desc" type="button">Product Details</button></li>
      <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#info" type="button">Additional Information</button></li>
      <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#reviews" type="button">Customer Reviews</button></li>
    </ul>

    <div class="tab-content">
      <div class="tab-pane fade show active" id="desc">
        <div class="single-tab-content-shop-details">
          {!! $product->description !!}
        </div>
      </div>

      <div class="tab-pane fade" id="info">
        <p><strong>Brand:</strong> {{ optional($product->brand)->name ?? 'N/A' }}</p>
        <p><strong>Weight:</strong> {{ $product->weight ?? 'N/A' }}</p>
        <p><strong>Dimensions:</strong> {{ $product->dimensions ?? 'N/A' }}</p>
      </div>

      <div class="tab-pane fade" id="reviews">
        <h4>No customer reviews yet.</h4>
      </div>
    </div>
  </div>

</div> <!-- /.shopifyish-container -->

<!-- === FEATURED PRODUCTS BLOCK LEFT EXACTLY AS-IS (I DID NOT MODIFY) === -->
<section class="bg-white py-5 mb-5">
        <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="title-area-between">
                    <h2 class="title-left pt--30">Featured Products</h2>
                    <div class="next-prev-swiper-wrapper">
                        <div class="swiper-button-prev first-prod-prev"><i class="fa-regular fa-chevron-left"></i></div>
                        <div class="swiper-button-next first-prod-next"><i class="fa-regular fa-chevron-right"></i></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
       

        <div class="swiper first-featured-swiper">
            <div class="swiper-wrapper">
                @forelse($featured as $product)
                    @php
                        $img = $product->images->first();
                        $oldPrice = $product->price * 1.33;
                        $discount = 25;
                        $shortDesc = \Illuminate\Support\Str::limit($product->short_description ?? 'High quality product selected by our team.', 60);
                        $rating = $product->rating ?? 4.6;
                        $deliveryTag = $product->fast_delivery ? 'Fast Delivery' : 'Standard';
                    @endphp

                    <div class="swiper-slide">
                        <div class="product-card glass-card">

                            <div class="discount-pill">{{ $discount }}% OFF</div>

                            <div class="product-image">
                                <a href="{{ route('products.show', $product->id) }}">
                                    <img src="{{ $img ? asset('storage/' . $img->path) : asset('assets/images/placeholder.png') }}"
                                         alt="{{ $product->name }}">
                                </a>
                            </div>

                            <div class="product-body">
                                <h6 class="product-title">{{ \Illuminate\Support\Str::limit($product->name, 50) }}</h6>
                                <div class="product-subtitle">{{ $shortDesc }}</div>

                                <div class="product-meta">
                                    <div class="product-rating">
                                        <i class="fa-solid fa-star" aria-hidden="true"></i>
                                        <span>{{ number_format($rating, 1) }}</span>
                                        <span style="color:#94a3b8;font-weight:600;">({{ $product->reviews_count ?? 12 }})</span>
                                    </div>
                                    <div class="badges" style="margin-left:auto;">
                                        <div class="badge">{{ $deliveryTag }}</div>
                                        <div class="badge">In Stock</div>
                                    </div>
                                </div>

                                <div class="price-row">
                                    <div>
                                        <div class="product-price">BHD{{ number_format($product->price, 3) }}</div>
                                        <div class="product-old-price">BHD{{ number_format($oldPrice, 3) }}</div>
                                    </div>

                                    <form action="{{ route('cart.add') }}" method="POST" class="d-flex align-items-center">
                                        @csrf
                                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                                        <input type="hidden" name="quantity" value="1">
                                        <button type="submit" class="premium-add-btn">
                                            <i class="fas fa-shopping-cart"></i>
                                            Add
                                        </button>
                                    </form>
                                </div>
                            </div>

                        </div>
                    </div>

                @empty
                    <div class="swiper-slide text-center">
                        <h4 class="text-muted py-5">No featured products available yet</h4>
                    </div>
                @endforelse
            </div>
        </div>

    </div>
</section>

@push('scripts')
<script>
/* ===== CORE UI BEHAVIOR: gallery + qty + cart sync ===== */
(function(){
  const mainImg = document.getElementById('shopifyishMainImage');
  const thumbs = document.getElementById('shopifyishThumbs');
  const thumbButtons = thumbs ? Array.from(thumbs.querySelectorAll('.shopifyish-thumb')) : [];
  const ppQtyInput = document.getElementById('ppQtyInput');
  const ppMinus = document.getElementById('ppMinus');
  const ppPlus = document.getElementById('ppPlus');
  const ppCartQty = document.getElementById('ppCartQty');
  const ppForm = document.getElementById('ppCartForm');

  /* Thumbnail click -> change image with fade */
  thumbButtons.forEach(btn => {
    btn.addEventListener('click', (e) => {
      const src = btn.dataset.src;
      if(!src) return;

      // set active class
      thumbButtons.forEach(t => t.classList.remove('active'));
      btn.classList.add('active');

      // fade-out -> change -> fade-in
      mainImg.style.opacity = 0;
      setTimeout(()=> {
        mainImg.src = src;
        mainImg.style.opacity = 1;
      }, 140);
    });
  });

  /* Simple hover zoom on desktop */
  let zooming = false;
  document.getElementById('shopifyishMainWrap').addEventListener('mousemove', (e) => {
    if(window.innerWidth <= 768) return;
    const rect = mainImg.getBoundingClientRect();
    const x = (e.clientX - rect.left) / rect.width * 100;
    const y = (e.clientY - rect.top) / rect.height * 100;
    mainImg.style.transformOrigin = `${x}% ${y}%`;
    mainImg.style.transform = 'scale(1.6)';
    zooming = true;
  });
  document.getElementById('shopifyishMainWrap').addEventListener('mouseleave', () => {
    mainImg.style.transform = 'scale(1)';
    mainImg.style.transformOrigin = 'center center';
    zooming = false;
  });

  /* Touch: tap toggles zoom (light) */
  let lastTap = 0;
  document.getElementById('shopifyishMainWrap').addEventListener('touchend', (ev)=> {
    const now = Date.now();
    if (now - lastTap < 300) { // double-tap -> toggle zoom
      if (mainImg.style.transform === 'scale(1.6)') {
        mainImg.style.transform = 'scale(1)';
      } else {
        mainImg.style.transform = 'scale(1.4)';
      }
    }
    lastTap = now;
  });

  /* Quantity handlers */
  function clampQty(v){
    v = parseInt(String(v).replace(/\D/g,'')) || 1;
    if (v < 1) v = 1;
    if (v > 9999) v = 9999;
    return v;
  }

  function syncQtyToHidden(){
    const val = clampQty(ppQtyInput.value);
    ppQtyInput.value = val;
    if (ppCartQty) ppCartQty.value = val;
  }

  if(ppMinus && ppPlus && ppQtyInput){
    ppMinus.addEventListener('click', ()=> {
      let q = clampQty(ppQtyInput.value);
      q = Math.max(1, q - 1);
      ppQtyInput.value = q;
      syncQtyToHidden();
    });
    ppPlus.addEventListener('click', ()=> {
      let q = clampQty(ppQtyInput.value);
      q = q + 1;
      ppQtyInput.value = q;
      syncQtyToHidden();
    });
    ppQtyInput.addEventListener('input', () => {
      // allow user to type; sanitize on input
      let sanitized = String(ppQtyInput.value).replace(/[^\d]/g,'');
      if (sanitized === '') { ppQtyInput.value = ''; return; }
      ppQtyInput.value = clampQty(sanitized);
      syncQtyToHidden();
    });
    ppQtyInput.addEventListener('blur', syncQtyToHidden);
    // initial sync
    syncQtyToHidden();
  }

  /* On form submit ensure qty is synced */
  if (ppForm) {
    ppForm.addEventListener('submit', function(evt){
      syncQtyToHidden();
      // no preventDefault; let backend handle it.
    });
  }

  /* Share button (native share where available) */
  const shareBtn = document.getElementById('ppShareBtn');
  if (shareBtn) {
    shareBtn.addEventListener('click', async () => {
      const url = window.location.href;
      const text = document.querySelector('.pp-title')?.innerText || document.title;
      if (navigator.share) {
        try { await navigator.share({ title: text, url }); } catch(e){ /* ignore user cancel */ }
      } else {
        // fallback: copy link
        try {
          await navigator.clipboard.writeText(url);
          shareBtn.innerText = 'Link copied';
          setTimeout(()=> shareBtn.innerHTML = '<i class="fa-solid fa-share-nodes"></i> Share', 1400);
        } catch(e) {
          window.open('mailto:?subject=' + encodeURIComponent(text) + '&body=' + encodeURIComponent(url));
        }
      }
    });
  }

  /* Compare button simple feedback (you can integrate real compare later) */
  const compareBtn = document.getElementById('ppCompareBtn');
  if (compareBtn){
    compareBtn.addEventListener('click', () => {
      compareBtn.innerText = 'Added';
      setTimeout(()=> compareBtn.innerHTML = '<i class="fa-solid fa-code-compare"></i> Compare', 1100);
    });
  }

})();

document.addEventListener('DOMContentLoaded', function () {

    // ---------- Utility: safe Swiper init ----------
    function safeInit(selector, options) {
        try {
            const el = document.querySelector(selector);
            if (!el) return null;
            // If it's already a Swiper instance, destroy to avoid duplicates (hot reload)
            if (el.swiper) {
                try { el.swiper.destroy(true, true); } catch(e) { /* ignore */ }
            }
            return new Swiper(el, options);
        } catch(e) {
            console.error('Swiper init failed for', selector, e);
            return null;
        }
    }

    // ---------- FIRST featured products ----------
    if (typeof Swiper !== 'undefined') {
        safeInit('.first-featured-swiper', {
            loop: true,
            spaceBetween: 20,
            speed: 900,
            autoplay: { delay: 3200, disableOnInteraction: false },
            slidesPerView: 4,
            navigation: { nextEl: '.first-prod-next', prevEl: '.first-prod-prev' },
            observer: true, observeParents: true, watchOverflow: true,
            breakpoints: {
                0: { slidesPerView: 1 },
                480: { slidesPerView: 2 },
                768: { slidesPerView: 2 },
                992: { slidesPerView: 3 },
                1200: { slidesPerView: 4 }
            }
        });


    } else {
        console.warn('Swiper not loaded — carousels not initialized');
    }


});
</script>
@endpush

@endsection
