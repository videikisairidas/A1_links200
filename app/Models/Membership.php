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

#[Fillable(['title', 'monthly_limit', 'max_files_per_upload'])]
#[Hidden(['user_id'])]
#[Table('memberships')]
#[WithoutTimestamps]
class Membership extends Model
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'title',
        'monthly_limit',
        'max_files_per_upload',
    ];

    protected $casts = [
        'sizes' => 'array',
    ];

    public function monthlyUploadLimit(): int
    {
        return $this->monthly_limit;
    }




}
