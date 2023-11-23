<div>
   <x-loading-indicator/>
    <div class="flex border bg-blue-900/5 border-dashed border-blue-900/30 p-4 rounded-md justify-center items-center mb-4">
        <h1 class="text-3xl text-blue-900">Total Locations- {{$total}}</h1>
    </div>
    <div class="flex justify-between p-4 rounded-md mb-4  bg-gray-200">

        <div class=" w-1/3 rounded-sm px-4">

            <x-input type="text" wire:model.debounce.500ms="search" placeholder="Search..." class="w-full border-0 h-12 rounded-lg">

            </x-input>

        </div>
        <div class=" w-1/3 rounded-sm px-4">

            <x-select wire:model="filtercons" type="text" class="block w-full" :ddlist="$consdistlist" idfield="ac_no" textfield="ac_name" />


        </div>
        <div>
            <x-primary-button wire:click="toggle('newmodal')">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 mr-2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>


                New Location</x-primary-button>

        </div>
    </div>

    <table class="w-full border-collapse border">

        <thead class="bg-gray-200 w-full">
            <td class=" text-left border font-semibold text-gray-700 p-2 w-16">Sr No.</td>

            @foreach($header as $head)
            <td class=" text-left border font-semibold text-gray-700 p-2">{{$head}}</td>
            
            @endforeach
        </thead>
        <tbody>
            @foreach($data->items() as $index=>$row)
            <tr>
                <td class="p-2 border text-sm uppercase text-gray-600 py-2">{{$index + $data->firstItem()}}</td>

                {{-- <td class="p-2 border text-sm uppercase text-gray-600">
                    @if($row->distcode && $row->distcode<10) 0{{$row->distcode}} @else {{$row->distcode}} @endif</td>
                <td class="p-2 border text-sm uppercase text-gray-600">{{$row->DesigCode}}</td> --}}
                <td class="p-2 border text-sm uppercase text-gray-600">{{$row->consname->ac_name}} ({{ $row->CONSCODE }})</td>
                <td class="p-2 border text-sm uppercase text-gray-600">{{$row->PS_LOCN_NO}}</td>
                <td class="p-2 border text-sm uppercase text-gray-600">{{$row->LOCN_BLDG_EN}}</td>
                <td class="p-2 border text-sm uppercase text-gray-600">{{($row->URBAN== false)?"Rural":"Urban"}}</td>




                <td class="px-2 border text-gray-600 w-8 ">
                    <div class="flex justify-center items-center"><a href="javascript:void(0)" wire:click='editobject({{ $row->id }})' class=" hover:bg-blue-100 p-2 rounded-md">

                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" class="w-4 h-4 stroke-blue-500">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                            </svg>




                        </a></div>


                </td>
             
                <td class="px-2 border text-gray-600 w-8">
                    <div class="flex justify-center items-center"><a href="javascript:void(0);" wire:click='openForDeletion({{ $row->id }})' class=" hover:bg-red-100 p-2 rounded-md">

                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" class="w-4 h-4 stroke-red-500">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                            </svg>


                        </a></div>


                </td>
               

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
            Add New Location
        </x-slot>


        <x-slot name="content">

            <div>

                <x-validation-errors class="mb-4" />
                <form method="POST">
                    @csrf
                    <div class="w-full flex gap-x-5">
                        
                        <div class="mt-4 w-full">
                            <x-label for="constituency" value="{{ __('Select Constituency') }}" />
                            <x-select wire:model="object.CONSCODE" type="text" class="block w-full" :ddlist="$consdistlist" idfield="ac_no" textfield="ac_name" />
                        </div>
                         <div class="mt-4 w-full">

                            <x-label for="empcode" value="{{ __('Location Name') }}" />
                            
                            <x-input wire:model="object.LOCN_BLDG_EN" class="block w-full" type="text" :value="old('LOCN_BLDG_EN')" required />
                        </div> 


                    </div>
                    <div class="w-full flex gap-x-5">

                        <div class="mt-4  w-full">
                            <x-label for="name" value="{{ __('Category') }}" />
                            <div class=" mt-2 flex  w-full rounded-md border bg-gray-100 border-gray-300 border-dashed p-4">
                                <div class="w-1/2">
                                    <input wire:model="object.URBAN" id="default-radio-1" checked type="radio" value="0" name="default-radio" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                    <label for="default-radio-1" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">Rural</label>
                                </div>
                                <div class="w-1/2">
                                    <input wire:model="object.URBAN" id="default-radio-1" type="radio" value="1" name="default-radio" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                    <label for="default-radio-1" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">Urban</label>
                                </div>
                            </div>
                        </div>
                        

                    </div>

                    <div class="flex gap-x-5 w-full">




                    </div>


                </form>
            </div>

        </x-slot>

        <x-slot name="footer">
            <x-secondary-button wire:click="$toggle('newmodal')" wire:loading.attr="disabled">
                Cancel
            </x-secondary-button>

            <x-primary-button class="ml-2" wire:click="addobject()" wire:loading.attr="disabled">
                Add New Location
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
            Update Location Details
        </x-slot>


        <x-slot name="content">

            <div>

                <x-validation-errors class="mb-4" />
                <form method="POST">
                    @csrf
                    <div class="w-full flex gap-x-5">
                        
                       
                         <div class="mt-4 w-full">

                            <x-label for="empcode" value="{{ __('Location Name') }}" />
                            
                            <x-input wire:model="editobject.LOCN_BLDG_EN" class="block w-full" type="text" :value="old('LOCN_BLDG_EN')" required />
                        </div> 


                    </div>
                    <div class="w-full flex gap-x-5">

                        <div class="mt-4  w-full">
                            <x-label for="name" value="{{ __('Category') }}" />
                            <div class=" mt-2 flex  w-full rounded-md border bg-gray-100 border-gray-300 border-dashed p-4">
                               @if($editobject)
                                <div class="w-1/2">
                                    <input wire:model="editobject.URBAN" id="default-radio-2"  type="radio" value="0" name="default-radio-2" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600" >
                                    <label for="default-radio-2" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">Rural</label>
                                </div>
                                <div class="w-1/2">
                                    <input wire:model="editobject.URBAN" id="default-radio-2" type="radio" value="1" name="default-radio-2" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600" >
                                    <label for="default-radio-2" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">Urban</label>
                                </div>
                                @endif
                            </div>
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
                Update Location
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
            Delete Location?
        </x-slot>


        <x-slot name="content">

            <div class="w-full flex flex-col justify-center">
                <h1 class="text-2xl text-red-800 ">Are you sure you want to permanently delete this location?</h1>

                 @if($editobject && isset($editobject["DISTNAME"]))
                <h3 class="text-lg text-gray-700 bg-red-50 my-2 p-2 rounded-md"><span class="font-semibold">District : </span>{{$editobject['DISTNAME']}}</h3>
                <h3 class="text-lg text-gray-700 bg-red-50 my-2 p-2 rounded-md"><span class="font-semibold">Constituency : </span>{{$editobject['CONSNAME']}}</h3>
                <h3 class="text-lg text-gray-700 bg-red-50 my-2 p-2 rounded-md"><span class="font-semibold">Location No. : </span>{{$editobject['PS_LOCN_NO']}}</h3>
                <h3 class="text-lg text-gray-700 bg-red-50 mb-2 p-2 rounded-md"><span class="font-semibold">Location Name: </span>{{$editobject['LOCN_BLDG_EN']}}</h3>
                <h3 class="text-lg text-gray-700 bg-red-50 mb-2 p-2 rounded-md"><span class="font-semibold">Urban/Rural: </span>{{$editobject['URBAN']==true?'URBAN':'RURAL'}}</h3>
                @endif
            </div>

        </x-slot>

        <x-slot name="footer">
            <x-secondary-button wire:click="$toggle('confirmupdatemodal')" wire:loading.attr="disabled">
                Cancel
            </x-secondary-button>
            @if($editobject )

            <x-primary-button class="ml-2" wire:click="deleteRecord({{$editobject['id']}})" wire:loading.attr="disabled">
                Delete Location
            </x-primary-button>
            @endif
        </x-slot>
    </x-confirmation-modal>
</div>
