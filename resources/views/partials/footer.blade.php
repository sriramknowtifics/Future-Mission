<footer class="site-footer">
  <div class="container">
    <div class="row">
      <div class="col">
        <p>&copy; {{ date('Y') }} Future Mission. All rights reserved.</p>
      </div>
      <div class="col text-right">
        <a href="{{ route('home') }}">Home</a> |
        <a href="{{ route('shop.index') }}">Shop</a> |
        <a href="{{ route('account.dashboard') }}">Account</a>
      </div>
    </div>
  </div>
</footer>
