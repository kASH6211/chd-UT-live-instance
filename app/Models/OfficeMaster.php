<?php

namespace App\Models;

use App\Http\Livewire\Masters\District;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OfficeMaster extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = [
        'distcode',
        'deptcode',
        'officecode',
        'office',
        'address',
        'office_ac',
        'sno',
        'subdeptcode',
        'officecodekey',
        'subdeptcodekey',
        'distcode_from',
        'EmailID',
    ];

    public function haslock()
    {
        return $this->hasOne(OfficeLock::class,'office_id','id');
    }

    public function pollingData()
    {
        return $this->hasMany(PollingData::class, 'distcode', 'distcode')
                    ->where('deptcode', $this->deptcode)
                    ->where('officecode', $this->officecode);
    }
   
    public function acname()
    {
        return $this->belongsTo(ConsList::class,'office_ac','AC_NO');
    }
}
