<x-app-layout>
    <x-slot name="header">
        <h2 class="text-md text-gray-500 leading-tight">
            <span class="font-semibold text-gray-800 text-2xl">Users Privileges </span> <br />({{ __('Users Management > User Privileges') }})
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg sm:px-6 lg:px-8 py-16">
                @livewire('users.privileges-component')
                @livewire('users.district-privileges-component')
                @livewire('users.office-privileges-component')
            </div>
        </div>
    </div>
</x-app-layout>
