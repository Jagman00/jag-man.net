<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Jobs;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Exception;
use Illuminate\Support\Facades\Log;

class trackSim extends Controller
{
    public function store(Request $request)
    {
        
        try {
            // Checking if Data Exists
            if(!isset($request->all()['data'])) {
                return response()->json([
                    'message' => 'Invalid Request.'
                ], 400);
            }

        //Get data from job
            $job_data = $request->all()['data']['object'];

        //Check if job exists

            if(Jobs::where('tracksim_id', $job_data['id'])->exists()) {
                return response() -> json([
                    'message' => 'Job already Exists.'
                ], 400);
            }

            $user = User::firstWhere('steam_id', $job_data['driver']['steam_id']);

            if (!$user) {
                return response()->json([
                    'message' => 'User not Found.'
                ], 400);
            }

            if ($request->all()['type'] === 'job.cancelled') {
                (new discordWebhook)->sendMessage($job_data, 'jobCancelled');
                return response()->json([
                    'message' => 'Job has been cancelled'
                ]);
            }

            if ($request->all()['type'] !== 'job.delivered') {
                return response()->json([
                    'message' => "Invalid Type.",
                ]);
            }

            

                try {
                    $income = collect($job_data['events'])->where('type', 'job.delivered')->first()['meta']['revenue'];

                } catch (Exception $e) {
                $income = '0';
                Log::error($e);
                    }

            
            $store_job = Jobs::create([
                'tracksim_id' => $job_data['id'],
                'steamid' => $job_data['driver']['steam_id'],
                'jobMarket' => $job_data['market'],
                'distanceDriven' => $job_data['driven_distance'],
                'jobDistanceDriven' => $job_data['planned_distance'],
                'fuelBurned' => $job_data['fuel_used'],
                'actualCargoDamage' => $job_data['cargo']['damage'],
                'jobCargoMass' => $job_data['cargo']['mass'],
                'gameId' => $job_data['game']['short_name'],
                'truckMake' => $job_data['truck']['brand']['name'],
                'truckModel' => $job_data['truck']['name'],
                'jobCargo' => $job_data['cargo']['name'],
                'jobCargoId' => $job_data['cargo']['unique_id'],
                'jobDestinationCity' => $job_data['destination_city']['name'],
                'jobDestinationCompany' => $job_data['destination_company']['name'],
                'jobSourceCity' => $job_data['source_city']['name'],
                'jobSourceCompany' => $job_data['source_company']['name'],
                'topSpeed' => $job_data['truck']['top_speed'],
                'jobIncome' => $income,
                'engineDamage' => $job_data['truck']['total_damage']['engine'],
                'transmissionDamage' => $job_data['truck']['total_damage']['transmission'],
                'cabinDamage' => $job_data['truck']['total_damage']['cabin'],
                'chassisDamage' => $job_data['truck']['total_damage']['chassis'],
                'wheelDamage' => $job_data['truck']['total_damage']['wheels'],
                'jobStartedEpoch' => $job_data['start_time'],
                'jobEndedEpoch' => $job_data['stop_time'],
            ]);

            (new discordWebhook)->sendMessage($job_data, 'jobDelivered', $income);
        

        return response()->json([
            'message' => 'Job has been saved to drivershub.'
        ]);

        } catch(Exception $e) {
            Log::error($e);
            return response()->json([
                'message' => $e->getMessage()
            ], 400);
        }
    }
}
