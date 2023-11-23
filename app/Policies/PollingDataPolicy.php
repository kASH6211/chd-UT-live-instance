<?php

namespace App\Policies;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Session;
use App\Models\User;
use App\Models\OfficeMaster;
use App\Models\OfficeLock;

    


class PollingDataPolicy
{


    use HandlesAuthorization;
    
    /**
     * 
     * Create a new policy instance.
     */
    

    public function view(User $user, \App\Models\PollingData $model=null)
    {

        //dd(Session::get('permissions.view_distmaster'));
       
            if(Session::get('permissions.view_pollingdata')==1)
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
                    case 4:  if($model->distcode==$user->distcode and $model->officecode==$user->officecode)
                               return 1;
                               break;
                    default: break;        
                   
                    }
                }
                
                
            }
        return 0;
    }

    public function create(User $user,\App\Models\PollingData $model=null)
    {

        if(Session::get('permissions.create_pollingdata')==1)
        {
            
            if($model==null and $user->role_id!=4)
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
                case 4: $offic=OfficeMaster::where('distcode',$user->distcode)->where('deptcode',$user->deptcode)->where('officecode',$user->officecode)->first();
                if($offic->haslock==null )
            {   
                if($model==null)
                {
                //    if($offic->hrmsdata==1)
                //    {
                //     return 0;
                //    }
                    return 1;
                }
                

                if($model->distcode==$user->distcode and $model->officecode==$user->officecode )

                    return 1;
                   break;
            }        
                
                
                
                default: break;        


                }
              
            
            }
            
            
        }

        return 0;
        
      }

    public function update(User $user, \App\Models\PollingData $model=null )
    {
        
        
        if(Session::get('permissions.update_pollingdata')==1)
        {
            if($model==null and $user->role_id!=4)
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
                case 4: $offic=OfficeMaster::where('distcode',$user->distcode)->where('deptcode',$user->deptcode)->where('officecode',$user->officecode)->first();
                if($offic->haslock==null )
                {   
                    if($model==null)
                        return 1;
                    if($model->transferred=='T')
                        return 1;
                    if($model->distcode==$user->distcode and $model->officecode==$user->officecode )
                        return 1;
                    break;
                 }        
                
                
                
                default: break;        


                }
              
            
            }
            
        }

        return 0;
    }

    public function delete(User $user, \App\Models\PollingData $model=null)
    {
        if(Session::get('permissions.delete_pollingdata')==1)
        {
            if( $model!=null )
            { 
                if($model->hrmsdata==1)
                {
                  return 0;
                }
            }
            if($model==null and $user->role_id!=4)
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
                case 4: $offic=OfficeMaster::where('distcode',$user->distcode)->where('deptcode',$user->deptcode)->where('officecode',$user->officecode)->first();
                if($offic->haslock==null )
            {   
                if($model==null)
                {
                    if($offic->hrmsdata==1)
                   {
                    return 0;
                   }
                   return 1;
                }
                

                if($model->distcode==$user->distcode and $model->officecode==$user->officecode )
                    return 1;
                   break;
            }        
                
                
                
                default: break;        


                }
              
            
            }
        }

        return 0;
    }
}
