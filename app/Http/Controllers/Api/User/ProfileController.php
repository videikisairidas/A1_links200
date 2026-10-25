<?php
namespace App\Http\Controllers\Api\User;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

use App\Models\User;
use App\Models\Country;
use App\Models\Media;
use App\Services\User\UserUpdateService;
use App\Services\Files\ImageTempService;
use App\Services\files\ImageResizeService;
//notification
// use App\Events\UserAlert;
// job
use App\Jobs\ImageDeleteJob;
// resources
use App\Http\Resources\UserResource;


// use function Laravel\Prompts\info;

class ProfileController extends Controller
{
    protected UserUpdateService $userUpdateService;

    public function __construct(UserUpdateService $userUpdateService)
    {
        $this->userUpdateService = $userUpdateService;
    }

    public function getUser(Request $request)
    {
        return new UserResource($request->user());
    }
    public function getCountries(Request $request)
    {
        return Country::all();
    }
    
    public function updateAvatar(
        Request $request,
        ImageTempService $imageTempService,
        ImageResizeService $resizeService
    ) {
        $validated = $request->validate([
            'avatar' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $user = $request->user();
        $file = $request->file('avatar');

        try {
            $media = $imageTempService->saveTempImage(User::class, $user->id, 'avatar', $file);
            $paths = $resizeService->resizeByType($media);
            // delete all old avatar
            $avatars = Media::query()
                ->where([
                    ['mediable_type', '=', User::class],
                    ['mediable_id', '=', $user->id],
                    ['collection_name', '=', 'avatar'],
                    ['id', '!=', $media->id]
                ])
                ->get();

            foreach ($avatars as $avatar) {
                ImageDeleteJob::dispatch($avatar);
            }
            info("test9");
            return response()->json([
                'message' => 'Avatar updated successfully',
                'user' => new UserResource($user->fresh()),
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to update avatar',
            ], 500);
        }
        
    }

    public function updateSocialLinks(Request $request)
    {
        $validated = $request->validate([
            'social_twitter'   => 'nullable|url|max:255',
            'social_facebook'  => 'nullable|url|max:255',
            'social_instagram' => 'nullable|url|max:255',
            'website_link'     => 'nullable|url|max:255',
        ]);

        $user = $request->user();

        try {
            $this->userUpdateService->setSocialLinks($user, $validated);

            return response()->json([
                'message' => 'Links updated successfully',
                'user' => new UserResource($user->fresh()),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to update links',
            ], 500);
        }
    } 
    public function updateProfile(Request $request)
    {   
        $validated = $request->validate([
            'username' => ['required', 'string', 'min:6', 'max:255', 'unique:user_profile,username,' . $request->user()->id],
            'first_name' => ['required', 'string', 'max:255'],
            'middle_name' => ['nullable', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'birth_date' => ['required', 'date', 'before:today'],
            'phone_number' => ['nullable', 'string', 'max:20'],
        ]);

        $user = $request->user();

        try {
            $this->userUpdateService->setProfile($user, $validated);

            return response()->json([
                'message' => 'Profile updated successfully',
                'user' => new UserResource($user->fresh()),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to update Profile',
                'errors' => $e->getMessage(),
            ], 500);
        }
    }
    
    public function updateAddress(Request $request)
    {
        $validated = $request->validate([
            'address' => ['required', 'string', 'max:255'],
            'address2' => ['nullable', 'string', 'max:255'],
            'city' => ['required', 'string', 'max:100'],
            'state' => ['required', 'string', 'max:100'],
            'post_code' => ['required', 'string', 'max:10'],
            'country_id' => ['required', 'exists:countries,id'],
        ]);
        info("test1");
        info(json_encode($validated));
        $user = $request->user();

        try {
            $this->userUpdateService->setAddress($user, $validated);
            // $address['country_name'] = $address->country->name ?? null;
            info("test4444");
            return response()->json([
                'message' => 'Address updated successfully',
                'user' => new UserResource($user->fresh()),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to update Address',
                'errors' => $e->getMessage(),
            ], 500);
        }
    }
}