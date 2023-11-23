<div>
<x-loading-indicator/>
<x-primary-button class="mb-2" wire:click="pending_download()" >
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 mr-2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m.75 12l3 3m0 0l3-3m-3 3v-6m-1.5-9H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
        </svg>
        Export to PDF</x-primary-button>
    <div class="flex flex-col border bg-blue-900/5 border-dashed border-blue-900/30 p-4 rounded-md justify-center items-center ">
 
        <h1 class="text-3xl text-blue-900">Total Offices - {{$total}}</h1>
        <span class="text-lg text-gray-500">Total offices that have not started data entry</span>
    </div>
    <div class="flex justify-between rounded-md">
        <div class=" w-2/3 rounded-sm flex items-end my-2"><h1 class="text-md font-semibold">
            Offices that have not started data entry</h1></div>
        <div class=" w-1/3  p-4 bg-gray-200 rounded-md my-2" >

            <x-input type="text"  wire:model.debounce.500ms="search" placeholder="Search Office" class="w-full border-0 h-12 rounded-lg">

            </x-input>

        </div>
       
    </div>

    <table  class="table-auto w-full border-collapse border">

        <thead class="bg-gray-200 w-full">
            <td class="border text-left font-semibold text-gray-700 p-2 w-8">Sr No.</td>

            @foreach($header as $head)
            <td class="border text-left font-semibold text-gray-700 p-2 w-16">{{$head}}</td>
            @endforeach
        </thead>
        <tbody>
            @foreach($data as $index=>$row)
            <tr>
                <td class="text-left  text-sm p-2 border text-gray-600 ">{{$index + $data->firstItem()}}</td>

                <td class="text-left  text-sm p-2 border text-gray-600">{{$this->getDeptName($row->deptcode)}}</td>
                <td class="text-left  text-sm p-2 border text-gray-600">{{$this->getSubDeptName($row->deptcode,$row->subdeptcode)}}</td>
                <td class="text-left  text-sm p-2 border text-gray-600">{{$row->office}}</td>
                <td class="text-left  text-sm p-2 border text-gray-600">{{$row->address}}</td>
                {{-- <td class="text-left  text-sm p-2 border text-gray-600">{{$row->selectedclass->description}}</td> --}}

            </tr>

            @endforeach




        </tbody>

    </table>
    <div class="py-2">
        {{ $data->links() }}
    </div>
 
</div>
