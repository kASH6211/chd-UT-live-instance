<?php

namespace App\Providers;

use App\Actions\Fortify\CreateNewUser;
use App\Actions\Fortify\ResetUserPassword;
use App\Actions\Fortify\UpdateUserPassword;
use App\Actions\Fortify\UpdateUserProfileInformation;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Laravel\Fortify\Fortify;
use App\Models\User;
use App\Models\Privileges;
use Illuminate\Support\Facades\Hash;
use Session;

class FortifyServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {

        Fortify::authenticateUsing(function (Request $request) {
            $user = User::where('user_id', $request->userid)->first();
            
            if ($user && Hash::check($request->password, $user->password)) {
                 
                $pp=array();
                $perm=Privileges::all();
                $type=array();
                foreach($perm as $y)
                {
                    $pp[$y->name]=0;
                    $type[$y->menutype]=0;
                }
                $p=$user->role_privilege_mapping;
                //dd($p);
                foreach($p as $x)
                {

                    $pp[$x->privileges->name]=1;
                    $type[$x->privileges->menutype]=1;
                }

                // dd($pp);
                
                //dd($type);

               
               
      
            
           
              // dd($type);
        
                Session::put('permissions',$pp);
                Session::put('menutype',$type);
                //Session::put('distcode',$user);
                
                //dd(Session::get('permissions.view_distmaster'));

            //    dd( Session::get('projectroles'));
                
                // Session::put('role_id',$user->role_id);
                // Session::put('role',$user->role->name);
                // Session::put('group_id',$user->group_id);
                // Session::put('group',$user->group->name);
                return $user;
            }
        });
        Fortify::createUsersUsing(CreateNewUser::class);
        Fortify::updateUserProfileInformationUsing(UpdateUserProfileInformation::class);
        Fortify::updateUserPasswordsUsing(UpdateUserPassword::class);
        Fortify::resetUserPasswordsUsing(ResetUserPassword::class);

        RateLimiter::for('login', function (Request $request) {
            $throttleKey = Str::transliterate(Str::lower($request->input(Fortify::username())).'|'.$request->ip());

            return Limit::perMinute(5)->by($throttleKey);
        });

        RateLimiter::for('two-factor', function (Request $request) {
            return Limit::perMinute(5)->by($request->session()->get('login.id'));
        });

        
    }
}
