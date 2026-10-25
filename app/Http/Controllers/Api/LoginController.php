<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; 
use Laravel\Socialite\Facades\Socialite;
use PragmaRX\Google2FA\Google2FA;

// error rateLimit
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;

use App\Models\User;

// use function Laravel\Prompts\info;
class LoginController extends Controller
{
    public function login(Request $request)
    {
        $this->rateLimit($request);
        // 422 error
        $credentials = $request->validate([
            'email' => 'required|string|email|max:255|exists:users', //|string|email|max:255
            'password' => 'required|string|min:8', //|string|min:8
        ]);
        //

        if (!Auth::validate($credentials)) {
            return response()->json(['message' => 'Password is incorrect'], 422);
        }
        $user = User::query()->where('email', $credentials['email'])->firstOrFail();
       
        // WEB LOGIN
        return $this->processLogin($user, $request);

    }

    public function loginWithGmail(Request $request)
    {
        $validated = $request->validate([
            'google_id' => 'required|string|max:255',
        ]);

  
        $user = User::query()->where('google_id', $validated['google_id'])->first();

        if (!$user) {
            return response()->json(['message' => 'No user found with this Google account'], 422);
        }

        return $this->processLogin($user, $request);

    }
    public function loginWith2FA(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'code' => 'required|string|min:6|max:7',
        ], [
            'user_id.exists' => 'User not found',
        ]);


        $user = User::findOrFail($validated['user_id']);
        $this->checkBannedStatus($user);
        $google2fa = new Google2FA();

        if (!$google2fa->verifyKey($user->google2fa_secret, $validated['code'])) {
            return response()->json([
                'status' => 'error',
                'message' => 'Code is incorrect',
            ], 200);
        } 

        return $this->respondWithSuccess($user, $request);

       
    }
    private function processLogin(User $user, Request $request)
    {
        $this->checkBannedStatus($user);

        if ($user->is_2fa_enabled) {
            return response()->json([
                'status' => '2fa_required',
                'data' => ['user_id' => $user->id]
            ]);
        }

        return $this->respondWithSuccess($user, $request);
    }
    private function checkBannedStatus(User $user)
    {
        if ($user->is_banned) {
            // Abort sends a consistent JSON response if the client expects JSON
            abort(422, 'Your account has been banned.');
        }
    }
    private function respondWithSuccess(User $user, Request $request)
    {
        Auth::login($user);
        $request->session()->regenerate();
        $token = $user->createToken('api')->plainTextToken;

        return response()->json([
            'status' => 'success',
            'message' => 'Login successful',
            'token' => $token,
        ]);
    }
   
    protected function rateLimit(Request $request)
    {
        $key = Str::lower($request->input('email')).'|'.$request->ip();

        if (RateLimiter::tooManyAttempts($key, 15)) {
            $seconds = RateLimiter::availableIn($key);

            return response()->json([
                'message' => "Too many login attempts. Try again in {$seconds} seconds."
            ], 429)->throwResponse();
        }

        RateLimiter::hit($key, 60); // 60 seconds decay
    }

}
     // MOBILE API LOGIN
        // $token = $user->createToken('mobile')->plainTextToken;

        // return response()->json([
        //     'status' => 'success',
        //     'message' => 'Login successful (mobile)',
        //     'token' => $token,
        //     'user' => $user,
        // ]);
    // public function redirectToGoogle()
    // {
    //     /** @var \Laravel\Socialite\Two\GoogleProvider  */
    //     $driver = Socialite::driver('google');
    //     return $driver->stateless()->redirect();
    // }

    // public function handleGoogleCallback()
    // {
    //     /** @var \Laravel\Socialite\Two\GoogleProvider  */
    //     $driver = Socialite::driver('google');
    //     $googleUser = $driver->stateless()->user();

    //     $googleUserId = $googleUser->getId();
    //     $googleEmail = $googleUser->getEmail();
    //     $first_name = $googleUser->getName();
    //     $birth_date = now()->subYears(16);

    //     $user_1 = User::where('google_id', $googleUserId)->first();
    //     $user_2 = User::where('email', $googleEmail)->first();

    //     // Already registered with Google → login
    //     if ($user_1) {
    //         Auth::login($user_1);
    //         return redirect()->route('profile');
    //     }
    //     if ($user_2 && !$user_1) {
    //         return redirect()->route('login')->withErrors([
    //             'google' => 'Your account is registered without Google login. Please use your email and password.'
    //         ]);
    //     }

    //     if (!$user_1 && !$user_2) {

    //         $data = [
    //             'google_id' => $googleUserId,
    //             'email' => $googleEmail,
    //             'first_name' => $first_name,
    //             'birth_date' => $birth_date,
    //             'password' => Str::password(16),
    //         ];
    //         $user = $this->userCreationService->registerNewUser($data);

    //         Auth::login($user);
    //         return redirect()->route('profile');
    //     }

    //     return redirect()->route('profile');
    // }



    // public function enable2FA(Request $request)
    // {
    //     $google2fa = new Google2FA();

    //     $secret = $google2fa->generateSecretKey();

    //     $request->user()->update([
    //         'google2fa_secret' => $secret,
    //     ]);

    //     $QR_Image = $google2fa->getQRCodeInline(
    //         'Your App Name',
    //         $request->user()->email,
    //         $secret
    //     );

    //     return view('auth.2fa_setup', [
    //         'qr' => $QR_Image,
    //         'secret' => $secret
    //     ]);
    // }
    // public function verify2FA(Request $request)
    // {
    //     $request->validate([
    //         'code' => 'required'
    //     ]);

    //     $google2fa = new Google2FA();

    //     $valid = $google2fa->verifyKey(
    //         auth()->user()->google2fa_secret,
    //         $request->code
    //     );

    //     if ($valid) {
    //         session(['2fa_verified' => true]);
    //         return redirect()->intended('/');
    //     }

    //     return back()->withErrors(['code' => 'Invalid authentication code']);
    // }
