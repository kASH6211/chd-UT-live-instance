<nav x-data="{ open: false }" class="bg-blue-900 border-b border-gray-100">
    <!-- Primary Navigation Menu -->
    <div class="mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex h-16 ">
            <div class="flex justify-start  w-80 items-center">
                <h1 class="text-sm  font-semibold text-white">NextGen DISE </h1>
            </div>
            <div class=" w-full flex justify-end">



                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    <x-dropdown align="right" width="64" nodropdown="true">

                        <x-slot name="trigger">
                            <span class="inline-flex rounded-md">
                                <a type="button" href="{{ route('dashboard') }}" class="cursor-pointer hover:bg-blue-700/50 rounded-md inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium  text-white bg-blue-900  focus:outline-none  transition ease-in-out duration-150">

                                    {{__('Dashboard')}}

                                </a>
                            </span>
                        </x-slot>
                        <x-slot name="content">
                            <!-- Account Management -->


                        </x-slot>
                    </x-dropdown>
                    @if(Session::get('menutype.masters')==1)       
                    <x-dropdown align="right" width="64">
                        <x-slot name="trigger">
                            
                            <span class="inline-flex rounded-md">
                                <button type="button" class=" hover:bg-blue-700/50 rounded-md inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium  text-white bg-blue-900  focus:outline-none  transition ease-in-out duration-150">
                                    {{__('Masters')}}
                                    <svg class="ml-2 -mr-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                                    </svg>
                                </button>
                            </span>
                        </x-slot>
                        <x-slot name="content">
                            <!-- Account Management -->
                            @canany(['view','create','update','delete'],[App\DesignationMaster::class])
                            <x-dropdown-link href="/master/designation">
                                {{ __('Designation Master') }}
                            </x-dropdown-link>
                            @endcanany
                            @canany(['view','create','update','delete'],[App\PayScale::class])
                            <x-dropdown-link href="/master/payscale">
                                {{ __('Pay Scale/ Grade Pay Master') }}
                            </x-dropdown-link>
                            @endcanany
                            @canany(['view','create','update','delete'],[App\ConsDist::class])
                            <x-dropdown-link href="/master/district/constituency">
                                {{ __('Constituency Master') }}
                            </x-dropdown-link>
                            @endcanany
                            @canany(['view','create','update','delete'],[App\DeptMaster::class])
                            <x-dropdown-link href="/master/department">
                                {{ __('Department  Master') }}
                            </x-dropdown-link>
                            @endcanany
                            @canany(['view','create','update','delete'],[App\SubDeptMaster::class])
                            <x-dropdown-link href="/master/subdepartment">
                                {{ __('Sub-department Master') }}
                            </x-dropdown-link>
                            @endcanany
                            @canany(['view','create','update','delete'],[App\OfficeMaster::class])
                            <x-dropdown-link href="/master/office">
                                {{ __('Office Master') }}
                            </x-dropdown-link>
                            @endcanany
                            @canany(['view','create','update','delete'],[App\BoothLocn::class])
                            <x-dropdown-link href="/master/boothlocn">
                                {{ __('Booth Locations Master') }}
                            </x-dropdown-link>
                            @endcanany
                            @canany(['view','create','update','delete'],[App\Booth::class])
                            <x-dropdown-link href="/master/booth">
                                {{ __('Booth Master') }}
                            </x-dropdown-link>
                            @endcanany
                        </x-slot>
                    </x-dropdown>
                @endif
                @if(Session::get('menutype.transactions')==1)
                    <x-dropdown align="right" width="64">
                        <x-slot name="trigger">
                            <span class="inline-flex rounded-md">
                                <button type="button" class=" hover:bg-blue-700/50 rounded-md inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium  text-white bg-blue-900  focus:outline-none  transition ease-in-out duration-150">
                                    {{__('Transactions')}}
                                    <svg class="ml-2 -mr-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                                    </svg>
                                </button>
                            </span>
                        </x-slot>
                        <x-slot name="content">
                            <!-- Account Management -->
                            @if(Auth::user()->role_id==4)
                            @canany(['view','create','update','delete'],[App\PollingData::class])
                           
                            
                            <x-dropdown-link href="/transactions/employee">
                                {{ __('Polling Personnel Data') }}
                            </x-dropdown-link>
                            @endcanany
                            @endif
                            @if(Session::get('permissions.submitted_offices')==1)
                            <x-dropdown-link href="/transactions/submitted">
                                {{ __('Process Office Data') }}
                            </x-dropdown-link>
                            @endif
                            @if(Session::get('permissions.finalized_offices')==1)
                            {{-- <x-dropdown-link href="/transactions/finalized">
                                {{ __('Finalized Offices') }}
                            </x-dropdown-link> --}}
                            @endif
                            @if(Session::get('permissions.mark_exemptions')==1)
                            <x-dropdown-link href="/transactions/exemption">
                                {{ __('Mark Exemptions') }}
                            </x-dropdown-link>
                            @endif
                            @if(Session::get('permissions.transfer_employee')==1)
                            <x-dropdown-link href="/transactions/transfer">
                                {{ __('Transfer Employee') }}
                            </x-dropdown-link>
                            @endif
                            {{-- <x-dropdown-link href="#" @click.prevent="$root.submit();">
                                {{ __('Polling Personnel Data Editing by Office') }}
                            </x-dropdown-link>
                            <x-dropdown-link href="#" @click.prevent="$root.submit();">
                                {{ __('Unlocking & Marking as Regular/Contractual') }}
                            </x-dropdown-link> --}}

                        </x-slot>
                    </x-dropdown>

                    {{-- <x-dropdown align="right" width="64">
                        <x-slot name="trigger">
                            <span class="inline-flex rounded-md">
                                <button type="button" class=" hover:bg-blue-700/50 rounded-md inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium  text-white bg-blue-900  focus:outline-none  transition ease-in-out duration-150">
                                    {{__('Query')}}
                    <svg class="ml-2 -mr-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                    </svg>
                    </button>
                    </span>
                    </x-slot>
                    <x-slot name="content">
                        <!-- Account Management -->
                        <x-dropdown-link href="#" @click.prevent="$root.submit();">
                            {{ __('Search on Name') }}
                        </x-dropdown-link>
                    </x-slot>
                    </x-dropdown> --}}

                    @endif
                    @if(Session::get('menutype.reports')==1)    
                    <x-dropdown align="right" width="64">
                        <x-slot name="trigger">
                            <span class="inline-flex rounded-md">
                                <button type="button" class=" hover:bg-blue-700/50 rounded-md inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium  text-white bg-blue-900  focus:outline-none  transition ease-in-out duration-150">
                                    {{__('Reports')}}
                                    <svg class="ml-2 -mr-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                                    </svg>
                                </button>
                            </span>
                        </x-slot>
                        <x-slot name="content">
                            <!-- Account Management -->
                            @if(Session::get('permissions.view_customizedchecklist')==1)
                            <x-dropdown-link href="/reports/customizedchecklist">
                                {{ __('Customized Checklist') }}
                            
                            </x-dropdown-link>
                            @endif
                            @if(Session::get('permissions.view_undertaking')==1)
                            <x-dropdown-link href="/reports/undertaking">
                                {{ __('Undertaking') }}
                                 </x-dropdown-link>
                                 @endif
                                 
                                 @if(Session::get('permissions.designationmaster_report')==1)  
                            <x-dropdown-link href="/reports/designationmaster">
                                {{ __('Designation Master') }}
                            
                            </x-dropdown-link>
                            @endif
                            @if(Session::get('permissions.payscalemaster_report')==1)  
                            <x-dropdown-link href="/reports/payscalemaster">
                                {{ __('Pay Scale Master') }}
                            
                            </x-dropdown-link>
                            @endif
                            @if(Session::get('permissions.exemptionlist_report')==1) 
                            <x-dropdown-link href="/reports/exemptionlist">
                                {{ __('Exemptions List') }}
                            </x-dropdown-link>
                            @endif
                            @if(Session::get('permissions.emailchecklist_report')==1) 
                            <x-dropdown-link href="/reports/emailchecklist">
                                {{ __('Email Checklist') }}
                            </x-dropdown-link>
                            @endif
                            {{-- <x-dropdown-link href="#" @click.prevent="$root.submit();">
                                {{ __('Checklist Signed by Staff') }}
                            </x-dropdown-link>
                            <x-dropdown-link href="#" @click.prevent="$root.submit();">
                                {{ __('Voter Registered at AC is Different From Office/Residence/Native AC') }}
                            </x-dropdown-link>
                            <x-dropdown-link href="#" @click.prevent="$root.submit();">
                                {{ __('Print Undertaking') }}
                            </x-dropdown-link>
                            <x-dropdown-link href="#" @click.prevent="$root.submit();">
                                {{ __('Designation Master') }}
                            </x-dropdown-link>
                            <x-dropdown-link href="#" @click.prevent="$root.submit();">
                                {{ __('Payscale Master') }}
                            </x-dropdown-link>
                            <x-dropdown-link href="#" @click.prevent="$root.submit();">
                                {{ __('Summary of Entered Records Available For Export') }}
                            </x-dropdown-link>
                            <x-dropdown-link href="#" @click.prevent="$root.submit();">
                                {{ __('Summary of Employees Data Already Exported') }}
                            </x-dropdown-link> --}}





                        </x-slot>
                    </x-dropdown>

                  @endif

                    {{-- @if(Auth::user()->role_id!=4)  --}}
                    @if(Session::get('menutype.administration')==1) 
                    <x-dropdown align="right" width="64">
                        <x-slot name="trigger">
                            <span class="inline-flex rounded-md">
                                <button type="button" class=" hover:bg-blue-700/50 rounded-md inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium  text-white bg-blue-900  focus:outline-none  transition ease-in-out duration-150">
                                    {{__('Administration')}}
                                    <svg class="ml-2 -mr-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                                    </svg>
                                </button>
                            </span>
                        </x-slot>
                        <x-slot name="content">
                            <!-- Account Management -->
                            @if(Session::get('permissions.import_to_dise')==1)
                            <x-dropdown-link href="/import/pulldata">
                                {{ __('Import Data to DISE') }}
                            </x-dropdown-link>
                            @endif
                            @if(Session::get('permissions.importfrom_hrms')==1)
                            <x-dropdown-link href="/import/hrmsdata">
                                {{ __('Import Data From HRMS to DISE') }}
                            </x-dropdown-link>
                            @endif
                            @if(Session::get('permissions.portal_configuration')==1)
                            <x-dropdown-link href="/configure">
                                {{ __('Portal Configuration Settings') }}
                            </x-dropdown-link>
                            @endif
                            {{-- <x-dropdown-link href="#" @click.prevent="$root.submit();">
                                {{ __('Backup Database') }}
                            </x-dropdown-link> --}}

                        </x-slot>
                    </x-dropdown>
                    @endif
                    {{-- @endif --}}

                    {{-- @if(Auth::user()->role_id!=4)  --}}
                    
                    {{-- @endif --}}

                    @if(Session::get('menutype.users')==1)    
                    <x-dropdown align="right" width="64">
                        <x-slot name="trigger">
                            <span class="inline-flex rounded-md">
                                <button type="button" class=" hover:bg-blue-700/50 rounded-md inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium  text-white bg-blue-900  focus:outline-none  transition ease-in-out duration-150">
                                    {{__('User Management')}}
                                    <svg class="ml-2 -mr-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                                    </svg>
                                </button>
                            </span>
                        </x-slot>
                        <x-slot name="content">
                            <!-- Account Management -->

                            @canany(['view','create','update','delete'],[App\User::class])
                           
                            <x-dropdown-link href="{{ route('users') }}">

                                {{ __('Users') }}
                            </x-dropdown-link>
                            @endcanany
                            @canany(['view','create','update','delete'],[App\role_privilege_mapping::class])
                           
                            
                            <x-dropdown-link href="/users/privileges">
                                {{ __('Privileges') }}
                            </x-dropdown-link>
                            @endcanany
                        </x-slot>
                    </x-dropdown>

@endif

{{-- <x-dropdown align="right" width="64" nodropdown="true">

    <x-slot name="trigger">
        <span class="inline-flex rounded-md">
            <a type="button" href="{{ route('dashboard') }}" class="cursor-pointer hover:bg-blue-700/50 rounded-md inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium  text-white bg-blue-900  focus:outline-none  transition ease-in-out duration-150">

                {{__('About')}}

            </a>
        </span>
    </x-slot>
    <x-slot name="content">
        <!-- Account Management -->


    </x-slot>
</x-dropdown> --}}
                </div>
            </div>

            <div class="hidden sm:flex sm:items-center sm:ml-6">
                <!-- Teams Dropdown -->
                @if (Laravel\Jetstream\Jetstream::hasTeamFeatures())
                <div class="ml-3 relative">
                    <x-dropdown align="right" width="60">
                        <x-slot name="trigger">
                            <span class="inline-flex rounded-md">
                                <button type="button" class=" hover:bg-blue-700/50  inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none focus:bg-gray-50 active:bg-gray-50 transition ease-in-out duration-150">
                                    {{ Auth::user()->currentTeam->name }}

                                    <svg class="ml-2 -mr-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 15L12 18.75 15.75 15m-7.5-6L12 5.25 15.75 9" />
                                    </svg>
                                </button>
                            </span>
                        </x-slot>

                        <x-slot name="content">
                            <div class="w-60">
                                <!-- Team Management -->
                                <div class="block px-4 py-2 text-xs text-gray-400">
                                    {{ __('Profile') }}
                                </div>

                                <!-- Team Settings -->
                                <x-dropdown-link href="{{ route('teams.show', Auth::user()->currentTeam->id) }}">
                                    {{ __('Team Settings') }}
                                </x-dropdown-link>

                                @can('create', Laravel\Jetstream\Jetstream::newTeamModel())
                                <x-dropdown-link href="{{ route('teams.create') }}">
                                    {{ __('Create New Team') }}
                                </x-dropdown-link>
                                @endcan

                                <!-- Team Switcher -->
                                @if (Auth::user()->allTeams()->count() > 1)
                                <div class="border-t border-gray-200"></div>

                                <div class="block px-4 py-2 text-xs text-gray-400">
                                    {{ __('Switch Teams') }}
                                </div>

                                @foreach (Auth::user()->allTeams() as $team)
                                <x-switchable-team :team="$team" />
                                @endforeach
                                @endif
                            </div>
                        </x-slot>
                    </x-dropdown>
                </div>
                @endif

                <!-- Settings Dropdown -->
                <div class="ml-3 relative">
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                            <button class="flex text-sm border-2 border-transparent rounded-full focus:outline-none focus:border-gray-300 transition">
                                <img class="h-8 w-8 rounded-full object-cover" src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}" />
                            </button>
                            @else
                            <span class="inline-flex rounded-md ">
                                <button type="button" class=" hover:bg-blue-700/50 rounded-md inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium  text-white bg-blue-900  focus:outline-none  transition ease-in-out duration-150">
                                    @php
                                    $words = explode(" ", Auth::user()->name);
                                    $acronym = "";
                                    foreach ($words as $w) {
                                    $acronym .= mb_substr($w, 0, 1);
                                    }
                                    @endphp
                                    <div class="bg-blue-800 w-9 h-9 rounded-full p-2">{{$acronym}}</div>

                                    <svg class="ml-2 -mr-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                                    </svg>
                                </button>
                            </span>
                            @endif
                        </x-slot>

                        <x-slot name="content">
                            <!-- Account Management -->
                            <div class="bg-blue-200 rounded-md flex flex-col justify-center items-center m-2 p-3">
                                <div class="bg-blue-900 w-9 h-9 rounded-full p-2 text-white text-sm">{{$acronym}}</div>
                                <div class="block px-4 pt-2 text-xs text-gray-400">
                                    <div class=" text-blue-900 w-full text-center  border-blue-300 pb-1">{{ Auth::user()->name }}</div>
                                    <div class=" text-blue-900 w-full text-center border border-dashed border-blue-900 rounded-md pt-1  pb-1"> {{ Auth::user()->userrole->name }}</div>
                                    <div class=" text-blue-900 w-full text-center pt-1 "> {{ Auth::user()->user_id }}</div>
                                
                                </div>

                            </div>
                            <div class="w-full group hover:bg-blue-900 group-hover:text-white   px-4 py-2 text-xs text-gray-700 ">
                                <span class=" text-gray-700">
                                    <a href="/user/profile" class="group-hover:text-white">Change Password </a>
                                </span><br />
                            </div>
                            
                           

                            <xsub-title>

                            </xsub-title>

                            @if (Laravel\Jetstream\Jetstream::hasApiFeatures())
                            <x-dropdown-link href="{{ route('api-tokens.index') }}" >
                                {{ __('API Tokens') }}
                            </x-dropdown-link>
                            @endif

                            <div class="border-t border-gray-200"></div>

                            <!-- Authentication -->
                            <form method="POST" action="{{ route('logout') }}" x-data>
                                @csrf

                                <x-dropdown-link href="{{ route('logout') }}" @click.prevent="$root.submit();" class="text-xs !text-gray-700 group">
                                   <span class="group-hover:text-white"> {{ __('Log Out') }} </span>
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                </div>
            </div>

            <!-- Hamburger -->
            <div class="-mr-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-100">
            <div class="flex items-center px-4">
                @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                <div class="shrink-0 mr-3">
                    <img class="h-10 w-10 rounded-full object-cover" src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}" />
                </div>
                @endif

                <div>
                    <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                    <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
                </div>
            </div>

            <div class="mt-3 space-y-1">
                <!-- Account Management -->
                <x-responsive-nav-link href="{{ route('profile.show') }}" :active="request()->routeIs('profile.show')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                @if (Laravel\Jetstream\Jetstream::hasApiFeatures())
                <x-responsive-nav-link href="{{ route('api-tokens.index') }}" :active="request()->routeIs('api-tokens.index')">
                    {{ __('API Tokens') }}
                </x-responsive-nav-link>
                @endif

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}" x-data>
                    @csrf

                    <x-responsive-nav-link href="{{ route('logout') }}" @click.prevent="$root.submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>

                <!-- Team Management -->
                @if (Laravel\Jetstream\Jetstream::hasTeamFeatures())
                <div class="border-t border-gray-200"></div>

                <div class="block px-4 py-2 text-xs text-gray-400">
                    {{ __('Manage Team') }}
                </div>

                <!-- Team Settings -->
                <x-responsive-nav-link href="{{ route('teams.show', Auth::user()->currentTeam->id) }}" :active="request()->routeIs('teams.show')">
                    {{ __('Team Settings') }}
                </x-responsive-nav-link>

                @can('create', Laravel\Jetstream\Jetstream::newTeamModel())
                <x-responsive-nav-link href="{{ route('teams.create') }}" :active="request()->routeIs('teams.create')">
                    {{ __('Create New Team') }}
                </x-responsive-nav-link>
                @endcan

                <!-- Team Switcher -->
                @if (Auth::user()->allTeams()->count() > 1)
                <div class="border-t border-gray-200"></div>

                <div class="block px-4 py-2 text-xs text-gray-400">
                    {{ __('Switch Teams') }}
                </div>

                @foreach (Auth::user()->allTeams() as $team)
                <x-switchable-team :team="$team" component="responsive-nav-link" />
                @endforeach
                @endif
                @endif
            </div>
        </div>
    </div>
</nav>
