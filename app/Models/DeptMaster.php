<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class DeptMaster extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = [
        'distcode',
        'deptcode',
        'deptname',
        'address',
        'CentreState',
        'included',
        'catcode',
        'IncludedMo',
        'IncludedCP',
        'deptcodekey',
        'IncludedContractual',
        'hrmsdata'
       
    ];
    public function district()
    {
        return $this->belongsTo(DistMaster::class,'distcode','DistCode');
    }
    public function cs()
    {
        return $this->belongsTo(DeptCateg::class,'catcode','catcode');
    }
    public function cate()
    {
        return $this->belongsTo(DeptCateg::class,'catcode','catcode');
    }
}
