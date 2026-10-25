<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Attributes\Table;
use Illuminate\Database\Eloquent\Attributes\WithoutTimestamps;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
//model
use App\Models\User;

#[Fillable(['content_18'])]
#[Hidden(['user_id'])]
#[Table('user_setting')]
#[WithoutTimestamps]
class UserSetting extends Model
{
    use HasApiTokens, HasFactory, Notifiable;

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
