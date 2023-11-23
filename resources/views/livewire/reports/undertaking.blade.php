<div>
    <x-loading-indicator />
    <x-primary-button wire:click="undertaking_download()">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 mr-2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m.75 12l3 3m0 0l3-3m-3 3v-6m-1.5-9H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
        </svg>


        Export to PDF</x-primary-button>
    <div class="w-7/12 mx-auto ">
        <div class="text-center font-bold text-lg my-4">CERTIFICATE</div>
        <div class="text-justify leading-[2.5rem]">

            It is certified that the data is accurate and complete in all respects and no employee other than the class 4 (peon/helpers) has been left out. The total employees in this office except class 4 employees are ,<span class=" underline bg-blue-100 text-gray-800 font-bold mr-2 px-2.5 py-0.5 rounded">{{$tot}}</span>, total Regular employees entered in the software are <span class=" underline bg-blue-100 text-gray-800 font-bold mr-2 px-2.5 py-0.5 rounded">{{$this->emptype["regular"]}}</span>, total Contractual employees entered in the software are <span class=" underline bg-blue-100 text-gray-800 font-bold mr-2 px-2.5 py-0.5 rounded">{{$this->emptype["contractual"]}}</span> .
        </div>
        <div class="text-justify leading-[2.5rem]">
            Further it is certified that the data submitted in the online NextGenDISE software and checklist report generated after feeding the data is correct and we are responsible for any wrong data entered.
        </div>
        <div class="mt-12 flex justify-between">
            <div class="w-1/2">
                <div> Signature of Data Entered</div>
                <div>Name:</div>
                <div>Designation:</div>
                <div>Contact No:</div>
            </div>
            <div>
                <div> Signature of Office Superintendent</div>
                <div>Name:</div>
                <div>Designation:</div>
                <div>Contact No:</div>
            </div>

        </div>
        <div class="mt-16">
            <div class="w-1/3 mx-auto">
                <div>Signature of Head of Office</div>
                <div>Name:</div>
                <div>Designation:</div>
                <div>Contact No:</div>
                <div>Stamp of Office:</div>
            </div>
        </div>
    </div>
</div>
