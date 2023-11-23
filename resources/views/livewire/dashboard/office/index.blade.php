<div class="w-full p-4 pb-1 bg-white min-h-screen">
    <div>
        <h1 class="uppercase pb-2  text-xl  leading-none text-gray-700 dark:text-white pr-1 flex justify-center items-center"> Office Summary</h1>

    </div>
   
    @if($finalSubmit)
    <div class=" my-8 bg-lime-500/30 animate-pulse  p-4 border-lime-700 border-0 rounded-md shadow-md flex flex-col justify-between items-center">
        <div class="flex  justify-center items-center">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" class="w-8 h-8 mr-2  stroke-green-800">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>



        </div>
        <div>
            <p class="text-green-800">Your have successfully submitted your data.</p>



        </div>

    </div>

    @else
    @if($cansubmitdata)
    <div class=" my-8 bg-red-800/10  p-4 border-red-900 border-0 rounded-md shadow-md flex  justify-between items-center">
        <div class="flex  justify-center items-center"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" class="w-5 h-5 mr-2  stroke-red-800">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
            </svg>
            <p class="text-red-800">Your have not performed final submission of your office data.</p>

        </div>
        <div>
            <x-danger-button wire:click="toggle('modalfinalsubmit')">Final Submit Your Data</x-danger-button>


        </div>

    </div>
    @else
    <div class=" my-8 bg-amber-600/10  p-4 border-amber-600 border-0 rounded-md shadow-md flex  justify-center items-center">
        <div class="flex  justify-center items-center"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" class="w-5 h-5 mr-2  stroke-red-800">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
            </svg>
            <p class="text-amber-800">Your can submit office data to DEO only after completing data entry of all your employees.</p>

        </div>
       
    </div>
    @endif
    @endif

  
    <div class="flex border bg-blue-900/10 mt-6 border-dashed border-blue-900/30 p-4 rounded-md justify-between items-center mb-4">

        <h1 class="text-l text-blue-900"><span class="font-semibold">Department -</span> {{ $deptname}}</h1>
        <h1 class="text-l text-blue-900"><span class="font-semibold">Office -</span> {{ $officename }}</h1>


    </div>

    <div class="grid grid-cols-5 py-8">
        <div class="p-4 cursor-pointer overflow-hidden transition-transform transform hover:scale-110 ">


            <div class="flex justify-center items-start bg-gradient-to-r from-blue-700 via-sky-600 to-orange-500  pb-1 w-full h-full shadow-lg rounded-t-xl">



                <div class="flex flex-col justify-center items-center w-full p-4  bg-orange-100 h-full rounded-t-lg">
                    <div class="pb-2">

                        <h1 class="text-xl text-orange-600"> {{$totpd}} </h1>
                    </div>
                    <h1>Total Employee</h1>
                </div>
            </div>

        </div>
        <div class="p-4 cursor-pointer  overflow-hidden transition-transform transform hover:scale-110">


            <div class="flex justify-center items-start bg-gradient-to-r from-blue-700 via-sky-600 to-amber-500 pb-1 w-full h-full shadow-lg  rounded-t-xl">



                <div class="flex flex-col justify-center items-center w-full p-4  bg-amber-100 h-full  rounded-t-lg">
                    <div class="pb-2">

                        <h1 class="text-xl text-yellow-700"> {{$totmale}} </h1>

                    </div>
                    <h1>Male</h1>
                </div>
            </div>

        </div>


        <div class="p-4 cursor-pointer  overflow-hidden transition-transform transform hover:scale-110">


            <div class="flex justify-center h-full items-start bg-gradient-to-r from-blue-700 via-sky-600 to-fuchsia-500 pb-1 w-full  shadow-lg rounded-t-xl">



                <div class="flex flex-col justify-center items-center w-full p-4  bg-fuchsia-100 h-full rounded-t-lg">
                    <div class="pb-2">

                        <h1 class="text-2xl text-fuchsia-700"> {{$totfemale}} </h1>
                    </div>
                    <h1>Female</h1>
                </div>
            </div>

        </div>


        <div class="p-4 cursor-pointer  overflow-hidden transition-transform transform hover:scale-110">

            <div class="flex justify-center items-start bg-gradient-to-r from-blue-700 via-sky-600 to-red-600 pb-1 w-full h-full shadow-lg rounded-t-xl ">



                <div class="flex flex-col justify-center items-center w-full p-4 bg-red-100 h-full rounded-t-lg">
                    <div class="pb-2">

                        <h1 class="text-xl text-red-700"> {{$totexempted}} </h1>
                    </div>
                    <h1>Exempted</h1>
                </div>
            </div>

        </div>
        <div class="p-4 cursor-pointer  overflow-hidden transition-transform transform hover:scale-110">


            <div class="flex justify-center items-start bg-gradient-to-r from-blue-700 via-sky-600 to-lime-500  pb-1 w-full h-full shadow-lg rounded-t-xl">



                <div class="flex flex-col justify-center items-center w-full p-4  bg-lime-100 h-full rounded-t-lg">
                    <div class="pb-2">

                        <h1 class="text-xl text-lime-800"> {{$totavailable}}</h1>
                    </div>
                    <h1>Available</h1>
                </div>
            </div>

        </div>
    </div>

    <div>
        @if($totalhrmsdata>0)
        <div class="border bg-gray-100 border-dashed border-gray-200 rounded-md p-4">
            <h1 class=" pb-2  text-md  leading-none text-gray-700 dark:text-white pr-1 flex font-semibold mb-2 ">HRMS Data Entry</h1>
            
            @livewire("progress-bar",["completed"=>$hrmscompleted,"total"=>$totalhrmsdata])
            
    
        </div>
        @endif
        <div class="p-2 pl-0 mt-6 border-t=0 border-gray-400 border-dashed">
            <h1 class="font-semibold text-xl text-red-800">Employees From HRMS </h1>
        </div>
       

        <table class="table-auto w-full border-collapse border">

            <thead class="bg-gray-200 w-full">
                <td class="border  font-semibold text-gray-700 p-2 w-20">Sr No.</td>

                @foreach($hrmsheader as $head)
                <td class="border  text-gray-700 p-2 font-semibold">{{$head}}</td>
                @endforeach
            </thead>


            <tbody>
                @foreach($hrmsNCdata as $index=>$row)
                <tr>
                    <td class=" border text-gray-600 p-1">{{$index + $hrmsNCdata->firstItem()}}</td>



                    <td class=" border p-1 text-gray-600 px-2">{{$row->Name}}</td>
                    <td class=" border p-1 text-gray-600 px-2">{{$row->FName}}</td>
                    <td class=" border p-1 text-gray-600 px-2 w-8">{{$row->sex}}</td>
                    <td class=" border p-1 text-gray-600 px-2 w-16">{{$row->dob}}</td>
                    


                    <td class=" border p-1 text-gray-600 px-2">
                    {{-- {{$row->designation->Designation}} --}}Designation
                    </td>


                    <td class=" border p-1 text-gray-600 ">{{$row->mobileno}}</td>
                    <td class=" border p-1 text-gray-600 px-2 w-32">{{$row->hrmscode}}</td>
                    @can(['update'],[App\Models\PollingData::class])

                    <td class=" border p-1 text-gray-600  w-6">
                        <a href="/transactions/employee/edit/{{$row->id}}">

                            <x-primary-button class="!p-2">Edit</x-primary-button>
                        </a>


                    </td>
                    @else
                    <td class="text-center border p-1 text-gray-600 w-6 ">

                            <svg data-tooltip-target="tooltip-default" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 stroke-red-700 m-auto">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" />
                              </svg>
                              
                          <div id="tooltip-default" role="tooltip" class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700">
                            Data is locked
                            <div class="tooltip-arrow" data-popper-arrow></div>
                        </div>
                    </td>


                    @endcan




                </tr>

                @endforeach




            </tbody>

        </table>
        @if($hrmsNCdata->count()==0)
        <div class="mt-4 p-4 flex justify-center items-center w-full text-gray-500">
            No employee in this section..!
        </div>
        @endif
        <div class="py-2">
            {{ $hrmsNCdata->links() }}
        </div>
        <div class=" border-gray-300 border-dashed py-4">
            <h1 class="font-semibold text-md text-gray-800">Employees transferred to your office </h1>
            <table class="table-auto w-full border-collapse border mt-4">

                <thead class="bg-amber-900/20 w-full">
                    <td class="border  text-center font-semibold text-gray-700 py-2 px-4 w-20">Sr No.</td>
    
                    @foreach($hrmsheader  as $head)
                    <td class="border text-center  text-gray-700 py-2 px-4 font-semibold">{{$head}}</td>
                    @endforeach
                </thead>
    
    
                <tbody>
                    @foreach($hrmsTransferreddata as $index=>$row)
                    <tr>
                        <td class=" border text-gray-600 p-1">{{$index + 1}}</td>
    
    
    
                        <td class=" border p-1 text-gray-600 px-2">{{$row->Name}}</td>
                        <td class=" border p-1 text-gray-600 px-2">{{$row->FName}}</td>
                        <td class=" border p-1 text-gray-600 px-2 w-8">{{$row->sex}}</td>
                        <td class=" border p-1 text-gray-600 px-2 w-16">{{$row->dob}}</td>
                        
    
    
                        <td class=" border p-1 text-gray-600 px-2">
                        {{-- {{$row->designation->Designation}} --}}Designation
                        </td>
    
    
                        <td class=" border p-1 text-gray-600 ">{{$row->mobileno}}</td>
                        <td class=" border p-1 text-gray-600 px-2 w-32">{{$row->hrmscode}}</td>
                        @can(['update'],[App\Models\PollingData::class])
    
                        <td class=" border p-1 w-6 text-gray-600 ">
                            <a href="/transactions/employee/edit/{{$row->id}}">
    
                                <x-primary-button class="!p-2">Edit</x-primary-button>
                            </a>
    
    
                        </td>
                        @else
                        <td class="text-center border p-1 text-gray-600  w-6">
    
                                <svg data-tooltip-target="tooltip-default" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 stroke-red-700 m-auto">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" />
                                  </svg>
                                  
                              <div id="tooltip-default" role="tooltip" class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700">
                                Data is locked
                                <div class="tooltip-arrow" data-popper-arrow></div>
                            </div>
                        </td>
    
    
                        @endcan
    
    
    
    
                    </tr>
    
                    @endforeach
    
    
    
    
                </tbody>
            </table>
            @if($hrmsTransferreddata->count()==0)
            <div class="mt-4 p-4 flex justify-center items-center w-full text-gray-500">
                No employee in this section..!
            </div>
            @endif
           
        </div>

    </div>

    <div>
        <div class="p-2 pl-0 mt-16 border-t=0 border-gray-400 border-dashed">
            <h1 class="font-semibold text-xl text-red-800">Employees Exempted From Polling Duty</h1>
        </div>

        <table class="table-auto w-full border-collapse border">

            <thead class="bg-gray-200 w-full">
                <td class="border  text-center font-semibold text-gray-700 py-2 px-4 w-20">Sr No.</td>

                @foreach($header as $head)
                <td class="border text-center  text-gray-700 py-2 px-4 font-semibold">{{$head}}</td>
                @endforeach
            </thead>


            <tbody>
                @foreach($exempted as $index=>$row)
                <tr>
                    <td class="text-center border text-gray-600 py-2">{{$index + $exempted->firstItem()}}</td>



                    <td class="text-center border text-gray-600 px-2">{{$row->Name}}</td>
                    <td class="text-center border text-gray-600 px-2">{{$row->FName}}</td>
                    <td class="text-center border text-gray-600 px-2 w-8">{{$row->sex}}</td>
                    <td class="text-center border text-gray-600 px-2 w-16">{{$row->dob}}</td>


                    <td class="text-center border text-gray-600 px-2">{{$row->designation->Designation}}</td>


                    <td class="text-center border text-gray-600 ">
                        @if($row->handicap ==1 && $row->longLeave ==1)
                        Employee is differently abled and on long leave.
                        @elseif($row->handicap ==1)
                        Employee is differently abled.
                        @elseif($row->longLeave ==1)
                        Employee is on long leave.
                        @else
                        {{$row->remarks}}
                        @endif

                    </td>
                    @can(['update'],[App\Models\PollingData::class])

                    <td class="text-center border text-gray-600 ">
                        <a href="/transactions/employee/edit/{{$row->id}}">

                            <x-primary-button class="!p-2">Edit</x-primary-button>
                        </a>


                    </td>
                    @else
                    <td class="text-center border text-gray-600 ">

                            <svg data-tooltip-target="tooltip-default" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 stroke-red-700 m-auto">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" />
                              </svg>
                              
                          <div id="tooltip-default" role="tooltip" class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700">
                            Data is locked
                            <div class="tooltip-arrow" data-popper-arrow></div>
                        </div>
                    </td>


                    @endcan




                </tr>

                @endforeach




            </tbody>

        </table>
        @if($exempted->count()==0)
        <div class="mt-4 p-4 flex justify-center items-center w-full text-gray-500">
            No Employee is exempted from polling duty!
        </div>
        @endif
        <div class="py-2">
            {{ $exempted->links() }}
        </div>

    </div>




    <x-confirmation-modal wire:model="modalfinalsubmit">
        <x-slot name="icon">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" class="stroke-white w-5 h-5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" />
            </svg>


        </x-slot>


        <x-slot name="title">
            Final Submit your Data
        </x-slot>


        <x-slot name="content">

            <div class="w-full flex flex-col justify-center">
                <div class="bg-orange-500/10 p-2 rounded-md border-0 border-red-700">
                    <h1 class="text-md text-red-700 mb-2 font-semibold">Are you sure you want to final submit your data?</h1>
                    <p class="text-sm">Upon final submission, your data will be locked. After data locking, you will have the ability to solely review the data that you have submitted. Making any alterations to employee particulars will not be feasible.</p>
                </div>

                <h2 class="my-4 font-bold text-xl ">Summary of Data</h2>
                <table>
                    <tr class="bg-gray-200" >
                        <td class="p-2">Total Employees Added</td>
                        <td class="p-2">{{$totpd}}</td>
                    </tr>
                    <tr class="bg-gray-100">
                        <td class="p-2">Total Males</td>
                        <td class="p-2">{{$totmale}}</td>


                    </tr>
                    <tr class="bg-gray-100">
                        <td class="p-2">Total Females</td>
                        <td class="p-2">{{$totfemale}}</td>


                    </tr>
                    <tr class="bg-gray-100">
                        <td class="p-2">Total Exempted</td>
                        <td class="p-2">{{$totexempted}}</td>


                    </tr>
                </table>
                <div class="bg-gray-200 flex space-between mt-2 ">
                
                        <div class="w-4/5 text-sm p-2">Total Available</div>
                        <div class="w-1/5 text-sm p-2 bg-lime-800/20 flex justify-center items-center">{{$totavailable}}</div>
                   
                </div>


            </div>

        </x-slot>

        <x-slot name="footer">
            <x-secondary-button wire:click="$toggle('modalfinalsubmit')" wire:loading.attr="disabled">
                Cancel
            </x-secondary-button>


            <x-primary-button class="ml-2" wire:click="finalSubmit()" wire:loading.attr="disabled">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 mr-2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" />
                </svg>


                Confirm Final Submission
            </x-primary-button>

        </x-slot>
    </x-confirmation-modal>


</div>
