@php use Illuminate\Support\Str; @endphp
@extends('layouts.theme')
@section('title', 'Booking Details')
@section('body_class','service-details bg-light')

@section('content')

<div class="container py-4">

    {{-- BREADCRUMB --}}
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb premium-breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('account.dashboard') }}">My Account</a></li>
            <li class="breadcrumb-item"><a href="{{ route('account.dashboard') }}#v-pills-bookings">My Bookings</a></li>
            <li class="breadcrumb-item active">Booking Details</li>
        </ol>
    </nav>


    <div class="row g-4">

        {{-- LEFT COLUMN --}}
        <div class="col-lg-8">

            {{-- MAIN CARD --}}
            <div class="premium-card p-4">

                <h3 class="premium-title mb-3">
                    Booking #{{ $order->id }}
                </h3>

                {{-- STATUS --}}
                <div class="mb-3">
                    <span class="badge bg-info text-dark px-3 py-2" style="font-size:14px;">
                        {{ ucfirst($order->service_status) }}
                    </span>
                </div>

                {{-- SERVICE DETAILS --}}
                <div class="d-flex gap-3 align-items-start mb-4">

                    {{-- Use the prepared $mainImageUrl passed from controller --}}
                    <img src="{{ $mainImageUrl }}" alt="{{ $order->service->name ?? 'Service' }}"
                        style="width:120px; height:100px; border-radius:12px; object-fit:cover;">


                    <div>
                        <h5 class="premium-subtitle mb-1">{{ $order->service->name }}</h5>
                        <div class="text-muted small">
                            Vendor: {{ optional($order->vendor)->shop_name }}
                        </div>
                    </div>
                </div>

                <hr>

                {{-- BOOKING INFORMATION --}}
                <h5 class="premium-subtitle mb-3">Booking Information</h5>

                <ul class="premium-summary-list mb-4">
                    <li><strong>Date:</strong> {{ $order->booking_date }}</li>
                    <li><strong>Time:</strong> {{ $order->booking_time }}</li>
                    <li><strong>Duration:</strong> {{ $order->duration_minutes }} mins</li>
                </ul>

                {{-- CUSTOMER DETAILS --}}
                <h5 class="premium-subtitle mb-3">Customer Info</h5>

                <ul class="premium-summary-list mb-4">
                    <li><strong>Name:</strong> {{ auth()->user()->name }}</li>
                    <li><strong>Phone:</strong> {{ auth()->user()->phone ?? '—' }}</li>
                    <li><strong>Address:</strong> {{ $order->address ?? 'Not provided' }}</li>
                </ul>

                {{-- NOTES --}}
                @if($order->notes)
                <div class="mb-4">
                    <h5 class="premium-subtitle">Notes</h5>
                    <p class="text-muted">{{ $order->notes }}</p>
                </div>
                @endif

                {{-- PRICE SUMMARY --}}
                <h5 class="premium-subtitle mb-3">Price Summary</h5>

                <table class="table table-borderless" style="font-size:15px;">
                    <tr>
                        <td>Base Price</td>
                        <td class="text-end">BHD {{ number_format($order->base_price, 2) }}</td>
                    </tr>
                    <tr>
                        <td>Discount</td>
                        <td class="text-end">- BHD {{ number_format($order->discount, 2) }}</td>
                    </tr>
                    <tr>
                        <td>Tax</td>
                        <td class="text-end">BHD {{ number_format($order->tax_amount, 2) }}</td>
                    </tr>
                    <tr>
                        <td><strong>Total</strong></td>
                        <td class="text-end"><strong>BHD {{ number_format($order->total_amount, 2) }}</strong></td>
                    </tr>
                </table>

                <hr>

                {{-- ACTION BUTTONS --}}
                <div class="d-flex gap-3 mt-4">

                    {{-- Cancel only if still pending --}}
                    @if($order->service_status === 'pending')
                        <form method="POST" action="{{ route('service.orders.destroy', $order->service_id) }}">
                            @csrf
                            <button class="premium-btn-outline">Cancel Booking</button>
                        </form>
                    @endif

                    <a href="{{ route('service.show', $order->service_id) }}" 
                       class="premium-btn-primary text-center" 
                       style="text-decoration:none;">
                        Rebook Service
                    </a>

                </div>

            </div>

        </div>


        {{-- RIGHT COLUMN --}}
        <div class="col-lg-4">

            {{-- VENDOR CARD --}}
            <div class="premium-card p-3">

                <h5 class="premium-subtitle mb-3">Vendor</h5>

                <div class="d-flex gap-3">
                    <img src="{{ optional($order->vendor)->logo 
                        ? asset('storage/'.$order->vendor->logo)
                        : asset('assets/images/vendor-placeholder.png') }}"
                        style="width:70px; height:70px; border-radius:10px; object-fit:cover;">

                    <div>
                        <div class="premium-vendor-name">
                            {{ optional($order->vendor)->shop_name }}
                        </div>
                        <div class="text-muted small">
                            {{ Str::limit(optional($order->vendor)->description, 80) }}
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>
</div>
@push('styles')
<style>

/* ----------------------------------------------------
   PREMIUM BOOKING PAGE UPGRADE
---------------------------------------------------- */

:root {
    --primary: #FFAB1D;
    --heading: #1E1E25;
    --text: #6E717A;
    --card-bg: #ffffff;
    --soft-bg: #f8f8fb;
    --radius: 18px;
    --shadow-lg: 0 12px 30px rgba(0,0,0,0.06);
    --shadow-sm: 0 5px 15px rgba(0,0,0,0.05);
}

/* MAIN CARD */
.premium-card {
    background: var(--card-bg);
    border-radius: var(--radius);
    box-shadow: var(--shadow-lg);
    padding: 25px !important;
    border: 1px solid #f0f0f0;
}

/* TITLES */
.premium-title {
    font-size: 26px;
    font-weight: 800;
    letter-spacing: -0.5px;
}

.premium-subtitle {
    font-weight: 700;
    color: var(--heading);
    font-size: 17px;
}

/* BADGE (pending, accepted, etc.) */
.badge {
    border-radius: 12px !important;
    font-weight: 600 !important;
}

/* SERVICE IMAGE */
.booking-service-image {
    width: 120px;
    height: 100px;
    border-radius: 14px;
    object-fit: cover;
    box-shadow: var(--shadow-sm);
    transition: .25s;
}
.booking-service-image:hover {
    transform: scale(1.03);
}

/* SUMMARY LIST */
.premium-summary-list li {
    padding: 6px 0;
    font-size: 15px;
    color: #444;
}

/* PRICE TABLE */
.premium-price-table td {
    padding: 6px 0;
    font-size: 15px;
}

.premium-price-table tr:last-child td {
    font-size: 17px !important;
}

/* BUTTONS */
.premium-btn-primary {
    background: linear-gradient(135deg, #ffb63a, #ff8a00);
    border-radius: 12px !important;
    color: #fff !important;
    padding: 11px 20px !important;
    font-size: 14px;
    font-weight: 600;
    box-shadow: var(--shadow-sm);
    transition: .25s;
}
.premium-btn-primary:hover {
    transform: translateY(-2px);
    background: linear-gradient(135deg, #ff9400, #ff7600);
}

.premium-btn-outline {
    border: 2px solid var(--primary);
    border-radius: 12px !important;
    padding: 10px 20px !important;
    font-size: 14px;
    font-weight: 600;
    color: var(--primary);
    transition: .25s;
}
.premium-btn-outline:hover {
    background: var(--primary);
    color: #fff;
    transform: translateY(-2px);
}

/* VENDOR CARD */
.premium-vendor-card {
    padding: 20px;
    border-radius: var(--radius);
    background: var(--card-bg);
    box-shadow: var(--shadow-lg);
    border: 1px solid #f0f0f0;
}

.premium-vendor-card img {
    width: 70px;
    height: 70px;
    border-radius: 12px;
    object-fit: cover;
    box-shadow: var(--shadow-sm);
}

.premium-vendor-name {
    font-size: 18px;
    font-weight: 700;
    color: var(--heading);
}

/* BREADCRUMB */
.premium-breadcrumb {
    background: var(--card-bg);
    padding: 10px 18px;
    border-radius: 14px;
    box-shadow: var(--shadow-sm);
    font-size: 14px;
}

/* HR */
hr {
    border-top: 1px solid #eee !important;
    margin: 20px 0 !important;
}

</style>
@endpush

@endsection
