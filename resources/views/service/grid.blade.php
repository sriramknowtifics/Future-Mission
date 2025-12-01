@php use Illuminate\Support\Str; @endphp
@extends('layouts.theme')
@section('title', 'Services')
@section('body_class', 'bg-light')

@section('content')
<div class="bg-white border-bottom">
    <div class="container py-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('service.index') }}">Services</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ $current ?? 'All Services' }}</li>
            </ol>
        </nav>
    </div>
</div>

<div class="container py-4">
    <div class="row g-4">

        {{-- SIDEBAR --}}
        <aside class="col-lg-3 order-lg-1 order-2">
            {{-- Price Filter --}}
            <div class="card mb-4 shadow-sm">
                <div class="card-body">
                    <h6 class="fw-bold mb-3">Price Filter</h6>
                    <form action="{{ route('service.index') }}" method="GET">
                        <div class="mb-2">
                            <label class="form-label small">Min (BHD)</label>
                            <div class="input-group">
                                <span class="input-group-text">BHD</span>
                                <input name="min_price" value="{{ request('min_price', '') }}" class="form-control form-control-sm" type="number" min="0" step="0.01">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small">Max (BHD)</label>
                            <div class="input-group">
                                <span class="input-group-text">BHD</span>
                                <input name="max_price" value="{{ request('max_price', '') }}" class="form-control form-control-sm" type="number" min="0" step="0.01">
                            </div>
                        </div>
                        <button class="btn btn-sm w-100 btn-cta">Apply</button>
                    </form>
                </div>
            </div>

            {{-- Category small round icons (style C) --}}
            <div class="card mb-4 shadow-sm">
                <div class="card-body">
                    <h6 class="fw-bold mb-3">Service Categories</h6>
                    <div class="d-flex flex-wrap gap-2">
                        @foreach($categories as $cat)
                        <a href="{{ route('service.index', ['service_category' => $cat->id]) }}" class="text-center text-decoration-none category-pill">
                            <div class="cat-icon d-flex align-items-center justify-content-center mb-1">
                                @if($cat->icon)
                                    <img src="{{ asset('storage/'.$cat->icon) }}" alt="{{ $cat->name }}" class="img-fluid" style="max-height:34px;">
                                @else
                                    <i class="fa fa-briefcase"></i>
                                @endif
                            </div>
                            <div class="small text-dark">{{ Str::limit($cat->name, 12) }}</div>
                        </a>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- Top vendors (optional) --}}
            <div class="card mb-4 shadow-sm">
                <div class="card-body">
                    <h6 class="fw-bold mb-3">Top Vendors</h6>
                    <ul class="list-unstyled mb-0">
                        @foreach($topVendors ?? [] as $vendor)
                        <li class="mb-2">
                            <a href="{{ route('vendor.show', $vendor->id) }}" class="small text-dark">
                                {{ $vendor->shop_name ?? $vendor->user->name }}
                            </a>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </aside>

        {{-- MAIN --}}
        <div class="col-lg-9 order-lg-2 order-1">

            {{-- header bar --}}
            <div class="d-flex justify-content-between align-items-center mb-3 gap-2">
                <div class="small text-muted">Showing <strong>{{ $services->count() }}</strong> of {{ $services->total() }}</div>

                <div class="d-flex gap-2 align-items-center">
                    <select class="form-select form-select-sm" onchange="window.location.href=this.value">
                        <option value="{{ route('service.index', request()->except('sort')) }}">Default Sorting</option>
                        <option value="{{ route('service.index', array_merge(request()->all(), ['sort'=>'price_asc'])) }}" @selected(request('sort')=='price_asc')>Price: Low to High</option>
                        <option value="{{ route('service.index', array_merge(request()->all(), ['sort'=>'price_desc'])) }}" @selected(request('sort')=='price_desc')>Price: High to Low</option>
                        <option value="{{ route('service.index', array_merge(request()->all(), ['sort'=>'newest'])) }}" @selected(request('sort')=='newest')>Newest First</option>
                    </select>
                </div>
            </div>

            {{-- service grid --}}
            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-4">
                @forelse($services as $service)
                    @php
                        $img = $service->images->where('is_primary', true)->first() ?? $service->images->first();
                        $hasDiscount = $service->offer_price && $service->offer_price < $service->price;
                        $discountPercent = $hasDiscount ? round((($service->price - $service->offer_price) / $service->price) * 100) : 0;
                        $availableDaysLabel = is_array($service->available_days) ? implode(', ', array_map('ucfirst', $service->available_days)) : null;
                    @endphp

                    <div class="col">
                        <div class="card h-100 service-card">
                            <div class="position-relative overflow-hidden">
                                {{-- Badge --}}
                                @if($hasDiscount)
                                    <span class="badge discount-badge">-{{ $discountPercent }}%</span>
                                @endif

                                {{-- Approval/status overlay --}}
                                @if(!$service->is_active || $service->approval_status !== 'approved')
                                    <span class="badge bg-secondary status-badge position-absolute">{{ $service->approval_status ?? 'pending' }}</span>
                                @endif

                                <a href="{{ route('service.show', $service->id) }}" class="d-block">
                                    <img src="{{ $img ? asset('storage/'.$img->path) : asset('assets/images/placeholder.png') }}"
                                         class="card-img-top" style="height:200px; object-fit:cover;" alt="{{ $service->name }}">
                                </a>
                            </div>

                            <div class="card-body d-flex flex-column">
                                <div class="d-flex justify-content-between align-items-start mb-1">
                                    <h6 class="mb-0">
                                        <a href="{{ route('service.show', $service->id) }}" class="text-dark text-decoration-none">
                                            {{ Str::limit($service->name, 60) }}
                                        </a>
                                    </h6>

                                    {{-- Rating (if present) --}}
                                    @if(isset($service->rating))
                                        <small class="text-warning ms-2" title="Rating">{{ number_format($service->rating,1) }} <i class="fa fa-star"></i></small>
                                    @endif
                                </div>

                                <small class="text-muted">{{ optional($service->category)->name ?? 'Uncategorized' }}</small>

                                {{-- short desc (one-liner) --}}
                                @if($service->short_description)
                                    <p class="small text-muted mt-2 mb-2">{{ Str::limit($service->short_description, 80) }}</p>
                                @endif

                                {{-- meta row --}}
                                <div class="d-flex small text-muted mb-3 gap-2 flex-wrap">
                                    {{-- duration --}}
                                    @if($service->duration_minutes)
                                        <div class="d-flex align-items-center"><i class="fa fa-clock me-1"></i> {{ intval($service->duration_minutes) }} min</div>
                                    @endif

                                    {{-- service type --}}
                                    <div class="d-flex align-items-center"><i class="fa fa-wifi me-1"></i> {{ ucfirst($service->service_type ?? '—') }}</div>

                                    {{-- available days --}}
                                    @if($availableDaysLabel)
                                        <div class="d-flex align-items-center"><i class="fa fa-calendar me-1"></i> {{ Str::limit($availableDaysLabel, 20) }}</div>
                                    @endif
                                </div>

                                <div class="mt-auto">
                                    {{-- Price block --}}
                                    <div class="d-flex align-items-center justify-content-between mb-3">
                                        <div>
                                            @if($hasDiscount)
                                                <div class="fs-6 fw-bold text-price">BHD {{ number_format($service->offer_price,2) }}</div>
                                                <div class="small text-muted text-decoration-line-through">BHD {{ number_format($service->price,2) }}</div>
                                            @else
                                                <div class="fs-6 fw-bold text-price">BHD {{ number_format($service->price,2) }}</div>
                                            @endif
                                        </div>

                                        {{-- vendor --}}
                                        <div class="text-end small text-muted">
                                            <div>{{ $service->vendor->shop_name ?? ($service->vendor->user->name ?? 'Vendor') }}</div>
                                            <div class="text-success small">{{ $service->vendor->city ?? '' }}</div>
                                        </div>
                                    </div>

                                    {{-- CTAs --}}
                                    <div class="d-flex gap-2">
                                        {{-- Book Now (primary) --}}
                                        <form action="{{ route('service.orders.store', $service->id) }}" method="POST" class="flex-grow-1">
                                            @csrf
                                            <input type="hidden" name="service_id" value="{{ $service->id }}">
                                            <button type="submit" class="btn btn-cta w-100">
                                                <i class="fa fa-calendar-plus me-1"></i> Book Now
                                            </button>
                                        </form>

                                        {{-- View Details --}}
                                        <a href="{{ route('service.show', $service->id) }}" class="btn btn-outline-secondary">
                                            Details
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                @empty
                    <div class="col-12 text-center py-5">
                        <img src="{{ asset('assets/images/empty-cart.png') }}" width="180" alt="no services">
                        <h5 class="mt-3 text-muted">No services found</h5>
                    </div>
                @endforelse
            </div>

            {{-- pagination --}}
            <div class="mt-4 d-flex justify-content-center">
                {{ $services->appends(request()->query())->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
</div>

@endsection

@push('styles')
<style>
:root{
  --color-primary: #FFAB1D;
  --color-primary-2: #FF9A00;
  --color-heading: #2C3C28;
  --card-radius: 14px;
  --shadow-sm: 0 6px 22px rgba(30,30,30,0.06);
}

/* page bg */
body { background: #f7f8fb !important; }

/* cards */
.service-card {
    border-radius: var(--card-radius);
    box-shadow: var(--shadow-sm);
    overflow: hidden;
    transition: transform .25s ease, box-shadow .25s ease;
}
.service-card:hover { transform: translateY(-6px); box-shadow: 0 22px 50px rgba(40,40,40,0.12); }

/* images */
.card-img-top { transition: transform .35s ease; }
.service-card:hover .card-img-top { transform: scale(1.04); }

/* price */
.text-price { color: #E38304; font-size: 1.05rem; }

/* discount badge */
.discount-badge {
    position: absolute;
    left: 12px;
    top: 12px;
    background: linear-gradient(90deg, #ff6b6b, #ff4757);
    color: #fff;
    padding: 6px 8px;
    border-radius: 8px;
    font-weight: 700;
    font-size: .85rem;
    z-index: 5;
}

/* status badge */
.status-badge {
    right: 12px;
    top: 12px;
    z-index: 5;
    padding: 6px 8px;
    border-radius: 8px;
    text-transform: capitalize;
}

/* CTA styles */
.btn-cta, .btn-cta:focus {
    background: linear-gradient(135deg, var(--color-primary), var(--color-primary-2));
    color: #111;
    font-weight: 700;
    border-radius: 10px;
    border: none;
    padding: 10px 12px;
    box-shadow: 0 8px 18px rgba(255,171,29,0.18);
}
.btn-cta:hover { transform: translateY(-2px); box-shadow: 0 12px 28px rgba(255,171,29,0.22); }

/* apply button smaller but matching tone */
.btn-cta-sm {
    background: linear-gradient(135deg, var(--color-primary), var(--color-primary-2));
    color: #111;
    font-weight: 700;
}

/* category small round icons (style C) */
.category-pill {
    width: 72px;
    text-align: center;
    color: #333;
}
.cat-icon {
    width: 56px;
    height: 56px;
    border-radius: 50%;
    background: #fff;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 6px 18px rgba(40,40,40,0.06);
    transition: transform .18s ease, box-shadow .18s ease;
}
.category-pill:hover .cat-icon { transform: translateY(-4px); box-shadow: 0 16px 36px rgba(40,40,40,0.12); }

/* small screens tweaks */
@media (max-width: 767.98px){
    .category-pill { width: 60px; }
    .cat-icon { width: 48px; height: 48px; }
    .card-img-top { height: 180px !important; object-fit: cover; }
}

/* subtle helper */
.small.text-muted { color: #6c7780; }

/* price currency appearance */
.price-bhd, .text-price { letter-spacing: 0.2px; }

/* accessibility: focus outlines */
a:focus, button:focus {
    outline: 3px solid rgba(255,171,29,0.18);
    outline-offset: 2px;
}
</style>
@endpush

@push('scripts')
<script>
    // optional: support small JS interactions in future (quick view / wishlist)
    document.addEventListener('click', function(e){
        // placeholder for progressive enhancement
    }, false);
</script>
@endpush
