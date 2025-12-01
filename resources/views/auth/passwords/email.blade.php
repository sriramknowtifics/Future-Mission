@extends('layouts.app')
@section('title','Reset Password')
@section('content')
<div class="row justify-content-center my-5">
  <div class="col-md-6">
    <h3>Reset Password</h3>
    <form action="{{ route('password.email') }}" method="POST">
      @csrf
      <div class="form-group">
        <label>Email</label>
        <input name="email" class="form-control" type="email" required>
      </div>
      <button class="btn btn-primary">Send reset link</button>
    </form>
  </div>
</div>
@endsection
