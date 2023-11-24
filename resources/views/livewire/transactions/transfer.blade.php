<div>
    <x-loading-indicator />
    <div>
        <div class="py-4 border-t-0 border-gray-400 border-dashed">
            <h1 class="font-semibold text-lg text-gray-800 ">Search Employees for Exemption</h1>
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

                   
                    @if($row->del=="o")    

                    <td class=" text-center border text-gray-600">
                        <a wire:click="getdata('{{$row->id}}','apply')">

                            <svg data-tooltip-target="tooltip-default-paused" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 stroke-red-700 m-auto">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M7.5 7.5h-.75A2.25 2.25 0 004.5 9.75v7.5a2.25 2.25 0 002.25 2.25h7.5a2.25 2.25 0 002.25-2.25v-7.5a2.25 2.25 0 00-2.25-2.25h-.75m0-3l-3-3m0 0l-3 3m3-3v11.25m6-2.25h.75a2.25 2.25 0 012.25 2.25v7.5a2.25 2.25 0 01-2.25 2.25h-7.5a2.25 2.25 0 01-2.25-2.25v-.75" />
                                  </svg>
                                  


                        </a>
                        <div id="tooltip-default-paused" role="tooltip" class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700">
                            Exempt employee from polling duty
                            <div class="tooltip-arrow" data-popper-arrow></div>
                        </div>
                    </td>
                    @else
                    <td class="text-center border text-gray-600 ">
                        <a wire:click="getdata('{{$row->id}}','remove')">
                            <svg data-tooltip-target="tooltip-default" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 stroke-green-700 m-auto">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M7.5 7.5h-.75A2.25 2.25 0 004.5 9.75v7.5a2.25 2.25 0 002.25 2.25h7.5a2.25 2.25 0 002.25-2.25v-7.5a2.25 2.25 0 00-2.25-2.25h-.75m-6 3.75l3 3m0 0l3-3m-3 3V1.5m6 9h.75a2.25 2.25 0 012.25 2.25v7.5a2.25 2.25 0 01-2.25 2.25h-7.5a2.25 2.25 0 01-2.25-2.25v-.75" />
                                  </svg>
                                  
                        </a>

                        <div id="tooltip-default" role="tooltip" class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700">
                            Remove exemption and make employee available for polling duty
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
 

<x-confirmation-modal wire:model="exemptmodal">
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
            <img src="{{$this->retrieveImage($empid->photoid) }}" alt="No Photo Available" class="h-32 w-32 rounded-md bg-gray-300">
            @endif
            <div class="w-full flex gap-x-5">
                <div class="mt-4 w-full">
                    <x-label for="name" value="{{ __('Name') }}" class="font-semibold" />
                    {{$empid->Name??""}}
                </div>
                <div class="mt-4 w-full">
                    <x-label for="name" value="{{ __('Father/Husband Name') }}" class="font-semibold"  />
                    {{$empid->FName??""}}
                </div>

            </div>
            <div class="w-full flex gap-x-5">
                <div class="mt-4 w-full">
                    <x-label for="name" value="{{ __('Mobile') }}" class="font-semibold"  />
                    {{$empid->mobileno??""}}
                </div>
                <div class="mt-4 w-full">
                    <x-label for="name" value="{{ __('Designation') }}" class="font-semibold"  />
                    {{$empid->designation->Designation??""}}
                </div>
            </div>
            <div class="w-full flex gap-x-5">
                <div class="mt-4 w-full">
                    <x-label for="name" value="{{ __('Employee Type') }}" class="font-semibold"  />
                    {{$empid->employeetype->EmpTypeName??""}}
                </div>
                <div class="mt-4 w-full">
                    <x-label for="name" value="{{ __('Class') }}"  class="font-semibold" />
                    {{$empid->electionclass->description??""}}
                </div>
            </div>

            @if($empid && $empid->del=="o")    
            <div class="mt-4 w-full">
                <x-label for="name" value="{{ __('Reason of Exemption') }}"  class="font-semibold" />
                <x-input class="w-full p-2" type="textarea" id="multilineText" wire:model.defer="Remarks" rows="10" />
            </div>
            @else
             <div class="mt-4 w-full">
                <x-label for="name" value="{{ __('Reason of Exemption') }}" class="font-semibold"  />
                <div class="bg-red-800/10 p-2 rounded-md mt-2 w-full">
                {{$empid->Remarks??"NA"}}
                </div> 
            </div>
            @endif

        </div>

    </x-slot>

    <x-slot name="footer">
        <x-secondary-button wire:click="toggle()" wire:loading.attr="disabled">
            Cancel
        </x-secondary-button>
        @if($empid && $empid->del=="o")    
        <x-primary-button  class="ml-2 " wire:click="exemptobject()" wire:loading.attr="disabled">
            Exempt Employee
        </x-primary-button>
        @else
        <x-primary-button class="ml-2" wire:click="removeexemptobject()" wire:loading.attr="disabled">
            Remove Exemption
        </x-primary-button>
        @endif
    </x-slot>
</x-confirmation-modal>
</div>
