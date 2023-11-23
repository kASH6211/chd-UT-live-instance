<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booth extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
    'DISTCODE',
'BOOTHNO',
'BOOTHNOA',
'CONSCODE',
'VILLAGE',
'POLLBUILD',
'POLLAREA',
'TYPE',
'TOTALVOTE',
'MALEVOTE',
'FEMALEVOTE',
'URBAN',
'FEMALEPARTY',
'NOOFOFFICER',
'RNO',
'PROCESSED',
'PARDANASHIN',
'CUNO',
'BUNO',
'CUNO1',
'BUNO1',
'MOREQUIRED',
'MOPROCESSED',
'PS_LOCN_NO',
'PHONE',
'DISTCODE_FROM',
'DEL',
'PS_LOCN_NO_KEY',
'PS_ID',
'OtherVote',
    ];
    public function consname()
    {
         return $this->belongsTo(ConsDist::class,'CONSCODE','ac_no');
    }
    public function distname()
    {
        return $this->belongsTo(DistMaster::class,'DISTCODE','DistCode');
    }
    public function locationname()
    {
        return $this->belongsTo(BoothLocn::class,'PS_LOCN_NO','PS_LOCN_NO');
    }

}
