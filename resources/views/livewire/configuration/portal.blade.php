<div>
    <x-loading-indicator />
    <x-validation-errors />
    {{-- @livewire('emailcomponent') --}}
    <div class="bg-gray-200 p-4 rounded-md flex flex-col w-full my-4">
        <h1 class="font-semibold">List of Districts (In .xls or xlsx format)</h1>
        <p class="text-gray-600">Excel will should contain name of districts and code of district (as per ECI)</p>

        <div class=" p-4 bg-white m-2">
            <div class="mt-4 w-full">
                <x-label for="name" value="{{ __('Upload Election Districts File (.xls or .xlsx)') }}" />
            </div>
            <div class="relative my-4">
                <!-- This is the visible part of the file input -->

                <x-input type="file" class="w-full h-full" wire:model="file" accept=".xls, .xlsx" required />

                <!-- This is the hidden button -->

            </div>
            <div class="w-full flex justify-end mt-2">
                <div>
                    <x-dark-button wire:click="import()">Import Excel</x-danger-button>
                </div>
            </div>
        </div>
        <div class="flex justify-end">
            <x-action-message class="mr-3 mt-3 text-gray-400 flex" on="savedDistricts">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="w-5 h-5 fill-lime-500 mr-1">
                    <path fill-rule="evenodd" d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12zm13.36-1.814a.75.75 0 10-1.22-.872l-3.236 4.53L9.53 12.22a.75.75 0 00-1.06 1.06l2.25 2.25a.75.75 0 001.14-.094l3.75-5.25z" clip-rule="evenodd" />
                </svg>

                {{ __('Districts Imported Successfully...') }}
            </x-action-message>
        </div>

    </div>
    <div class="bg-gray-200 p-4 rounded-md flex flex-col w-full my-4">
        <h1 class="font-semibold">Change login page text</h1>

        <div class=" w-full  mt-4">
            <x-input wire:model.defer="loginpagetext" class=" w-full" type="text" required />

        </div>
        <div class="flex justify-end mt-2">
            <x-dark-button wire:click="updateLoginText()">Update</x-dark-button>
        </div>
        <div class="flex justify-end">
            <x-action-message class="mr-3 mt-3 text-gray-400 flex" on="saved">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="w-5 h-5 fill-lime-500 mr-1">
                    <path fill-rule="evenodd" d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12zm13.36-1.814a.75.75 0 10-1.22-.872l-3.236 4.53L9.53 12.22a.75.75 0 00-1.06 1.06l2.25 2.25a.75.75 0 001.14-.094l3.75-5.25z" clip-rule="evenodd" />
                </svg>

                {{ __('Login page text updated successfully...') }}
            </x-action-message>
        </div>

    </div>
    <div class="bg-gray-200 p-4 rounded-md flex flex-col w-full my-4">
        <h1 class="font-semibold">Change Footer text </h1>

        <div class=" w-full  mt-4">
            <x-input wire:model.defer="footertext" class=" w-full" type="text" required />

        </div>
        <div class="flex justify-end mt-2">
            <x-dark-button wire:click="updateFooterText()">Update</x-dark-button>
        </div>
        <div class="flex justify-end">
            <x-action-message class="mr-3 mt-3 text-gray-400 flex" on="savedfooter">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="w-5 h-5 fill-lime-500 mr-1">
                    <path fill-rule="evenodd" d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12zm13.36-1.814a.75.75 0 10-1.22-.872l-3.236 4.53L9.53 12.22a.75.75 0 00-1.06 1.06l2.25 2.25a.75.75 0 001.14-.094l3.75-5.25z" clip-rule="evenodd" />
                </svg>

                {{ __('Footer text updated successfully...') }}
            </x-action-message>
        </div>

    </div>
     <div class="bg-gray-200 p-4 rounded-md flex flex-col w-full my-4">
        <h1 class="font-semibold">Email Configurations</h1>
            <div class="grid grid-cols-3 gap-x-6">
            <div class=" w-full  mt-4">
                 <x-label for="name" value="{{ __('Username') }}" />
                <x-input wire:model.defer="email_username" placeholder="Email Username" class=" w-full" type="text"  required />
            </div>
            <div class=" w-full  mt-4">
             <x-label for="name" value="{{ __('Password') }}" />
                <x-input wire:model.defer="email_password" placeholder="Email password" class=" w-full" type="password"  required />
            </div>
            <div class=" w-full  mt-4">
            <x-label for="name" value="{{ __('Subject') }}" />
                <x-input wire:model.defer="email_subject" placeholder="Email Subject" class=" w-full" type="text"  required />
            </div>
            <div class=" w-full  mt-4">
            <x-label for="name" value="{{ __('Header Image Link') }}" />
                <x-input wire:model.defer="email_headerimage_link" placeholder="Header Image Link" class=" w-full" type="text"  required />
            </div>
            <div class=" w-full  mt-4">
            <x-label for="name" value="{{ __('Port') }}" />
                <x-input wire:model.defer="email_port" placeholder="Email Port" class=" w-full" type="text"  required />
            </div>
            <div class=" w-full  mt-4">
            <x-label for="name" value="{{ __('Encryption') }}" />
                <x-input wire:model.defer="email_encryption" placeholder="Email Encryption" class=" w-full" type="text"  required />
            </div>
            <div class=" w-full  mt-4">
            <x-label for="name" value="{{ __('Transport') }}" />
                <x-input wire:model.defer="email_transport" placeholder="Email Transport" class=" w-full" type="text"  required />
            </div>
            <div class=" w-full  mt-4">
            <x-label for="name" value="{{ __('Host') }}" />
                <x-input wire:model.defer="email_host" placeholder="Email Host" class=" w-full" type="text"  required />
            </div>
            </div>
            <div class="flex justify-end mt-2"><x-dark-button wire:click="updateEmailConf()">Update</x-dark-button></div>
            <div class="flex justify-end">
                <x-action-message class="mr-3 mt-3 text-gray-400 flex" on="savedemail">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="w-5 h-5 fill-lime-500 mr-1">
                        <path fill-rule="evenodd" d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12zm13.36-1.814a.75.75 0 10-1.22-.872l-3.236 4.53L9.53 12.22a.75.75 0 00-1.06 1.06l2.25 2.25a.75.75 0 001.14-.094l3.75-5.25z" clip-rule="evenodd" />
                    </svg>

                    {{ __('Email Configurations updated successfully...') }}
                </x-action-message>
            </div>
        
   </div>
</div>
