<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class HrmsDepartment extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = [
        'hrms_deptcode',
        'hrms_department',
        'hrms_department_address',
        'dise_deptcode',
    ];
}
