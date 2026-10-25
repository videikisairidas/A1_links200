<?php 
namespace App\Services\User;

// use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;


use App\Models\User;
use App\Models\Role;

class UserCreationService 
{
    public function registerNewUser(array $data): User
    {
        $defaultRole = Role::query()->where('name', 'subscriber')->first();
        $defaultRoleId = $defaultRole ? $defaultRole->id : 3;
        //create user
        return DB::transaction(function () use ($data, $defaultRoleId) {
            
            // Instantiate the model without persisting immediately
            $user = new User();
            
            // Mass-assign safe fields using the model's standard attributes layer
            $user->fill([
                'email' => $data['email'],
                'google_id' => $data['google_id'] ?? null,
                // If your User model casts 'password' => 'hashed', raw values are safe.
                // Otherwise, explicitly enforce Hash::make($data['password']) here.
                'password' => $data['password'], 
            ]);

            // Set the guarded field explicitly via direct object property mutation
            $user->role_id = $defaultRoleId;
            
            // Save the complete record to the database
            $user->save();

            // 3. Provision dependent application tables
            $this->createUserProfile($user);
            $this->createUserSettings($user);

            return $user;
        });

    }

    protected function createUserProfile(User $user): void
    {
        $user->userProfile()->create([
            'username' => "account_" . Str::random(6),
        ]);
    }
    protected function createUserSettings(User $user): void
    {
        // $age = Carbon::parse($birthdate)->age;
        $user->userSetting()->create([
            // 'content_18' => $age >= 18
        ]);
    }

}