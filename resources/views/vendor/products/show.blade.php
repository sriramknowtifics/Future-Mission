@extends('layouts.layoutMaster')
@section('title', $product->name ?? 'Product')

@section('content')
  <div class="rts-chop-details-area rts-section-gap bg_light-1">
    <div class="container">
      <div class="shopdetails-style-1-wrapper">
        <div class="row g-5">
          <div class="col-xl-8">
            <div class="product-details-popup-wrapper in-shopdetails">
              <div class="rts-product-details-section product-details-popup-section">
                <div class="product-details-popup">
                  <div class="details-product-area">
                    <div class="product-thumb-area">
                      @php
                        $images = $product->images->pluck('path')->all();
                      @endphp

                      @if (count($images))
                        <div class="thumb-wrapper one filterd-items figure">
                          <div class="product-thumb zoom"
                            style="background-image:url('{{ asset('storage/' . $images[0]) }}')">
                            <img src="{{ asset('storage/' . $images[0]) }}" alt="{{ $product->name }}">
                          </div>
                        </div>

                        <div class="product-thumb-filter-group">
                          @foreach ($images as $img)
                            <div class="thumb-filter filter-btn" data-show=".one">
                              <img src="{{ asset('storage/' . $img) }}" alt="thumb"
                                style="width:60px;height:60px;object-fit:cover;">
                            </div>
                          @endforeach
                        </div>
                      @else
                        <div class="thumb-wrapper one">
                          <img src="{{ asset('assets/images/products/product-details.jpg') }}" alt="{{ $product->name }}">
                        </div>
                      @endif
                    </div>

                    <div class="contents">
                      <div class="product-status">
                        <span class="product-catagory">{{ $product->category->name ?? '' }}</span>
                      </div>
                      <h2 class="product-title">{{ $product->name }}</h2>
                      <p class="mt--20 mb--20">{!! nl2br(e($product->description)) !!}</p>

                      @if ($product->type === 'product')
                        <span class="product-price mb--15 d-block"
                          style="color:#dc2626;font-weight:600">₹{{ number_format($product->price, 2) }} <span
                            class="old-price ml--15">{{ $product->old_price ?? '' }}</span></span>
                      @else
                        @php $m = $product->service_meta ?? []; @endphp
                        <div class="mb-2"><strong>Duration:</strong> {{ $m['duration'] ?? '-' }}</div>
                        <div class="mb-2"><strong>Location:</strong> {{ $m['location'] ?? '-' }}</div>
                        <div class="mb-2"><strong>Hours:</strong> {{ $m['hours'] ?? '-' }}</div>
                      @endif

                      <div class="product-bottom-action">
                        @if ($product->type === 'product')
                          <form action="{{ route('cart.add') }}" method="POST">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            <div class="quantity-edit action-item">
                              <button type="button" class="button minus">-</button>
                              <input type="text" name="quantity" class="input" value="1">
                              <button type="button" class="button plus">+</button>
                            </div>
                            <button class="rts-btn btn-primary radious-sm with-icon" type="submit">Add To Cart</button>
                          </form>
                        @else
                          <a href="{{ route('contact') }}" class="rts-btn btn-primary">Contact / Book Service</a>
                        @endif
                      </div>

                      {{-- Uniques --}}
                      <div class="product-uniques mt-3">
                        <span class="sku"><strong>SKU:</strong> {{ $product->sku ?? '-' }}</span><br>
                        <span class="tags"><strong>Type:</strong> {{ ucfirst($product->type) }}</span>
                      </div>

                      {{-- share/wishlist --}}
                      <div class="share-option-shop-details mt-3">
                        <div class="single-share-option"><i class="fa-regular fa-heart"></i> Add To Wishlist</div>
                        <div class="single-share-option"><i class="fa-solid fa-share"></i> Share</div>
                      </div>

                    </div>
                  </div>
                </div>

                {{-- tabs (description, info, reviews) --}}
                <div class="product-discription-tab-shop mt--50">
                  <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item"><button class="nav-link active" data-bs-toggle="tab"
                        data-bs-target="#details">Product Details</button></li>
                    <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#info">Additional
                        Info</button></li>
                    <li class="nav-item"><button class="nav-link" data-bs-toggle="tab"
                        data-bs-target="#reviews">Reviews</button></li>
                  </ul>
                  <div class="tab-content p-3">
                    <div class="tab-pane fade show active" id="details">{!! nl2br(e($product->description)) !!}</div>
                    <div class="tab-pane fade" id="info">
                      <table class="table">
                        <tr>
                          <td>SKU</td>
                          <td>{{ $product->sku ?? '-' }}</td>
                        </tr>
                        <tr>
                          <td>Category</td>
                          <td>{{ $product->category->name ?? '' }}</td>
                        </tr>
                        <tr>
                          <td>Type</td>
                          <td>{{ ucfirst($product->type) }}</td>
                        </tr>
                      </table>
                    </div>
                    <div class="tab-pane fade" id="reviews">
                      {{-- implement reviews --}}
                      <p>No reviews yet.</p>
                    </div>
                  </div>
                </div>

              </div>
            </div>
          </div>

          {{-- right column --}}
          <div class="col-xl-3 offset-xl-1 rts-sticky-column-item">
            <div class="theiaStickySidebar">
              <div class="shop-sight-sticky-sidevbar mb--20">
                <h6 class="title">Available offers</h6>
                <div class="single-offer-area">
                  <div class="icon"><img src="{{ asset('assets/images/shop/01.svg') }}" alt=""></div>
                  <div class="details">
                    <p>Seller offers</p>
                  </div>
                </div>
              </div>
            </div>
          </div>

        </div>
      </div>
    </div>
  </div>
@endsection
