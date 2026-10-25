<?php 
namespace App\Models\Relations\User;

use App\Models\Media;
use App\Models\User;

trait Mediable
{
    public function avatar()
    {
        return $this->hasOne(Media::class, 'model_id')
            ->where('model_type', 'User')
            ->where('collection_name', 'avatar')
            ->latestOfMany();
    }

    // public function banner()
    // {
    //     return $this->morphOne(Media::class, 'mediable')->where('type', 'banner');
    // }

    // public function photos()
    // {
    //     return $this->morphMany(Media::class, 'mediable')->where('type', 'photo');
    // }

}