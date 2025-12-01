@extends('layouts.layoutMaster')

@section('title', 'Create Service Category')

@section('content')
<div class="container my-4">

  <h3>Create Service Category</h3>

  <form action="{{ route('admin.service_categories.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    {{-- Name --}}
    <div class="mb-3">
      <label class="form-label">Name *</label>
      <input type="text" name="name" value="{{ old('name') }}" class="form-control">
      @error('name') <small class="text-danger">{{ $message }}</small> @enderror
    </div>

    {{-- Slug --}}
    <div class="mb-3">
      <label class="form-label">Slug</label>
      <input type="text" name="slug" value="{{ old('slug') }}" class="form-control">
      <small class="text-muted">Leave empty to auto-generate.</small>
      @error('slug') <small class="text-danger">{{ $message }}</small> @enderror
    </div>

    {{-- Parent --}}
    <div class="mb-3">
      <label class="form-label">Parent Category</label>
      <select name="parent_id" class="form-select">
        <option value="">-- None --</option>
        @foreach($parents as $parent)
          <option value="{{ $parent->id }}" @selected(old('parent_id') == $parent->id)>
            {{ $parent->name }}
          </option>
        @endforeach
      </select>
      @error('parent_id') <small class="text-danger">{{ $message }}</small> @enderror
    </div>

    {{-- Icon --}}
    <div class="mb-3">
      <label class="form-label">Icon (PNG/SVG)</label>
      <input type="file" name="icon" class="form-control">
      @error('icon') <small class="text-danger">{{ $message }}</small> @enderror
    </div>

    {{-- Sort Order --}}
    <div class="mb-3">
      <label class="form-label">Sort Order</label>
      <input type="number" name="sort_order" value="{{ old('sort_order', 0) }}" class="form-control">
      @error('sort_order') <small class="text-danger">{{ $message }}</small> @enderror
    </div>

    {{-- Description --}}
    <div class="mb-3">
      <label class="form-label">Description</label>
      <textarea name="description" class="form-control" rows="3">{{ old('description') }}</textarea>
      @error('description') <small class="text-danger">{{ $message }}</small> @enderror
    </div>

    <button class="btn btn-primary">Save</button>
    <a href="{{ route('admin.service_categories.index') }}" class="btn btn-secondary">Cancel</a>

  </form>

</div>
@endsection
