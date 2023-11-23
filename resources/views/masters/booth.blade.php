<x-app-layout>
    <x-slot name="header">
        <h2 class="text-md text-gray-500 leading-tight">
            <span class="font-semibold text-gray-800 text-2xl">Booth  Master </span> <br />({{ __('Masters > Booth  ') }})
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 ">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg sm:px-6 lg:px-8 py-8">
                @livewire('masters.booth-component')
            </div>
        </div>
    </div>
</x-app-layout>
