@extends('layouts.theme')

@section('title', 'Shop - Future Mission')

@section('content')
  <div class="row my-4">
    <div class="col-md-3">
      <h5>Filters</h5>
      <form method="GET" action="{{ route('shop.index') }}">
        <input type="text" name="q" value="{{ request('q') }}" class="form-control mb-2" placeholder="Search...">
        <select name="category" class="form-control mb-2">
          <option value="">All Categories</option>
          @foreach(\App\Models\Category::orderBy('name')->get() as $category)
            <option value="{{ $category->id }}" @selected(request('category') == $category->id)>{{ $category->name }}</option>
          @endforeach
        </select>
        <button class="btn btn-primary btn-block" type="submit">Apply</button>
      </form>
    </div>

    <div class="col-md-9">
      <div class="row">
        @forelse($products as $product)
          <div class="col-md-4 mb-4">
            <div class="card product-card">
              @php $img = $product->images->first(); @endphp
              <a href="{{ route('products.show', $product->id) }}">
                <img src="{{ $img ? asset('storage/' . $img->path) : asset('assets/images/placeholder.png') }}"
                     class="card-img-top" alt="{{ $product->name }}">
              </a>
              <div class="card-body">
                <h6 class="card-title">{{ Str::limit($product->name, 60) }}</h6>
                <p class="card-text">₹{{ number_format($product->price,2) }}</p>
                <a href="{{ route('products.show', $product->id) }}" class="btn btn-sm btn-outline-primary">View</a>
                <form action="{{ route('cart.add') }}" method="POST" class="d-inline">
                  @csrf
                  <input type="hidden" name="product_id" value="{{ $product->id }}">
                  <button class="btn btn-sm btn-primary">Add to Cart</button>
                </form>
              </div>
            </div>
          </div>
        @empty
          <div class="col-12">
            <p>No products found.</p>
          </div>
        @endforelse
      </div>

      <div class="mt-3">
        {{ $products->withQueryString()->links() }}
      </div>
    </div>
  </div>
@endsection
