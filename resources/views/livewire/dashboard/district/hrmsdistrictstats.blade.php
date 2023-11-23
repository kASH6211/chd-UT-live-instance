<div>
<h1 class="font-semibold pb-4 border-b border-dashed border-gray-300 text-md  leading-none text-gray-700 dark:text-white pr-1 flex  items-center mt-4">District Wise Imported Data from HRMS</h1>
 <div class="p-2">
      <table class="table-auto w-full border-collapse border">

                <thead class="bg-gray-50 w-full">
                    @foreach ($headers as $head)
                       <td class="border text-left bg-gray-50 py-2 px-4 w-8 text-sm font-semibold text-gray-700">{{$head}}</td>
                    @endforeach
                 
                </thead>
                <tbody>
                  @foreach ($districts as $d)
                   <tr>  
                  <td class="border text-left text-gray-700  py-2 px-4 w-8 text-sm font-semibold ">{{$d->DistName}}</td>                
                 <td class="border text-left text-gray-700  py-2 px-4 w-8 text-sm font-semibold ">{{$dept[$d->id]}}</td>
                <td class="border text-left text-gray-700  py-2 px-4 w-8 text-sm font-semibold ">{{$off[$d->id]}}</td>
                <td class="border text-left text-gray-700  py-2 px-4 w-8 text-sm font-semibold ">{{$emp[$d->id]}}</td>
                
                 </tr>
                 @endforeach
                </tbody>
         </table>
         <div class="p-2">
         {{$districts->links()}}
         </div>
 </div>
   
</div>
