<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubdeptMaster extends Model
{
    use HasFactory;
    protected $table="subdept_masters";
    protected $fillable = [
        
    'distcode',
    'deptcode',
    'subdeptcode',
    'subdept',
    'address',
    'subdeptcodekey',
    'distcode_from',
    'hrmsdata'
    ];

    public function district()
    {
        return $this->belongsTo(DistMaster::class,'distcode','DistCode');
    }

    public function department()
    {
        return $this->belongsTo(DeptMaster::class,'deptcode','deptcode');
    }

    
}
