<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Ai Art competition' }}</title>

    {{-- @vite(['resources/css/frontend.css']) --}}
    {{-- @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot'))) --}}
        @vite(['resources/css/frontend.css'])
    {{-- @endif --}}

    <!-- Include CSS -->

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="checkUser" content="{{ Auth::check() }}">
    <meta name="TargetUserId" content="{{ $targerUserId ?? '' }}">
    
    <!-- Robots Meta Tag (optional: to control indexing) -->
    <meta name="robots" content="index, follow">
    {{-- <!-- Favicon -->asset($this->avatar_medium); --}}
    <link rel="icon" href="{{ asset('assets/images/favicon.png') }}" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans:ital,wght@0,100..900;1,100..900&family=Outfit:wght@100..900&display=swap" rel="stylesheet">
    <style>
        * {
            font-family:"Outfit", sans-serif;
        }
        a{
            font-family:"Outfit", sans-serif;
            font-weight: 500;
        }
    </style>
    <x-_meta 
        :title="$image->title ?? 'Links200 Share'" 
        :description="$image->description ?? 'Links200 is a platform that provides a space for users to share and discover links, fostering a community of knowledge and information exchange.'" 
        :image="isset($image) ? asset($image->image_large) : asset('assets/images/default-meta.webp')"
        :keywords="'Links200, sharing, discovery, community, knowledge, information exchange'"
    />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    {{-- <x-_alerts />
    <x-_alertYesNo /> --}}


    {{-- <header>
        @include('frontend._header')
        @include('frontend._header_mobile')
    </header> --}}

    <main>
        @yield('content')
    </main>

    <footer>
        @include('frontend._footer')
    </footer>

    {{-- uploading images/avatar/banner --}}
    {{-- <div id="uploadContainer"></div>
    <div id="imagePopUpContainer">
        <i class="fa-solid fa-xmark close"></i>
    </div> --}}
    <!-- Include JS -->
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/js/frontend.js'])
    @endif
    {{-- @vite(['resources/js/frontend.js'], '/assets/build') --}}
</body>
</html>