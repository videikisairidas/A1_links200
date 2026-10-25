<?php

namespace App\Http\Controllers\web_admin;
use App\Http\Controllers\Controller;

// use App\ModelServices\FileService;
// use App\Services\ProfileService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;




use App\Services\SettingsService;


class ProfileController extends Controller
{
    protected SettingsService $settingsService;

    public function __construct(SettingsService $settingsService)
    {
        $this->settingsService = $settingsService;
    }
    /**
     * Display the user's profile.
     *
     * @return \Illuminate\View\View
     */
    public function showProfile()
    {
        $user = Auth::user();

        $data = $this->settingsService->getProfileData($user);

        

        return view('dashboard.core.user-profile.index', $data);
    }


    /**
     * Update the user's login information.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateUserLogIn(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|min:8|confirmed', 
            'password_confirmation' => 'nullable|min:8',
        ]);

        $this->settingsService->setUserLogIn($user, $validated);

        return redirect()->back()->with('success', 'Profile updated successfully!');
    }

    public function updateUserProfile(Request $request)
    {
        $validated = $request->validate([
            'username'         => 'required|string|min:6|max:255|unique:user_profile,username,' . Auth::id(),
            'first_name'       => 'required|string|max:255',
            'middle_name'      => 'nullable|string|max:255',
            'last_name'        => 'nullable|string|max:255',
            'birth_date'       => 'required|date|before:today',
            'phone_number'     => 'nullable|string|max:20',
            'address'          => 'nullable|string|max:255',
            'city'             => 'nullable|string|max:255',
            'state'            => 'nullable|string|max:255',
            'post_code'        => 'nullable|string|max:10',
            'country_id'       => 'nullable|integer',
            'social_instagram' => 'nullable|url|max:255',
            'social_facebook'  => 'nullable|url|max:255',
            'social_twitter'   => 'nullable|url|max:255',
            'website_link'     => 'nullable|url|max:255',
        ]);

        try {
            $user = Auth::user();
            $this->settingsService->setUserProfile($user, $validated);
            return redirect()->back()->with('success', 'Profile updated successfully!');
        } catch (\Exception $e) {
            return back() 
                ->with('error', 'Something went wrong. Please try again.') 
                ->withInput();
        }
    }

    public function updateUserSettings(Request $request)
    {
        // $validated = $request->validate([
        //     'content_18' => '' . auth()->id(),
        // ]);
    }

    /**
     * Redirect the user to the Google authentication page.
     *
     * @return \Illuminate\Http\Response
     */
    public function profileRedirectToGoogle()
    {
        /** @var \Laravel\Socialite\Two\GoogleProvider  */
        $driver = Socialite::driver('google');

        return $driver->stateless()->redirect();
    }
    public function profileHandleGoogleCallback()
    {
        try {
            /** @var \Laravel\Socialite\Two\GoogleProvider  */
            $driver = Socialite::driver('google');
            $googleUser = $driver->stateless()->user();
        } catch (\Exception $e) {
            return redirect()->route('login')->withErrors(['google' => 'Failed to authenticate with Google.']);
        }

        $user = Auth::user();
        // Update their Google ID if not set
        if (!$user->google_id) {
            $user->update([
                'google_id' => $googleUser->getId(),
                'email' => $googleUser->getEmail(),
            ]);
        }

        return redirect()->route('profile')->with('success', 'Google account linked successfully!');
    }

}