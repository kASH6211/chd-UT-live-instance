<div>
<x-loading-indicator />


    <div class="flex border bg-blue-900/5 border-dashed border-blue-900/30 p-4 rounded-md justify-center items-center mb-4">

        <h1 class="text-3xl text-blue-900">Total Payscales-
            {{count($data)}}
        </h1>
    </div>
    <div class="flex justify-between p-4 rounded-md mb-4  bg-gray-200">

        <div class=" w-1/2 rounded-sm px-4">

            <x-input type="text" wire:model.debounce.500ms="search" placeholder="Search..." class="w-full border-0 h-12 rounded-lg">

            </x-input>

        </div>
        <div>
            <x-primary-button wire:click="pay_download()">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 mr-2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.72 13.829c-.24.03-.48.062-.72.096m.72-.096a42.415 42.415 0 0110.56 0m-10.56 0L6.34 18m10.94-4.171c.24.03.48.062.72.096m-.72-.096L17.66 18m0 0l.229 2.523a1.125 1.125 0 01-1.12 1.227H7.231c-.662 0-1.18-.568-1.12-1.227L6.34 18m11.318 0h1.091A2.25 2.25 0 0021 15.75V9.456c0-1.081-.768-2.015-1.837-2.175a48.055 48.055 0 00-1.913-.247M6.34 18H5.25A2.25 2.25 0 013 15.75V9.456c0-1.081.768-2.015 1.837-2.175a48.041 48.041 0 011.913-.247m10.5 0a48.536 48.536 0 00-10.5 0m10.5 0V3.375c0-.621-.504-1.125-1.125-1.125h-8.25c-.621 0-1.125.504-1.125 1.125v3.659M18 10.5h.008v.008H18V10.5zm-3 0h.008v.008H15V10.5z" />
                </svg>

                Print</x-primary-button>

        </div>
    </div>
    <div class="text-center font-semibold text-lg text-gray-700 py-2">PAYSCALE MASTER LIST OF DISTRICT <span class="uppercase">{{$data->first()->district->DistName??""}}</span></div>
       

    <table class="table-auto w-full border-collapse border">

        <thead class="bg-gray-200 w-full">
         {{--   <td class="border font-semibold text-gray-700 p-2 w-16 text-left">Sr No.</td>--}}

            @foreach($headers as $head)
            <td class="border font-semibold text-gray-700 p-2 text-left">{{$head}}</td>
            @endforeach
        </thead>
        <tbody>
            @foreach($data as $index=>$row)
            <tr>
                {{--<td class="p-2 border text-sm p-2 text-gray-600 ">{{$index + $data->firstItem()}}</td>--}}
                <td class="p-2 border text-sm p-2 text-gray-600">{{$row->id}}</td>
                <td class="p-2 border text-sm p-2 text-gray-600">{{$row->PayScale}}</td>
                <td class="p-2 border text-sm p-2 text-gray-600">{{$row->selectedclass->description}}</td>




            </tr>

            @endforeach




        </tbody>

    </table>
    <div class="py-2">
        {{ $data->links() }}
    </div>

   
</div>
