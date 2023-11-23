<?php

namespace App\Http\Livewire\Users;

use Livewire\Component;
use App\Models\Privileges;
use App\Models\role_privilege_mapping;
use App\Models\Session;
use Illuminate\Support\Facades\Auth;

class PrivilegesComponent extends Component
{
    public $editmode = false;
    public $privileges = null;
  
    public $mappedPrivileges = null;
    public $role;

   public function mount()
   {
    $this->role = 2;
    $this->loadprivileges();
    $this->loadMappedPrivileges();
   
   }

   public function render()
   {
    return view('livewire.users.privileges-component');
   }

   public function loadPrivileges()
   {
       $this->privileges = Privileges::where('type',1)->get();
   }
    public function loadMappedPrivileges()
   {
       $mapped= role_privilege_mapping::where('role_id',$this->role)->get();
       $setOfIds = $mapped->pluck('privilege_id')->toArray();
       $this->mappedPrivileges = array_fill_keys($setOfIds, true);
   }
   public function cancelEdit()
   {
    $this->toggle('edit');
   
   $this->loadMappedPrivileges();
    
   
   }
   public function savePrivileges()
   {
        
        $current = role_privilege_mapping::where('role_id',$this->role)->delete();
        foreach($this->mappedPrivileges as $key=>$prv)
        {   if($prv){
            $rpmapping = new role_privilege_mapping();
            $rpmapping->role_id = $this->role;
            $rpmapping->privilege_id = $key;
            $rpmapping->save();
        }
 
            
        }
        $sessions = Session::where('user_id','<>',Auth::user()->id)->delete();
      
        $this->emit('saved');
        $this->toggle('edit');
   }
   
    
    public function toggle($key)
    {
        if($key =="edit")
        {
            $this->editmode = !$this->editmode;
        }
    }
}






