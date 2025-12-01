@extends('layouts.theme')

@section('title', 'My Dashboard')

@section('vendor-style')
  @vite([
    'resources/assets/vendor/libs/apex-charts/apex-charts.scss',
    'resources/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.scss',
    'resources/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.scss',
    'resources/assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.scss'
  ])
@endsection

@section('vendor-script')
  @vite([
    'resources/assets/vendor/libs/apex-charts/apexcharts.js',
    'resources/assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js'
  ])
@endsection

@section('page-script')
  @vite(['resources/assets/js/app-ecommerce-dashboard.js'])
@endsection

@section('content')

{{-- ================================
    BREADCRUMB
================================ --}}
<div class="rts-navigation-area-breadcrumb mb-2">
    <div class="container-2">
        <div class="navigator-breadcrumb-wrapper">
            <a href="{{ url('/') }}">Home</a>
            <i class="fa-solid fa-chevron-right"></i>
            <span class="current">Account</span>
        </div>
    </div>
</div>


{{-- ================================
    MAIN LAYOUT
================================ --}}
<div class="account-tab-area-start rts-section-gap">
    <div class="container-2">
        <div class="row">

            {{-- SIDE NAV --}}
            <div class="col-lg-3">
                <div class="premium-side-nav nav flex-column nav-pills" id="v-pills-tab">

                    <button class="nav-link active" data-bs-toggle="pill" data-bs-target="#v-pills-dashboard">
                        <i class="fa-solid fa-gauge-high me-2"></i> Dashboard
                    </button>

                    <button class="nav-link" data-bs-toggle="pill" data-bs-target="#v-pills-bookings">
                        <i class="fa-solid fa-calendar-check me-2"></i> My Bookings
                    </button>

                    <button class="nav-link">
                        <i class="fa-solid fa-box-open me-2"></i> Orders
                    </button>

                    <button class="nav-link">
                        <i class="fa-solid fa-location-dot me-2"></i> Address
                    </button>

                    <button class="nav-link" data-bs-toggle="pill" data-bs-target="#v-pills-account-details">
                        <i class="fa-solid fa-user-gear me-2"></i> Account Details
                    </button>


                    <a href="{{ route('logout') }}" class="nav-link text-danger">
                        <i class="fa-solid fa-right-from-bracket me-2"></i> Logout
                    </a>
                </div>
            </div>


            {{-- CONTENT AREA --}}
            <div class="col-lg-9 ps-lg-5 pt-4 pt-lg-0">
                <div class="tab-content" id="v-pills-tabContent">


                    {{-- =============================
                        DASHBOARD TAB
                    =============================== --}}
                    <div class="tab-pane fade show active" id="v-pills-dashboard">

                        <h2 class="premium-heading mb-2">
                            Welcome back, {{ $username }} 👋
                        </h2>
                        <p class="text-muted mb-4">Here’s your activity summary.</p>

                        {{-- STATS --}}
                        <div class="row g-4 mb-4">

                            <div class="col-md-4">
                                <div class="premium-stat-card">
                                    <div>
                                        <div class="stat-label">Total Bookings</div>
                                        <div class="stat-value">{{ $serviceOrders->count() }}</div>
                                    </div>
                                    <div class="stat-icon bg-primary-light">
                                        <i class="fa-solid fa-calendar-check text-primary"></i>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="premium-stat-card">
                                    <div>
                                        <div class="stat-label">Pending</div>
                                        <div class="stat-value">{{ $serviceOrders->where('service_status','pending')->count() }}</div>
                                    </div>
                                    <div class="stat-icon bg-warning-light">
                                        <i class="fa-solid fa-hourglass-half text-warning"></i>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="premium-stat-card">
                                    <div>
                                        <div class="stat-label">Completed</div>
                                        <div class="stat-value">{{ $serviceOrders->where('service_status','completed')->count() }}</div>
                                    </div>
                                    <div class="stat-icon bg-success-light">
                                        <i class="fa-solid fa-circle-check text-success"></i>
                                    </div>
                                </div>
                            </div>

                        </div>

                        {{-- RECENT BOOKINGS --}}
                        <div class="premium-card mt-3">
                            <h5 class="premium-title mb-3">Recent Bookings</h5>

                            <div class="premium-table-wrapper">
                                <table class="table premium-table align-middle">
                                    <thead>
                                        <tr>
                                            <th>Service</th>
                                            <th>Date</th>
                                            <th>Status</th>
                                            <th>Total</th>
                                            <th></th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @forelse($serviceOrders->take(5) as $row)
                                        <tr>
                                            <td>
                                                <strong>{{ $row->service->name }}</strong>
                                                <small class="text-muted d-block">Vendor: {{ $row->vendor->shop_name }}</small>
                                            </td>
                                            <td>{{ $row->booking_date }}</td>
                                            <td>
                                                <span class="badge status-{{ $row->service_status }}">
                                                    {{ ucfirst($row->service_status) }}
                                                </span>
                                            </td>
                                            <td>BHD {{ number_format($row->total_amount, 2) }}</td>
                                            <td>
                                                <a href="{{ route('service.orders.show',$row->id) }}" class="premium-btn-sm">
                                                    View
                                                </a>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="5" class="text-center text-muted py-4">
                                                No bookings yet.
                                            </td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>


                    {{-- =============================
                        MY BOOKINGS
                    =============================== --}}
                    <div class="tab-pane fade" id="v-pills-bookings">

                        <div class="premium-card">
                            <h3 class="premium-title mb-3">My Bookings</h3>

                            <form method="POST" action="{{ route('service.orders.confirm') }}">
                                @csrf

                                <div class="premium-table-wrapper">
                                    <table class="table premium-table align-middle">
                                        <thead>
                                            <tr>
                                                <th><input type="checkbox" id="selectAll"></th>
                                                <th>Service</th>
                                                <th>Date</th>
                                                <th>Status</th>
                                                <th>Amount</th>
                                                <th></th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            @foreach($serviceOrders as $order)
                                            <tr>
                                                <td>
                                                    <input type="checkbox" name="selected[]" value="{{ $order->id }}" class="rowCheck">
                                                </td>

                                                <td>
                                                    <strong>{{ $order->service->name }}</strong>
                                                    <small class="text-muted d-block">Vendor: {{ $order->vendor->shop_name }}</small>
                                                </td>

                                                <td>{{ $order->booking_date }}</td>

                                                <td>
                                                    <span class="badge status-{{ $order->service_status }}">
                                                        {{ ucfirst($order->service_status) }}
                                                    </span>
                                                </td>

                                                <td><strong>BHD {{ number_format($order->total_amount, 2) }}</strong></td>

                                                <td>
                                                    <a href="{{ route('service.orders.show',$order->id) }}" class="premium-btn-sm">
                                                        View
                                                    </a>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>

                                <button class="premium-btn-primary mt-3">
                                    Confirm Booking
                                </button>
                            </form>
                        </div>

                    </div>
                    <div class="tab-pane fade" id="v-pills-account-details">
                        @include('account.account_details')
                    </div>


                </div>
            </div>

        </div>
    </div>
</div>


{{-- =============================
    PREMIUM CSS
============================== --}}
@push('styles')
<style>
/* ----------------------------------------------------
   Premium Global Variables
---------------------------------------------------- */
:root {
    --primary: #ff9d00;
    --primary-hover: #ff8200;
    --dark: #1f1f25;
    --text-muted: #6f7683;
    --radius: 16px;
    --shadow: 0 8px 25px rgba(0,0,0,.08);
}

/* ----------------------------------------------------
   Sidebar
---------------------------------------------------- */
.premium-side-nav .nav-link {
    padding: 14px 16px;
    border-radius: var(--radius);
    margin-bottom: 8px;
    font-weight: 600;
    color: #444;
    transition: .25s;
}
.premium-side-nav .nav-link:hover,
.premium-side-nav .nav-link.active {
    background: var(--primary);
    color: #fff;
    transform: translateX(4px);
}
.premium-side-nav .nav-link i {
    width: 18px;
}

/* ----------------------------------------------------
   Cards
---------------------------------------------------- */
.premium-card {
    background: #fff;
    border-radius: var(--radius);
    padding: 22px;
    box-shadow: var(--shadow);
}

/* ----------------------------------------------------
   Stat Cards
---------------------------------------------------- */
.premium-stat-card {
    background: #fff;
    padding: 20px;
    border-radius: var(--radius);
    box-shadow: var(--shadow);
    display: flex;
    justify-content: space-between;
    align-items: center;
}
.stat-label {
    font-size: 13px;
    color: var(--text-muted);
}
.stat-value {
    font-size: 32px;
    font-weight: 700;
}
.stat-icon {
    padding: 14px;
    border-radius: 14px;
    font-size: 24px;
}

/* Light backgrounds */
.bg-primary-light { background:#fff2d6; }
.bg-warning-light { background:#fff7d1; }
.bg-success-light { background:#e7ffe7; }

/* ----------------------------------------------------
   Table
---------------------------------------------------- */
.premium-table-wrapper {
    border-radius: var(--radius);
    overflow: hidden;
    border: 1px solid #f0f0f0;
}
.premium-table thead th {
    background: #f9f9f9;
    font-weight: 700;
    padding: 14px;
}
.premium-table tbody tr {
    transition: .25s;
}
.premium-table tbody tr:hover {
    background: #fff8eb;
}

/* ----------------------------------------------------
   Buttons
---------------------------------------------------- */
.premium-btn-primary {
    background: linear-gradient(135deg, var(--primary), var(--primary-hover));
    padding: 12px 20px;
    color: #fff !important;
    border-radius: 12px;
    font-weight: 600;
    transition: .25s;
    border: none;
}
.premium-btn-primary:hover {
    transform: translateY(-2px);
}

.premium-btn-sm {
    padding: 6px 14px;
    border-radius: 10px;
    font-size: 13px;
    border: 2px solid var(--primary);
    font-weight: 600;
    color: var(--primary);
    transition: .25s;
}
.premium-btn-sm:hover {
    background: var(--primary);
    color: #fff;
}

/* ----------------------------------------------------
   Status Badges
---------------------------------------------------- */
.badge {
    border-radius: 10px;
    padding: 6px 12px;
    font-weight: 600;
}
.status-pending { background: #fff3cd; color:#a07800; }
.status-completed { background:#d4f7dc; color:#2e7d32; }
.status-progress { background:#dcecff; color:#0b5ed7; }

.premium-heading {
    font-size: 28px;
    font-weight: 700;
    color: var(--dark);
}
</style>
@endpush


{{-- =============================
    JS
============================== --}}
@push('scripts')
<script>
document.getElementById("selectAll")?.addEventListener("click", function(){
    document.querySelectorAll(".rowCheck").forEach(cb => cb.checked = this.checked);
});
</script>
@endpush

@endsection
