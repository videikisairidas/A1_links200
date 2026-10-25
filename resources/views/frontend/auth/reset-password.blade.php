@extends('frontend.base')

@section('content')
<h1>reset Password</h1>
<p>If you've forgotten your password, you can reset it here. Please enter your email address below, and we'll send you a link to reset your password.</p>
<form method="POST" action="{{ route('post.reset.password') }}">
    @csrf
    <input type="hidden" name="token" value="{{ request()->route('token') }}">
    <input type="email" name="email" required placeholder="Enter your email">
    <input type="password" name="password" required placeholder="New password">
    <input type="password" name="password_confirmation" required placeholder="Confirm new password">
    <button type="submit">Reset Password</button>
</form>
@endsection