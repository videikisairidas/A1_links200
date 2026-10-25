<?php
namespace App\Services\Media;

use Illuminate\Pagination\LengthAwarePaginator;

use App\Models\Media;

class MediaService
{

    public function getMediaPaged($perPage = 10) : LengthAwarePaginator
    {
        return Media::latest()->paginate($perPage);
    }

}
