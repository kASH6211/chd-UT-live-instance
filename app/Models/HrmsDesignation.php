<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class HrmsDesignation extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = [
        'hrms_desigcode',
        'hrms_designation',
        'dise_desigcode',
    ];
}
