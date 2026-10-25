<?php
namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

use App\Models\User;
use App\Models\Message;
use App\Models\Chatroom;
use App\Models\Notification;

use App\Services\Notifications\NotificationsServices;

use function Laravel\Prompts\info;

class ChatroomController extends Controller
{
    // protected ChatService $chatService;
    // public function __construct(ChatService $chatService)
    // {
    //     $this->chatService = $chatService;
    // }
    public function getAllMessages(Request $request)
    {
        $chatroom = Chatroom::findOrFail($request['chatId']);
        Gate::authorize('accessChatroom', $chatroom);

        $messages = $chatroom
            ->messages()
            ->latest()
            ->limit(5)
            ->get();

        return response()->json([
            'success' => true, 
            'message' => 'Chats fetched successfully',
            'users' => $chatroom->users()->lightUsersWithPivot()->get(),
            'data' => $messages
        ]);
    }
    public function createMessage(Request $request)
    {
        $validated = $request->validate([
            'message' => 'required|string',
        ]);
        $chatroom = Chatroom::findOrFail($request['chatId']);
        Gate::authorize('accessChatroom', $chatroom);
  
        $chatroom->messages()->create([
            'body' => $validated['message'],
            'user_id' => $request->user()->id
        ]);

        $user = auth()->user();
        // $notification = Notification::create([
        //     'id' => Str::uuid()->toString(),
        //     'type' => 'message',
        //     'notifiable_id' => $user->id,
        //     'notifiable_type' => 'App\Models\User',
        //     'data' => [
        //         'message' => 'Your image is ready!',
        //         'url' => '/media/dashboard'
        //     ],
        //     'read_at' => null
        // ]);
        // NotificationsServices::send('notification', $notification->toArray());
        $notification = ([
            'id' => Str::uuid()->toString(),
            'type' => 'message',
            'notifiable_id' => $user->id,
            'notifiable_type' => 'App\Models\User',
            'data' => [
                'message' => $validated['message'],
                'url' => '/media/dashboard'
            ],
            'read_at' => null
        ]);
        NotificationsServices::send('notification', $notification);
        

        return response()->json([
            'status' => "success", 
            'message' => 'Chats fetched successfully',
        ]);

       
    }
    // $user = auth()->user();

    //     $notification = Notification::create([
    //         'id' => Str::uuid()->toString(),
    //         'type' => 'notification',
    //         'notifiable_id' => $user->id,
    //         'notifiable_type' => 'App\Models\User',
    //         'data' => [
    //             'message' => 'Your image is ready!',
    //             'url' => '/media/dashboard'
    //         ],
    //         'read_at' => null
    //     ]);
    //     NotificationsServices::send('notification', $notification->toArray());
}