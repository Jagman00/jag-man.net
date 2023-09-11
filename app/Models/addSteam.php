<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class addSteam extends Model
{
    use HasFactory;


    protected $table = 'users';

    protected $fillable = [
        'id',
        'steam_id'
    ];

}
