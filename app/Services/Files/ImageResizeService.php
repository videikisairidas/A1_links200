<?php 
namespace App\Services\Files;

use Intervention\Image\ImageManager;
use Intervention\Image\Interfaces\ImageInterface;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\Encoders\WebpEncoder; 
use Illuminate\Support\Facades\Storage;

use App\Models\Media;



use Nette\Utils\Json;
use function Laravel\Prompts\info;

class ImageResizeService
{
    protected array $config;
    protected $manager;
    

    public function __construct()
    {
        $this->manager = new ImageManager(new Driver());
        $this->config = config('media_av1');
    }

    public function resizeByType(Media $media): array
    {
        $type = $media->collection_name;
        $config = $this->config[$type];
        
        $sourcePath = Storage::disk('public')->path("temp/{$media->file_name}");
        $original = $this->manager->decode($sourcePath);
        
        $results = [];

        foreach ($config['sizes'] as $label => $dimensions) {
            $results[$label] = $this->processVariant($original, $media, $label, $dimensions, $config);
        }

        $media->update(['sizes' => $results]);
        Storage::disk('public')->delete("temp/{$media->file_name}");

        return $results;
    }

    /**
     * Handles the logic for a single size variant.
     */
    private function processVariant(ImageInterface $source, Media $media, string $label, ?array $dimensions, array $config): string
    {
        $image = clone $source;

        if ($dimensions) {
            $this->applyTransformation($image, $dimensions, $config['method'] ?? 'scale');
        }

        $encoded = $image->encode(new WebpEncoder(quality: 90));
        
        $folder = trim($config['path'] ?? $media->collection_name, '/');
        $name = pathinfo($media->file_name, PATHINFO_FILENAME);
        $path = "{$folder}/{$name}-{$label}.webp";

        Storage::disk('public')->put($path, (string) $encoded);

        return $path;
    }

    /**
     * Logic for HOW the pixels are manipulated.
     */
    private function applyTransformation(ImageInterface $image, array $dimensions, string $method): void
    {
        // Check for a zoom factor (e.g., 'small' => [100, 100, 'zoom' => 0.5])
        $zoom = $dimensions['zoom'] ?? null;

        if ($zoom) {
            $width = $image->width();
            $height = $image->height();
            
            // 1. Calculate the size of the square crop
            $cropSize = (int) (min($width, $height) * $zoom);
            
            // 2. Manual Center Calculation: (Total - Crop) / 2
            $offsetX = (int) (($width - $cropSize) / 2);
            $offsetY = (int) (($height - $cropSize) / 2);
            
            // 3. Perform the crop with explicit coordinates
            // This avoids passing 'center' and triggering the color decoder
            $image->crop($cropSize, $cropSize, $offsetX, $offsetY);
        }

        match ($method) {
            'scale' => $image->scaleDown($dimensions[0], $dimensions[1]),
            'cover' => $image->cover($dimensions[0], $dimensions[1]),
            'fit'   => $image->scale($dimensions[0], $dimensions[1]),
            default => $image->scaleDown($dimensions[0], $dimensions[1]),
        };
    }
}