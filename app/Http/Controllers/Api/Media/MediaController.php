<?php
namespace App\Http\Controllers\Api\Media;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\Services\Media\MediaService;



use function Laravel\Prompts\info;

class MediaController extends Controller
{   
    // MediaService
    protected $mediaService;

    public function __construct(MediaService $mediaService)
    {
        $this->mediaService = $mediaService;
    }

    public function getMedia(Request $request)
    {
        $validated = $request->validate([
            'page' => 'required|integer|min:1',
            'per_page' => 'required|integer|min:1|max:1000' ,
        ]);
        $page = $validated['page'];
        $perPage = $validated['per_page'];
        try {
            $media = $this->mediaService->getMediaPaged($perPage);
            return response()->json($media);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
        
    }
}