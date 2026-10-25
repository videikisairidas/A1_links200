<!DOCTYPE html>
<html lang="en">
<head>
    
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard')</title>

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.14.1/themes/base/jquery-ui.css">
    {{-- @viteReactRefresh --}}
    {{-- @vite(['resources/css/dashboard.min.css'])
     --}}
     @vite([
    'resources/css/dashboard.min.css',
    'resources/js/dashboard.js'
])

    @yield('baseHeader')
</head>
<body>
    <x-_alerts />
    <x-_alertYesNo />
    
    <nav>
        @include('dashboard.navigation')
    </nav>
    
    <header>
        @include('dashboard.header')
    </header>

    <main>
        @yield('content')
    </main>

    <footer>
        @include('dashboard.footer')
    </footer>

    <!-- Include JS -->
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://code.jquery.com/ui/1.14.1/jquery-ui.js"></script>
    {{-- @vite(['resources/js/dashboard.js']) --}}
    @yield('basefooter')
    
</body>
</html>