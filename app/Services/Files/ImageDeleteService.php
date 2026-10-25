<?php 
namespace App\Services\Files;

use Illuminate\Support\Facades\Storage;

use App\Models\Media;

class ImageDeleteService
{
    public function deleteTempImage(Media $media)
    {
        Storage::disk('public')->delete("temp/{$media->file_name}");
    }
    public function deleteOldImages(Media $media)
    {
        foreach ($media->sizes as $size => $path) {
            
            if (Storage::disk('public')->exists($path)) {
                Storage::disk('public')->delete($path);
            }
        }
    }
}