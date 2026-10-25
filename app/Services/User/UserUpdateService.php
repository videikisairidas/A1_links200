<?php 
namespace App\Services\User;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;


use App\Models\User;
use App\Models\Role;

class UserUpdateService
{
    public function setAvatar(User $user, array $data)
    {
        return DB::transaction(function () use ($user, $data) {
            $user->userProfile()->update($data);
            // return $user->userProfile()->first();
        });
    }
    public function setSocialLinks(User $user, array $data)
    {
        return DB::transaction(function () use ($user, $data) {
            $user->userProfile()->update($data);
            // return $user->userProfile()->first();
        });
    }
    public function setProfile(User $user, array $data)
    {
        return DB::transaction(function () use ($user, $data) {
        // Use the relationship to update
            $user->userProfile()->update($data);
            
            // Refresh and return the profile
            // return $user->userProfile()->first(); 
        });
    }
    public function setAddress(User $user, array $data)
    {
        info("test33");
        return DB::transaction(function () use ($user, $data) {
        // updateOrCreate returns the created/updated model instance directly
            $address = $user->address()->updateOrCreate(
                [], // Leave unique matching criteria blank if it's a strict 1-to-1 relationship mapping
                $data
            );
            // return $user->address()->updateOrCreate(
            //     ['user_id' => $user->id], // Attributes to find the record
            //     $data                     // Attributes to update/create
            // );
        });
    }

}