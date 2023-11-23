<div>
    <x-loading-indicator />
    <div>
        <div class="py-4 border-t-0 border-gray-400 border-dashed flex justify-between ">
            <h1 class="font-semibold text-lg text-gray-800 ">List of Employees Exempted</h1>
            <h1 class="font-semibold text-lg text-gray-800 ">District : <span>{{(Auth::user()->userdistrict->DistName)}}</span></h1>
        </div>
        <div class="flex border bg-blue-900/5 border-dashed border-blue-900/30 p-4 rounded-md justify-center items-center mb-4">

        <h1 class="text-3xl text-blue-900">Total Exemptions-
            {{count($data)}}
        </h1>
         </div>
         <div class="my-2 text-right">
            <x-primary-button wire:click="exempt_download()">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 mr-2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.72 13.829c-.24.03-.48.062-.72.096m.72-.096a42.415 42.415 0 0110.56 0m-10.56 0L6.34 18m10.94-4.171c.24.03.48.062.72.096m-.72-.096L17.66 18m0 0l.229 2.523a1.125 1.125 0 01-1.12 1.227H7.231c-.662 0-1.18-.568-1.12-1.227L6.34 18m11.318 0h1.091A2.25 2.25 0 0021 15.75V9.456c0-1.081-.768-2.015-1.837-2.175a48.055 48.055 0 00-1.913-.247M6.34 18H5.25A2.25 2.25 0 013 15.75V9.456c0-1.081.768-2.015 1.837-2.175a48.041 48.041 0 011.913-.247m10.5 0a48.536 48.536 0 00-10.5 0m10.5 0V3.375c0-.621-.504-1.125-1.125-1.125h-8.25c-.621 0-1.125.504-1.125 1.125v3.659M18 10.5h.008v.008H18V10.5zm-3 0h.008v.008H15V10.5z" />
                </svg>

                Print</x-primary-button>

        </div>
        {{-- <div class="flex mb-2 bg-gray-200 p-2 pl-4 pb-5 rounded-md">
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

        </div> --}}
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
                    <td class=" border text-gray-600 px-2 w-8">{{$row->department->deptname}}</td>
                    <td class=" border text-gray-600 px-2 ">{{$this->getofficeName($row['distcode'],$row['deptcode'],$row['officecode'])}}</td>


                    <td class=" border text-gray-600 px-2">{{$row->designation->Designation??"NA"}}</td>
                    <td class=" border text-gray-600 px-2">{{$row->Remarks??"NA"}}</td>

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
    <x-slot name="icon">
        <svg class="h-6 w-6 stroke-white" stroke-width="1.5" fill="none" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M19 7.5v3m0 0v3m0-3h3m-3 0h-3m-2.25-4.125a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zM4 19.235v-.11a6.375 6.375 0 0112.75 0v.109A12.318 12.318 0 0110.374 21c-2.331 0-4.512-.645-6.374-1.766z" />
        </svg>
    </x-slot>
    <x-slot name="subtitle">

    </x-slot>

    <x-slot name="title">
        Exemption to Employee from Election Duty
    </x-slot>


    <x-slot name="content">

        <div>

            <x-validation-errors class="mb-4" />
            @if($empid)
            <img src="{{$this->retrieveImage($empid->photoid) }}" alt="No Photo Available" class="h-32 w-32 rounded-md shadow-2xl">
            @endif
            <div class="w-full flex gap-x-5">
                <div class="mt-4 w-full">
                    <x-label for="name" value="{{ __('Name') }}" />
                    {{$empid->Name??""}}
                </div>
                <div class="mt-4 w-full">
                    <x-label for="name" value="{{ __('Father/Husband Name') }}" />
                    {{$empid->FName??""}}
                </div>

            </div>
            <div class="w-full flex gap-x-5">
                <div class="mt-4 w-full">
                    <x-label for="name" value="{{ __('Mobile') }}" />
                    {{$empid->mobileno??""}}
                </div>
                <div class="mt-4 w-full">
                    <x-label for="name" value="{{ __('Designation') }}" />
                    {{$empid->designation->Designation??""}}
                </div>
            </div>
            <div class="w-full flex gap-x-5">
                <div class="mt-4 w-full">
                    <x-label for="name" value="{{ __('Employee Type') }}" />
                    {{$empid->employeetype->EmpTypeName??""}}
                </div>
                <div class="mt-4 w-full">
                    <x-label for="name" value="{{ __('Class') }}" />
                    {{$empid->electionclass->description??""}}
                </div>
            </div>

            @if($empid && $empid->del=="o")    
            <div class="mt-4 w-full">
                <x-label for="name" value="{{ __('Reason of Exemption') }}" />
                <x-input class="w-full p-2" type="textarea" id="multilineText" wire:model.defer="Remarks" rows="10" />
            </div>
            @else
             <div class="mt-4 w-full">
                <x-label for="name" value="{{ __('Reason of Exemption') }}" />
                <div>
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
        <x-primary-button  class="ml-2 bg-red-700" wire:click="exemptobject()" wire:loading.attr="disabled">
            Exempt Employee
        </x-primary-button>
        @else
        <x-primary-button class="ml-2 bg-green-700" wire:click="removeexemptobject()" wire:loading.attr="disabled">
            Remove Exemption
        </x-primary-button>
        @endif
    </x-slot>
</x-confirmation-modal>
</div>
