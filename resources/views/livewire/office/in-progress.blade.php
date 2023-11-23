<div>
    <div class="flex flex-col border bg-blue-900/5 border-dashed border-blue-900/30 p-4 rounded-md justify-center items-center ">

        <h1 class="text-3xl text-blue-900">Total Offices - {{$total}}</h1>
        <span class="text-lg text-gray-500">Total offices where data entry is in progress</span>
    </div>
    <div class="flex justify-between rounded-md">
        <div class=" w-2/3 rounded-sm flex items-end my-2"><h1 class="text-md font-semibold">
            Offices that have started data entry of employee</h1></div>
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
                <td class="text-left text-sm p-2 border text-gray-600 ">{{$index + $data->firstItem()}}</td>
                <td class="text-left text-sm p-2 border text-gray-600">{{$row->office}}</td>

                <td class="text-left text-sm p-2 border text-gray-600">{{$this->getDeptName($row->deptcode)}}</td>
                <td class="text-left text-sm p-2 border text-gray-600">{{$this->getSubDeptName($row->deptcode,$row->subdeptcode)}}</td>
                <td class="text-left text-sm p-2 border text-gray-600">{{$row->address}}</td>
                {{-- <td class="text-left text-sm p-2 border text-gray-600">{{$row->selectedclass->description}}</td> --}}

            </tr>

            @endforeach




        </tbody>

    </table>
    <div class="py-2">
        {{ $data->links() }}
    </div>
</div>
