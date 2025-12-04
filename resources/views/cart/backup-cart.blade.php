@extends('layouts.theme')
@section('title','Cart')
@section('content')

<div class="container cart-container">

    <h2 class="cart-title">Your Cart</h2>

    {{-- EMPTY CART --}}
    @if($cart->isEmpty())
        <div class="cart-empty-box">
            <img src="/assets/images/empty-cart.png" class="empty-cart-img">
            <h3>Your Cart is Empty</h3>
            <p>Looks like you haven't added anything yet.</p>

            <a href="{{ route('shop.index') }}" class="btn-main">Start Shopping</a>
        </div>
    @else

    <div class="cart-grid">

        {{-- LEFT: ITEM LIST --}}
        <section class="cart-left">

            {{-- TOP BAR --}}
            <div class="cart-topbar">

                <label class="check-enhanced">
                    <input type="checkbox" id="selectAll">
                    <span class="checkmark"></span>
                    Select All
                </label>

                <div class="cart-top-actions">
                    <form class="coupon-form" onsubmit="return false;">
                        <input type="text" placeholder="Coupon code" class="coupon-input">
                        <button class="btn-main">Apply</button>
                    </form>

                    <form action="{{ route('cart.clear') }}" method="POST">
                        @csrf @method('DELETE')
                        <button class="btn-main btn-danger">Clear All</button>
                    </form>
                </div>
            </div>

            {{-- CART ITEMS --}}
            <div class="cart-item-list">

                @php $total = 0; @endphp

                @foreach($cart as $item)
                    @php
                        $product = $item->product;
                        $image = $product->images->first()
                                ? asset('storage/'.$product->images->first()->path)
                                : asset('/assets/images/placeholder.png');

                        $line = $item->price * $item->quantity;
                        $total += $line;
                    @endphp

                <div class="cart-item card-glass" data-id="{{ $item['id'] }}" data-price="{{ $item['price'] }}">

                    {{-- LEFT SIDE: checkbox + image + meta + remove --}}
                    <div class="ci-left">

                        <label class="check-enhanced">
                            <input type="checkbox" class="item-check" data-id="{{ $item['id'] }}">
                            <span class="checkmark"></span>
                        </label>

                        <div class="ci-thumb">
                            <img src="{{ $image }}" alt="{{ $product->name }}">
                        </div>

                        <div class="ci-meta">
                            <h4>{{ $product->name }}</h4>
                            <span class="sku">SKU: {{ $product->sku ?? 'N/A' }}</span>
                        </div>

                        <form action="{{ route('cart.remove', $item['id']) }}" method="POST" class="ci-remove">
                            @csrf @method('DELETE')
                            <button class="trash-btn"><i class="fa-regular fa-trash-can"></i></button>
                        </form>
                    </div>

                    {{-- PRICE --}}
                    <div class="ci-price">
                        <label>Price</label>
                        <div>BHD {{ number_format($item->price,3) }}</div>
                    </div>

                    {{-- QUANTITY --}}
                    <div class="ci-qty">
                        <label>Qty</label>

                        <form class="qty-form" action="{{ route('cart.update',$item['id']) }}" method="POST">
                            @csrf 

                            <div class="qty-box">
                                <button type="button" class="qty-dec">−</button>
                                <input type="number" name="qty" class="qty-input" min="1" value="{{ $item->quantity }}">
                                <button type="button" class="qty-inc">+</button>
                            </div>

                            <button type="submit" class="qty-save">Save</button>
                        </form>
                    </div>

                    {{-- SUBTOTAL --}}
                    <div class="ci-sub">
                        <label>Subtotal</label>
                        <div>BHD <span class="line-amount">{{ number_format($line,3) }}</span></div>
                    </div>

                </div> {{-- end item --}}

                @endforeach

            </div>
        </section>

        {{-- RIGHT SIDE: TOTAL SUMMARY --}}
        <aside class="cart-right">
            <div class="summary-box">

                <h3>Order Summary</h3>

                <div class="sum-row">
                    <span>Total Items</span>
                    <strong id="sum-items">{{ $cart->sum('quantity') }} Items</strong>
                </div>

                <div class="sum-row">
                    <span>Subtotal</span>
                    <strong id="sum-subtotal">BHD {{ number_format($total,3) }}</strong>
                </div>

                <p class="sum-note">Final shipping & taxes calculated at checkout.</p>

                <a href="{{ route('checkout.index') }}" class="btn-main full">Proceed to Checkout</a>
            </div>
        </aside>

    </div>

    @endif
</div>

@push('styles')
<style>
  /* ---------------------------------------
   BUTTON SYSTEM (custom, NOT rts-btn)
---------------------------------------- */
.btn-main {
    background: linear-gradient(135deg, #ffa200, #ff7a00);
    color: #fff !important;
    padding: 12px 22px;
    border-radius: 12px;
    font-weight: 700;
    border: none;
    display: inline-block;
    cursor: pointer;
    transition: .25s;
    box-shadow: 0 6px 16px rgba(255,122,0,0.22);
}
.btn-main:hover {
    transform: translateY(-2px);
    background: linear-gradient(135deg, #ff9500, #ff6300);
}
.btn-danger { background:#dc2626 !important; }

/* ---------------------------------------
   PAGE STRUCTURE
---------------------------------------- */
.cart-container { margin-top:28px; }

.cart-title {
    font-size:28px;
    font-weight:800;
    color:#0f172a;
    margin-bottom:20px;
}

/* ---------------------------------------
   EMPTY STATE
---------------------------------------- */
.cart-empty-box {
    text-align:center;
    padding:40px 20px;
    background:#fff;
    border-radius:16px;
}
.empty-cart-img { width:240px; }

/* ---------------------------------------
   GRID LAYOUT
---------------------------------------- */
.cart-grid {
    display:grid;
    grid-template-columns: 1fr 340px;
    gap:30px;
}
@media(max-width:900px){
    .cart-grid { grid-template-columns: 1fr; }
}

/* ---------------------------------------
   CART LEFT PANEL
---------------------------------------- */
.cart-topbar {
    display:flex;
    justify-content:space-between;
    flex-wrap:wrap;
    margin-bottom:18px;
    gap:12px;
}
.cart-top-actions { display:flex; gap:10px; flex-wrap:wrap; }

/* coupon field */
.coupon-input {
    padding:10px 14px;
    border-radius:14px;
    border:1px solid #ddd;
    outline:none;
}

/* ---------------------------------------
   ENHANCED CHECKBOX
---------------------------------------- */
.check-enhanced {
    display:flex;
    align-items:center;
    gap:8px;
    cursor:pointer;
}
.check-enhanced input { opacity:0; position:absolute; }
.check-enhanced .checkmark {
    width:18px;
    height:18px;
    border-radius:6px;
    border:2px solid #ffa200;
}
.check-enhanced input:checked + .checkmark {
    background:#ffa200;
}

/* ---------------------------------------
   CART ITEM (Glassy card)
---------------------------------------- */
.card-glass {
    background:rgba(255,255,255,0.38);
    border-radius:20px;
    padding:18px;
    border:1px solid rgba(255,255,255,0.4);
    backdrop-filter:blur(14px);
    display:grid;
    grid-template-columns: 1.7fr 1fr 1fr 1fr;
    align-items:center;
    gap:18px;
    margin-bottom:16px;
    box-shadow:0 10px 25px rgba(0,0,0,0.06);
}
@media(max-width:800px){
    .card-glass { grid-template-columns: 1fr 1fr; }
}
@media(max-width:560px){
    .card-glass { grid-template-columns: 1fr; }
}

/* LEFT INFO */
.ci-left { display:flex; align-items:center; gap:12px; }

.ci-thumb {
    width:70px; height:70px;
    background:#fff;
    border-radius:12px;
    display:flex; align-items:center; justify-content:center;
    overflow:hidden;
}
.ci-thumb img { width:100%; height:100%; object-fit:contain; }

.ci-meta h4 { margin:0; font-size:15px; font-weight:700; }
.sku { color:#64748b; font-size:12px; }

/* REMOVE BUTTON */
.trash-btn {
    background:none;
    border:none;
    font-size:20px;
    color:#dc2626;
    cursor:pointer;
}
.trash-btn:hover { color:#b91c1c; }

/* ---------------------------------------
   PRICE, QTY, SUBTOTAL
---------------------------------------- */
.ci-price label,
.ci-qty label,
.ci-sub label{
    font-size:12px;
    color:#6b7280;
    margin-bottom:4px;
    display:block;
}

/* quantity box */
.qty-box {
    display:flex;
    align-items:center;
    background:#fff;
    border:1px solid #e2e8f0;
    border-radius:12px;
}
.qty-box button {
    width:34px;
    height:34px;
    font-size:20px;
    background:#fff;
    border:none;
    cursor:pointer;
}
.qty-input {
    width:60px;
    border:none;
    text-align:center;
    font-size:16px;
    font-weight:700;
}

/* save btn */
.qty-save {
    margin-top:6px;
    padding:6px 12px;
    background:#16a34a;
    border-radius:8px;
    color:#fff;
    border:none;
}

/* ---------------------------------------
   RIGHT SUMMARY BOX
---------------------------------------- */
.cart-right { height:fit-content; }

.summary-box {
    background:#fff;
    padding:22px;
    border-radius:20px;
    border:1px solid #eee;
    box-shadow:0 10px 32px rgba(0,0,0,0.06);
}

.summary-box h3 {
    margin:0 0 14px 0;
    font-size:20px;
    font-weight:800;
}

.sum-row {
    display:flex;
    justify-content:space-between;
    margin-bottom:10px;
}

.sum-note {
    color:#64748b;
    font-size:13px;
    margin: 10px 0 18px 0;
}

.full { width:100%; text-align:center; display:block; }

/* ---------------------------------------
   BUTTON RESPONSIVENESS
---------------------------------------- */

.btn-main {
    width: auto;
    max-width: 100%;
    white-space: nowrap;
}

@media (max-width: 520px) {
    .btn-main {
        width: 100%;
        text-align: center;
        padding: 14px 18px;
        font-size: 15px;
    }

    .qty-save {
        width: 100%;
        font-size: 14px;
        padding: 8px 14px;
    }
}

/* Improve Save button style */
.qty-save {
    font-weight: 700 !important;
    letter-spacing: 0.3px;
}

/* ---------------------------------------
   ORDER SUMMARY – increase height/spacing
---------------------------------------- */

.summary-box {
    padding: 28px;
    border-radius: 24px;
}

.summary-box h3 {
    margin-bottom: 20px;
}

.sum-row {
    margin-bottom: 14px;
}

/* ---------------------------------------
   ENHANCED CHECKBOX (Tick Visible)
---------------------------------------- */

.check-enhanced {
    position: relative;
}

.check-enhanced input {
    position: absolute;
    opacity: 0;
    cursor: pointer;
    width: 20px;
    height: 20px;
}

.check-enhanced .checkmark {
    width: 20px;
    height: 20px;
    border-radius: 6px;
    border: 2px solid #ffa200;
    position: relative;
    display: inline-block;
}

.check-enhanced input:checked + .checkmark {
    background: #ffa200;
}

.check-enhanced input:checked + .checkmark::after {
    content: "✔";
    position: absolute;
    color: white;
    font-size: 14px;
    font-weight: 900;
    left: 3px;
    top: -2px;
}

/* ---------------------------------------
   CART RIGHT BUTTON RESPONSIVE
---------------------------------------- */
.full {
    width: 100%;
    padding: 14px;
    border-radius: 12px;
    font-size: 16px;
}

@media (max-width: 520px) {
    .full {
        padding: 16px;
        font-size: 17px;
    }
}

    </style>
@endpush
@push('scripts')
<script>
document.addEventListener("click", e => {

    // Increase quantity
    if (e.target.closest(".qty-inc")) {
        let input = e.target.closest(".qty-box").querySelector(".qty-input");
        input.value = parseInt(input.value) + 1;
    }

    // Decrease quantity
    if (e.target.closest(".qty-dec")) {
        let input = e.target.closest(".qty-box").querySelector(".qty-input");
        input.value = Math.max(1, parseInt(input.value) - 1);
    }
});
// Recalculate summary when selected items change
function updateSummary() {
    const selected = [...document.querySelectorAll(".item-check:checked")];

    let totalItems = 0;
    let subtotal = 0;

    if (selected.length === 0) {
        // Use full cart
        document.querySelectorAll(".cart-item").forEach(item => {
            let qty = parseInt(item.querySelector(".qty-input").value);
            let price = parseFloat(item.dataset.price);

            totalItems += qty;
            subtotal += qty * price;
        });
    } else {
        // Only selected items
        selected.forEach(chk => {
            const item = chk.closest(".cart-item");
            let qty = parseInt(item.querySelector(".qty-input").value);
            let price = parseFloat(item.dataset.price);

            totalItems += qty;
            subtotal += qty * price;
        });
    }

    document.getElementById("sum-items").textContent = totalItems + " Items";
    document.getElementById("sum-subtotal").textContent = "BHD " + subtotal.toFixed(3);
}

// Checkbox triggers summary update
document.addEventListener("change", e => {
    if (e.target.classList.contains("item-check") || e.target.id === "selectAll") {
        updateSummary();
    }
});

// Select All checkbox
document.getElementById("selectAll")?.addEventListener("change", function () {
    const all = document.querySelectorAll(".item-check");
    all.forEach(c => c.checked = this.checked);
    updateSummary();
});

// Recalculate summary when quantities change
document.addEventListener("input", e => {
    if (e.target.classList.contains("qty-input")) updateSummary();
});



</script>
@endpush
@endsection
