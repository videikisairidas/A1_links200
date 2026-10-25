<?php

use App\Http\Controllers\Api\LogOutController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// use App\Http\Controllers\AuthController;

use App\Http\Controllers\Api\EventsController;


use App\Http\Controllers\Api\User\ProfileController;
use App\Http\Controllers\Api\User\SettingsController;
use App\Http\Controllers\Api\Media\MediaController;
// use Illuminate\Container\Attributes\Log;
use App\Http\Controllers\Api\LoginController;
use App\Http\Controllers\Api\User\NotificationController;
use App\Http\Controllers\Api\User\ChatController;
use App\Http\Controllers\Api\User\ChatroomController;
//global
use App\Http\Controllers\Api\SearchController;
// use App\Http\Controllers\Api\User\JobsController;
// use App\Http\Controllers\Api\User\AlertController;
// use App\Http\Controllers\Api\User\JobsController as JobsController2;

use function Laravel\Prompts\info;

Route::middleware('web')->group(function () {
    // login
    Route::post('/login-submit', [LoginController::class, 'login'])->name('login.submit');
    Route::post('/gmail-login', [LoginController::class, 'loginWithGmail'])->name('gmail.login');
    Route::post('/2fa-login', [LoginController::class, 'loginWith2FA'])->name('2fa.login');

    // countries
    Route::get('/countries', [ProfileController::class, 'getCountries'])->name('countries');
    // global 
    Route::get('/user-search', [SearchController::class, 'searchUsers'])->name('user.search');
    
});

// middle throttle:2,1 ||| 2 seconds for 1 request
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout-web', [LogOutController::class, 'logout_web'])->name('logout-web');
    Route::post('/logout-app', [LogOutController::class, 'logout_app'])->name('logout-app');

    Route::get('/user', [ProfileController::class, 'getUser'])->name('user.data');
    //notifications
    Route::get('/user/notifications', [NotificationController::class, 'getNotifications'])->middleware('web')->name('user.notifications');
    Route::post('/user/notification/create', [NotificationController::class, 'createNotification'])->name('notification.create');
    Route::post('/user/notification/read-all', [NotificationController::class, 'readNotification'])->name('notification.read');
    Route::delete('/user/notification/delete-all', [NotificationController::class, 'deleteNotification'])->name('notification.delete');
    //profile
    Route::post('/user/avatar-update', [ProfileController::class, 'updateAvatar'])->name('user.avatar.update');
    Route::post('/user/social-update', [ProfileController::class, 'updateSocialLinks'])->name('user.social.update');
    Route::post('/user/profile-update', [ProfileController::class, 'updateProfile'])->name('user.profile.update');
    Route::post('/user/address-update', [ProfileController::class, 'updateAddress'])->name('user.address.update');
    //settings
    Route::post('/user/auth-update', [SettingsController::class, 'updateAuth'])->name('user.auth.update');
    Route::post('/user/gmail/assign', [SettingsController::class, 'updateGmail'])->name('user.gmail.assign');
    Route::post('/user/gmail/unassign', [SettingsController::class, 'unassignGmail'])->name('user.gmail.unassign');
    Route::post('/user/2fa/enable', [SettingsController::class, 'enable2FA'])->name('user.2fa.enable');
    Route::post('/user/2fa/disable', [SettingsController::class, 'disable2FA'])->name('user.2fa.disable');
});
//chat
Route::middleware('auth:sanctum', 'web')->group(function () {
    Route::get('/user/chats', [ChatController::class, 'getChats'])->name('user.chats');
    Route::get('/user/chat-requests', [ChatController::class, 'getChatReuqests'])->name('user.chats.requests');
    Route::post('/user/chats/create', [ChatController::class, 'createChatRoom'])->name('user.chat.create');

    Route::get('/user/chat/{chatId}/messages', [ChatroomController::class, 'getAllMessages'])->name('user.chat.messages');
    Route::post('/user/chat/{chatId}/message-create', [ChatroomController::class, 'createMessage'])->name('user.chat.message.create');
    Route::patch('/user/chat/{chatId}/message/update/{messageId}', [ChatroomController::class, 'updateMessage'])->name('user.chat.message.update');
    Route::delete('/user/chat/{chatId}/message/delete/{messageId}', [ChatroomController::class, 'deleteMessage'])->name('user.chat.message.delete');
    

});

// 'role:administrator'
Route::middleware('auth:sanctum')->group(function () {
   Route::get('/media', [MediaController::class, 'getMedia'])->name('get.media.list');
});

// Route::get('/test-image', function () {
//     $manager = new ImageManager(new Driver());
//     $path = public_path('/storage/temp/avatar_1776366734.jpg'); // Ensure a file exists here
    
//     try {
//         // Try the explicit path decoder found in your debug list
//         $image = $manager->decodePath($path);
//         return "Success! Image width is: " . $image->width();
//     } catch (\Exception $e) {
//         return "Failed: " . $e->getMessage();
//     }
// });