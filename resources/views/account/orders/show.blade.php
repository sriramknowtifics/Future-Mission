@extends('layouts.theme')

@section('title', 'Order Details')

@section('content')

{{-- ===========================================
     ORDER HEADER
=========================================== --}}
<div class="premium-card mb-4">
    <h3 class="premium-title mb-3">
        Order #{{ $order->order_number }}
    </h3>

    <div class="row">
        <div class="col-md-6">
            <h6 class="text-muted">Order Date</h6>
            <p>{{ $order->created_at->format('d M Y, h:i A') }}</p>
        </div>
        <div class="col-md-6">
            <h6 class="text-muted">Status</h6>
            <p>
                <span class="badge status-{{ $order->status }}">
                    {{ ucfirst($order->status) }}
                </span>
            </p>
        </div>
    </div>
</div>



{{-- ===========================================
     ⭐ ORDER TRACKING TIMELINE ADDED HERE ⭐
=========================================== --}}
<div class="premium-card mb-4">
    <h4 class="premium-title mb-3">Order Tracking</h4>

    @php
        $steps = ['pending', 'confirmed', 'processing', 'packed', 'shipped', 'delivered'];
        $currentIndex = array_search($order->status, $steps);
    @endphp

    <div class="tracking-wrapper">
        @foreach($steps as $index => $step)
            <div class="tracking-step">
                
                {{-- Circle --}}
                <div class="circle {{ $index <= $currentIndex ? 'active' : '' }}">
                    @if($index <= $currentIndex)
                        <i class="fa-solid fa-check"></i>
                    @endif
                </div>

                {{-- Label --}}
                <div class="label {{ $index <= $currentIndex ? 'active' : '' }}">
                    {{ ucfirst($step) }}
                </div>

                {{-- Connector Line --}}
                @if($index < count($steps) - 1)
                    <div class="line {{ $index < $currentIndex ? 'active' : '' }}"></div>
                @endif

            </div>
        @endforeach
    </div>
</div>




{{-- ===========================================
     ORDER ITEMS
=========================================== --}}
<div class="premium-card mb-4">
    <h4 class="premium-title mb-3">Items</h4>

    <div class="premium-table-wrapper">
        <table class="table premium-table align-middle">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Vendor</th>
                    <th>Qty</th>
                    <th>Subtotal</th>
                </tr>
            </thead>

            <tbody>
                @foreach($order->items as $item)
                <tr>
                    <td>{{ $item->name }}</td>
                    <td>{{ $item->vendor->shop_name ?? 'N/A' }}</td>
                    <td>{{ $item->qty }}</td>
                    <td>BHD {{ number_format($item->subtotal, 2) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>


{{-- ===========================================
     PAYMENT SUMMARY
=========================================== --}}
<div class="premium-card">
    <h4 class="premium-title mb-3">Payment Summary</h4>

    <div class="d-flex justify-content-between mb-2">
        <span>Subtotal:</span>
        <strong>BHD {{ number_format($order->subtotal_amount, 2) }}</strong>
    </div>
    <div class="d-flex justify-content-between mb-2">
        <span>Shipping:</span>
        <strong>BHD {{ number_format($order->shipping_cost, 2) }}</strong>
    </div>
    <div class="d-flex justify-content-between mb-2">
        <span>Tax:</span>
        <strong>BHD {{ number_format($order->tax_amount, 2) }}</strong>
    </div>
    <hr>
    <div class="d-flex justify-content-between">
        <span class="fw-bold">Total:</span>
        <strong class="text-primary">
            BHD {{ number_format($order->total_amount, 2) }}
        </strong>
    </div>

    @if(in_array($order->status, ['pending', 'paid']))
        <form action="{{ route('account.orders.cancel', $order->id) }}" method="POST" class="mt-3">
            @csrf
            <button class="premium-btn-primary w-100">
                Cancel Order
            </button>
        </form>
    @endif
</div>

@endsection


{{-- ===========================================
     PREMIUM TRACKING STYLES
=========================================== --}}
@push('styles')
<style>
.tracking-wrapper {
    display: flex;
    justify-content: space-between;
    position: relative;
    margin-top: 20px;
}

.tracking-step {
    text-align: center;
    position: relative;
    width: 16%;
}

.tracking-step .circle {
    width: 34px;
    height: 34px;
    border-radius: 50%;
    border: 3px solid #dcdcdc;
    margin: 0 auto;
    background: #fff;
    display: flex;
    justify-content: center;
    align-items: center;
    font-size: 14px;
    color: transparent;
}

.tracking-step .circle.active {
    background: var(--primary);
    border-color: var(--primary);
    color: #fff;
}

.tracking-step .label {
    margin-top: 8px;
    font-size: 13px;
    color: #777;
    font-weight: 600;
}

.tracking-step .label.active {
    color: var(--primary);
}

.tracking-step .line {
    height: 3px;
    width: 100%;
    background: #dcdcdc;
    position: absolute;
    top: 17px;
    left: 70%;
    z-index: -1;
}

.tracking-step .line.active {
    background: var(--primary);
}
</style>
@endpush
