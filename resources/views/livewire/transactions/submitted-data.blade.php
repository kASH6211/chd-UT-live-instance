<div>
    
   <div class="flex flex-col justify-center items-center">
        <h1 class="uppercase text-md font-semibold">{{ $officename }}</h1>
        
   </div>
   <div class="grid grid-cols-2 border-t border-gray-200 border-dashed mt-4 pt-4">
        <div class="">
            <div><span class="font-semibold">Department -</span> {{ $deptname}}</div>
            <div><span class="font-semibold">Sub Department -</span> {{ $subdeptname }}</div>

        </div>
        <div class=" flex flex-col justify-end items-end">
         
    
            <table>
                <tr>
                    <td><span class="font-semibold">Data Submitted on -</span></td><td> {{ $datesubmitted->format('d/M/Y') }}</td>
                </tr>
                <tr>
                    <td><span class="font-semibold">Total Employees -</span></td><td> {{ $totalemployees }}</td>
                </tr>
                <tr>
                    <td><span class="font-semibold">Males -</span></td><td> {{ $males }}</td>
                </tr>
                <tr>
                    <td><span class="font-semibold">Females -</span></td><td> {{ $females }}</td>
                </tr>
                <tr>
                    <td><span class="font-semibold text-lime-700">Available-</span></td><td class="font-semibold text-lime-700"> {{ $available}}</td>
                </tr>
                <tr>
                    <td><span class="font-semibold text-red-700">Exempted-</span></td><td class="font-semibold text-red-700"> {{ $exempted }}</td>
                </tr>
            </table>

        </div>

   </div>
   <div class="flex  mt-6 p-4 rounded-md justify-between items-center mb-4">

    <table class="table-auto w-full border-collapse border">
        <thead class="bg-gray-100 w-full">
            <td class="border text-center text-gray-700 py-2 px-4 w-8 text-sm font-semibold ">Sr No.</td>
            <td class="border text-center text-gray-700 py-2 px-4 text-sm font-semibold ">Photo</td>
            <td class="border text-center text-gray-700 py-2 px-4  text-sm font-semibold ">Name</td>
            <td class="border text-center text-gray-700 py-2 px-4 text-sm font-semibold ">Father/Husband Name</td>
            <td class="border text-center text-gray-700 py-2 px-4  text-sm font-semibold w-24 ">Sex</td>
            <td class="border text-center text-gray-700 py-2 px-4  text-sm font-semibold ">Address</td>
            <td class="border text-center text-gray-700 py-2 px-4 w-8 text-sm font-semibold ">Mobile</td>
            <td class="border text-center text-gray-700 py-2 px-4 w-8  text-sm font-semibold ">View Details</td>


        </thead>
        <tbody>
            @foreach($submitteddata as $index=>$row)
            @if($row->del =='d')
            <tr class="bg-red-50">
                <td class="text-center border text-gray-600 py-2">{{$index + $submitteddata->firstItem()}} </td>
                <td class="text-center border   h-16 w-16">
                    <img src="{{ $this->retrieveImage($row->photoid) }}" alt="Photo" class="h-16 w-16 rounded-md"></td>


                <td class="text-center border text-gray-600 px-2 "><span class=" line-through">{{$row->Name}}</span><br/><span class="text-sm text-red-700 font-semibold">(Exempted)</span></td>
                <td class="text-center border text-gray-600 px-2 line-through">{{$row->FName}}</td>
                <td class="text-center border text-gray-600 px-2 line-through">{{$row->sex}}</td>
                <td class="text-center border text-gray-600 px-2 line-through">{{$row->rAddress}}</td>


                <td class="text-center border text-gray-600 px-2 line-through">{{$row->mobileno}}</td>
            @else
            <tr>
                <td class="text-center border text-gray-600 py-2">{{$index + $submitteddata->firstItem()}}</td>
                <td class="text-center border     h-16 w-16">
                    <img src="{{ $this->retrieveImage($row->photoid) }}" alt="Photo" class="h-16 w-16 rounded-md"></td>


                <td class="text-center border text-gray-600 px-2">{{$row->Name}}</td>
                <td class="text-center border text-gray-600 px-2">{{$row->FName}}</td>
                <td class="text-center border text-gray-600 px-2">{{$row->sex}}</td>
                <td class="text-center border text-gray-600 px-2">{{$row->rAddress}}</td>


                <td class="text-center border text-gray-600 px-2">{{$row->mobileno}}</td>
            @endif
            

                @can(['view'],[App\Models\PollingData::class])
                <td class="text-center border text-gray-600 w-8 ">
                    <div class="flex justify-center items-center"><a href="javascript:void(0)" wire:key="{{$row->id}}" wire:click='viewrecord({{ $row->id }})' class="m-2 hover:bg-blue-100 p-2 rounded-md">


                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" class="w-5 h-5 stroke-blue-500">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>


                        </a></div>
                </td>
                @endcan
            </tr>
            @endforeach
        </tbody>
    </table>
    

</div>
<div>{{ $submitteddata->links() }}</div>
@if(!$this->isFinalized())
<div class="py-8 flex justify-center items-center mt-8 bg-gray-100 rounded-md">
    <x-primary-button class="mr-3" wire:click="toggle('final1')">Finalize this data</x-primary-button>
    <x-danger-button wire:click="returnToOffice()">Return data to office</x-primary-button>

</div>
@endif
<x-confirmation-modal maxWidth="4xl" wire:model="viewmodal">

    <x-slot name="icon">
        <svg class="h-6 w-6 stroke-white" stroke-width="1.5" fill="none" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M19 7.5v3m0 0v3m0-3h3m-3 0h-3m-2.25-4.125a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zM4 19.235v-.11a6.375 6.375 0 0112.75 0v.109A12.318 12.318 0 0110.374 21c-2.331 0-4.512-.645-6.374-1.766z" />
        </svg>
    </x-slot>


    <x-slot name="title">
        Employee Details
    </x-slot>


    <x-slot name="content">

        <h1 class="text-xl font-semibold mb-4 text-red-800">Personal Details</h1>
        <div class=" pr-10">
            @if($viewobject)
            <div>


                <img src="{{ $this->retrieveImage($viewobject->photoid) }}" alt="Photo" class="h-32 w-32 border-2 border-gray-400"></td>

            </div>

            @endif

            <div class="">
                <table class="w-full border-separate border-spacing-y-2">
                    <tr class="w-full mb-2 ">
                        <th class="w-4/12   border-b border-gray-200 p-1">Name</th>

                        <td class="w-8/12  border-b border-gray-200 p-1">

                            @if($viewobject)
                            {{ $viewobject->Name }}
                            @endif
                        </td>
                    </tr>
                    <tr class="w-full">
                        <th class="w-4/12   border-b border-gray-200  p-1">Father/Husband Name</th>


                        <td class="w-8/12  border-b border-gray-200  p-1">

                            @if($viewobject)
                            {{ $viewobject->FName }}
                            @endif
                        </td>
                    </tr>
                    <tr class="w-full">
                        <th class="w-4/12   border-b border-gray-200 p-1">Sex</th>


                        <td class="w-8/12  border-b border-gray-200  p-1">

                            @if($viewobject)
                            {{ ($viewobject->sex =='M')?"Male":"Female" }}
                            @endif
                        </td>
                    </tr>
                    <tr class="w-full">
                        <th class="w-4/12 border-b border-gray-200 p-1">Mobile Number</th>

                        <td class="w-8/12 border-b border-gray-200 p-1">
                            @if($viewobject)
                            {{ $viewobject->mobileno }}
                            @endif
                        </td>
                    </tr>
                    <tr class="w-full">
                        <th class="w-4/12 border-b border-gray-200 p-1">Email Address</th>

                        <td class="w-8/12 border-b border-gray-200 p-1">
                            @if($viewobject)
                            {{ $viewobject->emailid }}
                            @endif
                        </td>
                    </tr>
                    <tr class="w-full">
                        <th class="w-4/12 border-b border-gray-200 p-1">Date of Birth</th>

                        <td class="w-8/12 border-b border-gray-200 p-1">
                            @if($viewobject)
                            {{ $viewobject->dob}}
                            @endif
                        </td>
                    </tr>
                    <tr class="w-full">
                        <th class="w-4/12 border-b border-gray-200 p-1">Date of Retirement</th>

                        <td class="w-8/12 border-b border-gray-200 p-1">
                            @if($viewobject)
                            {{ $viewobject->retiredt}}
                            @endif
                        </td>
                    </tr>
                </table>
            </div>


        </div>



        <h1 class="text-xl font-semibold mb-4 mt-4 text-red-800">Designation & Salary</h1>

        <table class="w-full border-separate border-spacing-y-2">
            <tr class="w-full">
                <th class="w-4/12 border-b border-gray-200 p-1">Designation</th>
                <td class="w-8/12 border-b border-gray-200 p-1">
                    @if($viewobject)
                   
                    {{ $viewobject->DesigCode}}
                    @endif
                </td>
            </tr>
            <tr class="w-full">
                <th class="w-4/12 border-b border-gray-200 p-1">Employee Type</th>
                <td class="w-8/12 border-b border-gray-200 p-1">
                    @if($viewobject)
                    {{ $viewobject->employeetype->EmpTypeName}}
                    @endif
                </td>
            </tr>
            <tr class="w-full">
                <th class="w-4/12 border-b border-gray-200 p-1">Class</th>
                <td class="w-8/12 border-b border-gray-200 p-1">
                    @if($viewobject)
                    {{ $viewobject->category
                           }}
                    @endif
                </td>
            </tr>
            <tr class="w-full">
                <th class="w-4/12 border-b border-gray-200 p-1">Pay Scale</th>
                <td class="w-8/12 border-b border-gray-200 p-1">
                    @if($viewobject)
                    {{$this->getPayScaleTitle()}}

                    @endif
                </td>
            </tr>
            <tr class="w-full">
                <th class="w-4/12 border-b border-gray-200 p-1">Basic Pay</th>
                <td class="w-8/12 border-b border-gray-200 p-1">
                    @if($viewobject)
                    {{ $viewobject->basicPay}}
                    @endif
                </td>
            </tr>
            <tr class="w-full">
                <th class="w-4/12 border-b border-gray-200 p-1">DDO Code</th>
                <td class="w-8/12 border-b border-gray-200 p-1">
                    @if($viewobject)
                    {{ $viewobject->ddocode
                           }}
                    @endif
                </td>
            </tr>

            <tr class="w-full">
                <th class="w-4/12 border-b border-gray-200 p-1">HRMS Code</th>
                <td class="w-8/12 border-b border-gray-200 p-1">
                    @if($viewobject)
                    {{ $viewobject->hrmscode}}
                    @endif
                </td>
            </tr>
            <tr class="w-full">
                <th class="w-4/12 border-b border-gray-200 p-1">IFMS Payee Code</th>
                <td class="w-8/12 border-b border-gray-200 p-1">
                    @if($viewobject)
                    {{ $viewobject->ifmscode}}
                    @endif
                </td>
            </tr>
        </table>

        <h1 class="text-xl font-semibold mb-4  mt-4 text-red-800">Office & Home Address</h1>


        <table class="w-full border-separate border-spacing-y-2">

            <tr class="w-full mb-2">
                <th class="w-4/12 border-b border-gray-200 p-1">Native Assembly Segment</th>
                <td class="w-8/12 border-b border-gray-200 p-1">
                    @if($viewobject && $viewobject->nativecon)
                    {{ $viewobject->nativeconstituency->AC_NAME }}
                    @endif
                </td>
            </tr>
            <tr class="w-full mb-2">
                <th class="w-4/12 border-b border-gray-200 p-1">Residence Assembly Segment</th>
                <td class="w-8/12 border-b border-gray-200 p-1">
                    @if($viewobject && $viewobject->HomeCons)
                    {{ $viewobject->homeconstituency->AC_NAME}}

                    @endif
                </td>
            </tr>
            <tr class="w-full mb-2">
                <th class="w-4/12 border-b border-gray-200 p-1">Office Assembly Segment</th>
                <td class="w-8/12 border-b border-gray-200 p-1">
                    @if($viewobject && $viewobject->cons)
                    {{ $viewobject->officeconstituency->AC_NAME }}

                    @endif
                </td>
            </tr>
            <tr class="w-full mb-2">
                <th class="w-4/12 border-b border-gray-200 p-1">Office Name & Address</th>
                <td class="w-8/12 border-b border-gray-200 p-1">
                    @if($viewobject)
                    {{ $viewobject->office }}
                    @endif
                </td>
            </tr>
            <tr class="w-full mb-2">
                <th class="w-4/12 border-b border-gray-200 p-1">Residential Address & Phone No.</th>
                <td class="w-8/12 border-b border-gray-200 p-1">
                    @if($viewobject)
                    {{ $viewobject->rAddress }}
                    @endif
                </td>
            </tr>
        </table>

        <h1 class="text-xl font-semibold mb-4  mt-4 text-red-800">Election Duty</h1>


        <table class="w-full border-separate border-spacing-y-2">

            <tr class="w-full mb-2">
                <th class="w-4/12 border-b border-gray-200 p-1">Already Exercised Election Duty</th>
                <td class="w-8/12 border-b border-gray-200 p-1">
                    @if($viewobject)
                    {{ $viewobject->excercisedElectionDuty }}
                    @endif
                </td>
            </tr>
            <tr class="w-full mb-2">
                <th class="w-4/12 border-b border-gray-200 p-1">Select as </th>
                <td class="w-8/12 border-b border-gray-200 p-1">
                    @if($viewobject)
                    {{ $viewobject->electionclass->description}}
                    @endif
                </td>
            </tr>
            <tr class="w-full mb-2">
                <th class="w-4/12 border-b border-gray-200 p-1">Handicapped</th>
                <td class="w-8/12 border-b border-gray-200 p-1">
                    @if($viewobject)
                    {{-- {{ $viewobject->handicap? "Yes":"No"}} --}}
                    @endif
                </td>
            </tr>
            <tr class="w-full mb-2">
                <th class="w-4/12 border-b border-gray-200 p-1">On Long Leave</th>
                <td class="w-8/12 border-b border-gray-200 p-1">
                    @if($viewobject)
                    {{ $viewobject->longLeave? "Yes":"No"}}

                    @endif
                </td>
            </tr>
            <tr class="w-full mb-2">
                <th class="w-4/12 border-b border-gray-200 p-1">Remarks</th>
                <td class="w-8/12 border-b border-gray-200 p-1">
                    @if($viewobject && $viewobject->Remarks)
                    {{ $viewobject->Remarks}}
                    @endif
                </td>
            </tr>

        </table>
        <h1 class="text-xl font-semibold mb-4  mt-4 text-red-800">Bank Details</h1>

        <table class="w-full border-separate border-spacing-y-2">

            <tr class="w-full mb-2">
                <th class="w-4/12 border-b border-gray-200 p-1">Bank Name</th>
                <td class="w-8/12 border-b border-gray-200 p-1">
                    @if($viewobject and $viewobject->bank)
                    {{ $viewobject->bank->BankName }}
                    @endif
                </td>
            </tr>
            <tr class="w-full mb-2">
                <th class="w-4/12 border-b border-gray-200 p-1">Bank Account No.</th>
                <td class="w-8/12 border-b border-gray-200 p-1">
                    @if($viewobject && $viewobject->BankAcNo)
                    {{ $viewobject->BankAcNo }}
                    @endif
                </td>
            </tr>
            <tr class="w-full mb-2">
                <th class="w-4/12 border-b border-gray-200 p-1">Bank IFSC Code</th>
                <td class="w-8/12 border-b border-gray-200 p-1">
                    @if($viewobject && $viewobject->IfscCode)
                    {{ $viewobject->IfscCode}}
                    @endif
                </td>
            </tr>
        </table>

    </x-slot>
   
    <x-slot name="footer">
        @if($viewobject)
        @can(['update'],[App\Models\PollingData::class])
        <a href="employee/edit/{{$viewobject->id}}">
            <x-primary-button wire:loading.attr="disabled" class="mr-2">
                Edit
            </x-primary-button>
        </a>
        @endcan

        @can(['delete'],[App\Models\PollingData::class])
        <x-danger-button wire:click="openForDeletion({{$viewobject->id}})" wire:loading.attr="disabled" class="mr-2">

            Delete
        </x-danger-button>
        @endcan
        @endif
        <x-secondary-button wire:click="$toggle('viewmodal')" wire:loading.attr="disabled">
            Close
        </x-secondary-button>



    </x-slot>
</x-confirmation-modal>

<x-confirmation-modal wire:model="final1">

    <x-slot name="icon">
        <svg class="h-6 w-6 stroke-white" stroke-width="1.5" fill="none" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M19 7.5v3m0 0v3m0-3h3m-3 0h-3m-2.25-4.125a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zM4 19.235v-.11a6.375 6.375 0 0112.75 0v.109A12.318 12.318 0 0110.374 21c-2.331 0-4.512-.645-6.374-1.766z" />
        </svg>
    </x-slot>


    <x-slot name="title">
       Finalize and Lock the data
    </x-slot>


    <x-slot name="content">

        <div class="w-full flex flex-col justify-center">
            <h1 class="text-2xl text-red-800 ">Are you sure you want to finalize the data?</h1>
        </div>
        <div class="py-4">
            <table>
                <tr>
                    <td class="py-2 px-4"><span class="font-semibold">Office -</span> </td>
                    <td>{{ $officename }}</td>

                </tr>
                <tr>
                    <td class="py-2 px-4"><span class="font-semibold">Department -</span> </td>
                    <td>{{ $deptname }}</td>

                </tr>
                <tr>
                    <td class="py-2 px-4"><span class="font-semibold">Sub Department -</span> </td>
                    <td>{{ $subdeptname }}</td>

                </tr>
                <tr>
                    <td class="py-2 px-4"><span class="font-semibold">Total Employees -</span> </td>
                    <td>{{ $totalemployees }}</td>

                </tr>
                <tr>
                    <td class="py-2 px-4"><span class="font-semibold">Males -</span> </td>
                    <td>{{ $males}}</td>

                </tr>
                <tr>
                    <td class="py-2 px-4"><span class="font-semibold">Females -</span> </td>
                    <td>{{ $females }}</td>

                </tr>
                <tr>
                    <td class="py-2 px-4"><span class="font-semibold text-red-700">Exempted-</span> </td>
                    <td>{{ $exempted}}</td>

                </tr>
                <tr>
                    <td class="py-2 px-4"><span class="font-semibold text-green-700">Available-</span> </td>
                    <td>{{ $available }}</td>

                </tr>
            
            </table>
        </div>
        <div class="mt-4 p-3 border-0 bg-yellow-200 rounded-md">
                <span class="font-semibold text-red-700">Warning! -</span> Once office data is finalized it cannot be changed or sent back to office for modifications. Are you sure you want to finalize this data?
        </div>
        

    </x-slot>

    <x-slot name="footer">
        <x-primary-button wire:click="openfinal2()" wire:loading.attr="disabled" class="mr-2">
            Finalize
        </x-secondary-button>
        <x-secondary-button wire:click="$toggle('final1')" wire:loading.attr="disabled">
            Cancel
        </x-secondary-button>

       

    </x-slot>
</x-confirmation-modal>
<x-confirmation-modal wire:model="final2">

    <x-slot name="icon">
        <svg class="h-6 w-6 stroke-white" stroke-width="1.5" fill="none" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M19 7.5v3m0 0v3m0-3h3m-3 0h-3m-2.25-4.125a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zM4 19.235v-.11a6.375 6.375 0 0112.75 0v.109A12.318 12.318 0 0110.374 21c-2.331 0-4.512-.645-6.374-1.766z" />
        </svg>
    </x-slot>


    <x-slot name="title">
       Finalize and Lock the data
    </x-slot>


    <x-slot name="content">

        <div class="w-full flex flex-col justify-center">
            <h1 class="text-3xl text-red-800 ">Are you sure you want to finalize the data?</h1>
        </div>
       
        <div class="mt-4 p-3 border border-red-500 bg-yellow-200 rounded-md">
                <span class="font-semibold text-red-700">Warning! -</span> Once office data is finalized it cannot be changed or sent back to office for modifications. Are you sure you want to finalize this data?
        </div>

    </x-slot>

    <x-slot name="footer">
        <x-primary-button wire:click="finalize()" wire:loading.attr="disabled" class="mr-2">
            Finalize
        </x-secondary-button>
        <x-secondary-button wire:click="$toggle('final2')" wire:loading.attr="disabled">
            Cancel
        </x-secondary-button>

       

    </x-slot>
</x-confirmation-modal>
<x-confirmation-modal wire:model="returnback">

    <x-slot name="icon">
        <svg class="h-6 w-6 stroke-white" stroke-width="1.5" fill="none" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M19 7.5v3m0 0v3m0-3h3m-3 0h-3m-2.25-4.125a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zM4 19.235v-.11a6.375 6.375 0 0112.75 0v.109A12.318 12.318 0 0110.374 21c-2.331 0-4.512-.645-6.374-1.766z" />
        </svg>
    </x-slot>


    <x-slot name="title">
       Return to office
    </x-slot>


    <x-slot name="content">

        <div class="w-full flex flex-col justify-center">
            <h1 class="text-xl text-red-800 ">Are you sure you want to send this data back to the office?</h1>
        </div>
        <div class="py-4">
            <table>
                <tr>
                    <td class="py-2 px-4"><span class="font-semibold">Office -</span> </td>
                    <td>{{ $officename }}</td>

                </tr>
                <tr>
                    <td class="py-2 px-4"><span class="font-semibold">Department -</span> </td>
                    <td>{{ $deptname }}</td>

                </tr>
                <tr>
                    <td class="py-2 px-4"><span class="font-semibold">Sub Department -</span> </td>
                    <td>{{ $subdeptname }}</td>

                </tr>
                <tr>
                    <td class="py-2 px-4"><span class="font-semibold">Total Employees -</span> </td>
                    <td>{{ $totalemployees }}</td>

                </tr>
                <tr>
                    <td class="py-2 px-4"><span class="font-semibold">Males -</span> </td>
                    <td>{{ $males}}</td>

                </tr>
                <tr>
                    <td class="py-2 px-4"><span class="font-semibold">Females -</span> </td>
                    <td>{{ $females }}</td>

                </tr>
                <tr>
                    <td class="py-2 px-4"><span class="font-semibold text-red-700">Exempted-</span> </td>
                    <td>{{ $exempted}}</td>

                </tr>
                <tr>
                    <td class="py-2 px-4"><span class="font-semibold text-green-700">Available-</span> </td>
                    <td>{{ $available }}</td>

                </tr>
            </table>
        </div>
      
         <div class="mt-4 w-full">
                <x-label for="name" value="{{ __('Reason of Rectification') }}"  class="font-semibold" />
                <x-input class="w-full p-2" type="textarea" id="multilineText" wire:model.defer="reasonpublic" rows="10" />
            </div>
        <div class="mt-4 p-3 border border-red-500 bg-yellow-200 rounded-md">
                <span class="font-semibold text-red-700">Warning! -</span> Once office data is returned. The office can make changes to all the records of this data. Are you sure you want to send this data back to the office?
       
            </div>

         <div class="mt-4 p-3 border border-blue-500 border-dashed bg-blue-200 rounded-md">
                <span class="font-semibold text-blue-800">Note! -</span> <span class="">{{$officemail?"Office User will also receive email alert on - ".$officemail:" Office email not updated hence office will not get email alert."}}</span>
        </div>

    </x-slot>

    <x-slot name="footer">
        <x-primary-button wire:click="sendback()" wire:loading.attr="disabled" class="mr-2">
           Send Back to Office
        </x-secondary-button>
        <x-secondary-button wire:click="$toggle('returnback')" wire:loading.attr="disabled">
            Cancel
        </x-secondary-button>

       

    </x-slot>
</x-confirmation-modal>
</div>
