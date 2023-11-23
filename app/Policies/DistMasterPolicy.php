<?php

namespace App\Policies;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Session;
use App\Models\User;

class DistMasterPolicy
{


    use HandlesAuthorization;
    /**
     * 
     * Create a new policy instance.
     */
    

    public function view(User $user, DistMaster $model=null)
    {

        //dd(Session::get('permissions.view_distmaster'));
        if(Session::get('permissions.view_distmaster')==1)
        {
            if($model==null)
            {
                return 1;
            }
            
            
        }

        return 1;
    }

    public function create(User $user)
    {
        return 1;//Session::get('permissions.create_distmaster')==1;
      }

    public function update(User $user, DistMaster $model=null)
    {
        if(Session::get('permissions.update_distmaster')==1)
        {
            if($model==null)
            {
                return 1;
            }
            
            
        }

        return 1;}

    public function delete(User $user, DistMaster $model=null)
    {
        if(Session::get('permissions.delete_distmaster')==1)
        {

            if( $model!=null )
            { 
                if($model->hrmsdata==1)
                {
                  return 0;
                }
            }
            
            if($model==null)
            {
                return 1;
            }
           
            
        }

        return 1;
    }
}
