<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConnectionMaster extends Model
{
    use HasFactory;
    protected $fillable = [
        'distcode',
        'host',
        'description',
        'database',
        'username',
        'password'
    ];
    public function district()
    {
        return $this->belongsTo(DistMaster::class,'distcode','DistCode');
    }
}
