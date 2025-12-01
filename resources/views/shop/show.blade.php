@extends('layouts.theme')
@section('title', $product->name ?? 'Product')
@section('body_class','shop-details'. 'shop-main-h')

@section('content')

  <style>
      .zoom-wrapper {
          width: 100%;
          height: 520px;
          overflow: hidden;
          border-radius: 12px;
          background: #fafafa;
          display:flex;
          align-items:center;
          justify-content:center;
          position:relative;
      }
      .zoom-wrapper img {
          width:100%;
          height:100%;
          object-fit:cover;
          transition: transform .3s ease, opacity .2s;
      }

    .thumb-item:hover {
        transform: scale(1.05);
    }
    .active-thumb {
      border-color: #ff6f00 !important;
      transform: scale(1.07);
    }
    @media(max-width:768px){
        .product-gallery {
            flex-direction: column;
        }
        .gallery-thumbs {
            flex-direction: row !important;
            width: 100% !important;
            gap: 10px !important;
        }
        .thumb-item {
            width: 70px !important;
            height: 70px !important;
        }
        .main-image-wrapper {
            height: 360px !important;
        }
    }


  </style>

    <div class="rts-navigation-area-breadcrumb bg_light-1">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="navigator-breadcrumb-wrapper">
                        <a href="{{route('home')}}">Shop</a>
                        <i class="fa-regular fa-chevron-right"></i>
                        <a class="current" href="{{route('home')}}">Appliances</a>
                        <i class="fa-regular fa-chevron-right"></i>
                        <a class="current" href="{{route('home')}}">Thor Hammer</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
  <div class="rts-chop-details-area rts-section-gap bg_light-1">
  <div class="container">
<div class="shopdetails-style-1-wrapper">
    <div class="product-details-popup-wrapper in-shopdetails">
        <div class="rts-product-details-section rts-product-details-section2 product-details-popup-section">
            <div class="product-details-popup">
                <div class="details-product-area">

                    {{-- LEFT: PRODUCT GALLERY --}}
                    <div class="product-thumb-area">
                        <div class="cursor"></div>

                        {{-- MAIN IMAGES --}}
                        @foreach($product->images as $img)
                            @php $imgSrc = asset('storage/' . ltrim($img->path, '/')); @endphp
                            <div class="thumb-wrapper filterd-items {{ $loop->first ? 'one' : 'hide' }}">
                              <div class="zoom-wrapper">
                                  <img
                                      id="mainImage"
                                      src="{{ $imgSrc }}"
                                      alt="{{ $product->name }}"
                                      onmousemove="zoomImage(event)"
                                      onmouseleave="resetZoom()"
                                  >
                              </div>
                          </div>

                        @endforeach

                        {{-- THUMB SELECTOR --}}
                        <div class="product-thumb-filter-group">
                              @foreach($product->images as $img)
                                  @php
                                      $imgSrc = asset('storage/' . ltrim($img->path, '/'));
                                      $class = ['one','two','three','four','five'][$loop->index] ?? 'one';
                                  @endphp
                                  <div
                                      class="thumb-filter {{ $loop->first ? 'active-thumb' : '' }}"
                                      onclick="changeImage('{{ $imgSrc }}', this)"
                                  >
                                      <img src="{{ $imgSrc }}">
                                  </div>
                              @endforeach
                          </div>

                    </div>


                    {{-- RIGHT: DETAILS --}}
                    <div class="contents">

                        {{-- CATEGORY + RATING --}}
                        <div class="product-status">
                            <span class="product-catagory">
                                {{ optional($product->category)->name ?? 'Uncategorized' }}
                            </span>

                            <div class="rating-stars-group">
                                @php
                                    $rating = $product->rating ?? 0;
                                    $reviews = $product->reviews_count ?? 0;
                                @endphp

                                @for($i=1; $i<=5; $i++)
                                    @if($rating >= $i)
                                        <div class="rating-star"><i class="fas fa-star"></i></div>
                                    @elseif($rating >= $i-0.5)
                                        <div class="rating-star"><i class="fas fa-star-half-alt"></i></div>
                                    @else
                                        <div class="rating-star"><i class="far fa-star"></i></div>
                                    @endif
                                @endfor

                                <span>{{ $reviews }} Reviews</span>
                            </div>
                        </div>

                        {{-- TITLE --}}
                        <h2 class="product-title">{{ $product->name }}</h2>

                        {{-- SHORT DESCRIPTION --}}
                        <p class="mt--20 mb--20">
                            {!! $product->short_description ?? Illuminate\Support\Str::limit(strip_tags($product->description), 150) !!}
                        </p>

                        {{-- PRICE --}}
                        <span class="product-price mb--15 d-block" style="color:#DC2626; font-weight:600;">
                            ₹{{ number_format($product->price,2) }}
                            @if($product->old_price)
                                <span class="old-price ml--15">₹{{ number_format($product->old_price,2) }}</span>
                            @endif
                        </span>

                        {{-- ADD TO CART --}}
                        <div class="product-bottom-action">
                            <div class="cart-edits">
                                <div class="quantity-edit action-item">
                                    <button class="button"><i class="fal fa-minus minus"></i></button>
                                    <input type="text" class="input" value="1" name="qty" />
                                    <button class="button plus"><i class="fal fa-plus plus"></i></button>
                                </div>
                            </div>

                            <form action="{{ route('cart.add') }}" method="POST" class="add-to-cart-form">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                <input type="hidden" name="qty" id="cartQtyInput" value="1">

                                <button class="rts-btn btn-primary radious-sm with-icon">
                                    <div class="btn-text">Add To Cart</div>
                                    <div class="arrow-icon"><i class="fa-regular fa-cart-shopping"></i></div>
                                    <div class="arrow-icon"><i class="fa-regular fa-cart-shopping"></i></div>
                                </button>
                            </form>


                            <a href="#" class="rts-btn btn-primary ml--20"><i class="fa-light fa-heart"></i></a>
                        </div>

                        {{-- META DATA --}}
                        <div class="product-uniques">
                            <span class="sku product-unipue mb--10">
                                <span>SKU:</span> {{ $product->sku ?? 'N/A' }}
                            </span>

                            <span class="catagorys product-unipue mb--10">
                                <span>Categories:</span> {{ optional($product->category)->name ?? 'N/A' }}
                            </span>

                            <span class="tags product-unipue mb--10">
                                <span>Tags:</span>
                                @if($product->tags && count($product->tags))
                                    @foreach($product->tags as $tag)
                                        {{ $tag->name }}@if(!$loop->last), @endif
                                    @endforeach
                                @else
                                    N/A
                                @endif
                            </span>

                            <span class="tags product-unipue mb--10">
                                <span>Life:</span> {{ $product->life ?? 'N/A' }}
                            </span>

                            <span class="tags product-unipue mb--10">
                                <span>Type:</span> {{ ucfirst($product->type ?? 'N/A') }}
                            </span>

                            <span class="tags product-unipue mb--10">
                                <span>Brand:</span> {{ optional($product->brand)->name ?? 'N/A' }}
                            </span>
                        </div>

                        {{-- SHARE --}}
                        <div class="share-option-shop-details">
                          
<div class="single-share-option wishlist-wrapper">

    <form action="{{ route('wishlist.add') }}" method="POST">
        @csrf
        <input type="hidden" name="product_id" value="{{ $product->id }}">

        <button type="submit" class="wishlist-btn-premium">
            <i class="fa-regular fa-heart wishlist-icon"></i>
            <span>Add to Wishlist</span>
        </button>
    </form>

</div>


                            <div class="single-share-option">
                                <div class="icon"><i class="fa-solid fa-share"></i></div>
                                <span>Share</span>
                            </div>

                            <div class="single-share-option">
                                <div class="icon"><i class="fa-light fa-code-compare"></i></div>
                                <span>Compare</span>
                            </div>
                        </div>

                    </div><!-- end contents -->
                </div>
            </div>
        </div>
    </div>

    {{-- PRODUCT TABS (DESCRIPTION / INFO / REVIEWS) --}}
    <div class="product-discription-tab-shop mt--50">

        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item"><button class="nav-link active" data-bs-toggle="tab" data-bs-target="#desc">Product Details</button></li>
            <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#info">Additional Information</button></li>
            <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#reviews">Customer Reviews</button></li>
        </ul>

        <div class="tab-content">

            {{-- DESCRIPTION TAB --}}
            <div class="tab-pane fade show active" id="desc">
                <div class="single-tab-content-shop-details">
                    {!! $product->description !!}
                </div>
            </div>

            {{-- ADDITIONAL INFO TAB --}}
            <div class="tab-pane fade" id="info">
                <p><strong>Brand:</strong> {{ optional($product->brand)->name ?? 'N/A' }}</p>
                <p><strong>Weight:</strong> {{ $product->weight ?? 'N/A' }}</p>
                <p><strong>Dimensions:</strong> {{ $product->dimensions ?? 'N/A' }}</p>
            </div>

            {{-- REVIEWS TAB --}}
            <div class="tab-pane fade" id="reviews">
                <h4>No customer reviews yet.</h4>
            </div>

        </div>
    </div>
</div>

  </div>
</div>
{{-- FINAL EKOMART FEATURED PRODUCTS - 100% IDENTICAL TO THEME --}}
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

                                    <form action="{{ route('cart.add') }}" method="POST" class="add-to-cart-form">
                                            @csrf
                                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                                            <input type="hidden" name="qty" id="cartQtyInput" value="1">

                                            <button class="rts-btn btn-primary radious-sm with-icon">
                                                <div class="btn-text">Add To Cart</div>
                                                <div class="arrow-icon"><i class="fa-regular fa-cart-shopping"></i></div>
                                                <div class="arrow-icon"><i class="fa-regular fa-cart-shopping"></i></div>
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

{{-- PERFECT CSS + WORKING JS --}}
@push('styles')
<style>
    .single-grocery-product-one {
        background: #fff;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 4px 15px rgba(0,0,0,0.08);
        transition: all 0.4s ease;
        position: relative;
    }
    .single-grocery-product-one:hover {
        transform: translateY(-8px);
        box-shadow: 0 15px 30px rgba(0,0,0,0.15);
    }
    .single-grocery-product-one .discount {
        position: absolute;
        top: 10px;
        left: 10px;
        background: #ffab1d;
        color: #fff;
        font-size: 12px;
        font-weight: 700;
        padding: 4px 8px;
        border-radius: 4px;
        z-index: 10;
    }
    .single-grocery-product-one .thumbnail img {
        width: 100%;
        height: 180px;
        object-fit: contain;
        background: #f9f9f9;
        padding: 20px;
    }
    .single-grocery-product-one .content {
        padding: 16px;
        text-align: left !important;
    }
    .single-grocery-product-one .title a {
        color: #333;
        font-size: 14px;
        font-weight: 600;
        line-height: 1.4;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        text-decoration: none;
    }
    .single-grocery-product-one .unit {
        font-size: 13px;
        margin: 4px 0;
    }
    .single-grocery-product-one .current-price {
        font-size: 18px;
    }

    /* Quantity Input */
    .quantity-input {
        display: flex;
        border: 1.5px solid #ddd;
        border-radius: 6px;
        overflow: hidden;
        height: 36px;
        width: 100px;
    }
    .quantity-input .qty-btn {
        width: 32px;
        background: #fff;
        border: none;
        font-size: 16px;
        font-weight: bold;
        color: #666;
        cursor: pointer;
    }
    .quantity-input .qty-input {
        width: 36px;
        text-align: center;
        border: none;
        border-left: 1.5px solid #ddd;
        border-right: 1.5px solid #ddd;
        font-weight: bold;
        background: #fff;
    }

    /* Add to Cart Button - Orange Border → Fill Orange */
    .add-to-cart-btn {
        background: transparent;
        color: #ffab1d;
        border: 2px solid #ffab1d;
        padding: 7px 16px;
        border-radius: 6px;
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        gap: 8px;
        white-space: nowrap;
    }
    .add-to-cart-btn:hover {
        background: #ffab1d;
        color: #fff;
    }
    .add-to-cart-btn i {
        font-size: 16px;
    }
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
@endpush
@endsection

@push('scripts')
<script>

function zoomImage(e){
    const img = document.getElementById('mainImage');
    const rect = img.getBoundingClientRect();

    const x = (e.clientX - rect.left) / rect.width * 100;
    const y = (e.clientY - rect.top) / rect.height * 100;

    img.style.transformOrigin = `${x}% ${y}%`;
    img.style.transform = "scale(1.4)";
}

function resetZoom(){
    const img = document.getElementById('mainImage');
    img.style.transform = "scale(1)";
}

function changeImage(src, el) {
    document.querySelectorAll('.thumb-filter').forEach(t =>
        t.classList.remove('active-thumb')
    );
    el.classList.add('active-thumb');

    let main = document.getElementById('mainImage');
    main.style.opacity = 0;

    setTimeout(() => {
        main.src = src;
        main.style.opacity = 1;
    }, 150);
}


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
    const qtyInput = document.querySelector(".quantity-edit .input");
    const cartQtyHidden = document.getElementById("cartQtyInput");

    if (qtyInput && cartQtyHidden) {
        qtyInput.addEventListener("input", () => {
            let val = parseInt(qtyInput.value) || 1;
            if (val < 1) val = 1;
            cartQtyHidden.value = val;
        });
    }

});
</script>
@endpush
