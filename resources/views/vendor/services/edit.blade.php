@extends('layouts.layoutMaster')
@section('title', 'Edit Service')

@section('content')

<div class="container py-4">

    <h3 class="fw-bold mb-3">Edit Service</h3>

    {{-- SUCCESS --}}
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- ERRORS --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Fix the following errors:</strong>
            <ul class="mb-0">
                @foreach ($errors->all() as $e)
                    <li>{{ $e }}</li>
                @endforeach
            </ul>
        </div>
    @endif


    <form action="{{ route('vendor.services.update', $service->id) }}" 
          method="POST" enctype="multipart/form-data" 
          class="card shadow-sm p-4">

        @csrf 
        @method('PUT')


        {{-- ======================
             BASIC INFO
        ======================= --}}
        <h5 class="fw-bold mb-3">Basic Information</h5>

        <div class="mb-3">
            <label class="form-label">Service Name *</label>
            <input type="text" 
                   name="name" 
                   value="{{ old('name', $service->name) }}" 
                   class="form-control" required>
        </div>


        <div class="mb-3">
            <label class="form-label">Category *</label>
            <select name="category_id" class="form-select" required>
                <option value="">-- Select Category --</option>
                @foreach ($categories as $cat)
                    <option value="{{ $cat->id }}" 
                        @selected(old('category_id', $service->category_id) == $cat->id)>
                        {{ $cat->name }}
                    </option>
                @endforeach
            </select>
        </div>


        {{-- ======================
             PRICING
        ======================= --}}
        <h5 class="fw-bold mt-4 mb-3">Pricing</h5>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label">Base Price (BHD) *</label>
                <input type="number" 
                       name="price" 
                       step="0.01" 
                       class="form-control" 
                       required
                       value="{{ old('price', $service->price) }}">
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label">Offer Price (Optional)</label>
                <input type="number"
                       name="offer_price"
                       step="0.01"
                       class="form-control"
                       value="{{ old('offer_price', $service->offer_price) }}">
            </div>
        </div>


        {{-- ======================
             SERVICE DETAILS
        ======================= --}}
        <h5 class="fw-bold mt-4 mb-3">Service Details</h5>

        <div class="row mb-3">
            <div class="col-md-6 mb-3">
                <label class="form-label">Service Type *</label>
                <select name="service_type" class="form-select">
                    <option value="offline" @selected($service->service_type == 'offline')>Offline</option>
                    <option value="online" @selected($service->service_type == 'online')>Online</option>
                    <option value="both" @selected($service->service_type == 'both')>Both</option>
                </select>
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label">Duration (minutes)</label>
                <input type="number"
                       name="duration_minutes"
                       class="form-control"
                       placeholder="e.g. 60"
                       value="{{ old('duration_minutes', $service->duration_minutes) }}">
            </div>
        </div>


        {{-- AVAILABLE DAYS --}}
        <div class="mb-3">
            <label class="form-label">Available Days</label>
            <div class="card p-3">
                @php 
                    $days = ['monday','tuesday','wednesday','thursday','friday','saturday','sunday'];
                    $selectedDays = old('available_days', $service->available_days ?? []);
                @endphp

                @foreach($days as $d)
                    <label class="me-3">
                        <input type="checkbox" 
                            name="available_days[]" 
                            value="{{ $d }}"
                            @checked(in_array($d, $selectedDays))>
                        {{ ucfirst($d) }}
                    </label>
                @endforeach
            </div>
        </div>


        {{-- DESCRIPTIONS --}}
        <div class="mb-3">
            <label class="form-label">Short Description</label>
            <input type="text"
                   name="short_description"
                   class="form-control"
                   value="{{ old('short_description', $service->short_description) }}">
        </div>

        <div class="mb-3">
            <label class="form-label">Full Description</label>
            <textarea name="description" 
                      class="form-control" 
                      rows="6">{{ old('description', $service->description) }}</textarea>
        </div>


        {{-- ======================
             MEDIA
        ======================= --}}
        <h5 class="fw-bold mt-4 mb-3">Images</h5>

        {{-- UPLOAD NEW --}}
        <div class="mb-3">
            <label class="form-label">Upload New Images</label>
            <input type="file" 
                   name="gallery[]" 
                   multiple accept="image/*" 
                   class="form-control">
        </div>


        {{-- EXISTING IMAGES --}}
        @if ($service->images->count())
            <div class="mb-3">
                <label class="form-label">Existing Images</label>
                <div class="d-flex flex-wrap">

                    @foreach ($service->images as $img)
                        <div class="m-2 text-center">
                            <img src="{{ asset('storage/' . $img->path) }}"
                                 style="width:120px;height:120px;object-fit:cover;border-radius:6px;">

                            <div class="mt-1">
                                <label class="d-block">
                                    <input type="checkbox" 
                                           name="remove_image_ids[]" 
                                           value="{{ $img->id }}">
                                    Remove
                                </label>
                            </div>

                            @if ($img->is_primary)
                                <span class="badge bg-primary mt-1">Primary</span>
                            @endif
                        </div>
                    @endforeach

                </div>
            </div>
        @endif


        {{-- ======================
             TAX / HSN
        ======================= --}}
        <h5 class="fw-bold mt-4 mb-3">Tax & Invoice</h5>

        <div class="mb-3">
            <label class="form-label">HSN Code</label>
            <input type="text" 
                   name="hsn" 
                   class="form-control"
                   value="{{ old('hsn', $service->hsn) }}">
        </div>


        {{-- ======================
             ACTIVE STATUS
        ======================= --}}
        <h5 class="fw-bold mt-4 mb-3">Status</h5>

        <div class="mb-3">
            <label class="form-label d-block">Active?</label>

            <label class="me-3">
                <input type="radio" name="is_active" value="1" @checked($service->is_active)>
                Yes
            </label>

            <label>
                <input type="radio" name="is_active" value="0" @checked(!$service->is_active)>
                No
            </label>
        </div>


        <button type="submit" class="btn btn-primary btn-lg">
            <i class="fa fa-save"></i> Update Service
        </button>

    </form>
</div>

@endsection
