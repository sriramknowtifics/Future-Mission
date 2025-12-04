{{-- ============================================
     ADDRESS BOOK — PREMIUM VERSION
============================================= --}}

<div class="premium-card">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="premium-title mb-0">
            <i class="fa-solid fa-location-dot me-2"></i> My Addresses
        </h3>

        <button class="premium-btn-primary" data-bs-toggle="modal" data-bs-target="#addAddressModal">
            <i class="fa fa-plus me-1"></i> Add New
        </button>
    </div>

    {{-- Alerts --}}
    @if(session('success'))
        <div class="alert alert-success premium-alert">{{ session('success') }}</div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger premium-alert">
            <ul class="mb-0 ps-3">
                @foreach($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Address list --}}
    <div class="row g-4">

        @forelse($addresses as $address)
        <div class="col-md-6">
            <div class="address-box shadow-sm {{ $address->is_default ? 'address-default' : '' }}">

                <div class="d-flex justify-content-between">
                    <h5 class="fw-bold text-capitalize">
                        <i class="fa-solid fa-house me-2"></i>
                        {{ $address->type }}
                    </h5>

                    @if($address->is_default)
                        <span class="badge bg-success">Default</span>
                    @endif
                </div>

                <p class="mt-2 mb-1">
                    {{ $address->address_line }}<br>
                    {{ $address->city }}, {{ $address->state }}<br>
                    {{ $address->country }} - {{ $address->zip_code }}
                </p>

                @if($address->contact_phone)
                    <p class="small text-muted mb-2">📞 {{ $address->contact_phone }}</p>
                @endif

                <div class="d-flex justify-content-between mt-3">
                    {{-- Edit --}}
                    <button class="premium-btn-sm"
                            data-bs-toggle="modal"
                            data-bs-target="#editAddressModal{{ $address->id }}">
                        Edit
                    </button>

                    {{-- Delete --}}
                    <form action="{{ route('account.address.delete', $address->id) }}" method="POST" onsubmit="return confirm('Delete this address?')">
                        @csrf
                        @method('DELETE')
                        <button class="premium-btn-sm text-danger">Delete</button>
                    </form>

                    {{-- Make Default --}}
                    @if(!$address->is_default)
                        <form action="{{ route('account.address.default', $address->id) }}" method="POST">
                            @csrf
                            <button class="premium-btn-sm">Make Default</button>
                        </form>
                    @endif
                </div>
            </div>
        </div>

        {{-- EDIT MODAL --}}
        <div class="modal fade" id="editAddressModal{{ $address->id }}" tabindex="-1">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content premium-modal">

                    <form action="{{ route('account.address.update', $address->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="modal-header">
                            <h5 class="modal-title">Edit Address</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>

                        <div class="modal-body">
                            @include('account.partials.address_form', ['address' => $address])
                        </div>

                        <div class="modal-footer">
                            <button class="premium-btn-primary w-100">Save Changes</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>

        @empty
            <div class="col-12 text-center py-4">
                <img src="{{ asset('assets/images/empty-cart.png') }}" width="120">
                <h5 class="mt-3 text-muted">No addresses added yet</h5>
            </div>
        @endforelse

    </div>
</div>


{{-- ADD ADDRESS MODAL --}}
<div class="modal fade" id="addAddressModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content premium-modal">

            <form action="{{ route('account.address.store') }}" method="POST">
                @csrf

                <div class="modal-header">
                    <h5 class="modal-title">Add New Address</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    @include('account.partials.address_form')
                </div>

                <div class="modal-footer">
                    <button class="premium-btn-primary w-100">Add Address</button>
                </div>

            </form>
        </div>
    </div>
</div>


@push('styles')
<style>
.address-box {
    background: #fff;
    padding: 18px;
    border-radius: 16px;
    border: 1px solid #eee;
    transition: .25s;
}
.address-box:hover {
    background: #fff9ec;
    border-color: var(--primary);
    transform: translateY(-3px);
}
.address-default {
    border: 2px solid var(--primary);
    background: #fff8e6 !important;
}
.premium-modal {
    border-radius: 16px;
    padding: 0;
}
</style>
@endpush
