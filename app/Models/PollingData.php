<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\Rule;
use Illuminate\Database\Eloquent\SoftDeletes;


class PollingData extends Model
{
    use HasFactory;
    use SoftDeletes;
     protected $fillable = [
        'id',
        'distcode',
     //'rno',
     
     'Name',
     'FName',
     'rAddress',
     'HomeCons',
     'cons',
     'PayScaleCode',
     'basicPay',
     'office',
     'category',
     'DesigCode',
     //'SpouseWorking',
     'excercisedElectionDuty',
     'longLeave',
     'handicap',
     //'DOR',
     'BLO',
     'Remarks',
     //'id',
     //'login',
     'sex',
     'del',
     'dt',
     'deptcode',
     'officecode',
     //'PartyNo',
     //'POSNo',
    // 'reserve',
     //'cons_alot',
     //'StateCentre',
    //'sendtoother',
     //'sendreceivedist',
     //'oldrno',
     //'newpartyno',
     //'selected',
     'nativecon',
     'transferred',
     //'letterno',
     'epicno',
     //'centrecode',
     'mobileno',
     'emailid',
     'serialno',
    'partno',
     //'pan',
     'dob',
     'retiredt',
     'deptslno',
     //'exportdata',
     //'lotno',
     //'MachineSerialNumber',
     //'MachineName',
     //'ProcessorID',
     //'DataImportDate',
     'RegdVoterCons',
     //'AadhaarNo',
     //'EpicName',
     //'EpicFhName',
     //'EpicAadhaarNo',
     'BankId',
     'BankAcNo',
     'IfscCode',
     'EmpTypeId',
     'ddocode',
     'hrmscode',
     'ifmscode',
     'photoid'
     ];

     // Entry.php (Model)

     public function homeconstituency()
     {
         return $this->belongsTo(ConsList::class,'HomeCons','AC_NO');
     }
     public function department()
     {
         return $this->belongsTo(DeptMaster::class,'deptcode','deptcode');
     }
    //  public function officedata()
    //  {
    //      return $this->belongsTo(OfficeMaster::class,'officecode','officecode');
    //  }
     public function designation()
     {
         return $this->belongsTo(DesignationMaster::class,'DesigCode','DesigCode');
     }
     public function district()
     {
         return $this->belongsTo(DistMaster::class,'distcode','DistCode');
     }

     public function officeconstituency()
     {
         return $this->belongsTo(ConsList::class,'cons','AC_NO');
     }
     public function regdvotercons(){
        return $this->belongsTo(ConsList::class,'RegdVoterCons','AC_NO');
     }
     public function nativeconstituency()
     {
         return $this->belongsTo(ConsList::class,'nativecon','AC_NO');
     }

     public function employeetype()
     {
         return $this->belongsTo(EmpType::class,'EmpTypeId','EmpTypeId');
     }

     public function bank()
     {
         return $this->belongsTo(Bank::class,'BankId','BankId');
     }

     public function electionclass()
     {
         return $this->belongsTo(ClassMaster::class,'class','class');
     }

     public function photo()
     {
         return $this->belongsTo(PollingDataPhoto::class,'photoid','id');
     }
     




    

}
