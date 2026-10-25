<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Attributes\Table;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Str;

#[Fillable(['body', 'user_id',])]
#[Hidden([ 'chatroom_id'])]
#[Table('messages')]
class Message extends Model
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $casts = [
    ];
    public function chatroom(): BelongsTo
    {
        return $this->belongsTo(Chatroom::class);
    }
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    public function lightweightUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id')->lightUsers();
    }
}