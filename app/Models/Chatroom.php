<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Attributes\Table;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
//models
use App\Models\Message;


#[Fillable(['id', 'name', 'is_group'])]
#[Hidden(['pivot'])]
#[Table('chatrooms')]
class Chatroom extends Model
{
    public $incrementing = false;
    protected $keyType = 'string';

    use HasApiTokens, HasFactory, Notifiable;

    protected $casts = [
    ];
    //over write id to uuid

    // MODELS RELSTIONSHIPS
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }

    public function messages(): HasMany
    {
        return $this->hasMany(Message::class);
    }

}
