<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginRegisterController;
use App\Http\Controllers\UserController;
use Laravel\Socialite\Facades\Socialite;
use App\Http\Controllers\accountConnectionController;
use App\Http\Controllers\JobTableController;
use App\Http\Controllers\jobView;


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

Route::get('/', function () {
    return view('welcome');
});

Route::controller(LoginRegisterController::class)->group(function() {
    Route::get('/register', 'register')->name('register');
    Route::post('/store', 'store')->name('store');
    Route::get('/login', 'login')->name('login');
    Route::post('/authenticate', 'authenticate')->name('authenticate');
    Route::get('/dashboard', 'dashboard')->name('dashboard');
    Route::post('/logout', 'logout')->name('logout');
});

Route::get('/settings',[UserController::class, 'profilesettings'])->name('profilesettings');
Route::post('/settings', [UserController::class, 'store'])->name('user.profile.store');

Route::controller(accountConnectionController::class)->group(function () {
    Route::get('/steam-auth/redirect', 'SteamRedirect')->name('steam-auth');
    Route::get('/steam-auth/callback', 'SteamCallback');
    Route::get('/discord-auth/redirect', 'DiscordRedirect')->name('discord-auth');
    Route::get('discord-auth/callback', 'DiscordCallback');
});

Route::get('jobs', ['uses'=>'App\Http\Controllers\JobTableController@index', 'as'=>'jobs.index']);
//Route::get('job/{id}', [jobView::class, 'index']);
?>
