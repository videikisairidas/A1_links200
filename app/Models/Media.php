<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Attributes\Table;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

#[Fillable(['mediable_type', 'mediable_id', 'collection_name', 'file_name', 'sizes', 'title', 'description'])]
#[Hidden(['user_id'])]
#[Table('media')]
class Media extends Model
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $casts = [
        'sizes' => 'array',
    ];

    public function mediable()
    {
        return $this->morphTo();
    }



}
