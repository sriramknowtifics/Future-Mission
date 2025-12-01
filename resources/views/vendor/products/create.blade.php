@extends('layouts.layoutMaster')
@section('title', 'Add Product')

@section('content')

<div class="container py-4">

    <h3 class="fw-bold mb-4">Add New Product</h3>

    {{-- SUCCESS --}}
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- ERRORS --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Please fix the following errors:</strong>
            <ul class="mb-0">
                @foreach ($errors->all() as $e)
                    <li>{{ $e }}</li>
                @endforeach
            </ul>
        </div>
    @endif


    <form id="productForm"
          action="{{ route('vendor.products.store') }}"
          method="POST"
          enctype="multipart/form-data"
          class="card shadow-sm p-4">

        @csrf

        {{-- REQUIRED HIDDEN --}}
        <input type="hidden" name="type" value="product">



        {{-- ============================
              BASIC INFORMATION
        ============================= --}}
        <h5 class="fw-bold mb-3">Basic Information</h5>

        <div class="mb-3">
            <label class="form-label">Product Name *</label>
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
                    <option value="{{ $cat->id }}" @selected(old('category_id') == $cat->id)>
                        {{ $cat->name }}
                    </option>
                @endforeach
            </select>
        </div>



        {{-- ============================
                PRICING & STOCK
        ============================= --}}
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

        <div class="mb-3">
            <label class="form-label">Stock</label>
            <input type="number"
                   name="stock"
                   class="form-control"
                   value="{{ old('stock') }}">
        </div>

        <div class="mb-3">
            <label class="form-label">SKU (optional)</label>
            <input type="text"
                   name="sku"
                   class="form-control"
                   value="{{ old('sku') }}">
        </div>



        {{-- ============================
                DESCRIPTIONS
        ============================= --}}
        <h5 class="mt-4 fw-bold">Descriptions</h5>

        <div class="mb-3">
            <label class="form-label">Short Description (optional)</label>
            <input type="text"
                   class="form-control"
                   name="short_description"
                   value="{{ old('short_description') }}">
        </div>

        <div class="mb-3">
            <label class="form-label">Full Description</label>
            <textarea name="description"
                      class="form-control"
                      rows="6">{{ old('description') }}</textarea>
        </div>



        {{-- ============================
                IMAGE UPLOAD
        ============================= --}}
        <h5 class="mt-4 fw-bold">Product Images</h5>

        <div class="mb-3">
            <label class="form-label">Upload Images *</label>
            <input type="file"
                   name="images[]"
                   multiple
                   accept="image/*"
                   required
                   class="form-control">
            <small class="text-muted">First image will be primary</small>
        </div>



        {{-- ============================
                STATUS
        ============================= --}}
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



        {{-- ============================
               SUBMIT
        ============================= --}}
        <button type="submit" class="btn btn-primary btn-lg">
            <i class="fa fa-save"></i> Save Product
        </button>

    </form>
</div>

@endsection
