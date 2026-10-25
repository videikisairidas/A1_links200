<?php 

use Illuminate\Support\Facades\Broadcast;

// Broadcast::channel('user.{id}', function ($user, $id) {
//     return (int) $user->id === (int) $id;
// });
Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    info('Private channel auth', [
        'auth_user' => $user->id,
        'channel_user' => $id,
    ]);

    return (int) $user->id === (int) $id;
});
