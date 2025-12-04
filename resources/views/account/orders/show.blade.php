@extends('layouts.theme')
 
@section('title', 'Order Details')
 
@section('content')
 
{{-- ===========================================
     ORDER HERO / HEADER - PREMIUM
=========================================== --}}
<div class="order-hero mb-4">
    <div class="order-hero-inner">
        <div class="order-meta">
            <h2 class="order-number">Order <span>#{{ $order->order_number }}</span></h2>
            <p class="order-date text-muted">Placed on {{ $order->created_at->format('d M Y, h:i A') }}</p>
        </div>
 
        <div class="order-status-block">
            <div class="status-pill status-{{ $order->status }}">
                <strong>{{ ucfirst($order->status) }}</strong>
            </div>
            <div class="order-actions">
                {{-- keep logic intact; only styling --}}
                @if(in_array($order->status, ['pending', 'paid']))
                    <form action="{{ route('account.orders.cancel', $order->id) }}" method="POST" class="d-inline">
                        @csrf
                        <button class="btn cancel-btn">Cancel Order</button>
                    </form>
                @endif
            </div>
        </div>
    </div>
</div>
 
 
{{-- ===========================================
     ORDER TRACKING TIMELINE - PREMIUM
=========================================== --}}
<div class="card premium-card mb-4">
    <div class="card-body">
        <h4 class="premium-title mb-3">Order Tracking</h4>
 
        @php
            $steps = ['pending', 'confirmed', 'processing', 'packed', 'shipped', 'delivered'];
            $currentIndex = array_search($order->status, $steps);
        @endphp
 
        <div class="tracking-wrapper-modern">
            {{-- background progress bar --}}
            <div class="progress-line">
                <div class="progress-fill" style="width: {{ ($currentIndex / (count($steps)-1)) * 100 }}%;"></div>
            </div>
 
            @foreach($steps as $index => $step)
                @php $done = $index <= $currentIndex; @endphp
                <div class="tracking-node {{ $done ? 'done' : '' }}">
                    <div class="node-circle">
                        @if($done)
                            <i class="fa-solid fa-check"></i>
                        @else
                            <span class="node-num">{{ $index + 1 }}</span>
                        @endif
                    </div>
                    <div class="node-label">{{ ucfirst($step) }}</div>
                </div>
            @endforeach
        </div>
    </div>
</div>
 
 
{{-- ===========================================
     ITEMS + PAYMENT (two-column on wide)
=========================================== --}}
<div class="d-lg-flex gap-4">
 
    {{-- Items column (left) --}}
    <div class="flex-fill card premium-card mb-4">
        <div class="card-body">
            <h4 class="premium-title mb-3">Items</h4>
 
            <div class="premium-table-wrapper">
                <table class="table premium-table align-middle mb-0">
                    <thead>
                        <tr>
                            <th class="w-40">Product</th>
                            <th>Vendor</th>
                            <th class="text-center">Qty</th>
                            <th class="text-end">Subtotal</th>
                        </tr>
                    </thead>
 
                    <tbody>
                        @foreach($order->items as $item)
                        <tr>
                            <td>
                                <div class="product-cell">
                                    @php
                                        $img = $item->product?->thumbnail_url ?? asset('assets/images/placeholder.png');
                                    @endphp

                                    <img src="{{ $img }}" alt="{{ $item->name }}" class="product-thumb">

                                    <div class="product-info">
                                        <div class="product-name">{{ $item->name }}</div>
                                        @if(isset($item->variation) && $item->variation)
                                            <small class="text-muted">{{ $item->variation }}</small>
                                        @endif
                                    </div>
                                </div>
                            </td>
 
                            <td>{{ $item->vendor->shop_name ?? 'N/A' }}</td>
                            <td class="text-center">{{ $item->qty }}</td>
                            <td class="text-end fw-bold">BHD {{ number_format($item->subtotal, 2) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
 
    {{-- Payment Summary (right) --}}
    <aside class="card premium-card payment-card mb-4">
        <div class="card-body">
            <h4 class="premium-title mb-3">Payment Summary</h4>
 
            <div class="summary-row d-flex justify-content-between align-items-center mb-2">
                <span class="muted">Subtotal</span>
                <strong>BHD {{ number_format($order->subtotal_amount, 2) }}</strong>
            </div>
 
            <div class="summary-row d-flex justify-content-between align-items-center mb-2">
                <span class="muted">Shipping</span>
                <strong>BHD {{ number_format($order->shipping_cost, 2) }}</strong>
            </div>
 
            <div class="summary-row d-flex justify-content-between align-items-center mb-2">
                <span class="muted">Tax</span>
                <strong>BHD {{ number_format($order->tax_amount, 2) }}</strong>
            </div>
 
            <hr>
 
            <div class="summary-row d-flex justify-content-between align-items-center mb-0">
                <span class="total-label">Total</span>
                <div class="total-amount text-primary">
                    <strong>BHD {{ number_format($order->total_amount, 2) }}</strong>
                </div>
            </div>
 
            @if(in_array($order->status, ['pending', 'paid']))
                {{-- Keep the original cancel form as a fallback (styled) --}}
                <form action="{{ route('account.orders.cancel', $order->id) }}" method="POST" class="mt-3 d-none d-lg-block">
                    @csrf
                    <button class="premium-btn-primary w-100">
                        Cancel Order
                    </button>
                </form>
            @endif
        </div>
    </aside>
</div>
 
@endsection
 
 
{{-- ===========================================
     STYLES (push to styles stack)
=========================================== --}}
@push('styles')
<style>
/* ---------- Local tokens (keeps existing theme but more premium) ---------- */
:root {
    --card-bg: #ffffff;
    --muted: #7b8494;
    --accent: #ff9f00;
    --accent-soft: rgba(255,159,0,0.12);
    --accent-dark: #e08700;
    --surface: #f5f7fb;
    --border-subtle: #edf0f5;
    --shadow-soft: 0 14px 40px rgba(19, 28, 33, 0.10);
}
 
/* ---------- Global section background (only for this page block) ---------- */
.order-hero,
.premium-card {
    background: radial-gradient(circle at 0 0, rgba(255,159,0,0.08), transparent 55%),
                radial-gradient(circle at 100% 0, rgba(0,0,0,0.04), transparent 45%),
                var(--card-bg);
    border-radius: 18px;
    border: 1px solid var(--border-subtle);
    box-shadow: var(--shadow-soft);
}
 
/* ---------- Order hero ---------- */
.order-hero {
    padding: 18px 22px;
    margin-top: 8px;
}
.order-hero-inner {
    display:flex;
    align-items:center;
    justify-content:space-between;
    gap:16px;
    flex-wrap:wrap;
}
.order-number {
    margin:0;
    font-size:22px;
    font-weight:800;
    letter-spacing:0.02em;
    color:#1f252f;
}
.order-number span {
    color: var(--accent-dark);
    background: var(--accent-soft);
    padding:6px 12px;
    border-radius:999px;
    margin-left:6px;
}
.order-date {
    margin:6px 0 0;
    font-size:13px;
    color:var(--muted);
}
.order-status-block {
    display:flex;
    align-items:center;
    gap:12px;
    flex-wrap:wrap;
}
.status-pill {
    padding:8px 16px;
    border-radius:999px;
    font-size:13px;
    font-weight:700;
    background: #fff;
    border:1px solid rgba(0,0,0,0.04);
    box-shadow:0 8px 18px rgba(10,16,28,0.08);
}
.status-pill.status-pending   { color:#7a5a00; background:#fff7e6; border-color:var(--accent-soft); }
.status-pill.status-paid      { color:#0a6b4a; background:#eafaf2; }
.status-pill.status-confirmed { color:#0f4c81; background:#eaf4ff; }
.status-pill.status-processing{ color:#7a5a00; background:#fff7e6; }
.status-pill.status-packed    { color:#6b4a7a; background:#faf2ff; }
.status-pill.status-shipped   { color:#0f4c81; background:#eaf4ff; }
.status-pill.status-delivered { color:#007a3d; background:#e6fff0; }
 
.cancel-btn{
    border-radius:999px;
    padding:8px 14px;
    font-size:13px;
    font-weight:600;
    border:1px solid var(--border-subtle);
    background:#fff;
    color:var(--muted);
    transition:all .2s ease;
}
.cancel-btn:hover{
    border-color:#ffb74d;
    background:#fffaf3;
    color:#d38100;
}
 
/* ---------- Tracking timeline (more premium) ---------- */
.tracking-wrapper-modern {
    position:relative;
    padding:28px 10px 10px;
    display:flex;
    align-items:flex-start;
    justify-content:space-between;
    gap:10px;
}
 
.tracking-wrapper-modern .progress-line{
    position:absolute;
    left:44px;
    right:44px;
    top:38px;
    height:5px;
    border-radius:999px;
    background: linear-gradient(90deg, #edf0f5, #f3f5fa);
    overflow:hidden;
    z-index:0;
}
.tracking-wrapper-modern .progress-line .progress-fill{
    height:100%;
    background: linear-gradient(90deg, var(--accent), var(--accent-dark));
    border-radius:999px;
    width:100%; /* actual % width already set inline via style; this keeps smooth transition */
    transition:width .4s ease-out;
}
 
.tracking-node{
    position:relative;
    flex:1;
    z-index:1;
    text-align:center;
    display:flex;
    flex-direction:column;
    align-items:center;
    gap:6px;
}
.tracking-node .node-circle{
    width:48px;
    height:48px;
    border-radius:50%;
    border:2px solid #dfe3ef;
    background:#fff;
    display:flex;
    align-items:center;
    justify-content:center;
    box-shadow:0 10px 25px rgba(18,27,46,0.12);
    font-weight:700;
    color:#9aa3b5;
    transition:all .25s ease;
}
.tracking-node .node-num{ font-size:12px; }
.tracking-node.done .node-circle{
    background: radial-gradient(circle at 30% 0, #ffe4b3, #ff9f00);
    border-color:transparent;
    color:#fff;
    transform:translateY(-6px) scale(1.04);
}
.tracking-node .node-label{
    font-size:13px;
    font-weight:600;
    color:var(--muted);
}
.tracking-node.done .node-label{
    color:#1f252f;
}
 
/* ---------- Items & table ---------- */
.premium-title{
    font-size:15px;
    font-weight:700;
    letter-spacing:0.04em;
    text-transform:uppercase;
    color:#30384a;
}
 
.premium-table-wrapper{
    border-radius:14px;
    overflow:hidden;
    background:#fff;
}
.premium-table{
    margin-bottom:0;
}
.premium-table thead th{
    padding:14px 14px;
    font-size:12px;
    text-transform:uppercase;
    letter-spacing:0.08em;
    color:#6a3d8c;
    border-bottom:2px solid #4c1d95;
    background:linear-gradient(90deg,#faf6ff,#ffffff);
}
.premium-table tbody td{
    padding:16px 14px;
    font-size:14px;
    border-bottom:1px dashed rgba(0,0,0,0.04);
}
.premium-table tbody tr:last-child td{
    border-bottom:none;
}
.premium-table tbody tr:hover{
    background:#faf7ff;
}
 
/* Product cell */
.product-cell{
    display:flex;
    gap:12px;
    align-items:center;
}
.product-thumb{
    width:60px;
    height:60px;
    border-radius:12px;
    object-fit:cover;
    background:#f5f5f5;
    border:1px solid #eceff7;
}
.product-thumb.placeholder{
    display:inline-block;
}
.product-info .product-name{
    font-weight:700;
    color:#1f252f;
}
 
/* ---------- Layout: items + payment ---------- */
.d-lg-flex.gap-4{
    margin-bottom:0.75rem;
}
.payment-card{
    width:360px;
    max-width:100%;
    border-left:4px solid var(--accent);
    background: radial-gradient(circle at 0 0,rgba(255,159,0,0.14),transparent 55%), #ffffff;
}
.payment-card .card-body{
    padding-top:18px;
}
.summary-row .muted{
    color:var(--muted);
    font-size:14px;
}
.total-label{
    font-weight:800;
    color:#111827;
}
.total-amount{
    font-size:19px;
}
 
/* ---------- Buttons ---------- */
.premium-btn-primary{
    border-radius:999px;
    padding:11px 16px;
    border:none;
    font-weight:700;
    font-size:14px;
    background:linear-gradient(120deg,var(--accent),var(--accent-dark));
    color:#fff;
    box-shadow:0 12px 25px rgba(255,159,0,0.35);
    transition:transform .12s ease, box-shadow .12s ease, filter .12s ease;
}
.premium-btn-primary:hover{
    transform:translateY(-1px);
    filter:brightness(1.02);
    box-shadow:0 16px 32px rgba(255,159,0,0.40);
}
 
/* ---------- Utility tweaks ---------- */
.badge{border-radius:999px;padding:4px 10px;}
.text-muted{color:var(--muted)!important;}
 
@media (max-width:992px){
    .order-hero{border-radius:0;}
    .payment-card{margin-top:12px;}
}
@media (max-width:768px){
    .tracking-wrapper-modern{padding-top:40px;}
    .tracking-wrapper-modern .progress-line{
        left:34px; right:34px; top:40px;
    }
    .order-number{font-size:19px;}
}
</style>
@endpush
@push('styles')
<style>
/* ===========================
   Items & Payment — Premium Override
   Paste this AFTER your existing styles so it overrides where needed
   =========================== */
 
/* Table container - soft glass card with padding */
.premium-card .premium-table-wrapper {
  background: linear-gradient(180deg, rgba(255,255,255,0.6), rgba(255,255,255,0.9));
  border-radius: 12px;
  padding: 10px 16px 14px;
  box-shadow: 0 10px 28px rgba(19, 28, 33, 0.04);
  border: 1px solid rgba(0,0,0,0.03);
}
 
/* Table header - refined */
.premium-table thead th {
  padding: 14px 16px !important;
  font-size: 13px;
  text-transform: uppercase;
  letter-spacing: 0.06em;
  color: #4a2b52;          /* subtle purple-ish heading */
  border-bottom: 2px solid rgba(74,43,82,0.06);
  background: rgba(250,245,255,0.6);
}
 
/* Body cells - more breathing room */
.premium-table tbody td {
  padding: 18px 16px !important;
  vertical-align: middle;
  color: #1b2430;
  font-size: 14px;
}
 
/* Row hover - gentle lift */
.premium-table tbody tr {
  transition: transform .12s ease, background .12s ease, box-shadow .12s ease;
  border-radius: 8px;
}
.premium-table tbody tr:hover {
  transform: translateY(-4px);
  background: linear-gradient(90deg, rgba(250,250,252,0.8), rgba(255,255,255,0.9));
  box-shadow: 0 10px 30px rgba(19, 28, 33, 0.04);
}
 
/* Product cell - thumbnail + meta */
.product-cell {
  display:flex;
  gap:14px;
  align-items:center;
}
.product-thumb {
  width:72px;
  height:72px;
  border-radius:12px;
  object-fit:cover;
  border: 1px solid rgba(0,0,0,0.04);
  background: linear-gradient(180deg,#fafafa,#fff);
  box-shadow: 0 6px 18px rgba(19,28,33,0.04);
  transition: transform .18s ease;
}
.product-thumb.placeholder {
  display:inline-block;
  width:72px;
  height:72px;
  border-radius:12px;
  background: linear-gradient(135deg,#f3f3f5,#ffffff);
  border: 1px dashed rgba(0,0,0,0.03);
}
.product-cell:hover .product-thumb { transform: translateY(-4px) scale(1.01); }
 
/* Product info typography */
.product-info .product-name {
  font-weight:700;
  color:#0f1724;
  font-size:15px;
}
.product-info small {
  color: #7b8794;
  display:block;
  margin-top:4px;
}
 
/* Qty and subtotal alignment */
.premium-table td.text-center { text-align:center; }
.premium-table td.text-end { text-align:right; font-weight:700; color:#0b2a3a; }
 
/* Thin divider line under thead for subtle separation */
.premium-table thead th + th,
.premium-table tbody td + td { border-left: none; }
 
/* ===========================
   Payment summary — elegant card
   =========================== */
 
.payment-card {
  border-radius: 14px;
  overflow: visible;
  position: relative;
  padding: 0; /* use card-body padding only */
  background: linear-gradient(180deg, rgba(255,255,255,0.98), rgba(255,250,245,0.95));
  border: 1px solid rgba(0,0,0,0.04);
  box-shadow: 0 14px 40px rgba(19,28,33,0.06);
}
 
/* Accent stripe on the left with rounded notch */
.payment-card::before {
  content: "";
  position: absolute;
  left: -6px;
  top: 12px;
  bottom: 12px;
  width: 8px;
  background: linear-gradient(180deg, rgba(255,159,0,0.95), rgba(230,123,0,0.95));
  border-radius: 12px;
  box-shadow: 0 6px 18px rgba(230,123,0,0.08);
}
 
/* Inner body spacing */
.payment-card .card-body {
  padding: 20px;
  position: relative;
  z-index: 2;
}
 
/* Payment labels & values */
.payment-card .summary-row {
  display:flex;
  justify-content:space-between;
  align-items:center;
  gap: 12px;
  padding: 8px 0;
}
.payment-card .summary-row span {
  color: #6b7280;
  font-size:14px;
}
.payment-card .summary-row strong {
  color: #111827;
  font-size:14px;
}
 
/* Divider between totals */
.payment-card hr {
  border: none;
  border-top: 1px solid rgba(14,20,26,0.06);
  margin: 10px 0 14px;
}
 
/* Total row emphasis */
.payment-card .total-label {
  font-weight: 800;
  color: #111827;
  font-size:15px;
}
.payment-card .total-amount {
  font-size:18px;
  font-weight:900;
  color: #0866ff; /* strong blue for total */
}
 
/* Small CTA / cancel inside payment (keeps original markup) */
.payment-card .premium-btn-primary {
  margin-top: 12px;
  border-radius: 10px;
  padding: 10px 12px;
  font-weight: 800;
}
 
/* Responsive: make payment card flow well under table */
@media (max-width: 992px) {
  .premium-table thead th { font-size:12px; padding:12px; }
  .product-thumb { width:56px; height:56px; border-radius:10px; }
  .product-info .product-name { font-size:14px; }
  .payment-card { margin-top: 10px; }
}
 
/* Accessibility & small polish */
.premium-table td, .premium-table th, .payment-card span, .payment-card strong {
  -webkit-font-smoothing:antialiased;
  -moz-osx-font-smoothing:grayscale;
}
 
/* Small animation for totals to pop slightly on load */
@keyframes popIn {
  0% { transform: translateY(6px); opacity:0; }
  100% { transform: translateY(0); opacity:1; }
}
.payment-card .total-amount { animation: popIn .45s cubic-bezier(.2,.8,.2,1) both; }
 
</style>
@endpush