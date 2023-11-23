<div>
    <div class="flex border bg-blue-900/5 border-dashed border-blue-900/30 p-1 rounded-md justify-center items-center mb-4">
        <div class="w-2/3">
            <div class="flex">
                <h1 class="text-l text-blue-900"><span class="font-semibold">Department -</span> {{ $deptname }}</h1>
            </div>

            <div class="flex">
                <h1 class="text-l text-red-800"><span class="font-semibold">Office -</span> {{ $officename }}</h1>

            </div>
        </div>
        <div class="w-1/3 text-right">
            <h1 class="text-3xl text-blue-900">Total Employees- {{$total}}</h1>
        </div>


    </div>
    <div class="flex justify-between p-4 rounded-md mb-4  bg-gray-200">

        <div class=" w-1/2 rounded-sm px-4">

            <x-input type="text" wire:model.debounce.500ms="search" placeholder="Search..." class="w-full border-0 h-12 rounded-lg">

            </x-input>

        </div>
        <div>
            @can(['create'],[App\Models\PollingData::class])

            <a href="/transactions/employee/add">
                <x-primary-button>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 mr-2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                    </svg>


                    New Employee</x-primary-button>
            </a>
            @endcan


        </div>
    </div>
    <table class="table-auto w-full border-collapse border">

        <thead class="bg-gray-200 w-full">
            <td class="border font-semibold  text-gray-700 p-2 w-16">Sr No.</td>

            @foreach($header as $head)
            <td class="border font-semibold text-gray-700 p-2">{{$head}}</td>
            @endforeach
        </thead>


        <tbody>
            @foreach($data as $index=>$row)
            <tr  wire:key="{{ $row->id }}">
                <td class="text-left border text-gray-600 py-2">{{$index + $data->firstItem()}}</td>
                <td class="text-left border  h-20 w-20">
                    <img src="{{ $this->retrieveImage($row->photoid) }}" alt="Photo" class="h-20 w-20 rounded-md"></td>


                <td class="text-left border text-gray-600 px-2">{{$row->Name}}</td>
                <td class="text-left border text-gray-600 px-2">{{$row->FName}}</td>
                <td class="text-left border text-gray-600 px-2"> @if($row->sex =='M')
                    Male
                @elseif($row->sex =="F")
                    Female
                @else
                    Other
                @endif</td>
                <td class="text-left border text-gray-600 px-2">{{$row->rAddress}}</td>


                <td class="text-left border text-gray-600 px-2">{{$row->mobileno}}</td>

                @can(['view'],[App\Models\PollingData::class])
                <td class="text-left border text-gray-600 w-8 ">
                    <div class="flex justify-center items-center"><a href="javascript:void(0)"  wire:click='viewrecord({{ $row->id }})' class="m-2 hover:bg-blue-100 p-2 rounded-md">


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
<div class="py-2">
    {{ $data->links() }}
</div>
@if($data->count() <=0)
<div class="w-full  bg-gray-100 rounded-md flex justify-center items-center p-10 text-gray-500"> No record found ..</div>
@endif
<x-confirmation-modal wire:model="confirmdeletemodal">

    <x-slot name="icon">
        <svg class="h-6 w-6 stroke-white" stroke-width="1.5" fill="none" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M19 7.5v3m0 0v3m0-3h3m-3 0h-3m-2.25-4.125a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zM4 19.235v-.11a6.375 6.375 0 0112.75 0v.109A12.318 12.318 0 0110.374 21c-2.331 0-4.512-.645-6.374-1.766z" />
        </svg>
    </x-slot>


    <x-slot name="title">
        Delete Employee?
    </x-slot>


    <x-slot name="content">

        <div class="w-full flex flex-col justify-center">
            <h1 class="text-2xl text-red-800 ">Are you sure you want to permanently delete this employee?</h1>

        </div>

    </x-slot>

    <x-slot name="footer">
        <x-secondary-button wire:click="$toggle('confirmdeletemodal')" wire:loading.attr="disabled">
            Cancel
        </x-secondary-button>

        @if($delobject && $delobject->id )
        @can(['delete'],[App\Models\PollingData::class])
        <x-primary-button class="ml-2" wire:click="deleteRecord({{$delobject->id}})" wire:loading.attr="disabled">
            Delete Employee
        </x-primary-button>
        @endcan
        @endif

    </x-slot>
</x-confirmation-modal>


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
                                @if($viewobject->sex =='M')
                                    Male
                                @elseif($viewobject->sex =="F")
                                    Female
                                @else
                                    Other
                                @endif
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
                    {{ $viewobject->designation->Designation}}
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
                    {{ $viewobject->category=="O"?"Other":$viewobject->category
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
            <tr class="w-full mb-2">
                <th class="w-4/12 border-b border-gray-200 p-1">EPIC No.</th>
                <td class="w-8/12 border-b border-gray-200 p-1">
                    @if($viewobject)
                    {{ $viewobject->epicno}}
                    @endif
                </td>
            </tr>
            <tr class="w-full mb-2">
                <th class="w-4/12 border-b border-gray-200 p-1">Vote Registered at AC</th>
                <td class="w-8/12 border-b border-gray-200 p-1">
                    @if($viewobject && $viewobject->RegdVoterCons)
                    {{ $viewobject->regdvotercons->AC_NAME }}
                    @endif
                </td>
            </tr>
         
            <tr class="w-full mb-2">
                <th class="w-4/12 border-b border-gray-200 p-1">Part No.</th>
                <td class="w-8/12 border-b border-gray-200 p-1">
                    @if($viewobject)
                    {{ $viewobject->partno }}
                    @endif
                </td>
            </tr>
            <tr class="w-full mb-2">
                <th class="w-4/12 border-b border-gray-200 p-1">Serial No. in Part No.</th>
                <td class="w-8/12 border-b border-gray-200 p-1">
                    @if($viewobject)
                    {{ $viewobject->serialno }}
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
                <th class="w-4/12 border-b border-gray-200 p-1">Differently Abled</th>
                <td class="w-8/12 border-b border-gray-200 p-1">
                    @if($viewobject)
                    {{ $viewobject->handicap? "Yes":"No"}}
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
                    @if($viewobject)
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
                    @if($viewobject)
                    {{ $viewobject->BankAcNo }}
                    @endif
                </td>
            </tr>
            <tr class="w-full mb-2">
                <th class="w-4/12 border-b border-gray-200 p-1">Bank IFSC Code</th>
                <td class="w-8/12 border-b border-gray-200 p-1">
                    @if($viewobject)
                    {{ $viewobject->IfscCode}}
                    @endif
                </td>
            </tr>
        </table>

    </x-slot>
   
    <x-slot name="footer">
        @if($viewobject)
        @can(['update'],[App\Models\PollingData::class])
            <x-primary-button wire:loading.attr="disabled" class="mr-2" wire:click="openForEditing({{$viewobject->id}})" >
                Edit
            </x-primary-button>
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

</div>
