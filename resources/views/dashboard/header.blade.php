
    <a href="{{ url('/') }}">Home</a>
    <a href="{{ route('profile') }}">Profile</a>
    
    <div>
        <span>{{ auth()->user()->userProfile->first_name }}</span>
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit">Logout</button>
        </form>
    </div>
    {{-- {{ auth()->user()->userProfile->image_small }} --}}

    
