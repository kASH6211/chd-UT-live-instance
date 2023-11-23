<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DistMaster extends Model
{
    use HasFactory;
    // use SoftDeletes;
   
    protected $fillable = [
        'st_Code',
        'Division_No',
        'DistCode',
        'DistName',
        'pBooths',
        'ActiveStatus',
        'finalcircle',
        'o_id',
    ];

    
}
