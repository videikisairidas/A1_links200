<?php
namespace App\Http\Controllers\Api\User;
use App\Http\Controllers\Controller;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

use App\Services\Notifications\NotificationService;
use App\Notifications\UserAlert;
use App\Events\UserNotification;
use App\Events\SendNodeNotification;
use App\Jobs\SendDataToNodeServer;
use App\Services\Notifications\NotificationsServices;

use function Laravel\Prompts\info;

class NotificationController extends Controller
{
    // protected SettingsService $settingsService;
    
    public function getNotifications(Request $request)
    {
        return auth()->user()->notifications;
    }
    public function createNotification(Request $request)
    {
        info("works");
        $user = auth()->user();

        $notification = Notification::create([
            'id' => Str::uuid()->toString(),
            'type' => 'notification',
            'notifiable_id' => $user->id,
            'notifiable_type' => 'App\Models\User',
            'data' => [
                'message' => 'Your image is ready!',
                'url' => '/media/dashboard'
            ],
            'read_at' => null
        ]);
        NotificationsServices::send('notification', $notification->toArray());

        // return $notification;
        return response()->json([
            'message' => 'Notification created successfully'
        ]);
    }
    public function deleteNotification(Request $request)
    {
        $user = auth()->user();
        $user->notifications()->delete();
        return response()->json([
            'message' => 'Notifications deleted successfully'
        ]);
    }
}