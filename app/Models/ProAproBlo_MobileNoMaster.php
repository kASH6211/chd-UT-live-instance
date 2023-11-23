<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProAproBlo_MobileNoMaster extends Model
{
    use HasFactory;
    protected $primaryKey='id';
    protected $fillable=[
        'id',
        'MobileNo',
        'Name',
        'Desig',
        'ElectDuty',
        'DistCode',
        'ConsCode',
        'BoothNo',
        'BoothNoA',
        'DataEntryDate',
        'del',
        'ps_id',
        'DeptSlNo',

    ];
}
