@extends('layouts.app')
@section('title','Set a new password')
@section('content')
<div class="row justify-content-center my-5">
  <div class="col-md-6">
    <h3>Set a new password</h3>
    <form action="{{ route('password.update') }}" method="POST">
      @csrf
      <input type="hidden" name="token" value="{{ $token }}">
      <div class="form-group"><label>Email</label><input name="email" class="form-control" value="{{ $email ?? old('email') }}" required></div>
      <div class="form-group"><label>Password</label><input name="password" class="form-control" type="password" required></div>
      <div class="form-group"><label>Confirm</label><input name="password_confirmation" class="form-control" type="password" required></div>
      <button class="btn btn-primary">Reset password</button>
    </form>
  </div>
</div>
@endsection
