<x-app-layout>
    <x-slot name="header">
        <h2 class="text-md text-gray-500 leading-tight">
            @if($key == "all")
            <span class="font-semibold text-gray-800 text-2xl">All District Offices </span> <br />({{ __('Dashboard > Office Summary > Total Offices') }})
            @elseif($key =="submitted")
            <span class="font-semibold text-gray-800 text-2xl">Submitted Offices </span> <br />({{ __('Dashboard > Office Summary > Submitted') }})
            @elseif($key =="finalized")
            <span class="font-semibold text-gray-800 text-2xl">Finalized Offices </span> <br />({{ __('Dashboard > Office Summary > Finalized') }})
            @elseif($key =="inprogress")
            <span class="font-semibold text-gray-800 text-2xl">Office Data Entry In Progress </span> <br />({{ __('Dashboard > Office Summary > In Progress') }})
            @elseif($key =="pending")
            <span class="font-semibold text-gray-800 text-2xl">Office Data Entry Not Started </span> <br />({{ __('Dashboard > Office Summary > Pending') }})
            @elseif($key =="imported")
            <span class="font-semibold text-gray-800 text-2xl">Imported to Local Database</span> <br />({{ __('Dashboard > Office Summary > Imported') }})
            @endif
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg sm:px-6 lg:px-8 py-16">
                @if($key == "all")
                    @livewire('office.all-offices')
                @elseif($key =="submitted")
                    @livewire('office.submitted')
                @elseif($key =="finalized")
                    @livewire('office.finalized')
                @elseif($key =="inprogress")
                    @livewire('office.in-progress')
                @elseif($key =="pending")
                    @livewire('office.pending')
                @elseif($key =="imported")
                    @livewire('office.imported')
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
