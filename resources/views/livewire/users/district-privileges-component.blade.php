<div class="bg-gray-50 p-4 rounded-md">
    <div class="flex justify-between">
        <x-sub-title class="font-semibold">District Privileges</x-sub-title>


        @if(!$editmode)
        <a href="javascript:void(0)" class="cursor-pointer" wire:click="toggle('edit')"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 stroke-stone-500">
                <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
            </svg>
        </a>
        @endif
    </div>
    <div>
        <div class="grid grid-cols-4 gap-y-4 justify-center py-8">


            @foreach($privileges as $key=>$prv)
            @if($editmode)
            <form>
                <div class="flex">
                    <div class="flex items-center h-5">
                        <input id="helper-checkbox.{{ $prv->id }}" wire:model="mappedPrivileges.{{ $prv->id }}" aria-describedby="helper-checkbox-text" type="checkbox" value="" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                    </div>
                    <div class="ml-2 text-sm">
                        <label for="helper-checkbox.{{ $prv->id }}" class="font-medium font-semibold text-gray-900 dark:text-gray-300">{{$prv->name}}</label>
                        <p id="helper-checkbox-text" class="text-xs font-normal text-gray-500 dark:text-gray-300">{{$prv->description}}</p>
                    </div>
                </div>
            </form>

            @elseif((array_key_exists($prv->id, $mappedPrivileges))&& $mappedPrivileges[$prv->id])
            <div class="flex">
                <div class="flex items-center h-5">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 stroke-lime-600">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div class="ml-2 text-sm">
                    <label for="helper-checkbox" class="font-medium font-semibold text-gray-900 dark:text-gray-300">{{$prv->name}}</label>
                    <p id="helper-checkbox-text" class="text-xs font-normal text-gray-500 dark:text-gray-300">{{$prv->description}}</p>
                </div>

            </div>
            @endif
            @endforeach






        </div>
      
        <div class="flex justify-end mt-4">

            <div class="flex justify-end">
                <x-action-message class="mr-3 mt-3 text-gray-400 flex" on="saved">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="w-5 h-5 fill-lime-500 mr-1">
                        <path fill-rule="evenodd" d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12zm13.36-1.814a.75.75 0 10-1.22-.872l-3.236 4.53L9.53 12.22a.75.75 0 00-1.06 1.06l2.25 2.25a.75.75 0 001.14-.094l3.75-5.25z" clip-rule="evenodd" />
                    </svg>

                    {{ __('Admin privileges updated successfully...') }}
                </x-action-message>
            </div>


            @if($editmode)

            <x-secondary-button class="mr-1" wire:click="savePrivileges()">Save</x-secondary-button>
            <x-secondary-button wire:click="cancelEdit()">Cancel</x-secondary-button>
            @endif



        </div>



    </div>

</div>

