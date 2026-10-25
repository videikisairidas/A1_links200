@extends('frontend.base')

@section('content')
<div class="loginContainer">
    <div>
        <h2>{{ __('Login') }}</h2>


        <form method="POST" action="{{ route('login.submit') }}">
            @csrf

            <div class="form-group mb-3">
                <label for="email">{{ __('Email Address') }}</label>
                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ request()->query('email', '') }}" required autocomplete="email" autofocus>
            </div>

            <div class="form-group mb-3">
                <label for="password">{{ __('Password') }}</label>
                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" value="{{ request()->query('password', '') }}">
            </div>

            {{-- <div class="form-group mb-3">
                <a href="{{ route('register') }}">
                    {{ __("Register here.") }}
                </a>
            </div> --}}
                
            <div class="form-group mb-0">
                <button type="submit" class="btn btn-primary">
                    {{ __('Login') }}
                </button>
                {{-- @if (Route::has('get.forget.password'))
                    <a class="btn btn-link" href="{{ route('get.forget.password') }}">
                        {{ __('Forgot Your Password?') }}
                    </a>
                @endif --}}
            </div>
        </form>

        {{-- <a href="{{ route('google.login') }}" class="btn btn-google">
            <i class="fab fa-google"></i> Login with Gmail
        </a> --}}


    </div>
</div>
@endsection