<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
// use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Attributes\Table;
// use Illuminate\Database\Eloquent\Attributes\WithoutTimestamps;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
// models
use App\Models\User;

#[Fillable('id','type', 'notifiable_id', 'notifiable_type', 'data', 'read_at')]
#[Table('notifications')]
// #[WithoutTimestamps]
class Notification extends Model {
    use HasApiTokens, HasFactory, Notifiable;
    
    protected $keyType = 'string';
    public $incrementing = false;

    protected $casts = [
        'data' => 'array',
    ];

    public function users() {
        return $this->belongsToMany(User::class);
    }

    // public function userProfiles() {
    //     return $this->hasMany(UserProfile::class);
    // }
}