<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class accountConnectionController extends Controller
{
    public function SteamRedirect()
    {
        return Socialite::driver('steam')->redirect();
    }

    public function SteamCallback()
    {
        $steam = Socialite::driver('steam')->user();
       
        User::where('id', Auth::id())->update(array('steam_id' => $steam->id));
       

        if(Auth::check()){
        return redirect('/dashboard');
        }
        return redirect()->route('auth.login')
            ->withErrors([
            'email' => 'Please login to access the dashboard.',
        ])->onlyInput('email');
    } 
    public function DiscordRedirect()
    {
        return Socialite::driver('discord')->redirect();
    }

    public function DiscordCallback() 
    {
        $discord = Socialite::driver('discord')->user();
        if(Auth::check()) {
            User::where('id', Auth::id())->update(array('discord_id' => $discord->id));
            return redirect('/dashboard');
        }
        return redirect()->route('auth.login')
            ->withErrors([
            'email' => 'Please login to access the dashboard.',
        ])->onlyInput('email');
    }
};
