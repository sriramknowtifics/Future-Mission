@extends('layouts.theme')
@section('title','Contact')
@section('body_class','contact-page')

@section('content')
  <div class="container rts-section-gap">
    <h1>Contact Us</h1>
    <p>Phone: +258 3268 21485</p>
    <form action="{{ route('contact.send') ?? '#' }}" method="POST">
      @csrf
      <div class="form-group"><label>Name</label><input class="form-control" name="name"></div>
      <div class="form-group"><label>Email</label><input class="form-control" name="email"></div>
      <div class="form-group"><label>Message</label><textarea class="form-control" name="message"></textarea></div>
      <button class="rts-btn btn-primary">Send</button>
    </form>
  </div>
@endsection
