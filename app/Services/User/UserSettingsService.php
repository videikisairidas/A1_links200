<?php
namespace App\Services\User;

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use PragmaRX\Google2FA\Google2FA;

use App\Models\User;
use App\Models\UserProfile;
use App\Models\UserSetting;
use App\Models\Country;

class UserSettingsService
{   
    /**
     * Update user credentials.
     * 
     * @param  \App\Models\User  $user
     * @param  array<string, string>  $data
     * @return void
     */
    public function setLogIn(User $user, array $data) : void
    {
        $user->email = $data['email'];
        $user->password = $data['password'];
        $user->save();
        // $user->update([
        //     'email' => $data['email'],
        //     'password' => $data['password'], 
        // ]);
    }
    public function setGmail(User $user, array $data)
    {
        $user->google_id = $data['google_id'];
        $user->save();
        // DB::transaction(function () use ($user, $data) {
        //     $user->update([
        //         'google_id' => $data['google_id'],
        //     ]);
        // });
    }
    public function unsetGmail(User $user)
    {
        $user->google_id = null;
        $user->save();
        // DB::transaction(function () use ($user) {
        //     $user->update([
        //         'google_id' => null,
        //     ]);
        // });
    }
    //2fa 
    public function set2FA(User $user)
    {
        $google2fa = new Google2FA();

        $secret = $google2fa->generateSecretKey();

        $qrCodeUrl = $google2fa->getQRCodeUrl('Laravel API ', $user->email, $secret);

        $user->google2fa_secret = $secret;
        $user->is_2fa_enabled = true;
        $user->save();
        // $user->update([
        //     'google2fa_secret' => $secret,
        //     'is_2fa_enabled' => true,
        // ]);

        return $qrCodeUrl;
    }
    public function unset2FA(User $user)
    {
        $user->google2fa_secret = null;
        $user->is_2fa_enabled = false;
        $user->save();
    }

    // protected function setContent18Settings(User $user, $birthdate): void
    // {
    //     if ($birthdate) {
    //         $age = Carbon::parse($birthdate)->age;
    //         $user->userSetting()->update([
    //             'content_18' => $age >= 18
    //         ]);
    //     }
        
    // }
    
    /*later*/
    // public function setUserSettings(User $user, array $data): UserSetting
    // {
    //     $settings = $user->userSetting ?? new UserSetting();
    //     $settings->user_id = $user->id;
    //     // $settings->notifications = $data['notifications'] ?? $settings->notifications;
    //     // $settings->privacy = $data['privacy'] ?? $settings->privacy;
    //     $settings->save();

    //     return $settings;
    // }

}
