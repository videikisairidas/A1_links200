<?php
namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Attributes\Table;
use Illuminate\Database\Eloquent\Attributes\WithoutTimestamps;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

use App\Models\User;
// use App\Models\Address;
// use App\Models\Country;
use App\Models\Traits\User\UserProfileMethods;

#[Fillable(['username', 'first_name', 'middle_name', 'last_name', 'birth_date', 'phone_number', 'bio', 'social_instagram', 'social_facebook', 'social_twitter', 'website_link'])]
#[Hidden(['user_id'])]
#[Table('user_profile')]
#[WithoutTimestamps]
class UserProfile extends Model
{

    use HasApiTokens, HasFactory, Notifiable;
    // use ProfileDisplayMethods;
    use UserProfileMethods;
    
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    

    
    
    
}
