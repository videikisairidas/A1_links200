@extends('frontend.base')

@section('content')
<div class="signupContainer">
    <div>
        <h2>Register</h2>


        <form method="POST" action="{{ route('register.submit') }}"> {{-- Point to the POST route --}}
            @csrf 

            {{-- <div>
                <label for="name">First Name:</label>
                <input type="text" id="first_name" name="first_name" value="{{ old('name') }}" required autofocus>
            </div> --}}

            <div>
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" required>
            </div>

            <div>
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
            </div>

            <div>
                <label for="password_confirmation">Confirm Password:</label>
                <input type="password" id="password_confirmation" name="password_confirmation" required>
            </div>

            <div class="registerBtn">
                <button type="submit">Register</button>
            </div>
        </form>

        <a href="{{ route('login') }}">Login here</a>

        <a href="{{ route('google.login') }}" class="btn btn-google registerGoogle">
            <i class="fab fa-google"></i> Login with Gmail
        </a>
    </div>
</div>
@endsection