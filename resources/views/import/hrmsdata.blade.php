<x-app-layout>
    <x-slot name="header">
        <h2 class="text-md text-gray-500 leading-tight">
            <span class="font-semibold text-gray-800 text-2xl">Import HRMS Data to DISE</span> <br />({{ __('Administration > Import Data From HRMS to DISE') }})
        </h2>
    </x-slot>


    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg sm:px-6 lg:p-8">
                @livewire('import.hrms.master-data')
            </div>
        </div>
    </div>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg sm:px-6 lg:p-8">
                @livewire('import.hrms.district-data')
               
            </div>
        </div>
    </div>
  
 {{-- 
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg sm:px-6 lg:p-8">
                @livewire('import.hrms.office-data')
            </div>
        </div>
    </div> --}}
    {{-- <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg sm:px-6 lg:p-8">
                @livewire('import.hrms.employee-data')
            </div>
        </div>
    </div> --}}
    {{-- <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg sm:px-6 lg:p-8">
                @livewire('progress-bar')
            </div>
        </div>
    </div> --}}

  
    
</x-app-layout>
