@extends('layouts.layoutMaster')
@section('title', 'Categories')

@section('content')

<div class="d-flex justify-content-between align-items-center my-4">
    <h3 class="fw-bold">Categories</h3>

    <a href="{{ route('admin.categories.create') }}" class="btn btn-primary btn-sm">
        <i class="fa fa-plus"></i> Add Category
    </a>
</div>

<div class="card shadow-sm">
    <div class="card-body p-0">

        <table class="table table-hover table-striped mb-0 align-middle">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Icon</th>
                    <th>Name</th>
                    <th>Slug</th>
                    <th>Parent</th>
                    <th>Sort</th>
                    <th width="180">Actions</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($categories as $cat)
                <tr>

                    {{-- ID --}}
                    <td class="fw-bold">{{ $cat->id }}</td>

                    {{-- ICON --}}
                    <td style="width: 60px;">
                        @if($cat->icon)
                            <img src="{{ asset('storage/'.$cat->icon) }}"
                                 class="rounded"
                                 style="width:40px;height:40px;object-fit:contain;">
                        @else
                            <img src="{{ asset('assets/images/placeholder.png') }}"
                                 class="rounded"
                                 style="width:40px;height:40px;object-fit:contain;">
                        @endif
                    </td>

                    {{-- NAME --}}
                    <td class="fw-semibold">{{ $cat->name }}</td>

                    {{-- SLUG --}}
                    <td>{{ $cat->slug }}</td>

                    {{-- PARENT --}}
                    <td>{{ $cat->parent->name ?? '—' }}</td>

                    {{-- SORT ORDER --}}
                    <td>{{ $cat->sort_order }}</td>

                    {{-- ACTIONS --}}
                    <td>

                        {{-- EDIT --}}
                        <a href="{{ route('admin.categories.edit', $cat->id) }}"
                           class="btn btn-sm btn-primary">
                            <i class="fa fa-edit"></i> Edit
                        </a>

                        {{-- DELETE --}}
                        <form action="{{ route('admin.categories.destroy', $cat->id) }}"
                              method="POST"
                              class="d-inline"
                              onsubmit="return confirm('Delete this category?');">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger">
                                <i class="fa fa-trash"></i> Delete
                            </button>
                        </form>

                    </td>

                </tr>

                @empty

                <tr>
                    <td colspan="7" class="text-center py-4">
                        <img src="{{ asset('assets/images/empty-cart.png') }}"
                             width="120" class="mb-3">
                        <h5>No categories found.</h5>
                    </td>
                </tr>

                @endforelse
            </tbody>

        </table>

    </div>
</div>

{{-- PAGINATION --}}
<div class="mt-3">
    {{ $categories->links() }}
</div>

@endsection
