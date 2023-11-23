<?php

namespace App\Imports\ExcelImports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class DepartmentImport implements ToCollection
{
    /**
    * @param Collection $collection
    */
    public function collection(Collection $collection)
    {
        
        $data = [];
       
        dd($collection);
        foreach ($collection as $key=>$row) {
            
            // Assuming your Excel file has columns "column1", "column2", and so on.
            if($row[0] && $row[1] && $row[2])
            {
            $col1 = $row[0];
            $col2 = $row[1];
            $col3 = $row[1];


          
            // $infoMessage = "col1-->".$col1."  Col2-->".$col2;

            // Log::channel('mylog')->info($infoMessage);
         
            $data[] = [
                'column1' => $col1,
                'column2' => $col2,
                'column3' => $col3

                
                // Map additional columns as needed
            ];
          }
        }
       
        return $data;
    }
}
