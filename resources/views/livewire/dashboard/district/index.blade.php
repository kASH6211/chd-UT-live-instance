<div class="w-full p-4 pb-1 ">
    <div>
        <h1 class="font-semibold pb-2 border-b border-dashed border-gray-300 text-md  leading-none text-gray-700 dark:text-white pr-1 flex  items-center">District Summary</h1>

    </div>
    

    <div class="grid grid-cols-6 py-8">
        <div class="p-4 cursor-pointer overflow-hidden transition-transform transform hover:scale-110 ">


            <div class="flex justify-center items-start bg-gradient-to-r from-blue-700 via-sky-600 to-orange-500  pb-1 w-full h-full shadow-lg">



                <div class="flex flex-col justify-center items-center w-full p-4  bg-orange-50 h-full">
                    <div class="pb-2">

                        <h1 class="text-xl text-orange-600"> {{$totdept}} </h1>
                    </div>
                    <h1>Departments</h1>
                </div>
            </div>

        </div>
        <div class="p-4 cursor-pointer  overflow-hidden transition-transform transform hover:scale-110">


            <div class="flex justify-center items-start bg-gradient-to-r from-blue-700 via-sky-600 to-yellow-500 pb-1 w-full h-full shadow-lg">



                <div class="flex flex-col justify-center items-center w-full p-4  bg-yellow-50 h-full">
                    <div class="pb-2">

                        <h1 class="text-xl text-yellow-700"> {{$totsubdept}} </h1>

                    </div>
                    <h1>Sub-departments</h1>
                </div>
            </div>

        </div>


        <div class="p-4 cursor-pointer  overflow-hidden transition-transform transform hover:scale-110">


            <div class="flex justify-center items-start bg-gradient-to-r from-blue-700 via-sky-600 to-fuchsia-500 pb-1 w-full h-full shadow-lg">



                <div class="flex flex-col justify-center items-center w-full p-4  bg-fuchsia-50 h-full">
                    <div class="pb-2">

                        <h1 class="text-2xl text-fuchsia-700"> {{$totoffice}} </h1>
                    </div>
                    <h1>Offices</h1>
                </div>
            </div>

        </div>


        <div class="p-4 cursor-pointer  overflow-hidden transition-transform transform hover:scale-110">

            <div class="flex justify-center items-start bg-gradient-to-r from-blue-700 via-sky-600 to-red-600 pb-1 w-full h-full shadow-lg ">



                <div class="flex flex-col justify-center items-center w-full p-4 bg-red-50 h-full">
                    <div class="pb-2">

                        <h1 class="text-xl text-red-700"> {{$totpd}} </h1>
                    </div>
                    <h1>Total Employees</h1>
                </div>
            </div>

        </div>
        <div class="p-4 cursor-pointer  overflow-hidden transition-transform transform hover:scale-110">


            <div class="flex justify-center items-start bg-gradient-to-r from-blue-700 via-sky-600 to-lime-500  pb-1 w-full h-full shadow-lg">



                <div class="flex flex-col justify-center items-center w-full p-4  bg-lime-50 h-full">
                    <div class="pb-2">

                        <h1 class="text-xl text-lime-800"> {{$totlocations}}</h1>
                    </div>
                    <h1>Polling Locations</h1>
                </div>
            </div>

        </div>
        <div class="p-4 cursor-pointer  overflow-hidden transition-transform transform hover:scale-110">

            <div class="flex justify-center items-start bg-gradient-to-r from-blue-700 via-sky-600  to-sky-500 pb-1 w-full h-full shadow-lg ">




                <div class="flex flex-col justify-center items-center w-full p-4  bg-sky-50 h-full">

                    <div class="pb-2">
                        <h1 class="text-xl text-sky-600"> {{$totbooths}} </h1>
                    </div>


                    <h1>Polling Booths</h1>
                </div>
            </div>

        </div>





    </div>

 
    

     <h1 class="font-semibold pb-4 border-b border-dashed border-gray-300 text-md  leading-none text-gray-700 dark:text-white pr-1 flex  items-center mt-4">Polling Location & Polling Stations</h1>
 
    <div class="flex w-full p-4">

        <div id="chart" class=" w-full bg-gray-100 flex justify-center items-center text-center"></div>

        <script>
            var chartlabels = @json($chartboothslabels);
            var chartdata = @json($chartboothsdata);

            var options = {
                series: chartdata
                , chart: {
                    width: 380
                    , type: 'pie'
                , }
                , labels: chartlabels
                , responsive: [{
                    breakpoint: 480
                    , options: {
                        chart: {
                            width: 200
                        }
                        , legend: {
                            position: 'bottom'
                        }
                    }
                }]
            };



            var chart = new ApexCharts(document.querySelector("#chart"), options);
            chart.render();

        </script>
        <div class="w-3/5  p-4">
            <div class="w-full flex justify-center py-2 mb-2">
                <h2 class=" text-gray-700  text-md  font-semibold ">Constituency wise distribution of Polling Stations in district <span class="text-red-700">{{ $distname }}</span> </h2>
            </div>
            <table class="table-auto w-full border-collapse border">

                <thead class="bg-gray-100 w-full">
                    <td class="border text-gray-700 py-2 px-4 w-8 text-sm font-semibold ">Sr No.</td>

                    <td class="border text-gray-700 py-2 px-4 w-8 text-sm font-semibold ">Constituency Name</td>



                    <td class="border text-gray-700 py-2 px-4 w-8 text-sm font-semibold ">Locations</td>



                    <td class="border text-gray-700 py-2 px-4 w-8 text-sm font-semibold ">Booths</td>

                    <td class="border text-gray-700 py-2 px-4 w-8 text-sm font-semibold ">Ordinary</td>
                    <td class="border text-gray-700 py-2 px-4 w-8 text-sm font-semibold ">Vulnerable</td>
                    <td class="border text-gray-700 py-2 px-4 w-8 text-sm font-semibold ">Critical</td>




                </thead>
                <tbody>
                    @foreach($pssummary as $index=>$row)
                    <tr>
                        <td class="pl-4 border text-gray-600  text-sm py-2">{{$index +1}}</td>


                        <td class="pl-4 border text-gray-600 font-semibold text-sm">{{$this->getConsName($row['CONSCODE'])}}</td>


                        <td class="pl-4 border text-gray-600 font-semibold text-sm">{{$row['Locations']}}</td>


                        <td class="pl-4 border text-gray-600 font-semibold text-sm">{{$row['Booths']}}</td>

                        <td class="pl-4 border text-gray-600 font-semibold text-sm">{{$row['Ordinary']}}</td>
                        <td class="pl-4 border text-amber-600 font-semibold text-sm">{{$row['Sensitive']}}</td>
                        <td class="pl-4 border text-red-600 font-semibold text-sm">{{$row['VSensitive']}}</td>




                    </tr>

                    @endforeach




                </tbody>

            </table>

        </div>




    </div>
    <h1 class="font-semibold pb-4 border-b border-dashed border-gray-300 text-md  leading-none text-gray-700 dark:text-white pr-1  items-center mt-4">Office Summary</h1>
    <div>
       @livewire('dashboard.district.office-summary')
    </div>
    
   

    <h1 class="font-semibold pb-4 border-b border-dashed border-gray-300 text-md  leading-none text-gray-700 dark:text-white pr-1  items-center mt-4">Polling Data Stats</h1>
    <div>
       @livewire('dashboard.district.p-d-calculator')
    </div>

   

</div>
