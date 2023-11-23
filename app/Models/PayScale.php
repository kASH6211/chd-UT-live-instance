<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PayScale extends Model
{
    use HasFactory;
    protected $fillable = [

        'distcode',
           
        'PayScaleCode',
           'PayScale',
           'class',
        
    ];
    public function selectedclass()
    {
        return $this->belongsTo(ClassMaster::class,'class','class');
    }
    public function district()
    {
        return $this->belongsTo(DistMaster::class,'distcode','DistCode');
    }
}
