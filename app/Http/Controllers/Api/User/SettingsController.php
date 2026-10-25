<?php
namespace App\Http\Controllers\Api\User;
use App\Http\Controllers\Controller;

// use App\ModelServices\FileService;
// use App\Services\ProfileService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;


use App\Http\Resources\UserResource;

use App\Services\User\UserSettingsService;

use function Laravel\Prompts\info;

class SettingsController extends Controller
{
    // protected SettingsService $settingsService;
    protected UserSettingsService $userSettingsService;

    public function __construct(UserSettingsService $userSettingsService)
    {
        // $this->settingsService = new SettingsService();
        $this->userSettingsService = $userSettingsService;
    }




    public function updateAuth(Request $request)
    {
        $user = Auth::user();
        $validated = $request->validate([
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'password' => 'required|min:8|confirmed', 
            'password_confirmation' => 'required|min:8',
        ]);
        abort(403, 'Updating auth is not allowed');
        try {
            $this->userSettingsService->setLogIn($user, $validated);
            return response()->json([
                'message' => 'LogIn information updated successfully!',
                'user' => new UserResource($user->fresh()),
                ], 200);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
    public function updateGmail(Request $request)
    {
        $user = Auth::user();
        $validated = $request->validate([
            'google_id' => 'required|string|max:255|unique:users,google_id,' . $user->id,
        ]);
        try {
            $this->userSettingsService->setGmail($user, $validated);
            return response()->json([
                'message' => 'Gmail was assign successfully!',
                'user' => new UserResource($user->fresh()),
            ], 200);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
    public function unassignGmail()
    {
        $user = Auth::user();
        try {
            $this->userSettingsService->unsetGmail($user);
            return response()->json([
                'message' => 'Gmail was removed successfully!',
                'user' => new UserResource($user->fresh()),
            ], 200);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
    // google2FA
    public function enable2FA(Request $request)
    {
        $user = Auth::user();
        $qrCodeUrl = $this->userSettingsService->set2FA($user);

        return response()->json([
            'message' => '2FA enabled successfully',
            'qrCodeUrl' => $qrCodeUrl,
            'user' => new UserResource($user->fresh()),
        ]);

    }
    public function disable2FA(Request $request)
    {
        $user = Auth::user();
        $this->userSettingsService->unset2FA($user);
        return response()->json([
            'message' => '2FA disabled successfully',
            'user' => new UserResource($user->fresh()),
        ]);
    }


    
}