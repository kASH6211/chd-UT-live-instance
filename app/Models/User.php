<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;

use Illuminate\Database\Eloquent\Model;
class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'user_id',
        'email',
        'mobileno',
        'password',
        'role_id',
        'st_Code',
        'distcode',
        'deptcode',
        'subdeptcode',
        'officecode',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array<int, string>
     */
    protected $appends = [
        'profile_photo_url',
    ];

    public function role_privilege_mapping()
    {
        return $this->hasMany(role_privilege_mapping::class,'role_id','role_id');
    }
    public function userstate()
    {
        return $this->belongsTo(StateMaster::class,'st_Code','statecode');
    }
     public function userdistrict()
    {
        return $this->belongsTo(DistMaster::class,'distcode','DistCode');
    }
    public function userrole()
    {
        return $this->belongsTo(Role::class,'role_id','id');
    }
    // public function userdepartment()
    // {
    //     return $this->belongsTo(DeptMaster::class,'deptcode','deptcode');
    // }
    //  public function usersubdepartment()
    // {
    //     return $this->belongsTo(SubdeptMaster::class,'subdeptcode','deptcode');
    // }
}
