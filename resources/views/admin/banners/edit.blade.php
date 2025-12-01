@extends('layouts.layoutMaster')

@section('title', 'Edit Banner')

@section('content')
<style>
        .my-scalable-element {
        transition: transform 0.3s ease-in-out; /* Smooth transition */
    }

    .my-scalable-element:hover {
        transform: scale(1.1); /* Scale to 110% on hover */
    }
    </style>
<div class="container my-4">
    <h3>Edit Banner</h3>

    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>There were some problems with your input:</strong>
            <ul class="mb-0 mt-2">
                @foreach($errors->all() as $e)
                    <li>{{ $e }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.banners.update', $banner->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        {{-- Title --}}
        <div class="mb-3">
            <label class="form-label">Title *</label>
            <input type="text" name="title" value="{{ old('title', $banner->title) }}" class="form-control" required>
        </div>

        {{-- Subtitle --}}
        <div class="mb-3">
            <label class="form-label">Subtitle</label>
            <input type="text" name="subtitle" value="{{ old('subtitle', $banner->subtitle) }}" class="form-control">
        </div>

        {{-- Place --}}
        <div class="mb-3">
            <label class="form-label">Place *</label>
            <select name="place" id="place" class="form-select" required>
                <option value="">— Select Place —</option>
                <option value="1" @selected(old('place', $banner->place) == 1)>1</option>
                <option value="2" @selected(old('place', $banner->place) == 2)>2</option>
                <option value="3" @selected(old('place', $banner->place) == 3)>3</option>
                <option value="4" @selected(old('place', $banner->place) == 4)>4</option>
            </select>
        </div>

        {{-- Link URL --}}
        <div class="mb-3">
            <label class="form-label">Link URL</label>
            <input type="url" name="link_url" value="{{ old('link_url', $banner->link_url) }}" class="form-control">
        </div>

        {{-- Product Link --}}
        <div class="mb-3">
            <label class="form-label">Link to Product (optional)</label>
            <select name="product_id" class="form-select">
                <option value="">— None —</option>
                @foreach($products as $product)
                    <option value="{{ $product->id }}"
                        @selected(old('product_id', $banner->product_id) == $product->id)>
                        {{ $product->name }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Placement --}}
        <div class="mb-3">
            <label class="form-label">Placement *</label>
            <select name="placement" class="form-select" required>
                <option value="home" @selected(old('placement', $banner->placement) == 'home')>Home</option>
                <option value="category" @selected(old('placement', $banner->placement) == 'category')>Category pages</option>
                <option value="product" @selected(old('placement', $banner->placement) == 'product')>Product pages</option>
            </select>
        </div>

        {{-- Sort Order --}}
        <div class="mb-3">
            <label class="form-label">Sort Order</label>
            <input type="number" name="sort_order" value="{{ old('sort_order', $banner->sort_order) }}" class="form-control">
        </div>

        {{-- Active --}}
        <div class="mb-3 form-check">
            <input type="checkbox" class="form-check-input" id="is_active" name="is_active" value="1"
                {{ old('is_active', $banner->is_active) ? 'checked' : '' }}>
            <label for="is_active" class="form-check-label">Active</label>
        </div>

        {{-- Desktop Image --}}
        <div class="mb-3">
            <label class="form-label">Desktop Image *</label>
            <input type="file" name="desktop_image" class="form-control">
            <small id="desktop_hint" class="text-muted"></small>

            @if ($banner->desktop_image)
                <div class="mt-3">
                    <strong class='d-block mt-5 mb-2'>Current Desktop Image:</strong><br>
                    <img 
                    src="{{ asset('storage/' . $banner->desktop_image) }}"
                        class="img-fluid rounded shadow-sm border my-scalable-element"
                        style="max-width: 100%; height: auto; object-fit: cover;"
                    >

                </div>
            @endif
        </div>

        {{-- Mobile Image --}}
        <div class="mb-3">
            <label class="form-label">Mobile Image *</label>
            <input type="file" name="mobile_image" class="form-control">
            <small id="mobile_hint" class="text-muted"></small>

            @if ($banner->mobile_image)
                <div class="mt-3">
                    <strong class="d-block mb-2 mt-5">Current Mobile Image:</strong><br>
                    <img 
                        src="{{ asset('storage/' . $banner->mobile_image) }}"
                        class="img-fluid rounded shadow-sm border my-scalable-element"
                        style="max-width: 100%; height: auto; object-fit: cover;"
                    >
                </div>
            @endif
        </div>

        <button class="btn btn-primary">Update Banner</button>
        <a href="{{ route('admin.banners.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>

{{-- SAME JS USED IN CREATE FORM --}}
<script>
document.addEventListener("DOMContentLoaded", function () {

    const place = document.getElementById('place');
    const desktopHint = document.getElementById('desktop_hint');
    const mobileHint = document.getElementById('mobile_hint');

    function updateHints() {
        let p = place.value;

        if (p == '1') {
            desktopHint.textContent = "Recommended size: 1800 × 700";
            mobileHint.textContent = "Recommended size: 800 × 1200";
        } 
        else if (p == '2') {
            desktopHint.textContent = "Recommended size: 800 × 1000";
            mobileHint.textContent = "Recommended size: 800 × 1000";
        } 
        else if (p == '3' || p == '4') {
            desktopHint.textContent = "Recommended size: 1400 × 800";
            mobileHint.textContent = "Recommended size: 900 × 900";
        } 
        else {
            desktopHint.textContent = "";
            mobileHint.textContent = "";
        }
    }

    place.addEventListener('change', updateHints);
    updateHints();
});
</script>

@endsection
