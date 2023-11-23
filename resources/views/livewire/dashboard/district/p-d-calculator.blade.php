<div>
    {{-- <div class=" p-4rounded-md  my-2 flex justify-between items-center">
        <h1 class="text-gray-500">Criteria: Total Number of employees in a polling party - 4 (PRO-{{$pollingparty['pro']}} , APRO-{{$pollingparty['apro']}}, PO-{{$pollingparty['po']}}) + Reserve - {{$pollingparty['reserve']}}%</h1>
        <x-secondary-button wire:click="toggle('newmodal')">Change Criteria</x-primary-button>
    </div> --}}
    <div class="flex justify-center items-center w-full p-4">

        <div class="w-3/5 p-4">
            @php
            $pro_req = $calculateddata['pro_req']+$calculateddata['pro_reserve'];
            $pro_change = 0;
            if ($pro_req >0)
            {
                $pro_change = ($calculateddata['pro_avl']-$pro_req)/$pro_req;
            }

            $apro_req = $calculateddata['apro_req']+$calculateddata['apro_reserve'];
            $apro_change = 0;
            if ($apro_req >0)
            {
            $apro_change = ($calculateddata['apro_avl']-$apro_req)/$apro_req;
            }


            $po_req = $calculateddata['po_req']+$calculateddata['po_reserve'];
            $po_change = 0;
            if ($po_req >0)
            {
            $po_change = ($calculateddata['po_avl']-$po_req)/$po_req;
            }


            @endphp

            <table class="table-auto w-full border-collapse border">

                <thead class="bg-gray-100 w-full">
                    <td></td>

                    <td class="border bg-gray-100 py-2 px-4 w-8 text-sm font-semibold  text-center">Requirement (as per booths)</td>


                    <td class="border bg-gray-100 py-2 px-4 w-8 text-sm font-semibold  text-center">Reserve Required</td>
                    <td class="border bg-gray-100 py-2 px-4 w-8 text-sm font-semibold  text-center">Total Requirement</td>

                    <td class="border bg-gray-100 py-2 px-4 w-8 text-sm font-semibold  text-center">Availability</td>
                    <td class="border bg-gray-100 py-2 px-4 w-8 text-sm font-semibold  text-center">Status (% age)</td>

                </thead>
                <tbody>

                    <tr>
                        <td class="border bg-gray-50 py-2 px-4 w-8 text-sm font-semibold  text-center">PRO</td>
                        <td class="text-center border text-gray-600 font-semibold text-sm">{{$calculateddata['pro_req']}}</td>
                        <td class="text-center border text-gray-600 font-semibold text-sm">{{$calculateddata['pro_reserve']}}</td>
                        <td class=" text-center border text-gray-600 font-semibold text-sm">{{$calculateddata['pro_req']+$calculateddata['pro_reserve']}}</td>
                        <td class=" text-center border text-gray-600 font-semibold text-sm">{{$calculateddata['pro_avl']}}</td>
                        @if($pro_change <0) <td class=" bg-red-700 text-center border text-red-100 font-semibold text-sm">{{number_format($pro_change*100,2)}}%</td>
                            @else
                            <td class=" bg-green-700 text-center border text-green-100 font-semibold text-sm">+{{number_format($pro_change*100,2)}}%</td>

                            @endif

                    </tr>
                    <tr>
                        <td class="border bg-gray-50  py-2 px-4 w-8 text-sm font-semibold  text-center">APRO</td>
                        <td class="text-center border text-gray-600 font-semibold text-sm">{{$calculateddata['apro_req']}}</td>
                        <td class="text-center border text-gray-600 font-semibold text-sm">{{$calculateddata['apro_reserve']}}</td>
                        <td class="text-center border text-gray-600 font-semibold text-sm">{{$calculateddata['apro_req']+$calculateddata['apro_reserve']}}</td>
                        <td class="text-center border text-gray-600 font-semibold text-sm">{{$calculateddata['apro_avl']}}</td>
                        @if($apro_change <0) <td class=" bg-red-700 text-center border text-red-100 font-semibold text-sm">{{number_format($apro_change*100,2)}}%</td>
                            @else
                            <td class=" bg-green-700 text-center border text-green-100 font-semibold text-sm">+{{number_format($apro_change*100,2)}}%</td>

                            @endif


                    </tr>
                    <tr>
                        <td class="border bg-gray-50 py-2 px-4 w-8 text-sm font-semibold  text-center">PO</td>
                        <td class="text-center border text-gray-600 font-semibold text-sm">{{$calculateddata['po_req']}}</td>
                        <td class="text-center border text-gray-600 font-semibold text-sm">{{$calculateddata['po_reserve']}}</td>
                        <td class="text-center border text-gray-600 font-semibold text-sm">{{$calculateddata['po_req']+$calculateddata['po_reserve']}}</td>
                        <td class="text-center border text-gray-600 font-semibold text-sm">{{$calculateddata['po_avl']}}</td>
                        @if($po_change <0) <td class=" bg-red-700 text-center border text-red-100 font-semibold text-sm">{{number_format($po_change*100,2)}}%</td>
                            @else
                            <td class=" bg-green-700 text-center border text-green-100 font-semibold text-sm">+{{number_format($po_change*100,2)}}%</td>

                            @endif

                    </tr>
                    <tr>









                    </tr>

                    <tr>











                    </tr>






                </tbody>

            </table>
           {{-- <div class="bg-yellow-100 mt-3 border border-orange-500 rounded-md p-2">
                <h1 class="text-sm font-semibold">Summary</h1>
                <ul class="list-disc mx-4">
                    <li class="text-sm mb-1">
                        @if($pro_change <0) You have <span class="text-red-700 font-semibold bg-red-700/30 px-1 rounded-md mx-1">inadequate </span> number of PRO's available
                            @else
                            You have <span class="text-green-700 font-semibold bg-green-600/30 px-1 rounded-md mx-1">adequate </span> number of PRO's available.
                            @endif

                    </li>
                    <li class="text-sm mb-1">
                        @if($apro_change <0) You have <span class="text-red-700 font-semibold bg-red-700/30 px-1 rounded-md mx-1">inadequate </span> number of APRO's available
                            @else
                            You have <span class="text-green-700 font-semibold bg-green-600/30 px-1 rounded-md mx-1">adequate </span> number of APRO's available.
                            @endif

                    </li>
                    <li class="text-sm">
                        @if($po_change <0) You have <span class="text-red-700 font-semibold bg-red-700/30 px-1 rounded-md mx-1">inadequate </span> number of PO's available
                            @else
                            You have <span class="text-green-700 font-semibold bg-green-600/30 px-1 rounded-md mx-1">adequate </span> number of PO's available.
                            @endif

                    </li>
                </ul>
            </div> --}}

        </div>
        <div class="w-2/5 p-4">
            <div id="chartcalc"></div>
            <script>
                var pro_available = @json($calculateddata['pro_avl']);
                var pro_required = @json($calculateddata['pro_req']);
                var apro_available = @json($calculateddata['apro_avl']);
                var apro_required = @json($calculateddata['apro_req']);
                var po_available = @json($calculateddata['po_avl']);
                var po_required = @json($calculateddata['po_req']);
                var pro_reserved = @json($calculateddata['pro_reserve']);
                var apro_reserved = @json($calculateddata['apro_reserve']);
                var po_reserved = @json($calculateddata['po_reserve']);




                var options = {
                    series: [{
                        name: 'Available'
                        , data: [{
                                x: 'PRO'
                                , y: pro_available
                                , goals: [{
                                    name: 'Required'
                                    , value: (pro_required + pro_reserved)
                                    , strokeHeight: 5
                                    , strokeColor: '#00e396'
                                }]
                            }
                            , {
                                x: 'APRO'
                                , y: apro_available
                                , goals: [{
                                    name: 'Required'
                                    , value: (apro_required + apro_reserved)
                                    , strokeHeight: 5
                                    , strokeColor: '#00e396'
                                }]
                            }
                            , {
                                x: 'PO'
                                , y: po_available
                                , goals: [{
                                    name: 'Required'
                                    , value: (po_required + po_reserved)
                                    , strokeHeight: 5
                                    , strokeColor: '#00e396'
                                }]
                            },


                        ]
                    }]
                    , chart: {
                        height: 350
                        , type: 'bar'
                    }
                    , plotOptions: {
                        bar: {
                            columnWidth: '60%'
                        }
                    }
                    , colors: ['#feb019']
                    , dataLabels: {
                        enabled: false
                    }
                    , legend: {
                        show: true
                        , showForSingleSeries: true
                        , customLegendItems: ['Available', 'Required']
                        , markers: {
                            fillColors: ['#feb019', '#00e396']
                        }
                    }
                };

                var chart = new ApexCharts(document.querySelector("#chartcalc"), options);
                chart.render();

            </script>
        </div>
    </div>

    <x-confirmation-modal wire:model="newmodal">
        <x-slot name="icon">
            <svg class="h-6 w-6 stroke-white" stroke-width="1.5" fill="none" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M19 7.5v3m0 0v3m0-3h3m-3 0h-3m-2.25-4.125a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zM4 19.235v-.11a6.375 6.375 0 0112.75 0v.109A12.318 12.318 0 0110.374 21c-2.331 0-4.512-.645-6.374-1.766z" />
            </svg>
        </x-slot>
        <x-slot name="subtitle">

        </x-slot>

        <x-slot name="title">
            Change Criteria
        </x-slot>


        <x-slot name="content">

            <div>

                <x-validation-errors class="mb-4" />
                <form method="POST">
                    @csrf

                    <div class="w-full flex gap-x-5 bg-gray-100 p-3 rounded-md">


                        <div class=" w-full">
                            <x-label for="name" value="{{ __('Additional Staff (in %)') }}" />
                            <x-input wire:model="criteria.reserve" class="block w-full" type="text" :value="old('Pay Scale')" required />

                        </div>
                        @php
                            $data = [
                                ["title"=>'One female',"id"=>1],
                                ["title"=>'Two females',"id"=>2],
                                ["title"=>'Any no. of females',"id"=>0],

                    ];
                        @endphp
                         <div class=" w-full">
                            <x-label for="name" value="{{ __('No. of Females in a Female Party') }}" />
                            <x-select wire:model="criteria.nooffemales" type="text" class="block w-full" :ddlist="$data" idfield="id" textfield="title" />
                        </div> 

                    </div>

                    <div class=" mt-8 flex w-full bg-gray-100 rounded-md">

                       <div class="w-3/5 p-3">
                        <p>Do you want to Deploy Central Government Staff for Election Duty</p>
                        </div>
                        <div class="w-2/5 flex justify-end p-3">
                            <label class="flex items-center mr-2">
                                <input wire:model="criteria.centralemployee" type="radio" class="form-radio" name="central" value="1">
                                <span class="ml-2">Yes</span>
                            </label>
                        
                            <label class="flex items-center">
                                <input wire:model="criteria.centralemployee" type="radio" class="form-radio" name="central" value="0" >
                                <span class="ml-2">No</span>
                            </label>
                        </div>

                    </div>
                    <div class=" mt-4 flex w-full bg-gray-100 rounded-md">

                        <div class="w-3/5 p-3">
                         <p>Can an employee be deployed in a segment under which the Place of Posting Falls?</p>
                         </div>
                         <div class=" w-2/5 flex flex-col items-end">
                            <div class="flex flex-col w-full  items-end justify-end p-3 bg-gray-200 m-2 rounded-md">
                                <h1 class="font-semibold mb-1">Males</h1>
                            <div class="flex flex-shrink-0  justify-end">
                                 <label class="flex items-center mr-2">
                                     <input wire:model="criteria.officeconsmale" type="radio" class="form-radio" name="officeconsmale" value="1">
                                    <span class="ml-2">Yes</span>
                                </label>
                                <label class="flex items-center">
                                     <input wire:model="criteria.officeconsmale" type="radio" class="form-radio" name="officeconsmale" value="0" >
                                    <span class="ml-2">No</span>
                                 </label>
                            </div>
                        </div>
                        <div class="flex flex-col w-full  items-end justify-end p-3 bg-gray-200 m-2 mt-0 rounded-md">
                            <h1 class="font-semibold mb-1">Females</h1>
                        <div class="flex flex-shrink-0  justify-end">
                             <label class="flex items-center mr-2">
                                 <input wire:model="criteria.officeconsfemale" type="radio" class="form-radio" name="officeconsfemale" value="1">
                                <span class="ml-2">Yes</span>
                            </label>
                            <label class="flex items-center">
                                 <input wire:model="criteria.officeconsfemale" type="radio" class="form-radio" name="officeconsfemale" value="0" >
                                <span class="ml-2">No</span>
                             </label>
                        </div>
                    </div>
                        </div>
 
                     </div>
                     <div class=" mt-4 flex w-full bg-gray-100 rounded-md">

                        <div class="w-3/5 p-3">
                         <p>Can an employee be deployed in a segment under which the Place of Residence Falls?</p>
                         </div>
                         <div class=" w-2/5 flex flex-col items-end">
                            <div class="flex flex-col w-full  items-end justify-end p-3 bg-gray-200 m-2 rounded-md">
                                <h1 class="font-semibold mb-1">Males</h1>
                            <div class="flex flex-shrink-0  justify-end">
                                 <label class="flex items-center mr-2">
                                     <input wire:model="criteria.residenceconsmale" type="radio" class="form-radio" name="residenceconsmale" value="1">
                                    <span class="ml-2">Yes</span>
                                </label>
                                <label class="flex items-center">
                                     <input wire:model="criteria.residenceconsmale" type="radio" class="form-radio" name="residenceconsmale" value="0" >
                                    <span class="ml-2">No</span>
                                 </label>
                            </div>
                        </div>
                        <div class="flex flex-col w-full  items-end justify-end p-3 bg-gray-200 m-2 mt-0 rounded-md">
                            <h1 class="font-semibold mb-1">Females</h1>
                        <div class="flex flex-shrink-0  justify-end">
                             <label class="flex items-center mr-2">
                                 <input wire:model="criteria.residenceconsfemale" type="radio" class="form-radio" name="residenceconsfemale" value="1">
                                <span class="ml-2">Yes</span>
                            </label>
                            <label class="flex items-center">
                                 <input wire:model="criteria.residenceconsfemale" type="radio" class="form-radio" name="residenceconsfemale" value="0" >
                                <span class="ml-2">No</span>
                             </label>
                        </div>
                    </div>
                        </div>
 
                     </div>

                     <div class=" mt-4 flex w-full bg-gray-100 rounded-md">

                        <div class="w-3/5 p-3">
                         <p>Can an employee be deployed in a segment under which Native Place Falls?</p>
                         </div>
                         <div class=" w-2/5 flex flex-col items-end">
                            <div class="flex flex-col w-full  items-end justify-end p-3 bg-gray-200 m-2 rounded-md">
                                <h1 class="font-semibold mb-1">Males</h1>
                            <div class="flex flex-shrink-0  justify-end">
                                 <label class="flex items-center mr-2">
                                     <input wire:model="criteria.nativeconsmale" type="radio" class="form-radio" name="nativeconsmale" value="1">
                                    <span class="ml-2">Yes</span>
                                </label>
                                <label class="flex items-center">
                                     <input wire:model="criteria.nativeconsmale" type="radio" class="form-radio" name="nativeconsmale" value="0" >
                                    <span class="ml-2">No</span>
                                 </label>
                            </div>
                        </div>
                        <div class="flex flex-col w-full  items-end justify-end p-3 bg-gray-200 m-2 mt-0 rounded-md">
                            <h1 class="font-semibold mb-1">Females</h1>
                        <div class="flex flex-shrink-0  justify-end">
                             <label class="flex items-center mr-2">
                                 <input wire:model="criteria.nativeconsfemale" type="radio" class="form-radio" name="nativeconsfemale" value="1">
                                <span class="ml-2">Yes</span>
                            </label>
                            <label class="flex items-center">
                                 <input wire:model="criteria.nativeconsfemale" type="radio" class="form-radio" name="nativeconsfemale" value="0" >
                                <span class="ml-2">No</span>
                             </label>
                        </div>
                    </div>
                        </div>
 
                     </div>
                     <div class=" mt-8 flex w-full bg-gray-100 rounded-md">

                        <div class="w-3/5 p-3">
                         <p>Can female employees be considered for deployment as PRO or APRO also?</p>
                         </div>
                         <div class="w-2/5 flex justify-end p-3">
                             <label class="flex items-center mr-2">
                                 <input wire:model="criteria.femalepro" type="radio" class="form-radio" name="femalepro" value="1">
                                 <span class="ml-2">Yes</span>
                             </label>
                         
                             <label class="flex items-center">
                                 <input wire:model="criteria.femalepro" type="radio" class="form-radio" name="femalepro" value="0" >
                                 <span class="ml-2">No</span>
                             </label>
                         </div>
 
                     </div>
                     <div class=" mt-8 flex w-full bg-gray-100 rounded-md">

                        
                         <div class="flex w-full  justify-end p-3">
                             <label class="flex items-center mr-2">
                                 <input wire:model="criteria.distribution" type="radio" class="form-radio" name="distribution" value="Random">
                                 <span class="ml-2">Random Distribution</span>
                             </label>
                         
                             <label class="flex items-center">
                                 <input wire:model="criteria.distribution" type="radio" class="form-radio" name="distribution" value="Officecons" >
                                 <span class="ml-2">In the segment where office falls</span>
                             </label>
                         </div>
 
                     </div>

                   
                </form>
            </div>

        </x-slot>

        <x-slot name="footer">
            <x-secondary-button wire:click="$toggle('newmodal')" wire:loading.attr="disabled">
                Cancel
            </x-secondary-button>

            <x-primary-button class="ml-2" wire:click="addobject()" wire:loading.attr="disabled">
                Save Changes
            </x-primary-button>
        </x-slot>
    </x-confirmation-modal>


</div>
