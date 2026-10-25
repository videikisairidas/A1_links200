<?php
namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // $this refers directly to the underlying User model instance
        return [
            'id'             => $this->id,
            // 'token'          => $this->token,
            'role'           => $this->role?->name, // Directly grabs the name if role relation exists
            'google_id'      => $this->google_id,
            'is_2fa_enabled' => (bool) $this->is_2fa_enabled,
            'is_banned'      => (bool) $this->is_banned,
            'email'          => $this->email,

            // Always include related objects directly
            'user_profile'   => $this->userProfile,  
            'user_settings'  => $this->userSetting,  
            'avatar'         => $this->avatar,

            // Always include the structured address object
            'address'        => $this->address ? [
                ...$this->address->toArray(),
                'country_name' => $this->address->country?->name, // Directly checks nested relation
            ] : null,
        ];
    }
}
