@extends('dashboard.base')

@section('content')
<div id="container">
    <div class="usersListContainer"> 
        <h1>Users</h1>

        <form method="GET" action="{{ route('admin.user.list') }}">
            <input type="text" name="search" placeholder="Search users..." value="{{ request('search') }}" class="searchUserInput">
            <button type="submit" class="searchUserButton">Search</button>
        </form>

        @include('dashboard._navLinks', [
            'objectPaginate' => $users,
            'class' => 'usersNavLinks',
        ])

        <div class="usersList">
            @foreach ($users as $user)

                <div class="userCard">
                    <div class="userAvatar">
                        <img src="{{ asset($user->getAvatarImageSmall()) }}" alt="{{ $user->username }}" >
                    </div>
                    <div class="userInfo">
                        <h2>{{ $user->email }}</h2>
                        <h2>{{ $user->userProfile->first_name }} {{ $user->userProfile->last_name }}</h2>
                        <p>{{ $user->userProfile->username }}</p>
                    </div>
                    
                    <div class="userActions">
                        @if ($user->is_banned)
                        <form action="{{ route('admin.user.unban', $user->id) }}" method="POST" >
                                @csrf
                                @method('PUT')
                                <button type="submit" onclick="return confirm('Are you sure you want to ban this user?');">Unban User</button>
                            </form>
                            
                        @else
                            <form action="{{ route('admin.user.ban', $user->id) }}" method="POST" >
                                @csrf
                                @method('PUT')
                                <button type="submit" onclick="return confirm('Are you sure you want to ban this user?');">Ban User</button>
                            </form>
                        @endif

                        @if ($user->role_id == 1)
                            <form action="{{ route('admin.user.remove.admin', $user->id) }}" method="POST" >
                                @csrf
                                @method('PUT')
                                <button type="submit" onclick="return confirm('Are you sure you want to remove admin?');">Remove Admin</button>
                            </form>
                        @else
                            <form action="{{ route('admin.user.add.admin', $user->id) }}" method="POST" >
                                @csrf
                                @method('PUT')
                                <button type="submit" onclick="return confirm('Are you sure want to make admin?');">Make Admin</button>
                            </form>
                        @endif
                    </div>

                    {{-- <div>
                        <a href="{{ route('admin.users.edit', $user->id) }}"><i class="fa-regular fa-pen-to-square"></i></a> --}}
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection