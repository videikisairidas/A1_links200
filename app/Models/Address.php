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
//models
use App\Models\User;
use App\Models\Country;

#[Fillable(['address', 'address2', 'city', 'state', 'post_code', 'country_id', 'name'])]
#[Hidden(['user_id', 'is_primary'])]
#[Table('addresses')]
#[WithoutTimestamps]
class Address extends Model
{
    use HasApiTokens, HasFactory, Notifiable;

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function country()
    {
        return $this->belongsTo(Country::class);
    }
}
