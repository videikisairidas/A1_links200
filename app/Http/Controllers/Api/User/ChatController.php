<?php
namespace App\Http\Controllers\Api\User;
 
use App\Http\Controllers\Controller;
use App\Services\User\ChatService;
use Illuminate\Http\Request;

use App\Models\User;

use function Laravel\Prompts\info;

class ChatController extends Controller
{
    protected ChatService $chatService;
    public function __construct(ChatService $chatService)
    {
        $this->chatService = $chatService;
    }
    public function getUsers(Request $request)
    {
        $users = User::lightUsers()->get();
        return response()->json([
            'success' => true, 
            'message' => 'Chats fetched successfully',
            'data' => $users
        ]);
    }
    public function getChats(Request $request)
    {
        $chats = $this->chatService->getChats($request->user());
        
        return response()->json([
            'success' => true, 
            'message' => 'Chats fetched successfully',
            'data' => $chats
        ]);
    }
    public function getMyChatRequests(Request $request)
    {
        $chats = $this->chatService->getMyChatRequests($request->user());
        
        return response()->json([
            'success' => true, 
            'message' => 'Chats fetched successfully',
            'data' => $chats
        ]);
    }
    public function getChatReuqests(Request $request)
    {
        $chats = $this->chatService->getChatReuqests($request->user());
        
        return response()->json([
            'success' => true, 
            'message' => 'Chats fetched successfully',
            'data' => $chats
        ]);
    }
    public function createChatRoom(Request $request)
    {
        $validted = $request->validate([
            'users' => 'required|array|min:1',
            'users.*' => 'required|integer|exists:users,id',
            'name' => 'nullable|string',
            'is_group' => 'nullable|boolean'
        ]);

        $chatroom =$this->chatService->createChatRoom($validted);

        return response()->json([
            'success' => true, 
            'message' => 'Chat room created successfully',
            'data' => $chatroom
        ]);
    }
}