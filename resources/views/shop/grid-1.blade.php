@extends('layouts.theme')
@section('title', 'Shop')
@section('body_class', 'shop-grid-sidebar')


@section('content')

    <div class="rts-navigation-area-breadcrumb bg_light-1">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="navigator-breadcrumb-wrapper">
                        <a href="{{route('shop.index')}}">Shop</a>
                        <i class="fa-regular fa-chevron-right"></i>
                        @if($current != NULL)
                        <a id="breadcrumb-current" class="current" href="{{route('shop.index')}}">{{ $current}}</a>
                        @else
                        <a id="breadcrumb-current" class="current" href="{{route('shop.index')}}">All Products</a>

                        @endif
                        
                        <!-- <i class="fa-regular fa-chevron-right"></i>
                        <a class="current" href="{{route('home')}}">2L Mum Water</a> -->
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

  <div class="shop-grid-sidebar-area rts-section-gap">
    <div class="container">
      <div class="row g-0">
        {{-- Sidebar --}}
        <aside class="col-xl-4 rts-sticky-column-item pr--70">
          <div class="sidebar-filter-main theiaStickySidebar">

    <div class="single-filter-box">
        <h5 class="title">Price Filter</h5>

        <form action="{{ route('shop.index') }}" method="GET" class="filterbox-body">

            <div class="half-input-wrapper d-flex flex-column gap-2">

                <!-- Min Price -->
                <div class="single">
                    <label for="min" class="d-block mb-1" style="font-weight:500;">Min Price</label>
                    <div class="input-group" style="border:1px solid #e5e7eb;border-radius:8px;overflow:hidden;">
                        <span class="input-group-text"
                              style="background:#f3f4f6;border:none;font-weight:600;color:#4b5563;">₹</span>
                        <input id="min" name="min_price" type="number"
                               value="{{ request('min_price', 0) }}"
                               class="form-control"
                               style="border:none;box-shadow:none;">
                    </div>
                </div>

                <!-- Max Price -->
                <div class="single">
                    <label for="max" class="d-block mb-1" style="font-weight:500;">Max Price</label>
                    <div class="input-group" style="border:1px solid #e5e7eb;border-radius:8px;overflow:hidden;">
                        <span class="input-group-text"
                              style="background:#f3f4f6;border:none;font-weight:600;color:#4b5563;">₹</span>
                        <input id="max" name="max_price" type="number"
                               value="{{ request('max_price', 10000) }}"
                               class="form-control"
                               style="border:none;box-shadow:none;">
                    </div>
                </div>

            </div>

            <button class="rts-btn btn-primary mt-3 w-100"
                    style="padding:10px 18px;border-radius:6px;">
                Apply
            </button>

        </form>
    </div>



            {{-- category & tag filters (optional) --}}
            <div class="single-filter-box mt-3">
              <h5 class="title">Categories</h5>
              <div class="filterbox-body">
                <ul class="list-unstyled">
                  @foreach ($categories as $cat)
                     <li >
                    <a href="{{ route('shop.index', ['category' => $cat->id]) }}" class="menu-item">
                        <img src="{{ asset('storage/' . $cat->icon) }}" alt="icons">
                        <span>{{$cat->name}}</span>
                        <!-- <i class="fa-regular fa-plus"></i> -->
                    </a>
                </li>
                  @endforeach
                </ul>
              </div>
            </div>

            <div class="single-filter-box mt-3">
              <h5 class="title">Select Brands</h5>
              <div class="filterbox-body">
                <!-- limited brands , if exceeded more than 10 -->
                <ul class="list-unstyled">
                  @foreach ($categories as $cat)
                    <li><a href="{{ route('shop.index', ['category' => $cat->id]) }}">Brands</a></li>
                  @endforeach
                </ul>
              </div>
            </div>


            <div class="single-filter-box mt-3">
              <h5 class="title">Products status
              <div class="filterbox-body">
                <ul class="list-unstyled">
                    <li><a href="{{ route('shop.index', ['category' => 1]) }}">In Stock</a></li>
                    <li><a href="{{ route('shop.index', ['category' => 2]) }}">On Sale</a></li>

                  </ul>
              </div>
            </div>

          </div>
        </aside>


        {{-- Product grid --}}
        <div class="col-xl-8">
          <div class="filter-select-area">
                        <div class="top-filter">
                            <span>Showing 1–20 of 57 results</span>
                            <div class="right-end">
                                <span>Sort: Short By Latest</span>
                                <div class="button-tab-area">
                                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link single-button active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home-tab-pane" type="button" role="tab" aria-controls="home-tab-pane" aria-selected="true">
                                                <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <rect x="0.5" y="0.5" width="6" height="6" rx="1.5" stroke="#2C3B28" />
                                                    <rect x="0.5" y="9.5" width="6" height="6" rx="1.5" stroke="#2C3B28" />
                                                    <rect x="9.5" y="0.5" width="6" height="6" rx="1.5" stroke="#2C3B28" />
                                                    <rect x="9.5" y="9.5" width="6" height="6" rx="1.5" stroke="#2C3B28" />
                                                </svg>
                                            </button>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link single-button" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile-tab-pane" type="button" role="tab" aria-controls="profile-tab-pane" aria-selected="false">
                                                <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <rect x="0.5" y="0.5" width="6" height="6" rx="1.5" stroke="#2C3C28" />
                                                    <rect x="0.5" y="9.5" width="6" height="6" rx="1.5" stroke="#2C3C28" />
                                                    <rect x="9" y="3" width="7" height="1" fill="#2C3C28" />
                                                    <rect x="9" y="12" width="7" height="1" fill="#2C3C28" />
                                                </svg>
                                            </button>
                                        </li>
                                    </ul>

                                </div>
                            </div>
                        </div>
                        <div class="nice-select-area-wrapper-and-button">
                            <div class="nice-select-wrapper-1">
                                
                                <div class="single-select">
                                    <select>
                                        <option data-display="All Brands">All Brands</option>
                                        <option value="1">Some option</option>
                                        <option value="2">Another option</option>
                                        <option value="3" disabled>A disabled option</option>
                                        <option value="4">Potato</option>
                                    </select>
                                </div>
                                <div class="single-select">
                                    <select>
                                        <option data-display="All Size">All Size </option>
                                        <option value="1">Some option</option>
                                        <option value="2">Another option</option>
                                        <option value="3" disabled>A disabled option</option>
                                        <option value="4">Potato</option>
                                    </select>
                                </div>
                                <div class="single-select">
                                    <select>
                                        <option data-display="All Weight">All Weight</option>
                                        <option value="1">Some option</option>
                                        <option value="2">Another option</option>
                                        <option value="3" disabled>A disabled option</option>
                                        <option value="4">Potato</option>
                                    </select>
                                </div>
                            </div>
                            <div class="button-area">
                                <button class="rts-btn">Filter</button>
                                <button class="rts-btn">Reset Filter</button>
                            </div>
                        </div>
                    </div>
          <div class="tab-content mt-5" id="myTabContent">
              {{-- Product Grid --}}
            <div class="col-xl-12">
                <div class="row">
                    <div class="col-12 mb-4">
                        <div class="title-area-between">
                            <h3 class="title-left">All Products</h3>
                            <div class="sorting-area">
                                <select class="form-select" onchange="window.location.href=this.value">
                                    <option value="{{ route('shop.index', request()->except('sort')) }}">Default Sorting</option>
                                    <option value="{{ route('shop.index', array_merge(request()->all(), ['sort' => 'price_asc'])) }}" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Price: Low to High</option>
                                    <option value="{{ route('shop.index', array_merge(request()->all(), ['sort' => 'price_desc'])) }}" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Price: High to Low</option>
                                    <option value="{{ route('shop.index', array_merge(request()->all(), ['sort' => 'newest'])) }}" {{ request('sort') == 'newest' ? 'selected' : '' }}>Newest First</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row g-4">
                    @forelse($products as $product)
                        @php
                            $img = $product->images->first();
                            $oldPrice = $product->price * 1.4;
                            $discount = 25;
                        @endphp
                        <div class="col-xxl-3 col-xl-4 col-lg-4 col-md-6 col-sm-6">
                            <div class="single-shopping-card-one">
                                <div class="image-and-action-area-wrapper">
                                    <a href="{{ route('products.show', $product->id) }}" class="thumbnail-preview">
                                        @if($discount)
                                            <div class="badge">
                                                <span>{{ $discount }}% <br> Off</span>
                                                <i class="fa-solid fa-bookmark"></i>
                                            </div>
                                        @endif
                                        <img src="{{ $img ? asset('storage/' . $img->path) : asset('assets/images/placeholder.png') }}"
                                             alt="{{ $product->name }}" class="img-fluid">
                                    </a>
                                    <div class="action-share-option">
                                        <span class="single-action openuptip wishlist-btn" data-id="{{ $product->id }}" title="Add to Wishlist">
                                            <i class="fa-light fa-heart"></i>
                                        </span>
                                        <span class="single-action openuptip" title="Compare">
                                            <i class="fa-solid fa-arrows-retweet"></i>
                                        </span>
                                        <span class="single-action openuptip quickview-btn" data-id="{{ $product->id }}" title="Quick View">
                                            <i class="fa-regular fa-eye"></i>
                                        </span>
                                    </div>
                                </div>

                                <div class="body-content text-center">
                                    <a href="{{ route('products.show', $product->id) }}">
                                        <h4 class="title">{{ \Illuminate\Support\Str::limit($product->name, 50) }}</h4>
                                    </a>
                                    <span class="availability text-muted">{{ optional($product->category)->name ?? 'Uncategorized' }}</span>

                                    <div class="price-area my-3">
                                        <span class="current text-danger fw-bold">₹{{ number_format($product->price, 2) }}</span>
                                        @if($discount)
                                            <div class="previous text-muted">₹{{ number_format($oldPrice, 2) }}</div>
                                        @endif
                                    </div>

                                    <div class="cart-counter-action">
                                        <div class="quantity-edit d-inline-flex align-items-center">
                                            <button type="button" class="button minus"><i class="fa-regular fa-chevron-down"></i></button>
                                            <input type="text" class="input qty-input" value="1" readonly>
                                            <button type="button" class="button plus"><i class="fa-regular fa-chevron-up"></i></button>
                                        </div>

                                        <form action="{{ route('cart.add') }}" method="POST" class="d-inline">
                                            @csrf
                                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                                            <input type="hidden" name="quantity" class="cart-quantity" value="1">
                                            <button type="submit" class="rts-btn btn-primary radious-sm with-icon ms-2">
                                                <div class="btn-text">Add</div>
                                                <div class="arrow-icon"><i class="fa-regular fa-cart-shopping"></i></div>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12 text-center py-5">
                            <img src="{{ asset('assets/images/empty-cart.png') }}" alt="No Products" width="200">
                            <h4 class="mt-4 text-muted">No products found</h4>
                            <a href="{{ route('shop.index') }}" class="btn btn-primary mt-3">Browse All Products</a>
                        </div>
                    @endforelse
                </div>

                {{-- Pagination --}}
                <div class="mt-5">
                    {{ $products->appends(request()->query())->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </div>
    </div>
</div>


{{-- Custom Styles --}}
@push('styles')
<style>
    .single-shopping-card-one {
        background: #fff;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 4px 20px rgba(0,0,0,0.08);
        transition: all 0.4s ease;
    }
    .single-shopping-card-one:hover {
        transform: translateY(-10px);
        box-shadow: 0 20px 40px rgba(0,0,0,0.15);
    }
    .badge {
        position: absolute;
        top: 10px;
        left: 10px;
        background: #ff4757;
        color: white;
        font-size: 12px;
        padding: 5px 8px;
        border-radius: 6px;
        z-index: 10;
    }
    .action-share-option {
        position: absolute;
        top: 10px;
        right: 10px;
        background: white;
        padding: 8px;
        border-radius: 50px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        opacity: 0;
        visibility: hidden;
        transition: all 0.3s;
    }
    .single-shopping-card-one:hover .action-share-option {
        opacity: 1;
        visibility: visible;
    }
    .quantity-edit .input {
        width: 40px;
        text-align: center;
        border: none;
        font-weight: bold;
    }
    .quantity-edit .button {
        background: #f1f1f1;
        border: none;
        width: 30px;
        height: 30px;
        border-radius: 50%;
        cursor: pointer;
    }
</style>
@endpush

          </div></div></div>

          <div class="mt-4">
            {{ $products->withQueryString()->links() }}
          </div>
        </div>
      </div>
    </div>
  </div>
  @push('scripts')
    <script src="{{ asset('assets/js/plugins.js') }}"></script>

    <script src="{{ asset('assets/js/main.js') }}"></script>

    <script>
        $(document).ready(function() {
            $('select').niceSelect();
        });
    </script>


@endpush

@endsection
