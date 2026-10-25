<?php

namespace App\Models\Traits\User;

trait UserMethods
{
    /**
     * Scope: load lightweight user details with lightweight profile.
     */
    public function scopeLightUsersBase($query)
    {
        return $query
            ->with(['userProfile' => fn($q) => $q->lightUserProfile()])
            ->with(['avatar']);
    }
    public function scopeLightUsers($query)
    {
        return $query->select('users.id', 'users.email')
            ->lightUsersBase();
    }
    public function scopeLightUsersWithPivot($query)
    {
        return $query->select('users.id', 'users.email', 'chatroom_user.has_joined')
            ->lightUsersBase();
    }
}