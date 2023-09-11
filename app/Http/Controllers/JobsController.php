<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Jobs;
use Illuminate\Support\Facades\Http;

class JobsController extends Controller
{
    public function index(Request $request)
    {
    }

    public function store(Request $request)
    {
        $truckler_payload = $request['data'];

        $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL,"https://trucklerprocessor.jammerxd.dev/api/v1/process_delivery/88/3/");
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS,
                "data=" . $truckler_payload);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded'));


    // receive server response ...
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $server_output = curl_exec ($ch);
    $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close ($ch);
    if($httpcode == 200)
    {
        $json = json_decode($server_output,true);
        if (JSON_ERROR_NONE === json_last_error()) 
        {
            if($json['jobCancelPenalty'] > 0) {
                return 200;
            }
            if(!empty($json["steamID"]))
            {
                $job = new Jobs;
                $job->steamID = $json['steamID'];
                $job->jobMarket = $json['jobMarket'];
                $job->distanceDriven = $json['distanceDriven'];
                $job->jobDistanceDriven = $json['jobDistanceDriven'];
                $job->fuelBurned = $json['fuelBurned'];
                $job->actualCargoDamage = $json['actualCargoDamage'];
                $job->jobCargoMass = $json['jobCargoMass'];
                $job->gameId = $json['gameId'];
                $job->truckMake = $json['truckMake'];
                $job->truckModel = $json['truckModel'];
                $job->jobCargo = $json['jobCargo'];
                $job->jobCargoId = $json['jobCargoId'];
                $job->jobDestinationCity = $json['jobDestinationCity'];
                $job->jobDestinationCompany = $json['jobDestinationCompany'];
                $job->jobSourceCity = $json['jobSourceCity'];
                $job->jobSourceCompany = $json['jobSourceCompany'];
                $job->topSpeed = $json['topSpeed'];
                $job->jobIncome = $json['jobIncome'];
                $job->engineDamage = $json['engineDamage'];
                $job->transmissionDamage = $json['transmissionDamage'];
                $job->cabinDamage = $json['cabinDamage'];
                $job->chassisDamage = $json['chassisDamage'];
                $job->wheelDamage = $json['wheelDamage'];
                $job->jobStartedEpoch = $json['jobStartedEpoch'];
                $job->jobEndedEpoch = $json['jobEndedEpoch'];
                $job->jobAutoParkUsed = $json['jobAutoParkUsed'];
                $job->fuelPurchased = $json['fuelPurchased'];
                $job->save();

                (new discordWebhook)->sendMessage($json);
                return 200;
            }
        }
    }
    return 400;
}

    }

