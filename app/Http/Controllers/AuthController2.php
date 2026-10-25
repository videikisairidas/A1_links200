<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; 
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;
use PragmaRX\Google2FAQRCode\Google2FA;
use PragmaRX\Google2FA\Google2FA as Google2FAService;

use App\Models\User; // Import the User model

use App\Services\UserCreationService;

class AuthController2 extends Controller
{
    protected UserCreationService $userCreationService;
    public function __construct(UserCreationService $userCreationService)
    {
        $this->userCreationService = $userCreationService;
    }

    public function redirectToGoogle()
    {
        /** @var \Laravel\Socialite\Two\GoogleProvider  */
        $driver = Socialite::driver('google');
        return $driver->stateless()->redirect();
    }

    public function handleGoogleCallback()
    {
        /** @var \Laravel\Socialite\Two\GoogleProvider  */
        $driver = Socialite::driver('google');
        $googleUser = $driver->stateless()->user();

        $googleUserId = $googleUser->getId();
        $googleEmail = $googleUser->getEmail();
        $first_name = $googleUser->getName();
        $birth_date = now()->subYears(16);

        $user_1 = User::where('google_id', $googleUserId)->first();
        $user_2 = User::where('email', $googleEmail)->first();

        // Already registered with Google → login
        if ($user_1) {
            Auth::login($user_1);
            return redirect()->route('profile');
        }
        if ($user_2 && !$user_1) {
            return redirect()->route('login')->withErrors([
                'google' => 'Your account is registered without Google login. Please use your email and password.'
            ]);
        }

        if (!$user_1 && !$user_2) {

            $data = [
                'google_id' => $googleUserId,
                'email' => $googleEmail,
                'first_name' => $first_name,
                'birth_date' => $birth_date,
                'password' => Str::password(16),
            ];
            $user = $this->userCreationService->registerNewUser($data);

            Auth::login($user);
            return redirect()->route('profile');
        }

        return redirect()->route('profile');
    }

    public function logout(Request $request)
    {
        // 1. Revoke API Tokens if using Sanctum
        if ($request->user()->currentAccessToken()) {
            $request->user()->currentAccessToken()->delete();
        }

        // 2. Clear Session for Blade
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return $request->expectsJson() 
            ? response()->json(['message' => 'Logged out']) 
            : redirect()->route('login');
    }

    public function enable2FA(Request $request)
    {
        $google2fa = new Google2FA();

        $secret = $google2fa->generateSecretKey();

        $request->user()->update([
            'google2fa_secret' => $secret,
        ]);

        $QR_Image = $google2fa->getQRCodeInline(
            'Your App Name',
            $request->user()->email,
            $secret
        );

        return view('auth.2fa_setup', [
            'qr' => $QR_Image,
            'secret' => $secret
        ]);
    }
    public function verify2FA(Request $request)
    {
        $request->validate([
            'code' => 'required'
        ]);

        $google2fa = new Google2FAService();

        $valid = $google2fa->verifyKey(
            auth()->user()->google2fa_secret,
            $request->code
        );

        if ($valid) {
            session(['2fa_verified' => true]);
            return redirect()->intended('/');
        }

        return back()->withErrors(['code' => 'Invalid authentication code']);
    }
}

