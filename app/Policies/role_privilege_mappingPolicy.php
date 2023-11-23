<?php

namespace App\Policies;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Session;
use App\Models\User;

    


class role_privilege_mappingPolicy
{


    use HandlesAuthorization;
    
    /**
     * 
     * Create a new policy instance.
     */
    

    public function view(User $user, \App\Models\role_privilege_mapping $model=null)
    {

        //dd(Session::get('permissions.view_distmaster'));
        if(Session::get('permissions.view_role_privilege_mapping')==1)
        {
            if($model==null)
            {
                return 1;
            }
            
            
        }

        return 0;
    }

    public function create(User $user,\App\Models\role_privilege_mapping $model=null)
    {
        if(Session::get('permissions.create_role_privilege_mapping')==1)
        {
            if($model==null)
            {
                return 1;
            }
            else
            {

                switch($user->role_id)
                {

                case 1: return 1;
                          break;
                case 2: return 1;
                          break;
                case 3: if($model->distcode==$user->distcode)
                           return 1;
                        break;   
                case 4: if($model->distcode==$user->distcode)
                           return 1;
                        break;
                
                default: break;        


                }
              
            
            }
            
            
        }

        return 0;
      }

    public function update(User $user, \App\Models\role_privilege_mapping $model=null )
    {
        
        
        if(Session::get('permissions.update_role_privilege_mapping')==1)
        {
            if($model==null)
            {
                return 1;
            }
            else
            {

                if($user->role_id < $model->role_id)
                {

                   
                }
              
            
            }
            
            
        }

        return 0;
    }

    public function delete(User $user, \App\Models\role_privilege_mapping $model=null)
    {
        if(Session::get('permissions.delete_role_privilege_mapping')==1)
        {
            if($model==null)
            {
                return 1;
            }
            else
            {

                switch($user->role_id)
                {

                case 1: return 1;
                          break;
                case 2: return 1;
                          break;
                case 3: if($model->distcode==$user->distcode)
                           return 1;
                        break;   
                case 4: if($model->distcode==$user->distcode)
                           return 1;
                        break;
                
                default: break;        


                }
              
            
            }
           
            
        }

        return 0;
    }
}
