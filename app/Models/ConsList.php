<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConsList extends Model
{
    use HasFactory;
    protected $fillable = [
    'ST_CODE',
   'Division_No',
   'distCode',
   'AC_NO',
    'AC_NAME',
   'AC_TYPE',
   'PC_NO',
    ];
}
