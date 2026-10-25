<?php 
namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

use App\Models\Media;
use App\Services\Files\ImageDeleteService;

// use App\Services\files\ImageResizeService;

use function Laravel\Prompts\info;

class ImageDeleteJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public Media $media;

    public function __construct(Media $media)
    {
        $this->media = $media;
    }

    public function handle(ImageDeleteService $deleteImageService)
    {
        $deleteImageService->deleteOldImages($this->media);
        $this->media->delete();
    }
}
