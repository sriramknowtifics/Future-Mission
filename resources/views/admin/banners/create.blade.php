@extends('layouts.layoutMaster')

@section('title', 'Add Banner')

@section('content')
<div class="container my-4">
    <h3>Add Banner</h3>

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

    <form action="{{ route('admin.banners.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        {{-- Title --}}
        <div class="mb-3">
            <label class="form-label">Title *</label>
            <input type="text" name="title" value="{{ old('title') }}" class="form-control" required>
            @error('title')<small class="text-danger">{{ $message }}</small>@enderror
        </div>

        {{-- Subtitle --}}
        <div class="mb-3">
            <label class="form-label">Subtitle</label>
            <input type="text" name="subtitle" value="{{ old('subtitle') }}" class="form-control">
            @error('subtitle')<small class="text-danger">{{ $message }}</small>@enderror
        </div>

        {{-- Place dropdown (1–4) --}}
        <div class="mb-3">
            <label class="form-label">Place *</label>
            
            <select name="place" id="place" class="form-select" required>
                <option value="">— Select Place —</option>
                <option value="1" @selected(old('place') == 1)>1</option>
                <option value="2" @selected(old('place') == 2)>2</option>
                <option value="3" @selected(old('place') == 3)>3</option>
                <option value="4" @selected(old('place') == 4)>4</option>
            </select>
            @error('place')<small class="text-danger">{{ $message }}</small>@enderror
        </div>

        {{-- Link URL --}}
        <div class="mb-3">
            <label class="form-label">Link URL</label>
            <input type="url" name="link_url" value="{{ old('link_url') }}" class="form-control" placeholder="https://...">
            @error('link_url')<small class="text-danger">{{ $message }}</small>@enderror
        </div>

        {{-- Product --}}
        <div class="mb-3">
            <label class="form-label">Link to Product (optional)</label>
            <select name="product_id" class="form-select">
                <option value="">— None —</option>
                @foreach($products as $product)
                    <option value="{{ $product->id }}" @selected(old('product_id') == $product->id)>
                        {{ $product->name }}
                    </option>
                @endforeach
            </select>
            @error('product_id')<small class="text-danger">{{ $message }}</small>@enderror
        </div>

        {{-- Placement --}}
        <div class="mb-3">
            <label class="form-label">Placement *</label>
            <select name="placement" class="form-select" required>
                <option value="home" @selected(old('placement') == 'home')>Home</option>
                <option value="category" @selected(old('placement') == 'category')>Category pages</option>
                <option value="product" @selected(old('placement') == 'product')>Product pages</option>
            </select>
            @error('placement')<small class="text-danger">{{ $message }}</small>@enderror
        </div>

        {{-- Sort order --}}
        <div class="mb-3">
            <label class="form-label">Sort Order</label>
            <input type="number" name="sort_order" value="{{ old('sort_order', 0) }}" class="form-control">
            @error('sort_order')<small class="text-danger">{{ $message }}</small>@enderror
        </div>

        {{-- Active --}}
        <div class="mb-3 form-check">
            <input type="checkbox" class="form-check-input" id="is_active" name="is_active" value="1"
                   {{ old('is_active', true) ? 'checked' : '' }}>
            <label for="is_active" class="form-check-label">Active</label>
        </div>

        {{-- Desktop Image --}}
        <div class="mb-3">
            <label class="form-label">Desktop Image *</label>
            <input type="file" name="desktop_image" class="form-control" required>
            <small id="desktop_hint" class="text-muted"></small>
            @error('desktop_image')<small class="text-danger d-block">{{ $message }}</small>@enderror
        </div>

        {{-- Mobile Image --}}
        <div class="mb-3">
            <label class="form-label">Mobile Image *</label>
            <input type="file" name="mobile_image" class="form-control" required>
            <small id="mobile_hint" class="text-muted"></small>
            @error('mobile_image')<small class="text-danger d-block">{{ $message }}</small>@enderror
        </div>

        <button class="btn btn-primary">Save Banner</button>
        <a href="{{ route('admin.banners.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
<script>
document.addEventListener("DOMContentLoaded", function () {

    const place = document.getElementById('place');
    const desktopHint = document.getElementById('desktop_hint');
    const mobileHint = document.getElementById('mobile_hint');

    function updateHints() {
        let p = place.value;
        console.log('Place changed: ' + p);

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
    updateHints(); // trigger on first page load
});
</script>
@endsection

