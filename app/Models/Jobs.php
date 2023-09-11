<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jobs extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $table = 'jobs';
    /*protected $fillable = [
        'jobID',
        'tracksim_id',
        'steamID', 
        'jobMarket', 
        'distanceDriven', 
        'jobDistanceDriven', 
        'fuelBurned',
        'actualCargoDamaged',
        'jobCargoMass', 
        'gameId', 
        'truckMake', 
        'truckModel', 
        'jobCargo', 
        'jobCargoId', 
        'jobDestinationCity', 
        'jobDestinationCompany', 
        'jobSourceCity', 
        'jobSourceCompany', 
        'topSpeed', 
        'jobIncome', 
        'engineDamage', 
        'transmissionDamage', 
        'cabinDamage', 
        'chassisDamage', 
        'wheelDamage', 
        'jobStartedEpoch', 
        'jobEndedEpoch', 
        'jobAutoParkUsed', 
        'fuelPurchased'
    ];*/
    protected $guarded = [];
}
