@extends('layouts.layoutMaster')
@section('title', 'My Services')

@section('content')

<div class="d-flex justify-content-between align-items-center my-4">
    <h3 class="fw-bold">My Services</h3>
    <div>
        <a href="{{ route('vendor.services.create') }}" class="btn btn-success">
            <i class="fa fa-plus"></i> Add Service
        </a>
        <a href="#" class="btn btn-outline-secondary">Reports</a>
    </div>
</div>

{{-- SEARCH BAR --}}
<form method="GET" class="mb-4">
    <div class="input-group">
        <input 
            type="text" 
            name="q" 
            class="form-control"
            placeholder="Search services..." 
            value="{{ request('q') }}"
        >
        <button class="btn btn-primary">
            <i class="fa fa-search"></i> Search
        </button>
    </div>
</form>


{{-- SERVICES TABLE --}}
<div class="card shadow-sm">
    <div class="card-body p-0">
        <table class="table table-hover table-striped mb-0 align-middle">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Thumbnail</th>
                    <th>Name</th>
                    <th>Price</th>
                    <th>Type</th>
                    <th>Approval</th>
                    <th>Status</th>
                    <th width="180">Actions</th>
                </tr>
            </thead>

            <tbody>
            @forelse($services as $s)
                @php 
                    $primaryImg = $s->images->where('is_primary', true)->first();
                @endphp

                <tr>
                    {{-- ID --}}
                    <td class="fw-bold">{{ $s->id }}</td>

                    {{-- THUMBNAIL --}}
                    <td style="width: 80px;">
                        <img
                            src="{{ $primaryImg ? asset('storage/'.$primaryImg->path) : asset('assets/images/placeholder.png') }}"
                            class="rounded"
                            style="width:60px;height:60px;object-fit:cover;"
                            alt="service-img"
                        >
                    </td>

                    {{-- NAME --}}
                    <td class="fw-semibold">
                        {{ $s->name }}
                    </td>

                    {{-- PRICE --}}
                    <td>
                        <span class="text-success fw-bold">
                            BHD{{ number_format($s->price, 2) }}
                        </span>
                        @if ($s->offer_price)
                            <br>
                            <small class="text-muted">
                                Offer: BHD{{ number_format($s->offer_price, 2) }}
                            </small>
                        @endif
                    </td>

                    {{-- TYPE --}}
                    <td>{{ ucfirst($s->service_type) }}</td>

                    {{-- APPROVAL STATUS --}}
                    <td>
                        <span class="badge 
                            @if($s->approval_status == 'approved') bg-success
                            @elseif($s->approval_status == 'pending') bg-warning text-dark
                            @else bg-danger @endif">
                            {{ ucfirst($s->approval_status) }}
                        </span>
                    </td>

                    {{-- ACTIVE / INACTIVE --}}
                    <td>
                        <form action="{{ route('vendor.services.update', $s->id) }}" method="POST">
                            @csrf @method('PUT')
                            <input type="hidden" name="is_active" value="{{ $s->is_active ? 0 : 1 }}">
                            <button 
                                class="btn btn-sm {{ $s->is_active ? 'btn-success' : 'btn-secondary' }}">
                                {{ $s->is_active ? 'Active' : 'Inactive' }}
                            </button>
                        </form>
                    </td>

                    {{-- ACTIONS --}}
                    <td>

                        {{-- EDIT --}}
                        <a href="{{ route('vendor.services.update', $s->id) }}" 
                           class="btn btn-sm btn-primary">
                            <i class="fa fa-edit"></i> Edit
                        </a>

                        {{-- DELETE --}}
                        <form 
                            action="{{ route('vendor.services.destroy', $s->id) }}" 
                            method="POST"
                            class="d-inline"
                            onsubmit="return confirm('Delete this service?');"
                        >
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-danger">
                                <i class="fa fa-trash">Delete</i>
                            </button>
                        </form>

                    </td>
                </tr>

            @empty
                <tr>
                    <td colspan="8" class="text-center py-4">
                        <img src="{{ asset('assets/images/empty-cart.png') }}" 
                             width="120" class="mb-3">
                        <h5>No services found.</h5>
                    </td>
                </tr>
            @endforelse
            </tbody>

        </table>
    </div>
</div>

{{-- PAGINATION --}}
<div class="mt-3">
    {{ $services->links() }}
</div>

@endsection
