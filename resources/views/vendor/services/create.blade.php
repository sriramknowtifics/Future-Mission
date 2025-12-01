@extends('layouts.layoutMaster')
@section('title', 'Add Service')

@section('content')

<div class="container py-4">

    <h3 class="fw-bold mb-3">Add New Service</h3>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- ERROR DISPLAY --}}
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

    <form id="serviceForm" 
          action="{{ route('vendor.services.store') }}" 
          method="POST" 
          enctype="multipart/form-data" 
          class="card shadow-sm p-4">

        @csrf

        {{-- ======================
             BASIC INFORMATION
        ======================= --}}
        <h5 class="mb-3 fw-bold">Basic Information</h5>

        <div class="mb-3">
            <label class="form-label">Service Name *</label>
            <input type="text" 
                   name="name" 
                   class="form-control" 
                   required 
                   value="{{ old('name') }}">
        </div>

        <div class="mb-3">
            <label class="form-label">Category *</label>
            <select name="category_id" class="form-select" required>
                <option value="">-- Select category --</option>
                @foreach ($categories as $cat)
                    <option value="{{ $cat->id }}" 
                            @selected(old('category_id') == $cat->id)>
                        {{ $cat->name }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- ======================
              PRICING SECTION
        ======================= --}}
        <h5 class="mt-4 fw-bold">Pricing</h5>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label">Base Price (BHD) *</label>
                <input type="number" 
                       step="0.01" 
                       name="price" 
                       class="form-control" 
                       required
                       value="{{ old('price') }}">
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label">Offer Price (optional)</label>
                <input type="number" 
                       step="0.01" 
                       name="offer_price" 
                       class="form-control"
                       value="{{ old('offer_price') }}">
            </div>
        </div>

        {{-- ======================
            SERVICE DETAILS
        ======================= --}}
        <h5 class="mt-4 fw-bold">Service Details</h5>

        <div class="row mb-3">
            <div class="col-md-6">
                <label class="form-label">Service Type *</label>
                <select name="service_type" class="form-select" required>
                    <option value="offline">Offline</option>
                    <option value="online">Online</option>
                    <option value="both">Both</option>
                </select>
            </div>

            <div class="col-md-6">
                <label class="form-label">Duration (minutes)</label>
                <input type="number" 
                       name="duration_minutes" 
                       class="form-control"
                       placeholder="e.g. 60" 
                       value="{{ old('duration_minutes') }}">
            </div>
        </div>

        {{-- AVAILABLE DAYS --}}
        <div class="mb-3">
            <label class="form-label">Available Days (optional)</label>
            <div class="card p-3">
                @php 
                    $days = ['monday','tuesday','wednesday','thursday','friday','saturday','sunday'];
                @endphp

                @foreach($days as $day)
                    <label class="me-3">
                        <input type="checkbox" 
                               name="available_days[]" 
                               value="{{ $day }}">
                        {{ ucfirst($day) }}
                    </label>
                @endforeach
            </div>
        </div>

        {{-- SHORT DESCRIPTION --}}
        <div class="mb-3">
            <label class="form-label">Short Description</label>
            <textarea name="short_description" 
                      class="form-control" 
                      rows="3">{{ old('short_description') }}</textarea>
        </div>

        {{-- FULL DESCRIPTION --}}
        <div class="mb-3">
            <label class="form-label">Full Description</label>
            <textarea name="description" 
                      class="form-control" 
                      rows="6">{{ old('description') }}</textarea>
        </div>

        {{-- ======================
            MEDIA UPLOADS
        ======================= --}}
        <h5 class="mt-4 fw-bold">Upload Images</h5>

        {{-- THUMBNAIL --}}
        <div class="mb-3">
            <label class="form-label">Thumbnail Image *</label>
            <input type="file" 
                   name="thumbnail" 
                   accept="image/*" 
                   class="form-control" 
                   required>
        </div>

        {{-- GALLERY --}}
        <div class="mb-3">
            <label class="form-label">Gallery Images (optional)</label>
            <input type="file" 
                   name="gallery[]" 
                   multiple 
                   accept="image/*" 
                   class="form-control">
        </div>

        {{-- ======================
            INVOICE / TAX DETAILS
        ======================= --}}
        <h5 class="mt-4 fw-bold">Tax & Invoice Details</h5>

        <div class="mb-3">
            <label class="form-label">HSN Code (Optional)</label>
            <input type="text" 
                   name="hsn" 
                   class="form-control" 
                   value="{{ old('hsn') }}">
        </div>

        {{-- ======================
            STATUS
        ======================= --}}
        <h5 class="mt-4 fw-bold">Status</h5>

        <div class="mb-3">
            <label class="form-label d-block">Active?</label>
            <label class="me-3">
                <input type="radio" name="is_active" value="1" checked>
                Yes
            </label>
            <label>
                <input type="radio" name="is_active" value="0">
                No
            </label>
        </div>

        {{-- SUBMIT BUTTON --}}
        <button type="submit" class="btn btn-primary btn-lg">
            <i class="fa fa-save"></i> Save Service
        </button>

    </form>
</div>

@endsection
