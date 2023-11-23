<div>
    <div class="flex border bg-blue-900/5 border-dashed border-blue-900/30 p-4 rounded-md justify-center items-center ">

        <h1 class="text-3xl text-blue-900">Total Offices- {{$total}}</h1>
    </div>
    <div class="flex justify-between rounded-md">
        <div class=" w-2/3 rounded-sm flex items-end my-2"><h1 class="text-md font-semibold">All the offices registered under this district</h1></div>
        <div class=" w-1/3  p-4 bg-gray-200 rounded-md my-2" >

            <x-input type="text" wire:model.debounce.500ms="search" placeholder="Search..." class="w-full border-0 h-12 rounded-lg">

            </x-input>

        </div>
       
    </div>

    <table class="table-auto w-full border-collapse border">

        <thead class="bg-gray-200 w-full">
            <td class="text-left border text-gray-700 font-semibold p-2 w-8">Sr No.</td>

            @foreach($header as $head)
            <td class="text-left border text-gray-700 font-semibold p-2 w-16">{{$head}}</td>
            @endforeach
        </thead>
        <tbody>
            @foreach($data as $index=>$row)
            <tr>
                <td class="text-left border text-gray-600 text-sm p-2 ">{{$index + $data->firstItem()}}</td>
                <td class="text-left border text-gray-600 text-sm p-2">{{$row->office}}</td>

                <td class="text-left border text-gray-600 text-sm p-2">{{$this->getDeptName($row->deptcode)}}</td>
                <td class="text-left border text-gray-600 text-sm p-2">{{$this->getSubDeptName($row->deptcode,$row->subdeptcode)}}</td>
                <td class="text-left border text-gray-600 text-sm p-2">{{$row->address}}</td>
                {{-- <td class="text-left border text-gray-600 text-sm p-2">{{$row->selectedclass->description}}</td> --}}

            </tr>

            @endforeach




        </tbody>

    </table>
    <div class="py-2">
        {{ $data->links() }}
    </div>
</div>
