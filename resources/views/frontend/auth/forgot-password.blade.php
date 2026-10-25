@extends('frontend.base')

@section('content')
<h1>Forgot Password</h1>
<p>If you've forgotten your password, you can reset it here. Please enter your email address below, and we'll send you a link to reset your password.</p>
<form method="POST" action="{{ route('post.forget.password') }}">
    @csrf
    <input type="email" name="email" required placeholder="Enter your email">


    

    
    <button type="submit">Send Reset Link</button>
    
</form>
@if (session('status'))
    <div class="alert alert-success">
        {{ session('status') }}
    </div>
@endif
@if ($errors->has('email0'))
    <div class="alert alert-danger">{{ $errors->first('email0') }}</div>
@endif


@endsection