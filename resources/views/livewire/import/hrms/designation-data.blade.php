<div>
    <x-loading-indicator />
    <div class="alert alert-success">
        
    </div>

<x-validation-errors/>

<div class=" p-2"  >
<div class="mt-4 w-full">
    <x-label for="name" value="{{ __('Upload Designation File (.xls or .xlsx)') }}" />
</div>
<div class="relative my-4">
    <!-- This is the visible part of the file input -->
    
    <x-input type="file" class="w-full h-full" wire:model="file" accept=".xls, .xlsx"   required/>

    <!-- This is the hidden button -->
    
</div>
<div class="w-full flex justify-end mt-2">
    <div><x-dark-button wire:click="import()" >Import Excel</x-danger-button></div>
</div>

@if(session('success'))   

<div class="w-full flex justify-between  mt-2">
<div>
  
    <h1 class="text-lime-700 bg-lime-100 px-4 py-2 rounded-md">
        {{ session('success') }}
    </h1>
   

</div>



</div>

</div>
<div class="w-full mt-4 border border-dashed rounded-md border-gray-300 p-4">
 
   <h1><span class="text-gray-700 font-semibold">Summary:</span>{{ $count }} Designations are successfully Imported in {{ $exectime }}</h1>

</div>
@endif

</div>
