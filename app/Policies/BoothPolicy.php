<?php

namespace App\Policies;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Session;
use App\Models\User;

    


class BoothPolicy
{


    use HandlesAuthorization;
    
    /**
     * 
     * Create a new policy instance.
     */
    

    public function view(User $user, \App\Models\Booth $model=null)
    {

        //dd(Session::get('permissions.view_distmaster'));
        if(Session::get('permissions.view_booth')==1)
        {
            if($model==null)
            {
                return 1;
            }
            
            
        }

        return 0;
    }

    public function create(User $user,\App\Models\Booth $model=null)
    {
        if(Session::get('permissions.create_booth')==1)
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
                case 3: if($model->DISTCODE==$user->distcode)
                           return 1;
                        break;   
                case 4: if($model->DISTCODE==$user->distcode)
                           return 1;
                        break;
                
                default: break;        


                }
              
            
            }
            
            
        }

        return 0;
      }

    public function update(User $user, \App\Models\Booth $model=null )
    {
        
        
        if(Session::get('permissions.update_booth')==1)
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
                case 3: if($model->DISTCODE==$user->distcode)
                           return 1;
                        break;   
                case 4: if($model->DISTCODE==$user->distcode)
                           return 1;
                        break;
                
                default: break;        


                }
              
            
            }
            
            
        }

        return 0;
    }

    public function delete(User $user, \App\Models\Booth $model=null)
    {
        if(Session::get('permissions.delete_booth')==1)
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
                case 3: if($model->DISTCODE==$user->distcode)
                           return 1;
                        break;   
                case 4: if($model->DISTCODE==$user->distcode)
                           return 1;
                        break;
                
                default: break;        


                }
              
            
            }
           
            
        }

        return 0;
    }
}
