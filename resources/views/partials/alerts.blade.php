@if ($errors->any())
  <div class="alert alert-danger">
    <ul class="mb-0">
      @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
      @endforeach
    </ul>
  </div>
@endif

@foreach (['success','warning','info'] as $msg)
  @if(session($msg))
    <div class="alert alert-{{ $msg === 'info' ? 'primary' : $msg }}">
      {{ session($msg) }}
    </div>
  @endif
@endforeach
