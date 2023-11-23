<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DesignationMaster extends Model
{
    use HasFactory;
    use SoftDeletes;

   
        protected $fillable = [
            'distcode',
            'DesigCode',
            'Designation',
            'class',
            'SelectedCP',
            'desigcodekey',
            'distcode_from',
            'IncludedContractual',
            'hrmsdata',
        ];


    public function selectedclass()
    {
        return $this->belongsTo(ClassMaster::class,'class','class');
    }
    public function selectedcp()
    {
        return $this->belongsTo(SelectedCPMaster::class,'SelectedCP','code');
    }

    public function district()
    {
        return $this->belongsTo(DistMaster::class,'distcode','DistCode');
    }


        
        
}
