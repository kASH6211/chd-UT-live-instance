<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ElectionInfo extends Model
{
    use HasFactory;
    protected $fillable=[
    'Distcode',
'DCName',
'pBooths',
'ElectionDate',
'ElectionStartTime',
'ElectionEndTime',
'AssemblyElection',
'ParliamentaryElection',
'installed',
'Electionname',
'pc_no',
    ];

}
