<?php

namespace App\Models\Traits\User;

trait UserProfileMethods
{
    /**
     * Scope: load lightweight user details with lightweight profile.
     */
    public function scopeLightUserProfile($query)
    {
        return $query->select([
            'user_id',
            'username',
            'first_name',
            'middle_name',
            'last_name',
        ]);
    }
}