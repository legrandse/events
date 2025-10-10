<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OwnerController;

use App\Http\Controllers\WelcomeController;

use App\Http\Controllers\SocialController;


use App\Models\User;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Crypt;
use Propaganistas\LaravelPhone\PhoneNumber;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

	
	
   

Route::get('/', [WelcomeController::class, 'index'])->middleware(['guest'])->name('welcome');
Route::resource('owners', OwnerController::class);
Route::get('/redirect', [SocialController::class, 'redirectFacebook']);
    Route::get('/callback', [SocialController::class, 'facebookCallback']);
    Route::get('/google', [SocialController::class, 'redirectGoogle'])->name('auth.google');
    Route::get('/auth/google/callback', [SocialController::class, 'googleCallback']);

