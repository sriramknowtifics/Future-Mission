@extends('layouts.layoutMaster')

@section('title', 'Banners')

@section('content')
<div class="container my-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>Banners</h3>
        <a href="{{ route('admin.banners.create') }}" class="btn btn-primary btn-sm">Add Banner</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="table-responsive">
        <table class="table table-bordered table-striped align-middle">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Image</th>
                    <th>Title</th>
                    <th>Placement</th>
                    <th>Product</th>
                    <th>Link</th>
                    <th>Active</th>
                    <th>Sort</th>
                    <th width="160">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($banners as $banner)
                    <tr>
                        <td>{{ $banner->id }}</td>
                        <td>
                            @if($banner->desktop_image)
                                <img src="{{ asset('storage/'.$banner->desktop_image) }}"
                                     alt="{{ $banner->title }}"
                                     style="width:80px;height:50px;object-fit:cover;">
                            @else
                                <span class="text-muted">No image</span>
                            @endif
                        </td>
                        <td>{{ \Illuminate\Support\Str::limit($banner->title, 40) }}</td>
                        <td>
                            <span class="badge bg-info text-dark text-uppercase">
                                {{ $banner->placement }}
                            </span>
                        </td>
                        <td>
                            @if($banner->product)
                                <a href="{{ route('products.show', $banner->product->id) }}" target="_blank">
                                    {{ \Illuminate\Support\Str::limit($banner->product->name, 30) }}
                                </a>
                            @else
                                <span class="text-muted">—</span>
                            @endif
                        </td>
                        <td>
                            @if($banner->link_url)
                                <a href="{{ $banner->link_url }}" target="_blank">
                                    {{ \Illuminate\Support\Str::limit($banner->link_url, 25) }}
                                </a>
                            @else
                                <span class="text-muted">—</span>
                            @endif
                        </td>
                        <td>
                            @if($banner->is_active)
                                <span class="badge bg-success">Active</span>
                            @else
                                <span class="badge bg-secondary">Inactive</span>
                            @endif
                        </td>
                        <td>{{ $banner->sort_order }}</td>
                        <td>
                            <a href="{{ route('admin.banners.edit', $banner) }}"
                               class="btn btn-sm btn-primary mb-1">
                                Edit
                            </a>

                            {{-- DELETE (Remove banner) --}}
                            <form action="{{ route('admin.banners.destroy', $banner) }}"
                                  method="POST"
                                  class="d-inline"
                                  onsubmit="return confirm('Delete this banner?');">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger mb-1">
                                    Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" class="text-center text-muted py-4">
                            No banners found.
                            <a href="{{ route('admin.banners.create') }}">Add one now</a>.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
