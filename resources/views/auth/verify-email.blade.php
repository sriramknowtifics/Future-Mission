@extends('layouts.app')

@section('title','Verify your email')

@section('content')
<div class="row justify-content-center my-5">
  <div class="col-md-8">
    <h3>Verify your email</h3>
    <p>Please check your email and click the verification link. If you didn't receive it, you can request another.</p>

    <form action="{{ route('verification.resend') }}" method="POST" class="mt-3">
      @csrf
      <div class="form-group">
        <label>Email</label>
        <input type="email" name="email" value="{{ auth()->user()->email ?? '' }}" class="form-control" readonly>
      </div>
      <button class="btn btn-primary">Resend verification email</button>
    </form>
  </div>
</div>
@endsection
