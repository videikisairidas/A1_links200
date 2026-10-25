<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

// use App\Models\Relationships\User\UserLink;
// Traits and methods
use App\Models\Traits\User\passwordNotification;
USE App\Models\Traits\User\ProfileDisplayMethods;
use App\Models\Traits\User\RoleMethods;
use App\Models\Traits\User\WalletMethods;
// use App\Models\Traits\User\ChatMethods;
// use App\Models\Traits\User\FollowerMethods;



// models
use App\Models\Role;
use App\Models\UserProfile;
use App\Models\UserSetting;
use App\Models\Address;
use App\Models\Membership;
use App\Models\Notification;
// use App\Models\Follower;
// use App\Models\FriendRequest;
use App\Models\Submissions;
use App\Models\Images;
use App\Models\Folder;
use App\Models\Conversation;
use App\Models\Message;
use App\Models\MessageStatus;
// Relationships
// use App\Models\Relations\User\Mediable;
//filter
// use App\Models\Traits\User\QueryFilter;
use App\Models\Traits\User\UserMethods;


#[Fillable(['email', 'password', 'google_id', 'is_2fa_enabled'])]
#[Hidden(['password', 'remember_token', 'google2fa_secret', 'pivot'])]
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    /* Extra */
    use UserMethods;
    // use passwordNotification;
    // use RoleMethods,
    // // ProfileMethods,
    // ProfileDisplayMethods,
    // WalletMethods;
    //  // friends
    // // FollowerMethods,
   
    // /*relationships*/
    // use Mediable;


    // //filter query
    // use QueryFilter;


    // converting to some type of data
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    //  Relationships
    public function role()
    {
        return $this->belongsTo(Role::class);
    }
    public function membership()
    {
        return $this->belongsTo(Membership::class);
    }
    public function userProfile()
    {
        return $this->hasOne(UserProfile::class, 'user_id');
    }
    public function userSetting()
    {
        return $this->hasOne(UserSetting::class);
    }
    public function address()
    {
        return $this->hasOne(Address::class, 'user_id');
    }
    // IMAGES
    public function avatar()
    {
        return $this->morphOne(Media::class, 'mediable')->where('collection_name', 'avatar')
            ->select(['sizes']);
    }

    public function background()
    {
        return $this->morphOne(Media::class, 'mediable')->where('collection_name', 'background');
    }

    public function photos()
    {
        return $this->morphMany(Media::class, 'mediable')->where('collection_name', 'photo');
    }
    // blocked
    public function blockedUsers()
    {
        return $this->belongsToMany(User::class, 'blocked_users', 'user_id', 'blocked_user_id');
    }
    public function blockedBy()
    {
        return $this->belongsToMany(User::class, 'blocked_users', 'blocked_user_id', 'user_id');
    }
    //notifications
    public function notifications()
    {
        return $this->hasMany(Notification::class, 'notifiable_id')->where('notifiable_type', 'App\Models\User');
    }
    //chat 
    public function chatrooms()
    {
        return $this->belongsToMany(Chatroom::class, 'chatroom_user', 'user_id', 'chatroom_id')
            ->withPivot('has_joined')
            ->wherePivot('has_joined', true);
    }
    public function chatroom_requests()
    {
        return $this->belongsToMany(Chatroom::class, 'chatroom_user', 'user_id', 'chatroom_id')
            ->withPivot('has_joined')
            ->wherePivot('has_joined', false);
    }
}
