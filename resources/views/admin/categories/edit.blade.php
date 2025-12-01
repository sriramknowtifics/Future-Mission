@extends('layouts.layoutMaster')

@section('title', 'Edit Category')

@section('content')
<div class="container my-4">

    <h3>Edit Category</h3>

    <form action="{{ route('admin.categories.update', $category->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        {{-- Name --}}
        <div class="mb-3">
            <label class="form-label">Name *</label>
            <input type="text" name="name" value="{{ old('name', $category->name) }}" class="form-control">
            @error('name')<small class="text-danger">{{ $message }}</small>@enderror
        </div>

        {{-- Slug --}}
        <div class="mb-3">
            <label class="form-label">Slug</label>
            <input type="text" name="slug" value="{{ old('slug', $category->slug) }}" class="form-control">
            <small class="text-muted">Leave blank to auto-generate.</small>
            @error('slug')<small class="text-danger">{{ $message }}</small>@enderror
        </div>

        {{-- Parent --}}
        <div class="mb-3">
            <label class="form-label">Parent Category</label>
            <select name="parent_id" class="form-select">
                <option value="">-- None --</option>
                @foreach ($parents as $parent)
                    <option value="{{ $parent->id }}"
                        @selected(old('parent_id', $category->parent_id) == $parent->id)>
                        {{ $parent->name }}
                    </option>
                @endforeach
            </select>
            @error('parent_id')<small class="text-danger">{{ $message }}</small>@enderror
        </div>

        {{-- Icon --}}
        <div class="mb-3">
            <label class="form-label">Icon (PNG / SVG)</label>
            <input type="file" name="icon" class="form-control">

            @if ($category->icon)
                <div class="mt-2">
                    <strong>Current Icon:</strong><br>
                    <img src="{{ asset('storage/'. $category->icon) }}"
                        alt="Icon"
                        style="width:80px;height:80px;object-fit:contain;">
                </div>
            @endif

            @error('icon')<small class="text-danger">{{ $message }}</small>@enderror
        </div>

        {{-- Sort order --}}
        <div class="mb-3">
            <label class="form-label">Sort Order</label>
            <input type="number" name="sort_order" value="{{ old('sort_order', $category->sort_order) }}" class="form-control">
            @error('sort_order')<small class="text-danger">{{ $message }}</small>@enderror
        </div>

        {{-- Description --}}
        <div class="mb-3">
            <label class="form-label">Description</label>
            <textarea name="description" rows="3" class="form-control">{{ old('description', $category->description) }}</textarea>
            @error('description')<small class="text-danger">{{ $message }}</small>@enderror
        </div>

        <button class="btn btn-primary">Update</button>
        <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">Cancel</a>

    </form>
</div>
@endsection
