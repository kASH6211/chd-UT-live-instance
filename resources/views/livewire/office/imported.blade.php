<div>
    <div class="flex flex-col border bg-blue-900/5 border-dashed border-blue-900/30 p-4 rounded-md justify-center items-center ">

        <h1 class="text-3xl text-blue-900">Total Offices - {{$total}}</h1>
        <span class="text-lg text-gray-500">Total offices whose data has been imported to local database</span>
    </div>
    <div class="flex justify-between rounded-md">
        <div class=" w-2/3 rounded-sm flex items-end my-2"><h1 class="text-md font-semibold">
            Offices whose data has been imported to local database</h1></div>
        <div class=" w-1/3  p-4 bg-gray-200 rounded-md my-2" >

            <x-input type="text" wire:model.debounce.500ms="search" placeholder="Search..." class="w-full border-0 h-12 rounded-lg">

            </x-input>

        </div>
       
    </div>

    <table class="table-auto w-full border-collapse border">

        <thead class="bg-gray-200 w-full">
            <td class="border text-left font-semibold text-gray-700 p-2 w-8">Sr No.</td>

            @foreach($header as $head)
            <td class="border text-left font-semibold text-gray-700 p-2 w-16">{{$head}}</td>
            @endforeach
        </thead>
        <tbody>
            @foreach($data as $index=>$row)
            <tr>
                <td class="text-left text-sm p-2 border text-gray-600">{{$index + $data->firstItem()}}</td>
                <td class="text-left text-sm p-2 border text-gray-600">{{$row->office}}</td>

                <td class="text-left text-sm p-2 border text-gray-600">{{$this->getDeptName($row->deptcode)}}</td>
                <td class="text-left text-sm p-2 border text-gray-600">{{$this->getSubDeptName($row->deptcode,$row->subdeptcode)}}</td>
                <td class="text-left text-sm p-2 border text-gray-600">{{$row->address}}</td>
                {{-- <td class="text-left text-sm p-2 border text-gray-600">{{$row->selectedclass->description}}</td> --}}

            </tr>

            @endforeach




        </tbody>

    </table>
    @if($total ==0)
    <div class="w-full flex justify-center items-center h-24 bg-gray-100 mt-2">
        <h2 class="text-gray-500 text-md ">No records found...</h2>
    </div>
    @endif
    <div class="py-2">
        {{ $data->links() }}
    </div>
</div>
