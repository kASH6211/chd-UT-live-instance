<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PollingDataPhoto extends Model
{
    use HasFactory;
    protected $table = 'polling_data_photos';
    protected $primaryKey='id';
    protected $fillable = [
    'id',
    'empphoto',
    'deptslno',
    'PhotoFlag',
    ];

    
}
