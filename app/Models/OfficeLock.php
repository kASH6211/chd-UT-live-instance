<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OfficeLock extends Model
{
    use HasFactory;
    protected $fillable=[
     'office_id',
     'distcode',
     'import',
     'employeesfinalized',
     'finalized'
    ];

    public function office(){
        return $this->belongsTo(OfficeMaster::class);
    }
    public function district(){
        return $this->belongsTo(DistMaster::class,'distcode','id');
    }
}
