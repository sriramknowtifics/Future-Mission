@php use Illuminate\Support\Str; @endphp
@extends('layouts.theme')
@section('title', $service->name ?? 'Service')
@section('body_class','service-details bg-light')

@section('content')

<div class="container py-4">

    {{-- =========================
        BREADCRUMB
    ========================== --}}
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb premium-breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('service.index') }}">Services</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                {{ $service->name }}
            </li>
        </ol>
    </nav>


    <div class="row g-4">

        {{-- =========================
            LEFT COLUMN
        ========================== --}}
        <div class="col-lg-7">

            {{-- MAIN GALLERY CARD --}}
            <div class="premium-card p-3 position-relative">

                {{-- OFFER BADGE --}}
                @if($service->offer_price)
                    @php
                        $percent = round(100 - (($service->offer_price / max($service->price,1)) * 100));
                    @endphp
                    <span class="premium-offer-badge">
                        {{ $percent }}% OFF
                    </span>
                @endif

                {{-- MAIN IMAGE --}}
                <div class="premium-main-img-wrapper mb-3">
                    <img
                        id="mainServiceImage"
                        src="{{ $service->images->first() ? asset('storage/'.$service->images->first()->path) : asset('assets/images/placeholder.png') }}"
                        class="premium-main-img"
                    >
                </div>

                {{-- THUMBNAILS --}}
                <div class="d-flex flex-wrap gap-2">
                    @foreach($service->images as $img)
                        <button
                            class="premium-thumb-btn"
                            data-src="{{ asset('storage/'.$img->path) }}"
                        >
                            <img src="{{ asset('storage/'.$img->path) }}" class="premium-thumb-img">
                        </button>
                    @endforeach
                </div>

            </div>


            {{-- DETAILS CARD --}}
            <div class="premium-card p-4 mt-4">

                {{-- NAME --}}
                <h2 class="premium-title">{{ $service->name }}</h2>

                {{-- SHORT DESC --}}
                <p class="premium-desc">
                    {{ $service->short_description ?? Str::limit(strip_tags($service->description), 160) }}
                </p>

                {{-- RATING + INFO --}}
                <div class="d-flex flex-wrap align-items-center gap-4 mb-3">

                    {{-- RATING --}}
                    <div class="premium-rating">
                        @php $rating = $service->rating ?? 0; @endphp
                        @for($i=1;$i<=5;$i++)
                            @if($rating >= $i)
                                <i class="fas fa-star text-warning"></i>
                            @elseif($rating >= $i - 0.5)
                                <i class="fas fa-star-half-alt text-warning"></i>
                            @else
                                <i class="far fa-star text-muted"></i>
                            @endif
                        @endfor
                        <span class="text-muted small">({{ $service->reviews_count ?? 0 }} reviews)</span>
                    </div>

                    {{-- TYPE --}}
                    <div class="premium-info-badge">
                        <strong>Type:</strong> {{ ucfirst($service->service_type ?? '—') }}
                    </div>

                    {{-- DURATION --}}
                    @if($service->duration_minutes)
                        <div class="premium-info-badge">
                            <strong>Duration:</strong> {{ $service->duration_minutes }} mins
                        </div>
                    @endif
                </div>

                {{-- PRICE --}}
                        <div class="premium-price-box">

                            @if($service->offer_price)
                                <div class="text-muted small">Original</div>
                                <div class="premium-old-price">BHD {{ number_format($service->price,2) }}</div>

                                <div class="premium-price">
                                    BHD {{ number_format($service->offer_price,2) }}
                                </div>
                            @else
                                <div class="premium-price">
                                    BHD {{ number_format($service->price,2) }}
                                </div>
                            @endif

                        </div>

                        {{-- BUTTONS --}}
                        <div class="premium-action-row">
                            <button
                                class="premium-btn-primary"
                                data-bs-toggle="modal"
                                data-bs-target="#bookModal"
                            >
                                <i class="fa fa-calendar-check me-2"></i> Book Now
                            </button>

                            <form method="POST" action="{{ route('service.orders.store') }}" style="flex:1;">
                                @csrf
                                <input type="hidden" name="service_id" value="{{ $service->id }}">
                                <button class="premium-btn-outline w-100">
                                    Quick Book
                                </button>
                            </form>

                        </div>


            </div>


            {{-- DESCRIPTION / FAQ / REVIEWS --}}
            <div class="premium-card p-4 mt-4">
                <h4 class="premium-subtitle">Service Details</h4>

                <div class="premium-content">{!! $service->description !!}</div>

                <hr class="my-4">

                <h5 class="premium-subtitle">Frequently Asked Questions</h5>

                <div class="accordion premium-accordion" id="faqAccordion">
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed premium-accordion-btn" data-bs-toggle="collapse" data-bs-target="#faq1">
                                What does this service include?
                            </button>
                        </h2>
                        <div id="faq1" class="accordion-collapse collapse">
                            <div class="accordion-body">
                                {{ $service->short_description ?? 'Provided by vendor.' }}
                            </div>
                        </div>
                    </div>
                </div>

                <hr class="my-4">

                <h5 class="premium-subtitle">Customer Reviews</h5>
                <p class="text-muted">No reviews yet.</p>
            </div>

        </div>


        {{-- =========================
            RIGHT COLUMN
        ========================== --}}
        <div class="col-lg-5">

            {{-- VENDOR CARD --}}
            <div class="premium-card p-3 mb-4">

                <div class="d-flex gap-3">
                    <img
                        src="{{ optional($service->vendor)->logo ? asset('storage/'.$service->vendor->logo) : asset('assets/images/vendor-placeholder.png') }}"
                        class="premium-vendor-img"
                    >

                    <div>
                        <h5 class="premium-vendor-name">{{ optional($service->vendor)->shop_name ?? 'Vendor' }}</h5>
                        <p class="text-muted small">
                            {{ optional($service->vendor)->description ? Str::limit($service->vendor->description, 80) : '' }}
                        </p>
                        <a href="#" class="premium-link">Visit Shop →</a>
                    </div>
                </div>

                <div class="row text-center mt-3">
                    <div class="col">
                        <div class="premium-small-label">Jobs Done</div>
                        <div class="premium-small-value">{{ optional($service->vendor)->jobs_completed ?? 0 }}</div>
                    </div>
                    <div class="col">
                        <div class="premium-small-label">Rating</div>
                        <div class="premium-small-value">{{ optional($service->vendor)->rating ?? '—' }}</div>
                    </div>
                </div>

                <div class="mt-3">
                    <div class="premium-small-label mb-1">Contact Vendor</div>
                    <div class="d-flex gap-2">
                        @if(optional($service->vendor)->phone)
                            <a href="tel:{{ $service->vendor->phone }}" class="premium-btn-outline-sm">
                                <i class="fa fa-phone me-1"></i> Call
                            </a>
                        @endif
                        <a href="#" class="premium-btn-outline-sm">
                            Message
                        </a>
                    </div>
                </div>

            </div>


            {{-- SUMMARY CARD --}}
            <div class="premium-card p-3">
                <h5 class="premium-subtitle mb-3">Service Summary</h5>

                <ul class="premium-summary-list">
                    <li><strong>Category:</strong> {{ optional($service->category)->name ?? '—' }}</li>
                    <li><strong>Type:</strong> {{ ucfirst($service->service_type ?? '—') }}</li>
                    <li><strong>Duration:</strong> {{ $service->duration_minutes ? $service->duration_minutes.' mins' : '—' }}</li>
                    <li>
                        <strong>Available Days:</strong>
                        {{ $service->available_days ? implode(', ', (array)$service->available_days) : 'Everyday' }}
                    </li>
                </ul>
            </div>


            {{-- RELATED --}}
            <div class="premium-card p-3 mt-4">
                <h5 class="premium-subtitle mb-3">Related Services</h5>

                @foreach($related as $r)
                    <a href="{{ route('service.show', $r->id) }}" class="d-flex gap-3 premium-related-item">
                        <img src="{{ $r->images->first() ? asset('storage/'.$r->images->first()->path) : asset('assets/images/placeholder.png') }}"
                             class="premium-related-img">

                        <div>
                            <div class="premium-related-title">{{ Str::limit($r->name,40) }}</div>
                            <div class="premium-related-price">BHD {{ number_format($r->price,2) }}</div>
                        </div>
                    </a>
                @endforeach
            </div>

        </div>

    </div>
</div>



{{-- =========================
    BOOKING MODAL
========================= --}}
<div class="modal fade" id="bookModal">
    <div class="modal-dialog modal-dialog-centered">
        <form method="POST" action="{{ route('service.orders.store') }}" class="premium-modal">
            @csrf
            <input type="hidden" name="service_id" value="{{ $service->id }}">

            <div class="modal-header">
                <h5 class="modal-title premium-modal-title">Book {{ $service->name }}</h5>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">

                <label class="premium-label">Preferred date & time</label>
                <input type="datetime-local" name="scheduled_at" class="premium-input mb-3">

                <label class="premium-label">Time Slot</label>
                <input name="time_slot" class="premium-input mb-3" placeholder="Eg: 10:00 - 12:00">

                <label class="premium-label">Service Address</label>
                <textarea name="address" rows="2" class="premium-input mb-3"></textarea>

                <label class="premium-label">Notes</label>
                <textarea name="notes" rows="2" class="premium-input mb-3"></textarea>

            </div>

            <div class="modal-footer">
                <button class="premium-btn-outline">Cancel</button>
                <button class="premium-btn-primary">Continue Booking</button>
            </div>

        </form>
    </div>
</div>



{{-- =========================
    JS
========================= --}}
@push('scripts')
<script>
document.querySelectorAll('.premium-thumb-btn').forEach(btn=>{
    btn.addEventListener('click', function(){
        document.querySelectorAll('.premium-thumb-btn').forEach(b=>b.classList.remove('active'));
        this.classList.add('active');
        document.getElementById('mainServiceImage').src = this.dataset.src;
    });
});
</script>
@endpush



{{-- =========================
    PREMIUM CSS
========================= --}}
@push('styles')
<style>
:root {
    --primary: #FFAB1D;
    --heading: #1F1F25;
    --text: #6E777D;
    --radius: 16px;
    --shadow: 0 8px 22px rgba(0,0,0,0.08);
}

/* ===============================
   BREADCRUMB
=============================== */
.premium-breadcrumb {
    background: #fff;
    border-radius: var(--radius);
    box-shadow: var(--shadow);
    padding: 8px 16px;
}

/* ===============================
   CARD WRAPPER
=============================== */
.premium-card {
    background:#fff;
    border-radius:var(--radius);
    box-shadow:var(--shadow);
}

/* ==========================================================
   GLOBAL PREMIUM FONT TWEAK
========================================================== */
.premium-title,
.premium-subtitle,
.premium-vendor-name,
.premium-price {
    font-family: "Inter", "Barlow", sans-serif;
    font-weight: 700;
    letter-spacing: -0.3px;
}

.premium-desc,
.premium-info-badge,
.premium-small-label,
.premium-summary-list li,
.text-muted {
    font-family: "Inter", sans-serif;
    font-weight: 400;
    color: var(--text);
    font-size: 14px;
}

/* ==========================================================
   MAIN IMAGE (UPDATED)
========================================================== */
.premium-main-img-wrapper {
    width:100%;
    height: 350px !important;
    border-radius:var(--radius);
    overflow:hidden;
}

.premium-main-img {
    width:100%;
    height:100%;
    object-fit:cover;
    transition:0.3s;
}

.premium-main-img:hover {
    transform:scale(1.03);
}

/* ==========================================================
   THUMBNAILS (UPDATED)
========================================================== */
.premium-thumb-btn {
    width:78px !important;
    height:60px !important;
    border:none;
    background:#fff;
    border-radius:10px;
    overflow:hidden;
    box-shadow:0 4px 14px rgba(0,0,0,0.06);
    transition:0.3s;
}
.premium-thumb-btn:hover,
.premium-thumb-btn.active {
    transform:translateY(-3px);
    border:2px solid var(--primary);
}
.premium-thumb-img {
    width:100%;
    height:100%;
    object-fit:cover;
}

/* ==========================================================
   PRICE (NEW VERSION)
========================================================== */
.premium-price {
    font-size: 22px !important;     /* replaced old 28px */
    font-weight: 700 !important;
    color: var(--primary);
    letter-spacing: -0.3px;
}

.premium-old-price {
    text-decoration:line-through;
    color:#999;
    font-size:12px !important;      /* replaced old 14px */
    opacity:0.8;
}

.premium-price-box {
    margin-top: 8px;                /* replaced old 15px */
    margin-bottom: 12px;            /* extra spacing */
}

/* ==========================================================
   BUTTONS (REPLACED)
========================================================== */
.premium-action-row {
    display: flex;
    gap: 10px;
    margin-top: 10px;
}

.premium-btn-primary,
.premium-btn-outline {
    flex: 1;
    padding: 10px 12px !important;    /* smaller button */
    font-size: 13px !important;
    border-radius: 10px !important;
}

/* Primary button gradient */
.premium-btn-primary {
    background:linear-gradient(135deg,#ffb63a,#ff9d00);
    color:#fff;
    border:none;
    font-weight:600;
    transition:.25s;
}

.premium-btn-primary:hover {
    transform:translateY(-2px);
    background:linear-gradient(135deg,#ff9d00,#ff8200);
}

/* Outline */
.premium-btn-outline {
    border:2px solid var(--primary);
    color:var(--primary);
    font-weight:600;
}

.premium-btn-outline:hover {
    background:var(--primary);
    color:#fff;
}

/* icon size fix */
.premium-btn-primary i,
.premium-btn-outline i {
    font-size: 13px;
}

/* Vendor small buttons */
.premium-btn-outline-sm {
    border:1px solid var(--primary);
    padding:5px 10px;
    font-size:13px;
    border-radius:8px;
    color:var(--primary);
}
.premium-btn-outline-sm:hover {
    background:var(--primary);
    color:#fff;
}

/* Mobile responsiveness */
@media(max-width: 768px) {
    .premium-action-row {
        flex-direction: column;
    }
}

/* ==========================================================
   VENDOR CARD
========================================================== */
.premium-vendor-img {
    width:72px !important;
    height:72px !important;
    border-radius:12px;
    object-fit:cover;
}

.premium-vendor-name {
    font-size:17px !important;
    font-weight:700;
}

/* ==========================================================
   RELATED
========================================================== */
.premium-related-item {
    padding:10px;
    border-radius:10px;
    transition:0.3s;
}
.premium-related-item:hover {
    background:#fafafa;
    transform:translateX(4px);
}

.premium-related-img {
    width:64px;
    height:48px;
    border-radius:8px;
    object-fit:cover;
}

.premium-related-title {
    font-size:14px;
    font-weight:600;
}

.premium-related-price {
    font-size:13px;
    color:var(--primary);
}

/* ==========================================================
   MODAL
========================================================== */
.premium-modal {
    border-radius:var(--radius);
    box-shadow:var(--shadow);
}

.premium-modal-title {
    font-weight:700;
}

.premium-input {
    width:100%;
    border-radius:10px;
    padding:10px 12px;
    border:1px solid #ddd;
}

.premium-input:focus {
    border-color:var(--primary);
    box-shadow:0 0 0 0.2rem rgba(255,171,29,0.25);
}

/* ==========================================================
   OFFER BADGE
========================================================== */
.premium-offer-badge {
    position:absolute;
    top:14px;
    left:14px;
    background:var(--primary);
    padding:6px 12px;
    border-radius:10px;
    font-weight:600;
    color:#fff;
    box-shadow:var(--shadow);
}
/* FIX: Force Font Awesome star icons to be visible */
.premium-rating i.fas,
.premium-rating i.far {
    font-family: "Font Awesome 6 Free" !important;
    font-weight: 900 !important;  /* solid weight */
    display: inline-block !important;
    opacity: 1 !important;
    font-size: 15px !important;
}
.premium-rating i.fa-star-half-alt {
    font-weight: 900 !important;
}

</style>
@endpush

@endsection
