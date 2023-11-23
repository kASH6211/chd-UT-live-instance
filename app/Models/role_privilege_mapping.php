<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class role_privilege_mapping extends Model
{
    use HasFactory;
    protected $fillable = [
        'role_id',
        'privilege_id'
     ];

     function role()
    {
        return $this->belongsTo(Role::class);
    }
    function privileges()
    {
        return $this->belongsTo(Privileges::class,'privilege_id');
    }
    
 
}

