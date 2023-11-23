<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Booth;
use App\Models\ConsDist;
use App\Models\DistMaster;

class BoothLocn extends Model
{
    use HasFactory;
    protected $fillable = [

        'DISTCODE',
    'CONSCODE',
    'PS_LOCN_NO',
    'LOCN_BLDG_EN',
    'TOTAL_PS',
    'LOCN_CATY',
    'URBAN',
    'DISTCODE_FROM',
    'DEL',
    'ps_locn_no_key',
        ];

    public function consname()
    {
         return $this->belongsTo(ConsDist::class,'CONSCODE','ac_no');
    }
    public function distname()
    {
        return $this->belongsTo(DistMaster::class,'DISTCODE','DistCode');
    }
        
}
