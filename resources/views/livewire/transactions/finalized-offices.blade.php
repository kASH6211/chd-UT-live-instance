<div>
   <div>
       <div class="grid grid-cols-4">
          <a href="javascript:void(0)" wire:click="showData('total')">
          <div class="bg-gray-100 cursor-pointer hover:bg-blue-100 rounded-md flex flex-col justify-center items-center m-4 p-4 overflow-hidden transition-transform transform hover:scale-110">
             <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8">
                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 21h19.5m-18-18v18m10.5-18v18m6-13.5V21M6.75 6.75h.75m-.75 3h.75m-.75 3h.75m3-6h.75m-.75 3h.75m-.75 3h.75M6.75 21v-3.375c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21M3 3h12m-.75 4.5H21m-3.75 3.75h.008v.008h-.008v-.008zm0 3h.008v.008h-.008v-.008zm0 3h.008v.008h-.008v-.008z" />
              </svg>
              
             Total Offices
             <h1 class="text-xl font-semibold">{{ $total }}</h1>
          </div>
       </a>
       <a href="javascript:void(0)" wire:click="showData('submitted')">
          <div class="bg-gray-100 cursor-pointer hover:bg-blue-100 rounded-md flex flex-col justify-center items-center m-4 p-4 overflow-hidden transition-transform transform hover:scale-110">
             <div class="flex">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8">
                   <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 21h19.5m-18-18v18m10.5-18v18m6-13.5V21M6.75 6.75h.75m-.75 3h.75m-.75 3h.75m3-6h.75m-.75 3h.75m-.75 3h.75M6.75 21v-3.375c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21M3 3h12m-.75 4.5H21m-3.75 3.75h.008v.008h-.008v-.008zm0 3h.008v.008h-.008v-.008zm0 3h.008v.008h-.008v-.008z" />
                 </svg>
                 <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"  class="w-6 h-6 stroke-lime-800 -mt-2">
                   <path stroke-linecap="round" stroke-linejoin="round" d="M11.35 3.836c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m8.9-4.414c.376.023.75.05 1.124.08 1.131.094 1.976 1.057 1.976 2.192V16.5A2.25 2.25 0 0118 18.75h-2.25m-7.5-10.5H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V18.75m-7.5-10.5h6.375c.621 0 1.125.504 1.125 1.125v9.375m-8.25-3l1.5 1.5 3-3.75" />
                 </svg>
             </div>
           Offices Finalized
             <h1 class="text-xl font-semibold">{{ $finalized }}</h1>
    
          </div>
       </a>
      
       <a href="javascript:void(0)" wire:click="showData('progress')">
          
          <div class="bg-gray-100 cursor-pointer hover:bg-blue-100 rounded-md flex flex-col justify-center items-center m-4 p-4 overflow-hidden transition-transform transform hover:scale-110">
             <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8">
                   <path stroke-linecap="round" stroke-linejoin="round" d="M11.42 15.17L17.25 21A2.652 2.652 0 0021 17.25l-5.877-5.877M11.42 15.17l2.496-3.03c.317-.384.74-.626 1.208-.766M11.42 15.17l-4.655 5.653a2.548 2.548 0 11-3.586-3.586l6.837-5.63m5.108-.233c.55-.164 1.163-.188 1.743-.14a4.5 4.5 0 004.486-6.336l-3.276 3.277a3.004 3.004 0 01-2.25-2.25l3.276-3.276a4.5 4.5 0 00-6.336 4.486c.091 1.076-.071 2.264-.904 2.95l-.102.085m-1.745 1.437L5.909 7.5H4.5L2.25 3.75l1.5-1.5L7.5 4.5v1.409l4.26 4.26m-1.745 1.437l1.745-1.437m6.615 8.206L15.75 15.75M4.867 19.125h.008v.008h-.008v-.008z" />
                 </svg>
             Submitted but not Finalized
             <h1 class="text-xl font-semibold">{{ $submitted }}</h1>
    
          </div>
       </a>
      
       <a href="javascript:void(0)" wire:click="showData('pending')">
           <div class="text-center bg-gray-100 cursor-pointer hover:bg-green-100 rounded-md flex flex-col justify-center items-center m-4 p-4 overflow-hidden transition-transform transform hover:scale-110 border-2 border-green-600 border-dashed">
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8">
                   <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                 </svg>
                 
              Employees Finalized
              <h1 class="text-xl font-semibold">{{ $count }}</h1>
     
           </div>
        </a>
       </div>
    </div>

    <div class="mt-1 pt-1 border-t border-gray-300 border-dashed">
    <div class="rounded-md py-4 flex justify-between w-full">
       <div class="flex items-end w-3/5">
           <h1 class="text-md font-semibold">Summary of finalization details of all the submitted offices</h1>
       </div>
       <div class="w-2/5">
           <x-input class="px-4 w-full" wire:change="updatedSearch()" wire:model.debounce.500ms="search" placeholder="Search.."></x-input>
       </div>

    </div>

           <table class="table-auto w-full border-collapse border">
               <thead class="bg-gray-100 w-full">
                   <td class="border  text-gray-700 p-2 w-16 text-sm font-semibold ">Sr No.</td>
                   <td class="border  text-gray-700 p-2  text-sm font-semibold ">Office Name</td>
                   <td class="border  text-gray-700 p-2  text-sm font-semibold ">Department Name</td>
                   <td class="border  text-gray-700 p-2 w-36 text-sm font-semibold ">Total Employees</td>
                   <td class="border  text-gray-700 p-2 w-36 text-sm font-semibold ">Finalization Status</td>

               </thead>
               <tbody>
                @foreach($datasubmitted as $index=>$ds)
                   
                <tr class="cursor-pointer hover:bg-blue-900/10" wire:click="openDetails({{ $ds->id }})">
                    
                       <td class="px-2 border text-gray-600  text-sm py-2">{{ $index+1 }}</td>
                       <td class="px-2 border text-gray-600  text-sm">{{ $ds->office }} </td>
                       <td class="px-2 border text-gray-600  text-sm">{{ $this->getDeptName($ds->deptcode) }}</td>

                       @if($ds->employeesfinalized)
                       <td class="px-2 border text-gray-600  text-sm">{{ $ds->employeesfinalized}}</td>
                       @else
                       <td class="px-2 border text-gray-600  text-sm">-</td>

                       @endif 
                       
                       @if($ds->finalized ==1)
                        <td class="px-2 border-b text-green-500  text-sm flex justify-center items-center py-2">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                              </svg>
                              
                        </td>
                        @else
                        <td class="px-2 border-b  text-red-500  text-sm flex justify-center items-center  py-2">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9.75 9.75l4.5 4.5m0-4.5l-4.5 4.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                              </svg>
                            
                              
                        </td>
                        @endif
                      
                    
                   </tr>
              

                   @endforeach
             <!--      <tr>
                       <td class="text-center border text-gray-600 font-semibold text-sm py-2">2</td>
                       <td class="text-center border text-gray-600 font-semibold text-sm">Education Secondary</td>
                       <td class="text-center border text-gray-600 font-semibold text-sm">GSSS Vein Poin</td>
                       <td class="text-center border text-gray-600 font-semibold text-sm">2</td>
                       <td class="text-center border-b text-green-400 font-semibold text-sm flex justify-center items-center py-2">
                           <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                               <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                             </svg>
                             
                       </td>
                      

                   </tr>
                   <tr>
                       <td class="text-center border text-gray-600 font-semibold text-sm py-2">3</td>
                       <td class="text-center border text-gray-600 font-semibold text-sm">Education Secondary</td>
                       <td class="text-center border text-gray-600 font-semibold text-sm">GSSS Goindwal Sahib</td>
                       <td class="text-center border text-gray-600 font-semibold text-sm">9</td>
                       <td class="text-center border-b  text-green-400 font-semibold text-sm flex justify-center items-center  py-2">
                           <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                               <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                             </svg>
                             
                       </td>
                      

                   </tr>
                   <tr>
                       <td class="text-center border text-gray-600 font-semibold text-sm py-2">4</td>
                       <td class="text-center border text-gray-600 font-semibold text-sm">Education Secondary</td>
                       <td class="text-center border text-gray-600 font-semibold text-sm">GSSS Chohla Sahib</td>
                       <td class="text-center border text-gray-600 font-semibold text-sm">18</td>
                       <td class="text-center border-b text-green-400 font-semibold text-sm flex justify-center items-center  py-2">
                           <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                               <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                             </svg>
                             
                       </td>
                      

                   </tr>
                   <tr>
                       <td class="text-center border text-gray-600 font-semibold text-sm py-2">5</td>
                       <td class="text-center border text-gray-600 font-semibold text-sm">Education Secondary</td>
                       <td class="text-center border text-gray-600 font-semibold text-sm">GSSS Gaggo Buha</td>
                       <td class="text-center border text-gray-600 font-semibold text-sm">5</td>
                       <td class="text-center border-b  text-red-500 font-semibold text-sm flex justify-center items-center  py-2">
                           <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                               <path stroke-linecap="round" stroke-linejoin="round" d="M9.75 9.75l4.5 4.5m0-4.5l-4.5 4.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                             </svg>
                             
                      
                   </tr>
                   <tr>
                       <td class="text-center border text-gray-600 font-semibold text-sm py-2">6</td>
                       <td class="text-center border text-gray-600 font-semibold text-sm">Education Secondary</td>
                       <td class="text-center border text-gray-600 font-semibold text-sm">GSSS Noordi</td>
                       <td class="text-center border text-gray-600 font-semibold text-sm">18</td>
                       <td data-tooltip-target="tooltip-default" class="text-center  text-red-500 font-semibold text-sm flex justify-center items-center  py-2">
                           <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                               <path stroke-linecap="round" stroke-linejoin="round" d="M9.75 9.75l4.5 4.5m0-4.5l-4.5 4.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                             </svg>
                             <div id="tooltip-default" role="tooltip" class="absolute z-10 invisible inline-block px-3 py-2 text-xs font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700">
                               Data Not Submitted by office
                               <div class="tooltip-arrow" data-popper-arrow></div>
                           </div>
                             
                       </td>
                      

                   </tr> -->
               </tbody>

           </table>
           <div class="py-2">
                {{ $datasubmitted->links() }}
            </div>
       </div>
       <x-confirmation-modal wire:model="newmodal">
           <x-slot name="icon">
               <svg class="h-6 w-6 stroke-white" stroke-width="1.5" fill="none" viewBox="0 0 24 24">
                   <path stroke-linecap="round" stroke-linejoin="round" d="M19 7.5v3m0 0v3m0-3h3m-3 0h-3m-2.25-4.125a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zM4 19.235v-.11a6.375 6.375 0 0112.75 0v.109A12.318 12.318 0 0110.374 21c-2.331 0-4.512-.645-6.374-1.766z" />
               </svg>
           </x-slot>
       
       
           <x-slot name="title">
               {{ $title }}
           </x-slot>
       
       
           <x-slot name="content">
       
               <div class="w-full flex flex-col justify-center">
                 
       
               </div>
       
           </x-slot>
       
           <x-slot name="footer">
               <x-secondary-button wire:click="$toggle('newmodal')" wire:loading.attr="disabled">
                   Cancel
               </x-secondary-button>
       
              
           </x-slot>
       </x-confirmation-modal>
</div>
