<?php

namespace App\Policies;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Session;
use App\Models\User;

    


class UserPolicy
{


    use HandlesAuthorization;
    
    /**
     * 
     * Create a new policy instance.
     */
    
    public function createofficebulkuser(User $user, \App\Models\User $model=null)
    {
         if($user->role_id==3)
         {
            return 1;
         }

         return 0;   
    }
    public function view(User $user, \App\Models\User $model=null)
    {

        //dd(Session::get('permissions.view_distmaster'));
        if(Session::get('permissions.view_user')==1)
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
                 case 3: if($model->distcode==$user->distcode and $model->role_id==$user->role_id+1)
                            return 1;
                         break;   
                 case 4: if($model->distcode==$user->distcode and $model->officecode==$user->officecode)
                         return 1;
                        break;
                 
                 default: break;        
 
 
                 }
               
             
             }
       }
       return 0;
    }

    public function create(User $user,\App\Models\User $model=null)
    {

        if(Session::get('permissions.create_user')==1)
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
                case 3:  if($model->distcode==$user->distcode and $model->role_id>=$user->role_id)
                           return 1;
                        break;   
                case 4: if($model->distcode==$user->distcode and $model->officecode==$user->officecode)
                        return 1;
                       break;
                
                default: break;        


                }
              
            
            }
      }
      return 0;
    }


    public function update(User $user, \App\Models\User $model=null )
    {
        
        
        if(Session::get('permissions.update_user')==1)
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
                case 3:  if($model->distcode==$user->distcode and $model->role_id>=$user->role_id)
                           return 1;
                        break;   
                case 4: if($model->distcode==$user->distcode and $model->officecode==$user->officecode)
                        return 1;
                       break;
                
                default: break;        


                }
              
            
            }
            
            
        }

        return 0;
    }

    public function delete(User $user, \App\Models\User $model=null)
    {
        if(Session::get('permissions.delete_user')==1)
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
                case 3:  if($model->distcode==$user->distcode and $model->role_id>=$user->role_id)
                           return 1;
                        break;   
                case 4: if($model->distcode==$user->distcode and $model->officecode==$user->officecode)
                        return 1;
                       break;
                
                default: break;        


                }
              
            
            }
           
            
        }

        return 0;
    }
}
