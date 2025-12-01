@extends('layouts.theme')
@section('title','Cart')
@section('body_class','cart-page')

@section('content')
  <div class="container rts-section-gap">
    <h3>Your Cart</h3>

    @if(empty($cart) || count($cart) === 0)
      <p>Your cart is empty. <a href="{{ route('shop.index') }}">Continue shopping</a></p>
    @else
      <table class="table">
        <thead><tr><th>Product</th><th>Price</th><th>Qty</th><th>Subtotal</th><th></th></tr></thead>
        <tbody>
          @php $total = 0; @endphp
          @foreach($cart as $item)
            <tr>
              <td>{{ $item['name'] }}</td>
              <td>₹{{ number_format($item['price'],2) }}</td>
              <td>
                <form action="{{ route('cart.update') }}" method="POST" class="d-inline">
                  @csrf
                  <input type="hidden" name="product_id" value="{{ $item['product_id'] }}">
                  <input type="number" name="qty" value="{{ $item['qty'] }}" min="0" style="width:70px;">
                  <button class="btn btn-sm btn-secondary">Update</button>
                </form>
              </td>
              <td>₹{{ number_format($item['price'] * $item['qty'],2) }}</td>
              <td>
                <form action="{{ route('cart.remove', $item['product_id']) }}" method="POST">
                  @csrf
                  <button class="btn btn-sm btn-danger">Remove</button>
                </form>
              </td>
            </tr>
            @php $total += $item['price'] * $item['qty']; @endphp
          @endforeach
        </tbody>
      </table>

      <div class="text-right">
        <h4>Total: ₹{{ number_format($total,2) }}</h4>
        <a href="{{ route('checkout.index') }}" class="rts-btn btn-primary">Proceed to Checkout</a>
      </div>
    @endif
  </div>
@endsection
