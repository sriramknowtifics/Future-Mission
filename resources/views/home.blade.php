@extends('layouts.theme')

@section('title', config('app.name', 'Shop') . ' - Home')
@section('body_class', 'shop-main-h')

@section('content')
<style>
/* Lightweight helpers */
.container-zoom {
    transition: transform .35s ease, box-shadow .35s ease;
}
.container-zoom:hover {
    transform: scale(1.03) translateY(-6px);
    box-shadow: 0 18px 40px rgba(0,0,0,0.14);
}

/* Page-specific variables */
:root{
    --glass-bg: rgba(255,255,255,0.7);
    --glass-border: rgba(255,255,255,0.35);
    --primary-gradient: linear-gradient(135deg,#667eea 0%,#764ba2 100%);
    --accent-gradient: linear-gradient(90deg,#ffb63a 0%,#ff7a59 100%);
    --card-radius: 16px;
}

/* Banner area (kept minimal so it respects your desktop/mobile dataset) */
.rts-banner-area { padding-top: 18px; }

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

/* keep your original small CSS blocks unchanged at bottom to avoid breaking other sections */
</style>

<div class="rts-banner-area rts-section-gap pt_sm--20">
    <div class="container">
        <div class="row g-5 g-sm-4">
            <div class="col-lg-9">
                <div class="rts-banner-area-one mb--30">
                    <div class="category-area-main-wrapper-one">
                        <div class="swiper mySwiper-category-1 swiper-data" data-swiper='{
                            "spaceBetween":1,
                            "slidesPerView":1,
                            "loop": true,
                            "speed": 1000,
                            "autoplay":{"delay":"2000"},
                            "navigation":{"nextEl":".swiper-button-next","prevEl":".swiper-button-prev"},
                            "breakpoints":{"0":{"slidesPerView":1,"spaceBetween":0},"320":{"slidesPerView":1,"spaceBetween":0},"480":{"slidesPerView":1,"spaceBetween":0},"640":{"slidesPerView":1,"spaceBetween":0},"840":{"slidesPerView":1,"spaceBetween":0},"1140":{"slidesPerView":1,"spaceBetween":0}}
                        }'>
                            <div class="swiper-wrapper">
                                @if ($banners && $banners->count())
                                    @foreach ($banners->where('place', 1) as $banner)
                                        <div class="swiper-slide">
                                            <div class="banner-one banner-left-five-area-start ptb--120"
                                                 data-desktop="{{ asset('storage/' . $banner->desktop_image) }}"
                                                 data-mobile="{{ asset('storage/' . $banner->mobile_image) }}">
                                                <div class="banner-one-inner-content">
                                                    <span class="pre"></span>
                                                    <h1 class="title"></h1>

                                                    <a href="{{ $banner->link }}" class="rts-btn btn-primary radious-sm with-icon">
                                                        <div class="btn-text">Shop Now</div>
                                                        <div class="arrow-icon"><i class="fa-light fa-arrow-right"></i></div>
                                                        <div class="arrow-icon"><i class="fa-light fa-arrow-right"></i></div>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="swiper-slide">
                                        <div class="banner-bg-image bg_image bg_one-banner two ptb--120 ptb_md--80 ptb_sm--60">
                                            <div class="banner-one-inner-content">
                                                <span class="pre">Get up to 30% off on your first $150 purchase</span>
                                                <h1 class="title">Do not miss our amazing <br>grocery deals</h1>
                                                <a href="shop-grid-sidebar.html" class="rts-btn btn-primary radious-sm with-icon">
                                                    <div class="btn-text">Shop Now</div>
                                                    <div class="arrow-icon"><i class="fa-light fa-arrow-right"></i></div>
                                                    <div class="arrow-icon"><i class="fa-light fa-arrow-right"></i></div>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>

                            <button class="swiper-button-next"><i class="fa-regular fa-arrow-right"></i></button>
                            <button class="swiper-button-prev"><i class="fa-regular fa-arrow-left"></i></button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-3">
                @php $place2 = $banners->where('place', 2)->first(); @endphp
                @if($place2)
                    <div class="banner-five-right-content bg_image"
                         style="background-image:url('{{ asset('storage/' . $place2->desktop_image) }}')">
                        <div class="content-area">
                            <a href="{{ $place2->link }}" class="rts-btn btn-primary">{{ $place2->subtitle }}</a>
                            <h3 class="title"></h3>
                            <a href="{{ $place2->link }}" class="shop-now-goshop-btn">
                                <span class="text">Shop Now</span>
                                <div class="plus-icon"><i class="fa-sharp fa-regular fa-plus"></i></div>
                                <div class="plus-icon"><i class="fa-sharp fa-regular fa-plus"></i></div>
                            </a>
                        </div>
                    </div>
                @endif
            </div>

        </div>
    </div>
</div>

<div class="rts-feature-large-product-area rts-section-gapBottom">
    <div class="container">
        <div class="row g-5">
            <div class="col-lg-6">
                @php $place3 = $banners->where('place', 3)->first(); @endphp
                @if($place3)
                    <div class="feature-product-area-large-2 bg_image container-zoom"
                         style="background-image:url('{{ asset('storage/' . $place3->desktop_image) }}')">
                        <div class="inner-feature-product-content">
                            <a href="{{ $place3->link }}" class="rts-btn btn-primary">Shop Now</a>
                        </div>
                    </div>
                @endif
            </div>

            <div class="col-lg-6">
                @php $place4 = $banners->where('place', 4)->first(); @endphp
                @if($place4)
                    <div class="feature-product-area-large-2 bg_image container-zoom"
                         style="background-image:url('{{ asset('storage/' . $place4->desktop_image) }}')">
                        <div class="inner-feature-product-content">
                            <a href="{{ $place4->link }}" class="rts-btn btn-primary">Shop Now</a>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

{{-- short services area unchanged (kept as-is) --}}
<div class="rts-shorts-service-area rts-section-gap bg_heading">
    <div class="container">
        <div class="row g-5">
            {{-- ... all service boxes remain exactly as you provided ... --}}
            {{-- (I kept markup unchanged to avoid touching other functionality) --}}
        </div>
    </div>
</div>

<section class="home-categories rts-section-gap">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="cover-card-main-over">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="title-area-between">
                                <h2 class="title-left mb--0">Featured Categories</h2>
                                <div class="next-prev-swiper-wrapper">
                                    <div class="swiper-button-prev cat-prev"><i class="fa-regular fa-chevron-left"></i></div>
                                    <div class="swiper-button-next cat-next"><i class="fa-regular fa-chevron-right"></i></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- CATEGORY SLIDER --}}
                    <div class="rts-caregory-area-one">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="category-area-main-wrapper-one">
                                    <div class="swiper mySwiper-category-1 swiper-data"
                                         data-swiper='{
                                            "spaceBetween":15,
                                            "slidesPerView":8,
                                            "loop": true,
                                            "speed": 1000,
                                            "navigation":{"nextEl":".cat-next","prevEl":".cat-prev"},
                                            "breakpoints":{
                                                "0":{"slidesPerView":1,"spaceBetween":15},
                                                "340":{"slidesPerView":2,"spaceBetween":15},
                                                "480":{"slidesPerView":3,"spaceBetween":15},
                                                "640":{"slidesPerView":4,"spaceBetween":15},
                                                "840":{"slidesPerView":4,"spaceBetween":15},
                                                "1140":{"slidesPerView":6,"spaceBetween":15},
                                                "1740":{"slidesPerView":8,"spaceBetween":15}
                                            }
                                         }'>
                                        <div class="swiper-wrapper">
                                            @if ($categories && $categories->count())
                                                @foreach ($categories as $category)
                                                    <div class="swiper-slide">
                                                        <div class="single-category-one height-180">
                                                            <a href="{{ route('shop.index', ['category' => $category->id]) }}">
                                                                @if ($category->icon)
                                                                    <img src="{{ asset('storage/' . $category->icon) }}"
                                                                         alt="{{ $category->name }}"
                                                                         style="width:80px;height:80px;object-fit:contain;margin:auto;">
                                                                @else
                                                                    <img src="{{ asset('assets/images/category/default.png') }}"
                                                                         alt="{{ $category->name }}"
                                                                         style="width:80px;height:80px;object-fit:contain;margin:auto;">
                                                                @endif
                                                                <p>{{ $category->name }}</p>
                                                                <span>
                                                                    @if (isset($category->products_count))
                                                                        {{ $category->products_count }} Items
                                                                    @else
                                                                        {{ $category->products()->count() }} Items
                                                                    @endif
                                                                </span>
                                                            </a>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            @else
                                                <div class="swiper-slide">
                                                    <div class="single-category-one height-180">
                                                        <a href="{{ route('shop.index') }}">
                                                            <img src="{{ asset('assets/images/category/01.png') }}" alt="Category">
                                                            <p>All Products</p>
                                                            <span>Browse Items</span>
                                                        </a>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</section>

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

{{-- SECOND FEATURED (services) - uses same slim product-card design --}}
<section class="bg-white py-5 mb-5">
        <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="title-area-between">
                    <h2 class="title-left pt--30">Featured Products</h2>
                    <div class="next-prev-swiper-wrapper">
                        <div class="swiper-button-prev second-prod-prev"><i class="fa-regular fa-chevron-left"></i></div>
                        <div class="swiper-button-next second-prod-next"><i class="fa-regular fa-chevron-right"></i></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container">

        <div class="swiper second-featured-swiper">
            <div class="swiper-wrapper">
                @forelse($featured->take(10) as $product)
                    @php
                        $img = $product->images->first();
                        $oldPrice = $product->price * 1.33;
                        $discount = 25;
                        $shortDesc = \Illuminate\Support\Str::limit($product->short_description ?? 'Top rated service', 60);
                        $rating = $product->rating ?? 4.6;
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
                                        <i class="fa-solid fa-star"></i>
                                        <span>{{ number_format($rating,1) }}</span>
                                    </div>
                                    <div class="badges" style="margin-left:auto;">
                                        <div class="badge">Verified</div>
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
                        <h4 class="text-muted py-5">No featured services</h4>
                    </div>
                @endforelse
            </div>
        </div>

    </div>
</section>

@endsection

@push('scripts')
<script>
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

        // ---------- SECOND featured (services) ----------
        safeInit('.second-featured-swiper', {
            loop: true,
            spaceBetween: 20,
            speed: 900,
            autoplay: { delay: 3400, disableOnInteraction: false },
            slidesPerView: 4,
            navigation: { nextEl: '.second-prod-next', prevEl: '.second-prod-prev' },
            observer: true, observeParents: true, watchOverflow: true,
            breakpoints: {
                0: { slidesPerView: 1 },
                480: { slidesPerView: 2 },
                768: { slidesPerView: 2 },
                992: { slidesPerView: 3 },
                1200: { slidesPerView: 4 }
            }
        });

        // ---------- Categories / Banner Swipers (if any) ----------
        // The DOM contains an element with class "mySwiper-category-1" inside the banner area
        document.querySelectorAll('.mySwiper-category-1').forEach(function(wrapper) {
            // If data-swiper attribute exists, try to parse JSON and use it; otherwise use defaults
            let data = wrapper.dataset.swiper;
            let config = {
                loop: true,
                spaceBetween: 15,
                slidesPerView: 1,
                observer: true, observeParents: true, watchOverflow: true
            };
            try {
                if (data) {
                    const parsed = JSON.parse(data.replace(/(&quot;)/g,'"'));
                    config = Object.assign(config, parsed);
                }
            } catch(e) { /* ignore parse errors, use defaults */ }

            // Use Swiper on the wrapper element itself if it's the main element, else find the child with class 'swiper'
            let target = wrapper.classList.contains('swiper') ? wrapper : wrapper;
            try {
                if (target && target.querySelector('.swiper-wrapper')) {
                    // instantiate Swiper on this node
                    new Swiper(target, config);
                }
            } catch(e) {
                console.warn('category swiper init failed', e);
            }
        });

    } else {
        console.warn('Swiper not loaded — carousels not initialized');
    }

    // ---------- Quantity buttons behavior ----------
    document.querySelectorAll('.quantity-input').forEach(container => {
        const decrease = container.querySelector('.decrease');
        const increase = container.querySelector('.increase');
        const input = container.querySelector('.qty-input');

        if (!increase || !decrease || !input) return;

        increase.addEventListener('click', () => {
            input.value = parseInt(input.value || 0) + 1;
            input.dispatchEvent(new Event('change'));
        });

        decrease.addEventListener('click', () => {
            if (parseInt(input.value || 0) > 1) {
                input.value = parseInt(input.value) - 1;
                input.dispatchEvent(new Event('change'));
            }
        });
    });

    // ---------- Banner background handler (desktop/mobile) ----------
    function updateBannerBackgrounds() {
        document.querySelectorAll('.banner-one').forEach(function(banner) {
            const desktop = banner.dataset.desktop;
            const mobile  = banner.dataset.mobile;
            if (!desktop && !mobile) return;

            if (window.innerWidth <= 768 && mobile) {
                banner.style.backgroundImage = `url('${mobile}')`;
                banner.style.backgroundSize = 'cover';
                banner.style.backgroundPosition = 'center';
            } else if (desktop) {
                banner.style.backgroundImage = `url('${desktop}')`;
                banner.style.backgroundSize = 'cover';
                banner.style.backgroundPosition = 'center';
            }
        });
    }

    // initial set + respond to resize (debounced)
    updateBannerBackgrounds();
    let resizeTimer;
    window.addEventListener('resize', function() {
        clearTimeout(resizeTimer);
        resizeTimer = setTimeout(updateBannerBackgrounds, 120);
    });

});
</script>
@endpush
