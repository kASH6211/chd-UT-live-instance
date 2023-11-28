<div>
    <x-loading-indicator />
    <div>
        <div class="py-4 border-t-0 border-gray-400 border-dashed">
            <h1 class="font-semibold text-lg text-gray-800 ">Search Employees for Transfer</h1>
        </div>
        <div class="flex mb-2 bg-gray-200 p-2 pl-4 pb-5 rounded-md">
            <div class="grid grid-cols-3 gap-2">
                <div class="w-full">
                    <x-label for="name" value="{{ __('Department') }}" />
                    <x-select wire:model.defer="deptcode" wire:change="deptchange" type="text" class="block w-full" :ddlist="$alldeptlist" idfield="deptcode" textfield="deptname" />
                </div>
                @if($filterofficelist)
                <div class="w-full">
                    <x-label for="name" value="{{ __('Office') }}" />
                    <x-select wire:model.defer="officecode" wire:change="officechange" type="text" class="block w-full" :ddlist="$filterofficelist" idfield="officecode" textfield="office" />
                </div>
                @endif
                <div class="w-full">
                    <x-label for="name" value="{{ __('Search Employee Details') }}" />

                    <x-input wire:model.debounce.500ms="search" class="w-full" placeholder="Name,Father/Husband Name,Mobile,HRMS Code" type="text" :value="old('search')" required />
                </div>


            </div>

        </div>
    </div>
    <div>

        @if($result)

        <table class="table-auto w-full border-collapse border">

            <thead class="bg-gray-200 w-full">
                <td class="border font-semibold text-gray-700 py-2 px-4 w-20">Sr No.</td>

                @foreach($header as $head)
                <td class="border  text-gray-700 py-2 px-4 font-semibold">{{$head}}</td>
                @endforeach
            </thead>


            <tbody>
                @foreach($result as $index=>$row)
                <tr>
                    <td class=" px-4 border text-gray-600 py-2">{{$index + $result->firstItem()}}</td>



                    <td class=" border text-gray-600 px-2">{{$row->Name}}</td>
                    <td class=" border text-gray-600 px-2">{{$row->FName}}</td>
                    <td class=" border text-gray-600 px-2 w-8">{{$row->mobileno}}</td>
                    <td class=" border text-gray-600 px-2 ">{{$this->getofficeName($row['distcode'],$row['deptcode'],$row['officecode'])}}</td>


                    <td class=" border text-gray-600 px-2">{{$row->designation->Designation??"NA"}}</td>





                    @if($row->transferred=="T")
                    <td class="text-center border text-gray-600 ">
                        <a wire:click="getdata('{{$row->id}}','remove')" class="flex justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 ">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 9l6-6m0 0l6 6m-6-6v12a6 6 0 01-12 0v-3" />
                            </svg>


                        </a>

                        <div id="tooltip-default" role="tooltip" class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700">
                            Transfer employee within District
                            <div class="tooltip-arrow" data-popper-arrow></div>
                        </div>
                    </td>
                    @endif
                </tr>
                @endforeach




            </tbody>

        </table>
        @if($result->count()==0)
        <div class="mt-4 p-4 flex justify-center items-center w-full text-gray-500">
            No Employee found!
        </div>
        @endif
        <div class="py-2">
            {{ $result->links() }}
        </div>
        @endif
    </div>


    <x-confirmation-modal wire:model="transfermodal">
        <x-slot name="icon" class="">
            <svg class="h-6 w-6 stroke-white" stroke-width="1.5" fill="none" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M7.5 7.5h-.75A2.25 2.25 0 004.5 9.75v7.5a2.25 2.25 0 002.25 2.25h7.5a2.25 2.25 0 002.25-2.25v-7.5a2.25 2.25 0 00-2.25-2.25h-.75m0-3l-3-3m0 0l-3 3m3-3v11.25m6-2.25h.75a2.25 2.25 0 012.25 2.25v7.5a2.25 2.25 0 01-2.25 2.25h-7.5a2.25 2.25 0 01-2.25-2.25v-.75" />
            </svg>

        </x-slot>
        <x-slot name="subtitle">

        </x-slot>

        <x-slot name="title">
            Exemption Employee from Election Duty
        </x-slot>


        <x-slot name="content">

            <div>

                <x-validation-errors class="mb-4" />
                @if($empid)
                <div class="w-full grid grid-cols-2 gap-x-5">
                    <div>
                        <img src="{{$this->retrieveImage($empid->photoid) }}" alt="No Photo Available" class="h-32 w-32 rounded-md bg-gray-300">
                    </div>
                    <div class="w-full">
                        <x-label for="name" value="{{ __('Hrms Code') }}" class="font-semibold" />
                        <span class="text-lg font-bold text-blue-500">{{$empid->hrmscode??""}}</span>
                    </div>
                </div>
                @endif
                <div class="w-full flex gap-x-5">
                    <div class="mt-4 w-full">
                        <x-label for="name" value="{{ __('Name') }}" class="font-semibold" />
                        {{$empid->Name??""}}
                    </div>
                    <div class="mt-4 w-full">
                        <x-label for="name" value="{{ __('Father/Husband Name') }}" class="font-semibold" />
                        {{$empid->FName??""}}
                    </div>

                </div>
                <div class="w-full flex gap-x-5">
                    <div class="mt-4 w-full">
                        <x-label for="name" value="{{ __('Mobile') }}" class="font-semibold" />
                        {{$empid->mobileno??""}}
                    </div>
                    <div class="mt-4 w-full">
                        <x-label for="name" value="{{ __('Designation') }}" class="font-semibold" />
                        {{$empid->designation->Designation??""}}
                    </div>
                </div>
                <div class="w-full flex gap-x-5">
                    <div class="mt-4 w-full">
                        <x-label for="name" value="{{ __('Employee Type') }}" class="font-semibold" />
                        {{$empid->employeetype->EmpTypeName??""}}
                    </div>
                    <div class="mt-4 w-full">
                        <x-label for="name" value="{{ __('Class') }}" class="font-semibold" />
                        {{$empid->electionclass->description??""}}
                    </div>
                </div>




            </div>
            <div class="mt-4 p-3 border-0 bg-yellow-200 rounded-md mb-2">
                <span class="font-semibold text-red-700">Warning! -</span>Employee will be transfered to following new Department / Office. Once Employee data is transfered it will not be availble to current office for modifications.
                <span class="font-semibold">Are you sure you want to transfer this employee?</span>
            </div>
            <div class="flex mb-2 bg-gray-200 p-2 pl-4 pb-5 rounded-md">
                <div class="grid grid-cols-2 gap-2">
                    <div class="w-full">
                        <x-label for="name" value="{{ __('Department') }}" />
                        <x-select wire:model.defer="newdeptcode" wire:change="newdeptchange" type="text" class="block w-full" :ddlist="$alldeptlist" idfield="deptcode" textfield="deptname" />
                    </div>
                    @if($newfilterofficelist)
                    <div class="w-full">
                        <x-label for="name" value="{{ __('Office') }}" />
                        <x-select wire:model.defer="newofficecode" wire:change="officechange" type="text" class="block w-full" :ddlist="$newfilterofficelist" idfield="officecode" textfield="office" />
                    </div>
                    @endif



                </div>

            </div>

        </x-slot>

        <x-slot name="footer">
            <x-secondary-button wire:click="toggle()" wire:loading.attr="disabled">
                Cancel
            </x-secondary-button>

            <x-primary-button class="ml-2 " wire:click="transferobject()" wire:loading.attr="disabled">
                Transfer Employee
            </x-primary-button>

        </x-slot>
    </x-confirmation-modal>
</div>
