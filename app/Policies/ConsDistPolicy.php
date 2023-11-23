<?php

namespace App\Policies;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Session;
use App\Models\User;


class ConsDistPolicy
{


    use HandlesAuthorization;
   
    /**
     * 
     * Create a new policy instance.
     */
    

    public function view(User $user, \App\Models\ConsDist $model=null)
    {

        //dd(Session::get('permissions.view_distmaster'));
        if(Session::get('permissions.view_consdist')==1)
        {
            if($model==null)
            {
                return 1;
            }
            
            
        }

        return 0;
    }

    

      public function create(User $user,\App\Models\ConsDist $model=null)
      {
          if(Session::get('permissions.create_consdist')==1)
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
                  case 5: if($model->distcode==$user->distcode)
                          return 1;
                          break;       
                  
                  default: break;        
  
  
                  }
                
              
              }
              
              
          }
  
          return 0;
        } 

    public function update(User $user, \App\Models\ConsDist $model=null)
    {
        if(Session::get('permissions.update_consdist')==1)
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
                case 5: if($model->distcode==$user->distcode)
                        return 1;
                        break;        
                
                default: break;        


                }
              
            
            }
            
            
        }

        return 0;}

    public function delete(User $user, \App\Models\ConsDist $model=null)
    {
        if(Session::get('permissions.delete_consdist')==1)
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
                case 5: if($model->distcode==$user->distcode)
                        return 1;
                        break;        
                
                default: break;        


                }
              
            
            }
           
            
        }

        return 0;
    }
}
