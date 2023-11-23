<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class HrmsOffice extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = [
       'hrms_distcode',
               'distcode',
               'hrms_deptcode',
               'deptcode',
               'hrms_officecode',
               'officecode',
               'officename',
               'officeaddress',
               
    ];
}
