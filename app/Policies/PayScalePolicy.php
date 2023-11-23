<?php

namespace App\Policies;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Session;
use App\Models\User;
use App\Models\PayScale;

    


class PayScalePolicy
{


    use HandlesAuthorization;
    
    /**
     * 
     * Create a new policy instance.
     */
    

    public function view(User $user, \App\Models\PayScale $model=null)
    {

        //dd(Session::get('permissions.view_distmaster'));
        if(Session::get('permissions.view_payscale')==1)
        {
            if($model==null)
            {
                return 1;
            }
            
            
        }

        return 0;
    }

    public function create(User $user,\App\Models\PayScale $model=null)
    {
        if(Session::get('permissions.create_payscale')==1)
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

    public function update(User $user, \App\Models\PayScale $model=null )
    {
        
        
        if(Session::get('permissions.update_payscale')==1)
        {

            if( $model!=null )
            { 
                if($model->hrmsdata==1)
                {
                    $ps=PayScale::where('id',$model->id)->first();
                    if($ps->PayScale==$model->PayScale)
                      return 1;

                    return 0;  
                }
            }

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

    public function delete(User $user, \App\Models\PayScale $model=null)
    {
        if(Session::get('permissions.delete_payscale')==1)
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
