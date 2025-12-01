@extends('layouts.app')
@section('title','Vendor Settings')

@section('content')
<div class="my-4">
  <h3>Shop Settings</h3>

  <form action="{{ route('vendor.settings.update') }}" method="POST" enctype="multipart/form-data">
    @csrf @method('PUT')

    <div class="form-group">
      <label>Shop name</label>
      <input name="shop_name" class="form-control" value="{{ old('shop_name', $vendor->shop_name) }}">
    </div>

    <div class="form-group">
      <label>Shop description</label>
      <textarea name="description" class="form-control" rows="4">{{ old('description', $vendor->description) }}</textarea>
    </div>

    <div class="form-group">
      <label>Shop logo</label>
      <input type="file" name="logo" class="form-control-file">
      @if($vendor->logo ?? false)
        <img src="{{ asset('storage/' . $vendor->logo) }}" style="width:120px;margin-top:8px;">
      @endif
    </div>

    <div class="form-group">
      <label>Contact phone</label>
      <input name="phone" class="form-control" value="{{ old('phone', $vendor->phone) }}">
    </div>

    <button class="btn btn-primary">Save settings</button>
  </form>
</div>
@endsection
