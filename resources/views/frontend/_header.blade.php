

<a href="{{ url('/') }}">Home</a>
    {{-- <a href="{{ route('profile') }}">Profile</a>
    
    <div>
        <span>{{ auth()->user()->userProfile->first_name }}</span>
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit">Logout</button>
        </form>
    </div>

    @auth
        <!-- user profile / logout -->
        <!-- profile -->
        <a class="userName" href="{{ route('user.show.by.id', auth()->user()->id) }}">
            {{ auth()->user()->getDisplayName() }}
        </a>
        <!-- <div><a href="{{ url('/dashboard') }}">Dashboard</a></div> -->
        <div id="userProfileImage">
            <img src=" {{ auth()->user()->getAvatarImageSmall() }}"/>
            <i class="fa-solid fa-angle-down"></i>
            <div id="profileMenu">
                <a href="{{ route('profile') }}">Settings</a>
                <a href="{{ route('user.show.by.id', auth()->user()->id) }}">Images</a>
                <a href="{{ route('friends') }}">Chat & friends</a>
                {{-- logout --}
                <a href="#" id="logoutButton"> Logout </a>
                <form action="{{ route('logout') }}" method="POST" id="logout-form" style="display: none;">
                    @csrf
                    <button type="submit">Logout</button>
                </form>
                @if(auth()->user()->hasRole('administrator') )
                    <a href="{{ route('dashboard') }}">Dashboard</a>
                @endif
            </div>
        </div>
        
    
    @else
        <div id="userSearchIcon">
            <i class="fa-solid fa-magnifying-glass"></i>
        </div>
        <div><a href="{{ url('/signup') }}">SignUp</a></div>
        <div><a href="{{ url('/login') }}">Login</a></div>
    @endauth --}}