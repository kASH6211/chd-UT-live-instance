<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        #title {
            text-align: center;
            color: #1E3A8A;
            margin: 10px;
            font-weight: bold;
        }

        .size {
            font-size: 0.75rem;
            font-weight: 400;
            text-align: left;
        }

        table {
            width: 100%;
            text-align: left;
            border-spacing: 0px;
        }

        th {
            padding: 5px;
            text-align: left;
            vertical-align: top;
            }

        th>div {
            text-align: left;
            vertical-align: top;
            border: 0px solid #ccc;

        }

        .row td {
            border-bottom: 1px solid red;
            border-color: rgb(148 163 184);
            padding: 2px 10px 2px 0px;
        }

        .row div {
            width: 100%;
            border: 0px solid blue;
            vertical-align: top;
        }

        .bob {
            border-bottom: 1px solid red;
        }

        .pagenum:after {
            counter-increment: page;
            content: counter(pages);

        }

        header {
            /* add some css */
        }
        .pad{
            padding:5px 0px 5px 5px;
        }
    </style>
</head>
<body>
     <div id="title" class="text-center font-bold text-lg py-2">DESIGNATION MASTER LIST OF DISTRICT <span>{{strtoupper(Auth::user()->userdistrict->DistName)}}</span></div>
        <div  id="title" class="text-center font-bold p-1"> Total Offices - {{count($data)}}</div>
         <div id="title" class="text-center text-lg text-gray-500">Total offices that have not started data entry</div>
    
    <div class="mb-4">

     <table border=1>
            <thead>
                <tr>
                    <th class="pad">Sr.No.</th>
                    <th class="pad">{{$headers[0]}}</th>
                    {{-- <th class="pad">{{$headers[1]}}</th> --}}
                    <th class="pad">{{$headers[2]}}</th>
                    <th class="pad">{{$headers[3]}}</th>
                </tr>
            </thead>
            <tbody>
                 @foreach ($data as $index=>$row)
                <tr>
                    <td class="pad">{{$index + 1}}</td>
                    <td class="pad">{{$other[$row->deptcode]}}</td>
                    {{-- <td class="pad">{{$other[$row->subdeptcode]}}</td> --}}
                    <td class="pad">{{$row->office}}</td>
                    <td class="pad">{{$row->address}}</td>
                </tr>
                @endforeach 
            </tbody>
        </table>
        


        <div class="py-2">
            {{-- $data->links() --}}
        </div>
    </div>
</body>
</html>
