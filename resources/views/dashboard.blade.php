<x-app-layout>
    
    <x-slot name="header">
        <div class="w-full flex justify-between">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            @if( Auth::user() && Auth::user()->role_id ==2)
            {{ __(' State Dashboard') }}
            @elseif( Auth::user() && Auth::user()->role_id ==3)
            {{ __(' District Dashboard') }}
            @elseif(Auth::user() && Auth::user()->role_id ==4)
            {{ __(' Office Dashboard') }}

            @endif
        </h2>
        <h2 class="text-gray-500 font-semibold">District- {{ $distname }}</h2>
    </div>
    </x-slot>


    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                @if( Auth::user() && Auth::user()->role_id ==2)
                @livewire('dashboard.state.index')
                @elseif( Auth::user() && Auth::user()->role_id ==3)
                @livewire('dashboard.district.index')
                @elseif(Auth::user() && Auth::user()->role_id ==4)
                @livewire('dashboard.office.index')
                @endif

            </div>
            
        </div>
    </div>
</x-app-layout>
