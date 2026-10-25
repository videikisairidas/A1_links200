<?php 
namespace App\Services\Files;

use App\Models\Media;
use Illuminate\Http\UploadedFile;

// use function Laravel\Prompts\info;

// use 

class ImageTempService
{
    public function saveTempImage(string $model, int $id, string $collection_name , UploadedFile $file) : Media
    {   
        //store
        $filename = $this->generateFileName($file , $collection_name);
        $this->storeTempImage($file, $filename);
        //create media
        $media = $this->createMediaDB($model, $id, $collection_name, $filename);
        
        return $media;
    }

    protected function generateFileName(UploadedFile $file, string $collection_name) : string
    {
        $ext = $file->getClientOriginalExtension();
        $filename = $collection_name . '_' . time() . '.' . $ext;
        return $filename;
    }
    protected function storeTempImage(UploadedFile $file, string $filename)
    {   
        $file->storeAs('temp', $filename, 'public');
    }
    protected function createMediaDB($model, $id, $collection_name, $filename) : Media
    {
        return Media::Create([
            'mediable_type' => $model,
            'mediable_id' => $id,
            'collection_name' => $collection_name,
            'file_name' => $filename,
        ]);
    }
}