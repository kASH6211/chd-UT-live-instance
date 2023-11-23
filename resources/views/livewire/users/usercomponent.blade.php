<div>
    <x-loading-indicator />
    <div class="flex border bg-blue-900/5 border-dashed border-blue-900/30 p-4 rounded-md justify-center items-center mb-4">

        <h1 class="text-3xl text-blue-900">Total Users- {{$total}}</h1>
    </div>
    <div class="flex justify-between p-4 rounded-md mb-4  bg-gray-200">

        <div class=" w-1/2 rounded-sm px-4">

            <x-input type="text" wire:model.debounce.500ms="search" placeholder="Search..." class="w-full border-0 h-12 rounded-lg">

            </x-input>

        </div>
        @can('createofficebulkuser',App\User::class)
        <div>
            
            <x-primary-button wire:click="createOfficeUsersBulk()">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 mr-2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>


                Create Office Users with Email Id</x-primary-button>

        </div>
        @endcan
        <div>
            <x-primary-button wire:click="toggle('newmodal')">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 mr-2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>


                New User</x-primary-button>

        </div>
    </div>

    <table class="table-auto w-full border-collapse border">

        <thead class="bg-gray-200 w-full">
            <td class="px-2 text-left border text-gray-700 py-2text-sm font-semibold  w-16">Sr No.</th>

                @foreach($header as $head)
            <td class=" text-left border text-gray-700   w-16 text-sm font-semibold  p-2">{{$head}}</th>
                @endforeach
        </thead>
        <tbody>
            @foreach($data as $index=>$row)
            <tr>
                <td class="text-center border text-gray-600 py-2">{{$index + $data->firstItem()}}</td>
                <td class="text-center border text-gray-600">{{$row->user_id}}</td>
                @if(Auth::user()->role_id ==2)

                <td class="text-center border text-gray-600">{{$row->userdistrict->DistName}}</td>
                <td class="text-center border text-gray-600">{{$row->name}}</td>
                <td class="text-center border text-gray-600">{{$row->email}}</td>
                @else
                <td class="text-center border text-gray-600">{{$this->getOfficeName($row->deptcode,$row->officecode)}}</td>

                <td class="text-center border text-gray-600">{{$this->getDeptName($row->deptcode)}}</td>
                @endif
                {{-- <td class="text-center border text-gray-600">{{$row->name}}</td> --}}

                {{-- <td class="text-center border text-gray-600">{{$row->email}}</td> --}}


                {{-- <td class="text-center border text-gray-600">@if($row->st_Code){{$row->userstate->StateName}}@endif</td> --}}


                {{-- <td class="text-center border text-gray-600">@if($row->distcode){{$row->userdistrict->DistName}}@endif</td> --}}
                {{-- {{  dd($row->officecode)}} --}}





                <td class="text-center border text-gray-600 w-8 ">
                    <div class="flex justify-center items-center"><a href="javascript:void(0)" wire:click="viewobject('{{$row->id}}')" class="m-2 hover:bg-blue-100 p-2 rounded-md">

                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" class="w-5 h-5 stroke-blue-500">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>




                        </a></div>


                </td>

                <td class="text-center border text-gray-600 w-8 ">
                    <div class="flex justify-center items-center"><a href="javascript:void(0)" wire:click="editobject('{{$row->id}}')" class="m-2 hover:bg-blue-100 p-2 rounded-md">

                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" class="w-5 h-5 stroke-blue-500">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                            </svg>




                        </a></div>


                </td>


                <td class="text-center border text-gray-600 w-8">
                    <div class="flex justify-center items-center"><a href="javascript:void(0);" wire:click="openForDeletion('{{$row->id}}')" class="m-2 hover:bg-red-100 p-2 rounded-md">

                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" class="w-5 h-5 stroke-red-500">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                            </svg>


                        </a></div>


                </td>
                <td class="text-center border text-gray-600 w-8">
                    <div class="flex justify-center items-center"><a href="javascript:void(0);" wire:click="openForResetPassword('{{$row->id}}')" class="m-2 hover:bg-red-100 p-2 rounded-md">

                            <svg viewBox="0 0 24 24" class="w-5 h-5" xmlns="http://www.w3.org/2000/svg">
                                <path d="m12.63 2c5.53 0 10.01 4.5 10.01 10s-4.48 10-10.01 10c-3.51 0-6.58-1.82-8.37-4.57l1.58-1.25c1.41 2.29 3.92 3.82 6.8 3.82a8 8 0 0 0 8-8 8 8 0 0 0 -8-8c-4.08 0-7.44 3.06-7.93 7h2.76l-3.74 3.73-3.73-3.73h2.69c.5-5.05 4.76-9 9.94-9m2.96 8.24c.5.01.91.41.91.92v4.61c0 .5-.41.92-.92.92h-5.53c-.51 0-.92-.42-.92-.92v-4.61c0-.51.41-.91.91-.92v-1.01c0-1.53 1.25-2.77 2.77-2.77 1.53 0 2.78 1.24 2.78 2.77zm-2.78-2.38c-.75 0-1.37.61-1.37 1.37v1.01h2.75v-1.01c0-.76-.62-1.37-1.38-1.37z" /></svg>


                        </a></div>


                </td>

            </tr>

            @endforeach




        </tbody>

    </table>
    <div class="py-2">
        {{ $data->links() }}
    </div>




    <!-- Modals Code Starts Here -->
    <x-confirmation-modal wire:model="newmodal">
        <x-slot name="icon">
            <svg class="h-6 w-6 stroke-white" stroke-width="1.5" fill="none" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M19 7.5v3m0 0v3m0-3h3m-3 0h-3m-2.25-4.125a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zM4 19.235v-.11a6.375 6.375 0 0112.75 0v.109A12.318 12.318 0 0110.374 21c-2.331 0-4.512-.645-6.374-1.766z" />
            </svg>
        </x-slot>
        <x-slot name="subtitle">

        </x-slot>

        <x-slot name="title">
            Add New User
        </x-slot>


        <x-slot name="content">

            <div>

                <x-validation-errors class="mb-4" />
                <form method="POST">
                    @csrf

                    <div class="w-full flex gap-x-5">


                        <div class="mt-4 w-full">
                            <x-label for="name" value="{{ __('Name') }}" />
                            <x-input wire:model.defer="object.name" class="block w-full" type="text" :value="old('name')" required />

                        </div>
                        <div class="mt-4 w-full">
                            <x-label for="name" value="{{ __('Email') }}" />
                            <x-input wire:model.defer="object.email" class="block w-full" type="email" :value="old('email')" required />

                        </div>
                        <div class="mt-4 w-full">
                            <x-label for="name" value="{{ __('Mobile No.') }}" />
                            <x-input wire:model.defer="object.mobileno" minlength="10" maxlength="10" class="block w-full" type="text" :value="old('mobileno')" required />

                        </div>


                    </div>

                    <div class="flex gap-x-5 w-full">

                        {{-- <div class="mt-4 w-full">
                            <x-label for="name" value="{{ __('Role') }}" />
                        <x-select wire:model="object.role_id" type="text" class="block w-full" :ddlist="$rolelist" idfield="id" textfield="name" />
                    </div> --}}
                    {{-- <div class="mt-4 w-full">
                            <x-label for="name" value="{{ __('State') }}" />
                    <x-select wire:model="object.st_Code" wire:change="loadDistricts()" type="text" class="block w-full" :ddlist="$statelist" idfield="statecode" textfield="StateName" />
            </div> --}}


</div>
<div class="flex gap-x-5 w-full">
    {{-- @if($districtlist)
                        <div class="mt-4 w-full">
                            <x-label for="name" value="{{ __('District') }}" />
    <x-select wire:model="object.distcode" wire:change="loadDepartments()" type="text" class="block w-full" :ddlist="$districtlist" idfield="DistCode" textfield="DistName" />
</div>
@endif --}}
@if(Auth::user()->role_id<=2) @if($districtlist) <div class="mt-4 w-full">
    <x-label for="name" value="{{ __('District') }}" />
    <x-select wire:model="object.distcode" type="text" class="block w-full" :ddlist="$districtlist" idfield="DistCode" textfield="DistName" />
    </div>
    @endif
    @endif


    @if($rolelist)
    <div class="mt-4 w-full">
        <x-label for="name" value="{{ __('Role') }}" />
        <x-select wire:model="object.role_id" type="text" class="block w-full" :ddlist="$rolelist" idfield="id" textfield="name" />
    </div>
    @endif


    @if($object->role_id==4)
    @if($deptlist )
    <div class="mt-4 w-full">
        <x-label for="name" value="{{ __('Department') }}" />
        <x-select wire:model="object.deptcode" wire:change="loadOffices()" type="text" class="block w-full" :ddlist="$deptlist" idfield="deptcode" textfield="deptname" />
    </div>
    @endif
    </div>
    <div class="flex gap-x-5 w-full">
        @if($officelist)
        <div class="mt-4 w-full">
            <x-label for="name" value="{{ __('Office') }}" />
            <x-select wire:model="object.officecode" type="text" class="block w-full" :ddlist="$officelist" idfield="officecode" textfield="office" />

        </div>
        @endif
        @endif

    </div>

    </form>
    </div>

    </x-slot>

    <x-slot name="footer">
        <x-secondary-button wire:click="$toggle('newmodal')" wire:loading.attr="disabled">
            Cancel
        </x-secondary-button>

        <x-primary-button class="ml-2" wire:click="addobject()" wire:loading.attr="disabled">
            Add New User
        </x-primary-button>
    </x-slot>
    </x-confirmation-modal>



    <x-confirmation-modal wire:model="editmodal">
        <x-slot name="icon">
            <svg class="h-6 w-6 stroke-white" stroke-width="1.5" fill="none" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M19 7.5v3m0 0v3m0-3h3m-3 0h-3m-2.25-4.125a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zM4 19.235v-.11a6.375 6.375 0 0112.75 0v.109A12.318 12.318 0 0110.374 21c-2.331 0-4.512-.645-6.374-1.766z" />
            </svg>
        </x-slot>


        <x-slot name="title">
            Update User Details
        </x-slot>


        <x-slot name="content">

            <div>

                <x-validation-errors class="mb-4" />
                <form method="POST">
                    @csrf
                    <div class="w-full flex flex-col justify-center">

                        @if($editobject )
                        <h3 class=" text-gray-700 bg-gray-100 my-2 p-2 rounded-md text-md"><span class="font-semibold text-md">User Id : </span>{{$editobject['user_id']}}</h3>
                        @if(Auth::user()->role_id==1)

                        @elseif(Auth::user()->role_id==2)
                        <h3 class=" text-gray-700 bg-gray-100 my-2 p-2 rounded-md text-md"><span class="font-semibold text-md">District : </span>{{$editobject['distname']}}</h3>

                        @else
                        <h3 class=" text-gray-700 bg-gray-100 my-2 p-2 rounded-md text-md"><span class="font-semibold text-md">Office : </span>{{$this->getOfficeName($editobject['deptcode'],$editobject['officecode'])}}</h3>
                        <h3 class=" text-gray-700 bg-gray-100 mb-2 p-2 rounded-md text-md"><span class="font-semibold text-md">Department: </span>{{$this->getDeptName($editobject['deptcode'])}}</h3>
                        @endif

                        @endif
                    </div>
                    <div class="w-full flex gap-x-5">

                        <div class="mt-4 w-full">
                            <x-label for="name" value="{{ __('Name') }}" />
                            <x-input wire:model.defer="editobject.name" class="block w-full" type="text" :value="old('name')" required />

                        </div>
                        <div class="mt-4 w-full">
                            <x-label for="name" value="{{ __('Email') }}" />
                            <x-input wire:model.defer="editobject.email" class="block w-full" type="email" :value="old('email')" required />

                        </div>
                        <div class="mt-4 w-full">
                            <x-label for="name" value="{{ __('Mobile') }}" />
                            <x-input wire:model.defer="editobject.mobileno" minlength="10" maxlength="10" class="block w-full" type="text" :value="old('email')" required />

                        </div>




                    </div>
                </form>

            </div>

        </x-slot>

        <x-slot name="footer">
            <x-secondary-button wire:click="$toggle('editmodal')" wire:loading.attr="disabled">
                Cancel
            </x-secondary-button>

            <x-primary-button class="ml-2" wire:click="Update()" wire:loading.attr="disabled">
                Update User Details
            </x-primary-button>
        </x-slot>
    </x-confirmation-modal>

    <x-confirmation-modal wire:model="confirmupdatemodal">
        <x-slot name="icon">
            <svg class="h-6 w-6 stroke-white" stroke-width="1.5" fill="none" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M19 7.5v3m0 0v3m0-3h3m-3 0h-3m-2.25-4.125a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zM4 19.235v-.11a6.375 6.375 0 0112.75 0v.109A12.318 12.318 0 0110.374 21c-2.331 0-4.512-.645-6.374-1.766z" />
            </svg>
        </x-slot>


        <x-slot name="title">
            Delete User?
        </x-slot>


        <x-slot name="content">

            <div class="w-full flex flex-col justify-center">
                <h1 class="text-lg text-red-800 ">Are you sure you want to permanently delete this user?</h1>
                @if($editobject && $editobject['user_id'] && $editobject['name'])
                <h3 class="text-md text-gray-700 bg-gray-100 my-2 p-2 rounded-md"><span class="font-semibold">User Id : </span>{{$editobject['user_id']}}</h3>
                <h3 class="text-md text-gray-700 bg-gray-100 mb-2 p-2 rounded-md"><span class="font-semibold">Name: </span>{{$editobject['name']}}</h3>
                <h3 class="text-md text-gray-700 bg-gray-100 my-2 p-2 rounded-md"><span class="font-semibold">Email Id : </span>{{$editobject['email']}}</h3>
                <h3 class="text-md text-gray-700 bg-gray-100 mb-2 p-2 rounded-md"><span class="font-semibold">Mobile: </span>{{$editobject['mobileno']}}</h3>
                @if(Auth::user()->role_id ==1)
                @elseif(Auth::user()->role_id==2)
                <h3 class="text-md text-gray-700 bg-gray-100 my-2 p-2 rounded-md"><span class="font-semibold">District : </span>{{$editobject['distname']}}</h3>

                @else
                <h3 class="text-md text-gray-700 bg-gray-100 my-2 p-2 rounded-md"><span class="font-semibold">Office : </span>{{$this->getOfficeName($editobject['deptcode'],$editobject['officecode'])}}</h3>
                <h3 class="text-md text-gray-700 bg-gray-100 mb-2 p-2 rounded-md"><span class="font-semibold">Department: </span>{{$this->getDeptName($editobject['deptcode'])}}</h3>

                @endif
                @endif
            </div>

        </x-slot>

        <x-slot name="footer">
            <x-secondary-button wire:click="$toggle('confirmupdatemodal')" wire:loading.attr="disabled">
                Cancel
            </x-secondary-button>
            @if($editobject && $editobject['id'] )

            <x-primary-button class="ml-2" wire:click="deleteRecord({{$editobject['id']}})" wire:loading.attr="disabled">
                Delete User
            </x-primary-button>
            @endif
        </x-slot>
    </x-confirmation-modal>


    {{-- password reset modal  starts here --}}
    <x-confirmation-modal wire:model="confirmresetpassmodal">
        <x-slot name="icon">
            <svg class="h-6 w-6 stroke-white" stroke-width="1.5" fill="none" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M19 7.5v3m0 0v3m0-3h3m-3 0h-3m-2.25-4.125a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zM4 19.235v-.11a6.375 6.375 0 0112.75 0v.109A12.318 12.318 0 0110.374 21c-2.331 0-4.512-.645-6.374-1.766z" />
            </svg>
        </x-slot>


        <x-slot name="title">
            Reset Password of User?
        </x-slot>


        <x-slot name="content">

            <div class="w-full flex flex-col justify-center">
                <h1 class="text-lg text-red-800 ">Are you sure you want to Reset password to default ?</h1>

                @if($editobject and $editobject['user_id'] and $editobject['name'])
                <h3 class="text-md text-gray-700 bg-gray-100 my-2 p-2 rounded-md"><span class="font-semibold">User Id : </span>{{$editobject['user_id']}}</h3>
                <h3 class="text-md text-gray-700 bg-gray-100 mb-2 p-2 rounded-md"><span class="font-semibold">Name: </span>{{$editobject['name']}}</h3>
                <h3 class="text-md text-gray-700 bg-gray-100 my-2 p-2 rounded-md"><span class="font-semibold">Email Id : </span>{{$editobject['email']}}</h3>
                <h3 class="text-md text-gray-700 bg-gray-100 mb-2 p-2 rounded-md"><span class="font-semibold">Mobile: </span>{{$editobject['mobileno']}}</h3>
                @if(Auth::user()->role_id ==1)
                @elseif(Auth::user()->role_id==2)
                <h3 class="text-md text-gray-700 bg-gray-100 my-2 p-2 rounded-md"><span class="font-semibold">District : </span>{{$editobject['distname']}}</h3>

                @else
                <h3 class="text-md text-gray-700 bg-gray-100 my-2 p-2 rounded-md"><span class="font-semibold">Office : </span>{{$this->getOfficeName($editobject['deptcode'],$editobject['officecode'])}}</h3>
                <h3 class="text-md text-gray-700 bg-gray-100 mb-2 p-2 rounded-md"><span class="font-semibold">Department: </span>{{$this->getDeptName($editobject['deptcode'])}}</h3>

                @endif @endif
            </div>

        </x-slot>

        <x-slot name="footer">
            <x-secondary-button wire:click="$toggle('confirmresetpassmodal')" wire:loading.attr="disabled">
                Cancel
            </x-secondary-button>
            @if($editobject && $editobject['user_id'] )

            <x-primary-button class="ml-2" wire:click="resetPassword('{{$editobject['id']}}')" wire:loading.attr="disabled">
                Reset Password
            </x-primary-button>
            @endif
        </x-slot>
    </x-confirmation-modal>

    {{-- view modal starts her --}}
    <x-confirmation-modal wire:model="viewmodal">
        <x-slot name="icon">
            <svg class="h-6 w-6 stroke-white" stroke-width="1.5" fill="none" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M19 7.5v3m0 0v3m0-3h3m-3 0h-3m-2.25-4.125a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zM4 19.235v-.11a6.375 6.375 0 0112.75 0v.109A12.318 12.318 0 0110.374 21c-2.331 0-4.512-.645-6.374-1.766z" />
            </svg>
        </x-slot>


        <x-slot name="title">
            View User
        </x-slot>


        <x-slot name="content">

            <div class="w-full flex flex-col justify-center">
                {{-- <h1 class="text-2xl text-red-800 ">Are you sure you want to Reset password to default ?</h1> --}}

                @if($viewobject )
                {{-- {{  dd($viewobject)}} --}}
                <h3 class="text-md text-gray-700 bg-gray-100 my-2 p-2 rounded-md"><span class="font-semibold">User Id : </span>{{$viewobject['user_id']}}</h3>
                <h3 class="text-md text-gray-700 bg-gray-100 mb-2 p-2 rounded-md"><span class="font-semibold">Name: </span>{{$viewobject['name']}}</h3>
                <h3 class="text-md text-gray-700 bg-gray-100 my-2 p-2 rounded-md"><span class="font-semibold">Email Id : </span>{{$viewobject['email']}}</h3>
                <h3 class="text-md text-gray-700 bg-gray-100 mb-2 p-2 rounded-md"><span class="font-semibold">Mobile: </span>{{$viewobject['mobileno']}}</h3>
                @if(Auth::user()->role_id ==1)
                @elseif(Auth::user()->role_id==2)
                <h3 class="text-md text-gray-700 bg-gray-100 my-2 p-2 rounded-md"><span class="font-semibold">District : </span>{{$viewobject->userdistrict->DistName}}</h3>

                @else
                <h3 class="text-md text-gray-700 bg-gray-100 my-2 p-2 rounded-md"><span class="font-semibold">Office : </span>{{$this->getOfficeName($viewobject['deptcode'],$viewobject['officecode'])}}</h3>
                <h3 class="text-md text-gray-700 bg-gray-100 mb-2 p-2 rounded-md"><span class="font-semibold">Department: </span>{{$this->getDeptName($viewobject['deptcode'])}}</h3>

                @endif

                @endif
            </div>

        </x-slot>

        <x-slot name="footer">
            <x-secondary-button wire:click="$toggle('viewmodal')" wire:loading.attr="disabled">
                Close
            </x-secondary-button>

        </x-slot>
    </x-confirmation-modal>
    </div>
