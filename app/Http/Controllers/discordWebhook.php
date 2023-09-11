<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class discordWebhook extends Controller
{
    public function sendMessage($json, $type, $income)
    {
        $name = User::firstWhere('steam_id', $json['driver']['steam_id']);
        if (!$name) {
            $name = 'Unknown User';
            $avatar = "1688957496.png";
        } else {
            $avatar = $name->avatar;
        }
        if ($name->discord_id === null) {
            $username = '**' . $name->name . '**';
        } else {
            $username = '<@' . $name->discord_id . '>';
        }
        $timestamp = date("c", strtotime("now"));
        if ($type === 'jobCancelled') {
            return Http::post('https://discord.com/api/webhooks/1118186816634359808/bo9lrUfJBtaEOEd_6lw5MIR9ItJrrx-3mf1K25pEPHa6Hkk8-QDvatLlzkV_W0TXZ9VB', [
                'embeds' => [
                    [
                        'title' => 'Job Cancelled',
                        'thumbnail' => [
                            'url' => 'https://jag-man.net/avatars/' . $avatar
                        ],
                        'description' => 'A new job has been cancelled by ' . $username,
                        'color' => '7506394',
                        "footer" => [
                            "text" => "https://jag-man.net"
                        ],
                        "timestamp" => $timestamp,
                    ],
                ]
            ]);
        }


        if ($type === 'jobDelivered') {

            try {
        return Http::post('https://discord.com/api/webhooks/1118186816634359808/bo9lrUfJBtaEOEd_6lw5MIR9ItJrrx-3mf1K25pEPHa6Hkk8-QDvatLlzkV_W0TXZ9VB', 
        
        [

            'embeds' => [
                [
                    'title' => "Job Delivered",
                    'thumbnail' => [
                        'url' => 'https://jag-man.net/avatars/' . $avatar
                    ],
                    'description' => 'A new job has been delivered by ' . $username,
                    'color' => '7506394',
                    "footer" => [
                        "text" => "https://jag-man.net"
                    ],
                    "timestamp" => $timestamp,
                    'fields'=> [
                    [
                        'name' => ':arrow_right: From',
                        'value' => $json['source_city']['name'] . ', ' . $json['source_company']['name'],
                        'inline' => true
                    ],
                    [
                        'name' => ':arrow_right: To',
                        'value' => $json['destination_city']['name'] . ', ' . $json['destination_company']['name'],
                        'inline' => true
                    ],
                    [
                        'name' => ':map: Distance Driven',
                        'value' => round($json['driven_distance'], 0) . ' km',
                        'inline' => true
                    ],
                    [
                        'name' => ':package: Cargo',
                        'value' => $json['cargo']['name'],
                        'inline' => true
                    ],
                    [
                        'name' => ':euro: Income',
                        'value' => $income,
                        'inline' => true
                    ],
                    [
                        'name' => ':adhesive_bandage: Damage',
                        'value' => round($json['cargo']['damage']*100, 0) . ' %',
                        'inline' => true
                    ]
              
                        ]  
                ]
            ]
        ]);
    } catch (\Exception $e) {
        Log::error($e);
    }
    }
    }
}
