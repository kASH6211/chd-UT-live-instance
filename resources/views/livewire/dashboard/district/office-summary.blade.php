<div>
   <div class="grid grid-cols-6">
      <a href="/office/detail/all" target="_blank">
      <div data-tooltip-target="tooltip-total" class="bg-gray-100 cursor-pointer hover:bg-blue-100 rounded-md flex flex-col justify-center items-center m-4 p-4 overflow-hidden transition-transform transform hover:scale-110">
         <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8">
            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 21h19.5m-18-18v18m10.5-18v18m6-13.5V21M6.75 6.75h.75m-.75 3h.75m-.75 3h.75m3-6h.75m-.75 3h.75m-.75 3h.75M6.75 21v-3.375c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21M3 3h12m-.75 4.5H21m-3.75 3.75h.008v.008h-.008v-.008zm0 3h.008v.008h-.008v-.008zm0 3h.008v.008h-.008v-.008z" />
          </svg>
          
         Total Offices
         <h1 class="text-xl font-semibold">{{ $total }}</h1>
      </div>
      <div id="tooltip-total" role="tooltip" class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700">
   Offices added to your district
    <div class="tooltip-arrow" data-popper-arrow></div>
    </div>
   </a>
   <a href="/office/detail/submitted" target="_blank">
      <div data-tooltip-target="tooltip-submitted" class="bg-gray-100 cursor-pointer hover:bg-blue-100 rounded-md flex flex-col justify-center items-center m-4 p-4 overflow-hidden transition-transform transform hover:scale-110">
         <div class="flex">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8">
               <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 21h19.5m-18-18v18m10.5-18v18m6-13.5V21M6.75 6.75h.75m-.75 3h.75m-.75 3h.75m3-6h.75m-.75 3h.75m-.75 3h.75M6.75 21v-3.375c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21M3 3h12m-.75 4.5H21m-3.75 3.75h.008v.008h-.008v-.008zm0 3h.008v.008h-.008v-.008zm0 3h.008v.008h-.008v-.008z" />
             </svg>
             <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"  class="w-6 h-6 stroke-lime-800 -mt-2">
               <path stroke-linecap="round" stroke-linejoin="round" d="M11.35 3.836c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m8.9-4.414c.376.023.75.05 1.124.08 1.131.094 1.976 1.057 1.976 2.192V16.5A2.25 2.25 0 0118 18.75h-2.25m-7.5-10.5H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V18.75m-7.5-10.5h6.375c.621 0 1.125.504 1.125 1.125v9.375m-8.25-3l1.5 1.5 3-3.75" />
             </svg>
         </div>
        Submitted 
         <h1 class="text-xl font-semibold">{{ $submitted }}</h1>
      </div>
      <div id="tooltip-submitted" role="tooltip" class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700">
   Offices submitted their employees data
    <div class="tooltip-arrow" data-popper-arrow></div>
    </div>
      
   </a>
   
   <a href="/office/detail/finalized" target="_blank">
      <div  data-tooltip-target="tooltip-final" class="bg-gray-100 cursor-pointer hover:bg-blue-100 rounded-md flex flex-col justify-center items-center m-4 p-4 overflow-hidden transition-transform transform hover:scale-110">
         <div class="flex">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                
         </div>
        Finalized 
         <h1 class="text-xl font-semibold">{{ $finalized }}</h1>

      </div>
        <div id="tooltip-final" role="tooltip" class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700">
   Offices data finalized by you
    <div class="tooltip-arrow" data-popper-arrow></div>
    </div>
   </a>
   <a href="/office/detail/inprogress" target="_blank">
      
      <div  data-tooltip-target="tooltip-progress" class="bg-gray-100 cursor-pointer hover:bg-blue-100 rounded-md flex flex-col justify-center items-center m-4 p-4 overflow-hidden transition-transform transform hover:scale-110">
         <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8">
               <path stroke-linecap="round" stroke-linejoin="round" d="M11.42 15.17L17.25 21A2.652 2.652 0 0021 17.25l-5.877-5.877M11.42 15.17l2.496-3.03c.317-.384.74-.626 1.208-.766M11.42 15.17l-4.655 5.653a2.548 2.548 0 11-3.586-3.586l6.837-5.63m5.108-.233c.55-.164 1.163-.188 1.743-.14a4.5 4.5 0 004.486-6.336l-3.276 3.277a3.004 3.004 0 01-2.25-2.25l3.276-3.276a4.5 4.5 0 00-6.336 4.486c.091 1.076-.071 2.264-.904 2.95l-.102.085m-1.745 1.437L5.909 7.5H4.5L2.25 3.75l1.5-1.5L7.5 4.5v1.409l4.26 4.26m-1.745 1.437l1.745-1.437m6.615 8.206L15.75 15.75M4.867 19.125h.008v.008h-.008v-.008z" />
             </svg>
         In Progress
         <h1 class="text-xl font-semibold">{{ $inprogress }}</h1>

      </div>
        <div id="tooltip-progress" role="tooltip" class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700">
   Offices started data entry
    <div class="tooltip-arrow" data-popper-arrow></div>
    </div>
   </a>
   <a href="/office/detail/pending" target="_blank">
      <div data-tooltip-target="tooltip-pending" class="bg-gray-100 cursor-pointer hover:bg-blue-100 rounded-md flex flex-col justify-center items-center m-4 p-4 overflow-hidden transition-transform transform hover:scale-110">
         <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8">
               <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
             </svg>
         Pending
         <h1 class="text-xl font-semibold">{{ $pending }}</h1>

      </div>
       <div id="tooltip-pending" role="tooltip" class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700">
   Yet to start data entry
    <div class="tooltip-arrow" data-popper-arrow></div>
    </div>
   </a>
   <a href="/office/detail/imported" target="_blank">
      <div data-tooltip-target="tooltip-imported" class="bg-gray-100 cursor-pointer hover:bg-blue-100 rounded-md flex flex-col justify-center items-center m-4 p-4 overflow-hidden transition-transform transform hover:scale-110">
         <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8">
               <path stroke-linecap="round" stroke-linejoin="round" d="M9 8.25H7.5a2.25 2.25 0 00-2.25 2.25v9a2.25 2.25 0 002.25 2.25h9a2.25 2.25 0 002.25-2.25v-9a2.25 2.25 0 00-2.25-2.25H15m0-3l-3-3m0 0l-3 3m3-3V15" />
             </svg>
         Imported
         <h1 class="text-xl font-semibold">{{ $imported }}</h1>

      </div>
      <div id="tooltip-imported" role="tooltip" class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700">
   Data imported and pushed to local database
    <div class="tooltip-arrow" data-popper-arrow></div>
    </div>
   </a>
   </div>

 
</div>
