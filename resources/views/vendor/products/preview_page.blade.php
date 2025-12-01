{{-- resources/views/products/preview.blade.php --}}
@php
  // $product: object (from controller), $images: array of image URLs, $is_preview true
@endphp

<div class="rts-chop-details-area">
  <div class="container">
    <div class="shopdetails-style-1-wrapper">
      <div class="row g-5">
        <div class="col-xl-8">
          <div class="product-details-popup-wrapper">
            <div class="product-details-popup">
              <div class="details-product-area">
                <div class="product-thumb-area">
                  @if (count($images))
                    <div class="thumb-wrapper one filterd-items figure">
                      <div class="product-thumb">
                        <img src="{{ $images[0] }}" alt="preview" style="width:100%;object-fit:cover;">
                      </div>
                    </div>
                    <div class="product-thumb-filter-group mt-2">
                      @foreach ($images as $img)
                        <div class="thumb-filter" style="display:inline-block;margin-right:8px;">
                          <img src="{{ $img }}" alt="thumb"
                            style="width:60px;height:60px;object-fit:cover;">
                        </div>
                      @endforeach
                    </div>
                  @else
                    <img src="{{ asset('assets/images/products/product-details.jpg') }}" alt="preview"
                      style="width:100%;object-fit:cover;">
                  @endif
                </div>

                <div class="contents">
                  <div class="product-status">
                    <span class="product-catagory">{{ optional($product->category)->name ?? '' }}</span>
                  </div>

                  <h2 class="product-title">{{ $product->name }}</h2>

                  <p class="mt-3 mb-3">{!! nl2br(e($product->description ?? '')) !!}</p>

                  @if ($product->type === 'product')
                    <div class="product-price mb-3"><strong>Price:</strong>
                      ₹{{ number_format($product->price ?? 0, 2) }}</div>
                  @else
                    <div class="product-price mb-3"><strong>Service</strong></div>
                    <div class="mb-2"><strong>Duration:</strong> {{ $service_meta['duration'] ?? '' }}</div>
                    <div class="mb-2"><strong>Location:</strong> {{ $service_meta['location'] ?? '' }}</div>
                    <div class="mb-2"><strong>Hours:</strong> {{ $service_meta['hours'] ?? '' }}</div>
                  @endif

                  <div class="product-bottom-action mt-3">
                    <a href="#" class="rts-btn btn-primary">Contact / Book</a>
                  </div>

                  <div class="product-uniques mt-3">
                    <div><strong>SKU:</strong> {{ $product->sku ?? '-' }}</div>
                    <div><strong>Type:</strong> {{ ucfirst($product->type) }}</div>
                    <div><strong>Status:</strong>
                      {{ $product->status ?? 'draft' }}{{ isset($is_preview) ? ' (preview)' : '' }}</div>
                  </div>

                </div>
              </div>

            </div>
          </div>

        </div>

        {{-- right column offers --}}
        <div class="col-xl-3 offset-xl-1">
          <div class="shop-sight-sticky-sidevbar">
            <h6 class="title">Available offers</h6>
            <div class="single-offer-area">
              <div class="icon"><img src="{{ asset('assets/images/shop/01.svg') }}" alt=""></div>
              <div class="details">
                <p>Seller offer (preview)</p>
              </div>
            </div>
          </div>
        </div>

      </div>
    </div>
  </div>
</div>
