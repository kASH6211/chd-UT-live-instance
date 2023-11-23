<div class="flex flex-col w-full ">
    <div class="flex w-full">
        <div class="flex w-full bg-gray-300   bg-gradient-to-r from-red-700 to-lime-700 via-amber-500">
           
            
            <div class="h-8 w-0 bg-gray-300 rounded-xl opacity-0" style="width:{{ $percentage }}%">
                   
            </div>
            <div class="h-8 w-full bg-gray-300 opacity-100 " style="width:{{ 100-$percentage }}%"></div>

        </div>
      </div>
    <div class="flex w-full justify-center itemsc-center"> {{$percentage }} % Completed ({{ $completed }} out of {{ $total }} total)</div>
   
</div>