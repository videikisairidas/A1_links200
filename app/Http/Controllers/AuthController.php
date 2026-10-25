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

use App\Services\User\UserCreationService;
use League\Config\Exception\ValidationException;

use function Laravel\Prompts\info;


class AuthController extends Controller
{
    protected UserCreationService $userCreationService;
    public function __construct(UserCreationService $userCreationService)
    {
        $this->userCreationService = $userCreationService;
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|string|email|max:255|exists:users', //|string|email|max:255
            'password' => 'required|string|min:8', //|string|min:8
        ]);

        if (!Auth::attempt($credentials)) {
            return response()->json(['message' => 'Email or password is incorrect'], 401);
        }

        $user = Auth::user();

        Auth::login($user);
        return redirect()->route('profile')->with('success', 'Registration successful! You are now logged in.');


    }

    public function register(Request $request)
    {
        // 1. Validate the incoming request data
        $validatedData = $request->validate([
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'], // Check uniqueness in 'users' table
            'password' => ['required', 'string', 'min:20', 'confirmed'],
        ]);

        $user = $this->userCreationService->registerNewUser($validatedData);

        Auth::login($user);

        if ($request->expectsJson()) {
            $token = $user->createToken('auth_token')->plainTextToken;
            return response()->json(['token' => $token, 'user' => $user], 201);
        }
    
        return redirect()->route('profile')->with('success', 'Registration successful! You are now logged in.');

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

        $user_1 = User::query()->where('google_id', $googleUserId)->first();
        $user_2 = User::query()->where('email', $googleEmail)->first();

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


    public function logout_web(Request $request)
    {
        // Check if we actually have a session to log out
        if (Auth::guard('web')->check()) {
            Auth::guard('web')->logout();
        }

        // Always invalidate to be safe, even if already logged out
        $request->session()->invalidate();
        
        // Regenerate CSRF token to prevent fixation attacks on the next login
        $request->session()->regenerateToken();

        return response()->json(['message' => 'Web session cleared'], 200);
    }
    public function logout_app(Request $request)
    {
        $user = $request->user();

        if ($user && $user->currentAccessToken()) {
            $user->currentAccessToken()->delete();
        }

        return response()->json(['message' => 'Logged out']);
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

        $google2fa = new Google2FA();

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

