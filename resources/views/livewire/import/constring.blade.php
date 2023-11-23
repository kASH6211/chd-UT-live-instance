<div>
    
     <div class="flex justify-between p-4 rounded-md mb-4  bg-gray-200">

        <div class=" w-1/2 rounded-sm px-4">

            <x-input type="text" wire:model.debounce.500ms="search" placeholder="Search..." class="w-full border-0 h-12 rounded-lg">

            </x-input>

        </div>
        <div>
           
            @if(!count($data))
             <x-primary-button wire:click="toggle('newmodal')">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 mr-2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
                New Connection</x-primary-button>
            @endif

        </div>
    </div>

    <table class="table-auto w-full border-collapse border">

        <thead class="bg-gray-200 w-full">
            <th class="border text-gray-700 py-2 px-4 w-8">Sr No.</th>

            @foreach($header as $head)
            <th class="border text-gray-700 py-2 px-4">{{$head}}</th>
            @endforeach
        </thead>
        <tbody>
            @foreach($data as $index=>$row)
            <tr>
                <td class="text-center border text-gray-600 py-2">{{$index + $data->firstItem()}}</td>

                 <td class="text-center border text-gray-600">{{$row->district->DistName}}</td>
               <td class="text-center border text-gray-600">{{$row->host}}</td>
                 <td class="text-center border text-gray-600">{{$row->database}}</td>
                <td class="text-center border text-gray-600">{{$row->username}}</td>
                <td class="text-center border text-gray-600">
                {{str_repeat('*', strlen($row->password))}}
                </td>




                <td class="text-center border text-gray-600 w-8 ">
                    <div class="flex justify-center items-center"><a href="javascript:void(0)" wire:click='editobject("{{$row->id}}")' class="m-2 hover:bg-blue-100 p-2 rounded-md">

                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" class="w-5 h-5 stroke-blue-500">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
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

    <x-confirmation-modal wire:model="editmodal">
        <x-slot name="icon">
            <svg class="h-6 w-6 stroke-white" stroke-width="1.5" fill="none" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M19 7.5v3m0 0v3m0-3h3m-3 0h-3m-2.25-4.125a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zM4 19.235v-.11a6.375 6.375 0 0112.75 0v.109A12.318 12.318 0 0110.374 21c-2.331 0-4.512-.645-6.374-1.766z" />
            </svg>
        </x-slot>


        <x-slot name="title">
            Connection Setup for Importing Data
        </x-slot>


        
        <x-slot name="content">

             <div>

                <x-validation-errors class="mb-4" />
                <form method="POST">
                    @csrf

                    <div class="w-full flex gap-x-5">


                        <div class="mt-4 w-full">
                            <x-label for="name" value="{{ __('Host IP Address') }}" />
                            <x-input wire:model="editobject.host" class="block w-full" type="text" :value="old('host')" required />

                        </div>
                    </div>
                    <div class="w-full flex gap-x-5">


                        <div class="mt-4 w-full">
                            <x-label for="name" value="{{ __('Database Name') }}" />
                            <x-input wire:model="editobject.database" class="block w-full" type="text" :value="old('database')" required />

                        </div>
                    </div>
                    <div class="w-full flex gap-x-5">


                        <div class="mt-4 w-full">
                            <x-label for="name" value="{{ __('User Name') }}" />
                            <x-input wire:model="editobject.username" class="block w-full" type="text" :value="old('database')" required />

                        </div>
                    </div>
                    <div class="w-full flex gap-x-5">


                        <div class="mt-4 w-full">
                            <x-label for="name" value="{{ __('Password') }}" />
                            <x-input wire:model="editobject.password" class="block w-full" type="password" :value="old('password')" required />

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
                Update Details
            </x-primary-button>
        </x-slot>
    </x-confirmation-modal>
     <x-confirmation-modal wire:model="newmodal">
        <x-slot name="icon">
            <svg class="h-6 w-6 stroke-white" stroke-width="1.5" fill="none" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M19 7.5v3m0 0v3m0-3h3m-3 0h-3m-2.25-4.125a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zM4 19.235v-.11a6.375 6.375 0 0112.75 0v.109A12.318 12.318 0 0110.374 21c-2.331 0-4.512-.645-6.374-1.766z" />
            </svg>
        </x-slot>


        <x-slot name="title">
            Add new Connection Setup for Importing Data
        </x-slot>


        
        <x-slot name="content">

             <div>

                <x-validation-errors class="mb-4" />
                <form method="POST">
                    @csrf

                    <div class="w-full flex gap-x-5">


                        <div class="mt-4 w-full">
                            <x-label for="name" value="{{ __('Host IP Address') }}" />
                            <x-input wire:model="addobject.host" class="block w-full" type="text" :value="old('host')" required />

                        </div>
                    </div>
                    <div class="w-full flex gap-x-5">


                        <div class="mt-4 w-full">
                            <x-label for="name" value="{{ __('Database Name') }}" />
                            <x-input wire:model="addobject.database" class="block w-full" type="text" :value="old('database')" required />

                        </div>
                    </div>
                    <div class="w-full flex gap-x-5">


                        <div class="mt-4 w-full">
                            <x-label for="name" value="{{ __('User Name') }}" />
                            <x-input wire:model="addobject.username" class="block w-full" type="text" :value="old('username')" required />

                        </div>
                    </div>
                    <div class="w-full flex gap-x-5">


                        <div class="mt-4 w-full">
                            <x-label for="name" value="{{ __('Password') }}" />
                            <x-input wire:model="addobject.password" class="block w-full" type="password" :value="old('password')" required />

                        </div>
                    </div>
                    
                </form>

            </div> 

        </x-slot>

        <x-slot name="footer">
            <x-secondary-button wire:click="$toggle('newmodal')" wire:loading.attr="disabled">
                Cancel
            </x-secondary-button>

            <x-primary-button class="ml-2" wire:click="add()" wire:loading.attr="disabled">
                Add Details
            </x-primary-button>
        </x-slot>
    </x-confirmation-modal>
</div>
