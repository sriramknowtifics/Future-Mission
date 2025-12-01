@extends('layouts.layoutMaster')
@section('title', 'Edit Product')

@section('content')

<div class="container py-4">

    <h3 class="fw-bold mb-3">Edit Product</h3>

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

    <form 
        action="{{ route('vendor.products.update', $product->id) }}" 
        method="POST" 
        enctype="multipart/form-data" 
        class="card shadow-sm p-4">

        @csrf
        @method('PUT')

        {{-- Hidden: Product Type --}}
        <input type="hidden" name="type" value="{{ old('type', $product->type) }}">

        {{-- ======================
             BASIC INFORMATION
        ======================= --}}
        <h5 class="fw-bold">Basic Information</h5>

        <div class="mb-3">
            <label class="form-label">Product Name *</label>
            <input name="name" class="form-control"
                value="{{ old('name', $product->name) }}" required>
        </div>

        <div class="row">
            {{-- CATEGORY --}}
            <div class="col-md-6 mb-3">
                <label class="form-label">Category</label>
                <select name="category_id" class="form-select">
                    <option value="">-- Select --</option>
                    @foreach ($categories as $cat)
                        <option value="{{ $cat->id }}"
                            @selected(old('category_id', $product->category_id) == $cat->id)>
                            {{ $cat->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- BRAND --}}
            <div class="col-md-6 mb-3">
                <label class="form-label">Brand (optional)</label>
                <select name="brand_id" class="form-select">
                    <option value="">-- Select --</option>
                    @foreach ($brands as $b)
                        <option value="{{ $b->id }}"
                            @selected(old('brand_id', $product->brand_id) == $b->id)>
                            {{ $b->name }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        {{-- SHORT DESCRIPTION --}}
        <div class="mb-3">
            <label class="form-label">Short Description</label>
            <input name="short_description"
                class="form-control"
                value="{{ old('short_description', $product->short_description) }}">
        </div>

        {{-- FULL DESCRIPTION --}}
        <div class="mb-3">
            <label class="form-label">Full Description</label>
            <textarea name="description" class="form-control" rows="5">
                {{ old('description', $product->description) }}
            </textarea>
        </div>

        {{-- ======================
              PRICING
        ======================= --}}
        <h5 class="mt-4 fw-bold">Pricing</h5>

        <div class="row mb-3">
            <div class="col-md-4">
                <label class="form-label">Price (BHD)</label>
                <input name="price" type="number" step="0.01" class="form-control"
                    value="{{ old('price', $product->price) }}" required>
            </div>

            <div class="col-md-4">
                <label class="form-label">Offer Price (optional)</label>
                <input name="offer_price" type="number" step="0.01" class="form-control"
                    value="{{ old('offer_price', $product->offer_price) }}">
            </div>

            <div class="col-md-4">
                <label class="form-label">Stock</label>
                <input name="stock" type="number" class="form-control"
                    value="{{ old('stock', $product->stock) }}">
            </div>
        </div>

        {{-- SKU --}}
        <div class="mb-3">
            <label class="form-label">SKU (optional)</label>
            <input name="sku" class="form-control"
                value="{{ old('sku', $product->sku) }}">
        </div>

        {{-- ======================
              SERVICE META (if type == service)
        ======================= --}}
        @if ($product->type === 'service')
            <h5 class="mt-4 fw-bold">Service Details</h5>

            <div class="row mb-3">
                <div class="col-md-4">
                    <label class="form-label">Service Duration</label>
                    <input name="service_duration" class="form-control"
                        value="{{ old('service_duration', $product->service_meta['duration'] ?? '') }}">
                </div>

                <div class="col-md-4">
                    <label class="form-label">Location</label>
                    <input name="service_location" class="form-control"
                        value="{{ old('service_location', $product->service_meta['location'] ?? '') }}">
                </div>

                <div class="col-md-4">
                    <label class="form-label">Working Hours</label>
                    <input name="service_hours" class="form-control"
                        value="{{ old('service_hours', $product->service_meta['hours'] ?? '') }}">
                </div>
            </div>
        @endif

        {{-- ======================
              MEDIA: IMAGES
        ======================= --}}
        <h5 class="mt-4 fw-bold">Images</h5>

        <div class="mb-3">
            <label class="form-label">Upload New Images</label>
            <input type="file" name="images[]" multiple accept="image/*" class="form-control">
        </div>

        {{-- Existing images --}}
        @if ($product->images->count())
            <div class="mb-3">
                <label class="form-label">Existing Images</label>
                <div class="d-flex flex-wrap">
                    @foreach ($product->images as $img)
                        <div class="m-2 text-center">
                            <img src="{{ asset('storage/' . $img->path) }}"
                                class="rounded"
                                style="width:110px; height:110px; object-fit:cover; border:1px solid #ddd;">
                            
                            <div class="mt-1">
                                <label class="d-block">
                                    <input type="checkbox" name="remove_image_ids[]" value="{{ $img->id }}">
                                    Remove
                                </label>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        {{-- ======================
              ACTIVE / STATUS
        ======================= --}}
        <h5 class="mt-4 fw-bold">Status</h5>

        <div class="form-check mb-3">
            <input type="checkbox" 
                   class="form-check-input" 
                   name="is_active" 
                   id="is_active"
                   value="1"
                   @checked(old('is_active', $product->is_active))>

            <label class="form-check-label" for="is_active">
                Active (visible after approval)
            </label>
        </div>

        {{-- SUBMIT --}}
        <button class="btn btn-primary btn-lg">
            Update Product
        </button>

    </form>
</div>

@endsection
