<?php 
namespace App\Services\User;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;


use App\Models\User;
use App\Models\Chatroom;


class ChatService
{
    public function getChats(User $user)
    {   
        return $user->chatrooms()
            ->with([
                'users' => fn($q) => $q->lightUsers()
            ])
            ->get();

        // return Chatroom::query()
        //     // chatrooms where THIS user is a member
        //     ->whereHas('users', fn($q) => $q->where('users.id', $user->id))

        //     // 2. ✅ FIX: Use the actual pivot table name and column string instead of wherePivot
        //     ->whereHas('users', fn($q) => $q->where('chatroom_user.has_joined', true), '>=', 2)

        //     // 3. Eager load the required data relations to avoid N+1 leaks
        //     ->with(['users'])
            
        //     // 4. ✅ FIX: Apply the same real table name to your count payload
        //     ->withCount(['users as joined_count' => fn($q) => 
        //         $q->where('chatroom_user.has_joined', true)
        //     ])
        //     ->get();
    }
    public function getMyChatRequests(User $user)
    {
        return $user->chatrooms()
            ->has('users', '<', 2)
            ->with('users')
            ->get();
    }
    public function getChatRequests(User $user)
    {
        return $user->chatroom_requests()->with('users')->get();
    }
    public function createChatRoom(array $data)
    {
        $chatroom = Chatroom::create([
            'id' => (string) Str::uuid(),
            'name' => $data['name'],
            'is_group' => $data['is_group'] ?? false,
        ]);
        
        //
        $chatroom->users()->attach(auth()->user()->id, ['has_joined' => true]);
        $chatroom->users()->attach($data['users']);

        return $chatroom;
    }

}