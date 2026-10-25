<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; 

use function Laravel\Prompts\info;

class LogOutController extends Controller
{   
    // logout API FOR REACT WEB
    public function logout_web(Request $request)
    {
        info("logout web");
        if (Auth::guard('web')->check()) {
            Auth::guard('web')->logout();
        }

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return response()->json(['message' => 'Logged out (web)'], 200);
    }
    // logout API For tokens (mobile app /desktop app)
    public function logout_app(Request $request)
    {
        $token = $request->user()?->currentAccessToken();

        if ($token) {
            $token->delete();
        }

        return response()->json(['message' => 'Logged out (app)'], 200);
    }
}


