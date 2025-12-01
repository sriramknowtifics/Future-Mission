@extends('layouts.layoutMaster')
@section('title', 'Pending Services')

@section('content')

<div class="d-flex justify-content-between align-items-center my-4">
    <h3 class="fw-bold">Pending Service Approvals</h3>

    <a href="{{ route('admin.services.index') }}" class="btn btn-outline-secondary">
        <i class="fa fa-list"></i> View All Services
    </a>
</div>

<div class="card shadow-sm">
    <div class="card-body p-0">

        <table class="table table-hover table-striped mb-0 align-middle">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Image</th>
                    <th>Service</th>
                    <th>Vendor</th>
                    <th>Category</th>
                    <th>Price</th>
                    <th>Submitted</th>
                    <th width="200">Actions</th>
                </tr>
            </thead>

            <tbody>

            @forelse ($services as $s)

                @php
                    $primaryImg = $s->images->where('is_primary', true)->first();
                @endphp

                <tr>

                    {{-- ID --}}
                    <td class="fw-bold">{{ $s->id }}</td>

                    {{-- IMAGE --}}
                    <td style="width:80px;">
                        <img src="{{ $primaryImg 
                            ? asset('storage/'.$primaryImg->path) 
                            : asset('assets/images/placeholder.png') }}"
                             class="rounded"
                             style="width:60px;height:60px;object-fit:cover;">
                    </td>

                    {{-- SERVICE NAME --}}
                    <td class="fw-semibold">{{ $s->name }}</td>

                    {{-- VENDOR --}}
                    <td>
                        {{ $s->vendor->shop_name 
                            ?? ($s->vendor->user->name ?? 'Unknown') }}
                    </td>

                    {{-- CATEGORY --}}
                    <td>{{ $s->category->name ?? 'Uncategorized' }}</td>

                    {{-- PRICE --}}
                    <td>
                        <span class="text-success fw-bold">
                            BHD{{ number_format($s->price, 2) }}
                        </span>
                        @if ($s->offer_price)
                            <br><small class="text-muted">
                                Offer: BHD{{ number_format($s->offer_price, 2) }}
                            </small>
                        @endif
                    </td>

                    {{-- DATE --}}
                    <td>{{ $s->created_at->diffForHumans() }}</td>

                    {{-- ACTIONS --}}
                    <td>

                        {{-- APPROVE --}}
                        <form 
                            action="{{ route('admin.services.approve', $s->id) }}"
                            method="POST"
                            class="d-inline">
                            @csrf
                            <button class="btn btn-sm btn-success">
                                <i class="fa fa-check"></i> Approve
                            </button>
                        </form>

                        {{-- REJECT BUTTON (modal trigger) --}}
                        <button 
                            class="btn btn-sm btn-danger"
                            data-bs-toggle="modal"
                            data-bs-target="#rejectModal"
                            data-service-id="{{ $s->id }}">
                            <i class="fa fa-times"></i> Reject
                        </button>

                    </td>

                </tr>

            @empty

                <tr>
                    <td colspan="8" class="text-center py-4">
                        <img src="{{ asset('assets/images/empty-cart.png') }}" width="120" class="mb-3">
                        <h5>No pending services.</h5>
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


{{-- ================================
        REJECT MODAL
================================ --}}
<div class="modal fade" id="rejectModal" tabindex="-1">
  <div class="modal-dialog">
    <form method="POST" id="rejectForm">
      @csrf
      <div class="modal-content">

        <div class="modal-header bg-danger text-white">
          <h5 class="modal-title">Reject Service</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
        </div>

        <div class="modal-body">
          <label class="form-label fw-bold">Reason (optional)</label>
          <textarea name="reason" rows="3" class="form-control"
                    placeholder="Reason for rejection..."></textarea>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-danger">Reject</button>
        </div>

      </div>
    </form>
  </div>
</div>

@endsection


@push('scripts')
<script>
    // Auto-fill reject form dynamically
    const rejectModal = document.getElementById('rejectModal');
    rejectModal.addEventListener('show.bs.modal', function (e) {
        const serviceId = e.relatedTarget.getAttribute('data-service-id');
        document.getElementById('rejectForm').action = "/admin/services/reject/" + serviceId;
    });
</script>
@endpush
