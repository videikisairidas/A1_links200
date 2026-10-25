<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;
// use Illuminate\Database\Eloquent\Attributes\Hidden;
// use Illuminate\Database\Eloquent\Attributes\Table;
use Illuminate\Database\Eloquent\Attributes\WithoutTimestamps;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

// use App\Models\User;
use App\Models\Address;

#[Fillable('name', 'code', 'region')]
// #[Table('user_profile')]
#[WithoutTimestamps]
class Country extends Model
{
    use HasApiTokens, HasFactory, Notifiable;

    // Relationships
    public function address() 
    {
        return $this->hasMany(Address::class);
    }

}
