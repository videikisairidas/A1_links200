<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
// use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Attributes\Table;
use Illuminate\Database\Eloquent\Attributes\WithoutTimestamps;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
// models
use App\Models\User;

#[Fillable('name')]
#[Table('roles')]
#[WithoutTimestamps]
class Role extends Model {
    use HasApiTokens, HasFactory, Notifiable;

    public function users() {
        return $this->belongsToMany(User::class);
    }

    // public function userProfiles() {
    //     return $this->hasMany(UserProfile::class);
    // }
}