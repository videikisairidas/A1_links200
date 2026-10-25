@extends('dashboard.base')

@section('content')
<div id="userProfileSettings"> 
<div class="userProfileSettings">

    <form method="POST" action="{{ route('user.profile.update') }}" enctype="multipart/form-data" class="userProfileForm">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="username">{{ __('Username') }}</label>
            <input id="username" type="text" class="form-control" name="username" value="{{ $profile->username }}" required>
        </div>

        <div class="form-group">
            <label for="first_name">{{ __('First Name') }}</label>
            <input id="first_name" type="text" class="form-control" name="first_name" value="{{ $profile->first_name }}" required>
        </div>

        <div class="form-group">
            <label for="middle_name">{{ __('Middle Name') }}</label>
            <input id="middle_name" type="text" class="form-control" name="middle_name" value="{{ $profile->middle_name }}">
        </div>

        <div class="form-group">
            <label for="last_name">{{ __('Last Name') }}</label>
            <input id="last_name" type="text" class="form-control" name="last_name" value="{{ $profile->last_name }}" >
        </div>

        <div class="form-group">
            <label for="birth_date">{{ __('Birth Date') }}</label>
            <input id="birth_date" type="date" class="form-control" name="birth_date" value="{{ $profile->birth_date }}">    
        </div>

        <div class="form-group">
            <label for="phone_number">{{ __('phone_number') }}</label>
            <input id="phone_number" type="text" class="form-control" name="phone_number" value="{{ $profile->phone_number }}">
        </div>

        <div class="form-group">
            <label for="address">{{ __('Address') }}</label>
            <input id="address" type="text" class="form-control" name="address" value="{{ $profile->address }}">    
        </div>

        <div class="form-group">
            <label for="state">{{ __('State') }}</label>
            <input id="state" type="text" class="form-control" name="state" value="{{ $profile->state }}">
        </div>
        <div class="form-group">
            <label for="city">{{ __('City') }}</label>
            <input id="city" type="text" class="form-control" name="city" value="{{ $profile->city }}">
        </div>

        <div class="form-group">
            <label for="post_code">{{ __('Zip Code') }}</label>
            <input id="post_code" type="text" class="form-control" name="post_code" value="{{ $profile->post_code }}">
        </div>

        <div class="form-group">
            <label for="country_id">{{ __('Country') }}</label>
            <select id="country_id" class="form-control" name="country_id">
                <option value="">Select Country</option>
                @foreach($countries as $country)
                    <option value="{{ $country->id }}" {{ $profile->country_id == $country->id ? 'selected' : '' }}>
                        {{ $country->name }}
                    </option>
                @endforeach
            </select>
        </div>

        
        <div class="form-group">
            <label for="social_instagram">{{ __('Instagram Link') }}</label>
            <input id="social_instagram" type="url" class="form-control" name="social_instagram" value="{{ $profile->social_instagram }}">
        </div>

        <div class="form-group">
            <label for="social_facebook">{{ __('Facebook Link') }}</label>
            <input id="social_facebook" type="url" class="form-control" name="social_facebook" value="{{ $profile->social_facebook }}">
        </div>

        <div class="form-group">
            <label for="social_twitter">{{ __('Twitter Link') }}</label>
            <input id="social_twitter" type="url" class="form-control" name="social_twitter" value="{{ $profile->social_twitter }}">
        </div>

        <div class="form-group">
            <label for="website_link">{{ __('Personal Website') }}</label>
            <input id="website_link" type="url" class="form-control" name="website_link" value="{{ $profile->website_link }}">
        </div>
        <div style=""></div>
        <button type="submit" class="btn btn-primary">{{ __('Update Profile') }}</button>
    </form>

    <form method="POST" action="{{ route('user.update') }}">
        @csrf
        @method('PUT')
        
        <div class="form-group">
            <label for="email">{{ __('Email') }}</label>
            <input id="email" type="email" class="form-control" name="email" value="{{ old('email', auth()->user()->email) }}" required>
        </div>
        <div class="form-group">
            <label for="password">{{ __('New Password (optional)') }}</label>
            <input id="password" type="password" class="form-control" name="password">
        </div>
        <div class="form-group">
            <label for="password_confirmation">{{ __('Confirm New Password') }}</label>
            <input id="password_confirmation" type="password" class="form-control" name="password_confirmation">
        </div>

        <button type="submit" class="btn btn-primary">{{ __('Update Log IN') }}</button>
    </form>

    {{-- <a href="{{ route('profile.google.login') }}" class="btn btn-danger mt-4">
        <i class="fab fa-google"></i> Assign Google Account
    </a> --}}

    <form method="POST" action="{{ route('user-settings.update') }}">
        @csrf
        @method('PUT')

        <div class="form-group flex">
            <label for="email">{{ __('Content 18+') }}</label>
            <input type="checkbox"
                name="content_18"
                {{-- value="1" --}}
                disabled
                {{ auth()->user()->userSetting->content_18 ? 'checked' : '' }}
            >
        </div>

        <button type="submit" class="btn btn-primary">{{ __('Update Settings') }}</button>
    </form>
</div>
</div>
@endsection