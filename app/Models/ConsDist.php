<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConsDist extends Model
{
    use HasFactory;
    protected $fillable = [
        'distcode',
    'ac_no',
    'ac_name',
    'admincontrol',
    'admindistcode',
    'innerpcircle',
    'innerpcirclef',
    'startpartyno',
    'locpartyno',
    'mostartpartyno',
    'molocpartyno',
    'mosurplus',
    'del',
        ];

        public function district()
        {
            return $this->belongsTo(DistMaster::class,'distcode','DistCode');
        }
        public function acname()
        {
            return $this->belongsTo(ConsList::class,'ac_no','AC_NO');
        }
    
}
