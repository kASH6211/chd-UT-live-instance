<x-form-section submit="updatePassword">
    <x-slot name="title">
        {{ __('Update Password') }}
    </x-slot>

    <x-slot name="description">
        {{ __('Ensure your account is using a long, random password to stay secure.') }}
    </x-slot>
   

    <x-slot name="form">
        <div class="w-full p-4 bg-amber-100 rounded-md  my-3">
            <h3 class="font-semibold text-red-800 text-md">Password Policy</h3>
            <ul class="list-disc ml-6 text-gray-600 text-sm">
                <li>The password must be between 8 and 15 characters in length. </li>
                <li>The password must begin with a letter (a-z or A-Z). </li>
                <li>The password must include at least one special character from the following set: @, #, ., -, $.</li>
            </ul>
        </div>
        <div class= "grid grid-cols-6 gap-6">
        <div class="col-span-6 sm:col-span-4">
            <x-label for="current_password" value="{{ __('Current Password') }}" />
            <x-input id="current_password" type="password" class="mt-1 block w-full" wire:model.defer="state.current_password"  />
            <x-input-error for="current_password" class="mt-2" />
        </div>

        <div class="col-span-6 sm:col-span-4">
            <x-label for="password" value="{{ __('New Password') }}" />
            <x-input id="password" type="password" class="mt-1 block w-full" wire:model.defer="state.password"  />
            <x-input-error for="password" class="mt-2" />
        </div>

        <div class="col-span-6 sm:col-span-4">
            <x-label for="password_confirmation" value="{{ __('Confirm Password') }}" />
            <x-input id="password_confirmation" type="password" class="mt-1 block w-full" wire:model.defer="state.password_confirmation"  />
            <x-input-error for="password_confirmation" class="mt-2" />
        </div>
    </div>

    </x-slot>

    <x-slot name="actions">
        <x-action-message class="mr-3 mt-3 text-gray-400 flex" on="saved">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="w-5 h-5 fill-lime-500 mr-1">
                <path fill-rule="evenodd" d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12zm13.36-1.814a.75.75 0 10-1.22-.872l-3.236 4.53L9.53 12.22a.75.75 0 00-1.06 1.06l2.25 2.25a.75.75 0 001.14-.094l3.75-5.25z" clip-rule="evenodd" />
            </svg>
            {{ __('Your password has beed updated successfully.') }}
        </x-action-message>

        <x-button>
            {{ __('Save') }}
        </x-button>
    </x-slot>
</x-form-section>
