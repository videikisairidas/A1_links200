<?php

// use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;

// Route::get('/test', function () {
//     return view('welcome');
// });

Route::get('/', function () {
    return view('frontend.pages.home');
});
Route::get('/av', function () {
    return view('frontend.pages.av');
});
Route::get('/200x-digital', function () {
    return view('frontend.pages.200x');
});
Route::get('/links200', function () {
    return view('frontend.pages.links200');
});
// Route::get('/maxyou200', function () {
//     return view('frontend.pages.maxyou200');
// });
Route::get('/maxyou200', function () {
    return view('frontend.pages.maxyou200');
});

// Route::get('/login', function () {
//     return view('frontend.auth.login');
// });

// Route::post('/login', [AuthController::class, 'login']);

// Route::get('/dashboard', function () {
//     return view('dashboard.dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

// Route::middleware('auth')->group(function () {
//     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
// });

// require __DIR__.'/auth.php';
