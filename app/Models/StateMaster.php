<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StateMaster extends Model
{
    use HasFactory;
    protected $primaryKey = 'statecode';
    protected $keyType = 'string';
    protected $fillable = [
        'statecode',
        'StateName',
    ];
   



    
}
