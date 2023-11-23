<?php

namespace App\Http\Livewire\Import;

use App\Models\ConnectionMaster;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\DeptMaster;
use App\Models\OfficeLock;
use App\Models\SubdeptMaster;
use App\Models\OfficeMaster;
use Exception;
use Livewire\WithPagination;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Schema;
use Illuminate\Validation\ValidationException;
use Livewire\Component;
use PDO;


class Pulldata extends Component
{

    use WithPagination;
    use AuthorizesRequests;
    public $search = "";
    public $deptlist = null;
    public $subdeptlist = null;

    public $perPage = 10;

    public $tables1;
    public $tables2;
    public $pgsql = [];
    public $tab1 = array(30);
    public $list2 = [];
    public $finalstatus = [];
    public $msg = "";
    public $progress = "0";
    public $distcode = '';
    public $editobject;
    public $object = null;
    public $confirmupdatemodal;
    public $confirmstatus;
    public $snf = 0;
    public $connectionConfig = [];
    public $serverinfo = 0;

    public function mount()
    {

        $this->distcode = Auth::user()->distcode;
        $info = ConnectionMaster::where('distcode', $this->distcode)->first();
        if ($info) {
            $this->serverinfo = $info;
        }
        $c = $this->getConnection($this->distcode);
        if ($c != null && count($c) > 0) {
            $this->snf = 0;

            // Create a dynamic database connection

            // $remote = DB::connection('pgsql')->select('SELECT table_name FROM information_schema.tables WHERE table_schema = \'public\' ');
            // $this->pgsql = (array_map('current', $remote));

            // $this->tables2 = $conn->select("SELECT TABLE_NAME FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_TYPE = 'BASE TABLE'");
            // $this->list2 = array_map('current', $this->tables2);

        } else {
            $this->snf = 1;
        }
    }

    public function render()
    {
        // $this->authorize('view', OfficeMaster::class);
        $header = ['Department', 'Sub Department', 'Office', 'Employee', 'Submitted', 'Finalized', 'Import'];

        $data = DB::table('office_masters')
        ->leftJoin('office_locks', function ($join) {
            $join->on('office_masters.id', '=', 'office_locks.office_id');
        })->where('office_masters.distcode',Auth::User()->distcode)->when($this->search,function($query, $search){
            return $query->where('office_masters.office','ILIKE',"%$this->search%");
        })
        ->orderBy('office_locks.imported', 'ASC')
        ->orderBy('office_locks.finalized', 'DESC')
           ->paginate($this->perPage);
        $data->withPath('/import/pulldata');
        $tot =  OfficeMaster::where('distcode', $this->distcode)->get()->count();

        //  dd($data);
        return view('livewire.import.pulldata', ["data" => $data, "header" => $header, "total" => $tot]);
    }

    public function openforexport($id)
    {

        $data = OfficeMaster::where('id', $id)->first();;
        // $this->authorize('update',$data);

        $this->editobject['deptcode'] =  $data->deptcode;
        $this->editobject['office'] =  $data->office;
        $this->editobject['address'] =  $data->address;
        $this->editobject['id'] =  $data->id;

        $this->toggle('confirmupdatemodal');
    }

    public function getSubDeptName($deptcode, $subdeptcode)
    {
        if ($subdeptcode)
            $subdept = SubdeptMaster::where('distcode', $this->distcode)->where('deptcode', $deptcode)->where('subdeptcode', $subdeptcode)->first();

        if ($subdept)
            return $subdept->subdept;
        return null;
    }

    public function getDeptName($deptcode)
    {
        if ($deptcode)
            $dept = DeptMaster::where('distcode', $this->distcode)->where('deptcode', $deptcode)->first();

        if ($dept)
            return $dept->deptname;
        return null;
    }


    public function toggle($key)
    {
        switch ($key) {
            case "confirmstatus":
                $this->confirmupdatemodal = !$this->confirmupdatemodal;
                break;
            case "confirmupdatemodal":
                $this->confirmupdatemodal = !$this->confirmupdatemodal;
                break;
        }
    }

    public function exportRecord($code)
    {
       
        $update = OfficeMaster::where('id', $code)->first();

        $this->finalstatus = $this->migrateCompleteData($update);

        if ($this->finalstatus["code"] == 200) {
            $this->confirmupdatemodal = !$this->confirmupdatemodal;
            $this->confirmstatus = !$this->confirmstatus;
            $imp = $update->haslock;
            $imp["imported"] = 1;
            $imp->save();

            // $this->authorize('update',$del);

            $this->editobject['id'] = '';
            $this->editobject['deptcode'] = '';
            $this->editobject['office'] = '';
            $this->editobject['address'] = '';


            $this->dispatchBrowserEvent('banner-message', [
                'style' => 'success',
                'message' => 'Office Exported Successfully!'
            ]);
            $this->emit('close-banner');
        } else {

            $this->confirmupdatemodal = !$this->confirmupdatemodal;
            $this->confirmstatus = !$this->confirmstatus;
        }
    }

    public function getConnection($distcode)
    {

        $data = ConnectionMaster::where('distcode', $distcode)->get()->first();

        if ($data) {

            $dynamicConnectionConfig = [
                'driver' => 'sqlsrv',
                'host' => $data->host,
                'port' => $data->port,
                'database' => $data->database,
                'username' => $data->username,
                'password' => $data->password,
                'trust_server_certificate' => 'true',
                // ... other configuration options
            ];



            try {
                // Create a dynamic database connection
                $dynamicConnectionName = $data->discode . 'sqlsrv'; // Change this to a unique name
                config(["database.connections.$dynamicConnectionName" => $dynamicConnectionConfig]);
                $conn = DB::connection($dynamicConnectionName);

                $x = $conn->select("SELECT TABLE_NAME FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_TYPE = 'BASE TABLE'");

                if (count($x) > 0) {
                    return [$dynamicConnectionConfig];
                } else {
                    return [];
                }
            } catch (\Exception $e) {

                return null;
            }
        }

        return [];
    }

    public  function migrateBank()
    {
        try {
            $fromtable = "banks";
            $totable = "Bank";

            $dynamicConnectionName = $this->distcode . 'sqlsrv'; // Change this to a unique name
            config(["database.connections.$dynamicConnectionName" => $this->getConnection($this->distcode)[0]]);
            $conn = DB::connection($dynamicConnectionName);


            // Fetch data from remote PostgreSQL database
            $remoteData = DB::connection('pgsql')->table($fromtable)->get();


            // Push fetched data into local MSSQL database
            // 
            $tableExists = Schema::connection($dynamicConnectionName)->hasTable($totable);

            if ($tableExists) {
                // The table exists
                $conn->table($totable)->truncate();
            } else {


                $columns = [
                    'BankId' => 'INT IDENTITY(1,1)  PRIMARY KEY',
                    'BankName' => 'VARCHAR(255)',
                ];

                // Generate the SQL query for creating the table
                $query = "CREATE TABLE $totable (";

                foreach ($columns as $columnName => $columnDefinition) {
                    $query .= "$columnName $columnDefinition, ";
                }
                $query = rtrim($query, ', ') . ")";

                // Execute the query using the specified connection
                $conn->statement($query);
            }


            foreach ($remoteData as $data) {

                $conn->table($totable)->insert([
                    'BankId' => $data->BankId,
                    'BankName' => $data->BankName,
                    // ... map other columns
                ]);
            }
        } catch (\Exception $e) {
            return $e;
        }
    }

    public  function migrateEmpType()
    {
        try {
            $fromtable = "emp_types";
            $totable = "EmpType";

            $dynamicConnectionName = $this->distcode . 'sqlsrv'; // Change this to a unique name
            config(["database.connections.$dynamicConnectionName" => $this->getConnection($this->distcode)[0]]);
            $conn = DB::connection($dynamicConnectionName);
            // Fetch data from remote PostgreSQL database
            $remoteData = DB::connection('pgsql')->table($fromtable)->get();

            // Push fetched data into local MSSQL database
            // 
            $tableExists = Schema::connection($dynamicConnectionName)->hasTable($totable);

            if ($tableExists) {
                // The table exists
                $conn->table($totable)->truncate();
            } else {


                $columns = [
                    'EmpTypeId' => 'INT IDENTITY(1,1)  PRIMARY KEY',
                    'EmpTypeName' => 'VARCHAR(255)',
                ];

                // Generate the SQL query for creating the table
                $query = "CREATE TABLE $totable (";

                foreach ($columns as $columnName => $columnDefinition) {
                    $query .= "$columnName $columnDefinition, ";
                }
                $query = rtrim($query, ', ') . ")";
                // Execute the query using the specified connection
                $conn->statement($query);
            }

            foreach ($remoteData as $data) {

                $conn->table($totable)->insert([
                    'EmpTypeId' => $data->EmpTypeId,
                    'EmpTypeName' => $data->EmpTypeName,
                    // ... map other columns
                ]);
            }
        } catch (\Exception $e) {
            return $e;
        }
    }

    public  function migrateStateMaster()
    {
        try {
            $fromtable = "state_masters";
            $totable = "StateMaster";

            $dynamicConnectionName = $this->distcode . 'sqlsrv'; // Change this to a unique name
            config(["database.connections.$dynamicConnectionName" => $this->getConnection($this->distcode)[0]]);
            $conn = DB::connection($dynamicConnectionName);

            // Fetch data from remote PostgreSQL database
            $remoteData = DB::connection('pgsql')->table($fromtable)->get();

            // Push fetched data into local MSSQL database
            // 
            $tableExists = Schema::connection($dynamicConnectionName)->hasTable($totable);

            if ($tableExists) {
                // The table exists
                $conn->table($totable)->truncate();
            } else {


                $columns = [
                    'id' => 'INT IDENTITY(1,1)  PRIMARY KEY',
                    'statecode' => 'VARCHAR(255)',
                    'StateName' => 'VARCHAR(255)',
                ];

                // Generate the SQL query for creating the table
                $query = "CREATE TABLE $totable (";

                foreach ($columns as $columnName => $columnDefinition) {
                    $query .= "$columnName $columnDefinition, ";
                }
                $query = rtrim($query, ', ') . ")";
                // Execute the query using the specified connection
                $conn->statement($query);
            }

            foreach ($remoteData as $data) {

                $conn->table($totable)->insert([
                    'statecode' => $data->statecode,
                    'StateName' => $data->StateName,
                    // ... map other columns
                ]);
            }
        } catch (\Exception $e) {
            return $e;
        }
    }

    public  function migrateDepartmentMaster($office)
    {
        try {
            $fromtable = "dept_masters";
            $totable = "DeptMaster";

            $dynamicConnectionName = $this->distcode . 'sqlsrv'; // Change this to a unique name
            config(["database.connections.$dynamicConnectionName" => $this->getConnection($this->distcode)[0]]);
            $conn = DB::connection($dynamicConnectionName);

            // Fetch data from remote PostgreSQL database
            $remoteData = DB::connection('pgsql')->table($fromtable)
                ->where('distcode', $office->distcode)
                ->where('deptcode', $office->deptcode)->get();

            // Push fetched data into local MSSQL database

            $tableExists = Schema::connection($dynamicConnectionName)->hasTable($totable);

            if ($tableExists) {
                // The table exists
                $conn->table($totable)->where('distcode', $office->distcode)
                    ->where('deptcode', $office->deptcode)
                    ->delete();
            } else {


                $columns = [
                    //list of columns

                ];

                // Generate the SQL query for creating the table
                $query = "CREATE TABLE $totable (";

                foreach ($columns as $columnName => $columnDefinition) {
                    $query .= "$columnName $columnDefinition, ";
                }
                $query = rtrim($query, ', ') . ")";
                // Execute the query using the specified connection
                $conn->statement($query);
            }

            foreach ($remoteData as $data) {

                $conn->table($totable)->insert([
                    'distcode' => $data->distcode,
                    'deptcode' => $data->deptcode,
                    'deptname' => $data->deptname,
                    'address' =>  $data->address,
                    'CentreState' =>  $data->CentreState,
                    'included' => $data->included,
                    'catcode' => $data->catcode,
                    'IncludedMo' => $data->IncludedMo,
                    'IncludedCP' => $data->IncludedCP,
                    'deptcodekey' => $data->deptcodekey,
                    'IncludedContractual' => $data->IncludedContractual,
                    'hrmsdata'=>$data->hrmsdata,
                ]);
            }
        } catch (\Exception $e) {
            return $e;
        }
    }

    public  function migrateSubDepartmentMaster($office)
    {
        try {
            $fromtable = "subdept_masters";
            $totable = "subdeptmaster";

            $dynamicConnectionName = $this->distcode . 'sqlsrv'; // Change this to a unique name
            config(["database.connections.$dynamicConnectionName" => $this->getConnection($this->distcode)[0]]);
            $conn = DB::connection($dynamicConnectionName);

            // Fetch data from remote PostgreSQL database
            $remoteData = DB::connection('pgsql')->table($fromtable)
                ->where('distcode', $office->distcode)
                ->where('deptcode', $office->deptcode)
                ->where('subdeptcode', $office->subdeptcode)->get();

            // Push fetched data into local MSSQL database

            $tableExists = Schema::connection($dynamicConnectionName)->hasTable($totable);

            if ($tableExists) {
                // The table exists
                $conn->table($totable)->where('distcode', $office->distcode)
                    ->where('deptcode', $office->deptcode)
                    ->where('subdeptcode', $office->subdeptcode)->delete();
            } else {


                $columns = [
                    //list of columns
                ];

                // Generate the SQL query for creating the table
                $query = "CREATE TABLE $totable (";

                foreach ($columns as $columnName => $columnDefinition) {
                    $query .= "$columnName $columnDefinition, ";
                }
                $query = rtrim($query, ', ') . ")";
                // Execute the query using the specified connection
                $conn->statement($query);
            }

            foreach ($remoteData as $data) {

                $conn->table($totable)->insert([
                    'distcode' => $data->distcode,
                    'deptcode' => $data->deptcode,
                    'subdeptcode' => $data->subdeptcode,
                    'subdept' =>  $data->subdept,
                    'address' =>  $data->address,
                    'subdeptcodekey' => $data->subdeptcodekey,
                    'distcode_from' => $data->distcode_from,
                    'hrmsdata'=>$data->hrmsdata,
                ]);
            }
        } catch (\Exception $e) {
            return $e;
        }
    }
    public  function migrateOfficeMaster($office)
    {
        try {
            $fromtable = "office_masters";
            $totable = "officemaster";

            $dynamicConnectionName = $this->distcode . 'sqlsrv'; // Change this to a unique name
            config(["database.connections.$dynamicConnectionName" => $this->getConnection($this->distcode)[0]]);
            $conn = DB::connection($dynamicConnectionName);

            // Fetch data from remote PostgreSQL database
            $remoteData = DB::connection('pgsql')->table($fromtable)
                ->where('distcode', $office->distcode)
                ->where('deptcode', $office->deptcode)
                ->where('subdeptcode', $office->subdeptcode)
                ->where('officecode', $office->officecode)->get();

            // Push fetched data into local MSSQL database

            $tableExists = Schema::connection($dynamicConnectionName)->hasTable($totable);

            if ($tableExists) {
                // The table exists
                $conn->table($totable)->where('distcode', $office->distcode)
                    ->where('deptcode', $office->deptcode)
                    ->where('subdeptcode', $office->subdeptcode)
                    ->where('officecode', $office->officecode)->delete();
            } else {


                $columns = [
                    //list of columns
                ];

                // Generate the SQL query for creating the table
                $query = "CREATE TABLE $totable (";

                foreach ($columns as $columnName => $columnDefinition) {
                    $query .= "$columnName $columnDefinition, ";
                }
                $query = rtrim($query, ', ') . ")";
                // Execute the query using the specified connection
                $conn->statement($query);
            }

            foreach ($remoteData as $data) {

                $conn->table($totable)->insert([
                    'distcode' => $data->distcode,
                    'deptcode' => $data->deptcode,
                    'officecode' => $data->officecode,
                    'office' => $data->office,
                    'address' => $data->address,
                    'sno' => $data->sno,
                    'subdeptcode' =>  $data->subdeptcode,
                    'officecodekey' =>  $data->officecodekey,
                    'subdeptcodekey' => $data->subdeptcodekey,
                    'distcode_from' => $data->distcode_from,
                    'hrmsdata'=>$data->hrmsdata,
                    // 'EmailID' => $data->EmailID
                ]);
            }
        } catch (\Exception $e) {
            return $e;
        }
    }
    public  function migrateDesignationMaster($office)
    {
        try {
            $fromtable = "designation_masters";
            $totable = "Designation";

            $dynamicConnectionName = $this->distcode . 'sqlsrv'; // Change this to a unique name
            config(["database.connections.$dynamicConnectionName" => $this->getConnection($this->distcode)[0]]);
            $conn = DB::connection($dynamicConnectionName);

            // Fetch data from remote PostgreSQL database
            $remoteData = DB::connection('pgsql')->table($fromtable)
                ->where('distcode', $office->distcode)->get();

            // Push fetched data into local MSSQL database

            $tableExists = Schema::connection($dynamicConnectionName)->hasTable($totable);

            if ($tableExists) {
                // The table exists
                $conn->table($totable)->where('distcode', $office->distcode)->delete();
            } else {


                $columns = [
                    //list of columns
                ];

                // Generate the SQL query for creating the table
                $query = "CREATE TABLE $totable (";

                foreach ($columns as $columnName => $columnDefinition) {
                    $query .= "$columnName $columnDefinition, ";
                }
                $query = rtrim($query, ', ') . ")";
                // Execute the query using the specified connection
                $conn->statement($query);
            }

            foreach ($remoteData as $data) {

                $conn->table($totable)->insert([
                    'distcode' => $data->distcode,
                    'DesigCode' => $data->DesigCode,
                    'Designation' => $data->Designation,
                    'class' => $data->class,
                    'SelectedCP' => $data->SelectedCP,
                    'desigcodekey' => $data->desigcodekey,
                    'distcode_from' =>  $data->distcode_from,
                    'IncludedContractual' =>  $data->IncludedContractual,
                    'hrmsdata'=>$data->hrmsdata,

                ]);
            }
        } catch (\Exception $e) {
            return $e;
        }
    }
    public  function migratePayScaleMaster($office)
    {
        try {
            $fromtable = "pay_scales";
            $totable = "PayScale";

            $dynamicConnectionName = $this->distcode . 'sqlsrv'; // Change this to a unique name
            config(["database.connections.$dynamicConnectionName" => $this->getConnection($this->distcode)[0]]);
            $conn = DB::connection($dynamicConnectionName);

            // Fetch data from remote PostgreSQL database
            $remoteData = DB::connection('pgsql')->table($fromtable)
                ->where('distcode', $office->distcode)->get();

            // Push fetched data into local MSSQL database

            $tableExists = Schema::connection($dynamicConnectionName)->hasTable($totable);

            if ($tableExists) {
                // The table exists
                $conn->table($totable)->where('distcode', $office->distcode)->delete();
            } else {


                $columns = [
                    //list of columns
                ];

                // Generate the SQL query for creating the table
                $query = "CREATE TABLE $totable (";

                foreach ($columns as $columnName => $columnDefinition) {
                    $query .= "$columnName $columnDefinition, ";
                }
                $query = rtrim($query, ', ') . ")";
                // Execute the query using the specified connection
                $conn->statement($query);
            }

            foreach ($remoteData as $data) {

                $conn->table($totable)->insert([
                    'distcode' => $data->distcode,
                    'PayScaleCode' => $data->PayScaleCode,
                    'PayScale' => $data->PayScale,
                    'class' => $data->class,

                ]);
            }
        } catch (\Exception $e) {
            return $e;
        }
    }
    public  function migrateConsList($office)
    {
        try {
            $fromtable = "cons_lists";
            $totable = "cons_list";

            $dynamicConnectionName = $this->distcode . 'sqlsrv'; // Change this to a unique name
            config(["database.connections.$dynamicConnectionName" => $this->getConnection($this->distcode)[0]]);
            $conn = DB::connection($dynamicConnectionName);

            // Fetch data from remote PostgreSQL database
            $remoteData = DB::connection('pgsql')->table($fromtable)
                ->get();

            // Push fetched data into local MSSQL database

            $tableExists = Schema::connection($dynamicConnectionName)->hasTable($totable);

            if ($tableExists) {
                // The table exists
                $conn->table($totable)->delete();
            } else {


                $columns = [
                    //list of columns
                ];

                // Generate the SQL query for creating the table
                $query = "CREATE TABLE $totable (";

                foreach ($columns as $columnName => $columnDefinition) {
                    $query .= "$columnName $columnDefinition, ";
                }
                $query = rtrim($query, ', ') . ")";
                // Execute the query using the specified connection
                $conn->statement($query);
            }

            foreach ($remoteData as $data) {

                $conn->table($totable)->insert([
                    'ST_CODE' => $data->ST_CODE,
                    'Division_No' => $data->Division_No,
                    'distCode' => $data->distCode,
                    'AC_NO' => $data->AC_NO,
                    'AC_NAME' => $data->AC_NAME,
                    'AC_TYPE' => $data->AC_TYPE,
                    'PC_NO' => $data->PC_NO,

                ]);
            }
        } catch (\Exception $e) {
            return $e;
        }
    }
    public  function migrateConsDist($office)
    {
        try {
            $fromtable = "cons_dists";
            $totable = "cons_dist";

            $dynamicConnectionName = $this->distcode . 'sqlsrv'; // Change this to a unique name
            config(["database.connections.$dynamicConnectionName" => $this->getConnection($this->distcode)[0]]);
            $conn = DB::connection($dynamicConnectionName);

            // Fetch data from remote PostgreSQL database
            $remoteData = DB::connection('pgsql')->table($fromtable)
                ->where('distcode', $office->distcode)->get();

            // Push fetched data into local MSSQL database

            $tableExists = Schema::connection($dynamicConnectionName)->hasTable($totable);

            if ($tableExists) {
                // The table exists
                $conn->table($totable)->where('distcode', $office->distcode)->delete();
            } else {


                $columns = [
                    //list of columns
                ];

                // Generate the SQL query for creating the table
                $query = "CREATE TABLE $totable (";

                foreach ($columns as $columnName => $columnDefinition) {
                    $query .= "$columnName $columnDefinition, ";
                }
                $query = rtrim($query, ', ') . ")";
                // Execute the query using the specified connection
                $conn->statement($query);
            }

            foreach ($remoteData as $data) {

                $conn->table($totable)->insert([
                    'distcode' => $data->distcode,
                    'ac_no' => $data->ac_no,
                    'ac_name' => $data->ac_name,
                    'admincontrol' => $data->admincontrol,
                    'admindistcode' => $data->admindistcode,
                    'innerpcircle' => $data->innerpcircle,
                    'innerpcirclef' => $data->innerpcirclef,
                    'startpartyno' => $data->startpartyno,
                    'locpartyno' => $data->locpartyno,
                    'mostartpartyno' => $data->mostartpartyno,
                    'molocpartyno' => $data->molocpartyno,
                    'mosurplus' => $data->mosurplus,
                    'del' => $data->del,
                ]);
            }
        } catch (\Exception $e) {
            return $e;
        }
    }
    public  function migrateElectionInfo($office)
    {
        try {
            $fromtable = "election_infos";
            $totable = "ElectionInfo";

            $dynamicConnectionName = $this->distcode . 'sqlsrv'; // Change this to a unique name
            config(["database.connections.$dynamicConnectionName" => $this->getConnection($this->distcode)[0]]);
            $conn = DB::connection($dynamicConnectionName);

            // Fetch data from remote PostgreSQL database
            $remoteData = DB::connection('pgsql')->table($fromtable)
                ->where('Distcode', $office->distcode)->get();

            // Push fetched data into local MSSQL database

            $tableExists = Schema::connection($dynamicConnectionName)->hasTable($totable);

            if ($tableExists) {
                // The table exists
                $conn->table($totable)->where('Distcode', $office->distcode)->delete();
            } else {


                $columns = [
                    //list of columns
                ];

                // Generate the SQL query for creating the table
                $query = "CREATE TABLE $totable (";

                foreach ($columns as $columnName => $columnDefinition) {
                    $query .= "$columnName $columnDefinition, ";
                }
                $query = rtrim($query, ', ') . ")";
                // Execute the query using the specified connection
                $conn->statement($query);
            }

            foreach ($remoteData as $data) {

                $conn->table($totable)->insert([
                    'Distcode' => $data->Distcode,
                    'DCName' => $data->DCName,
                    'pBooths' => $data->pBooths,
                    'ElectionDate' => $data->ElectionDate,
                    'ElectionStartTime' => $data->ElectionStartTime,
                    'ElectionEndTime' => $data->ElectionEndTime,
                    'AssemblyElection' => $data->AssemblyElection,
                    'ParliamentaryElection' => $data->ParliamentaryElection,
                    'installed' => $data->installed,
                    'Electionname' => $data->Electionname,
                    'pc_no' => $data->pc_no,

                ]);
            }
        } catch (\Exception $e) {
            return $e;
        }
    }
    public  function migrateBoothLocation($office)
    {
        try {
            $fromtable = "booth_locns";
            $totable = "Booths_Locn";

            $dynamicConnectionName = $this->distcode . 'sqlsrv'; // Change this to a unique name
            config(["database.connections.$dynamicConnectionName" => $this->getConnection($this->distcode)[0]]);
            $conn = DB::connection($dynamicConnectionName);

            // Fetch data from remote PostgreSQL database
            $remoteData = DB::connection('pgsql')->table($fromtable)
                ->where('DISTCODE', $office->distcode)->get();

            // Push fetched data into local MSSQL database

            $tableExists = Schema::connection($dynamicConnectionName)->hasTable($totable);

            if ($tableExists) {
                // The table exists
                $conn->table($totable)->where('DISTCODE', $office->distcode)->delete();
            } else {


                $columns = [
                    //list of columns
                ];

                // Generate the SQL query for creating the table
                $query = "CREATE TABLE $totable (";

                foreach ($columns as $columnName => $columnDefinition) {
                    $query .= "$columnName $columnDefinition, ";
                }
                $query = rtrim($query, ', ') . ")";
                // Execute the query using the specified connection
                $conn->statement($query);
            }

            foreach ($remoteData as $data) {

                $conn->table($totable)->insert([
                    'DISTCODE' => $data->DISTCODE,
                    'CONSCODE' => $data->CONSCODE,
                    'PS_LOCN_NO' => $data->PS_LOCN_NO,
                    'LOCN_BLDG_EN' => $data->LOCN_BLDG_EN,
                    'TOTAL_PS' => $data->TOTAL_PS,
                    'LOCN_CATY' => $data->LOCN_CATY,
                    'URBAN' => $data->URBAN,
                    'DISTCODE_FROM' => $data->DISTCODE_FROM,
                    'DEL' => $data->DEL,
                    'PS_LOCN_NO_KEY' => $data->PS_LOCN_NO_KEY,
                ]);
            }
        } catch (\Exception $e) {
            return $e;
        }
    }

    public  function migrateBoothStation($office)
    {
        try {
            $fromtable = "booths";
            $totable = "booths";

            $dynamicConnectionName = $this->distcode . 'sqlsrv'; // Change this to a unique name
            config(["database.connections.$dynamicConnectionName" => $this->getConnection($this->distcode)[0]]);
            $conn = DB::connection($dynamicConnectionName);

            // Fetch data from remote PostgreSQL database
            $remoteData = DB::connection('pgsql')->table($fromtable)
                ->where('DISTCODE', $office->distcode)->get();

            // Push fetched data into local MSSQL database

            $tableExists = Schema::connection($dynamicConnectionName)->hasTable($totable);

            if ($tableExists) {
                // The table exists
                $conn->table($totable)->where('distcode', $office->distcode)->delete();
            } else {


                $columns = [
                    //list of columns
                ];

                // Generate the SQL query for creating the table
                $query = "CREATE TABLE $totable (";

                foreach ($columns as $columnName => $columnDefinition) {
                    $query .= "$columnName $columnDefinition, ";
                }
                $query = rtrim($query, ', ') . ")";
                // Execute the query using the specified connection
                $conn->statement($query);
            }

            foreach ($remoteData as $data) {

                $conn->table($totable)->insert([
                    'distcode' => $data->DISTCODE,
                    'boothno' => $data->BOOTHNO,
                    'boothnoA' => $data->BOOTHNOA,
                    'consCode' => $data->CONSCODE,
                    'village' => $data->VILLAGE,
                    'PollBuild' => $data->POLLBUILD,
                    'PollArea' => $data->POLLAREA,
                    'Type' => $data->TYPE,
                    'TotalVote' => $data->TOTALVOTE,
                    'MaleVote' => $data->MALEVOTE,
                    'FemaleVote' => $data->FEMALEVOTE,
                    'Urban' => $data->URBAN,
                    'femaleparty' => $data->FEMALEPARTY,
                    'noofofficer' => $data->NOOFOFFICER,
                    'rno' => $data->RNO,
                    'processed' => $data->PROCESSED,
                    'pardanashin' => $data->PARDANASHIN,
                    'cuno' => $data->CUNO,
                    'buno' => $data->BUNO,
                    'cuno1' => $data->CUNO1,
                    'buno1' => $data->BUNO1,
                    'morequired' => $data->MOREQUIRED,
                    'moprocessed' => $data->MOPROCESSED,
                    'ps_locn_no' => $data->PS_LOCN_NO,
                    'phone' => $data->PHONE,
                    'distcode_from' => $data->DISTCODE_FROM,
                    'del' => $data->DEL,
                    'ps_locn_no_key' => $data->PS_LOCN_NO_KEY,
                    'ps_id' => $data->PS_ID,
                    'OtherVote' => $data->OtherVote,
                ]);
            }
        } catch (\Exception $e) {
            return $e;
        }
    }
    public  function migratePollingData($office)
    {
        try {
            $fromtable = "polling_data";
            $totable = "Polling_Data";

            $dynamicConnectionName = $this->distcode . 'sqlsrv'; // Change this to a unique name
            config(["database.connections.$dynamicConnectionName" => $this->getConnection($this->distcode)[0]]);
            $conn = DB::connection($dynamicConnectionName);

            // Fetch data from remote PostgreSQL database
            $remoteData = DB::connection('pgsql')->table($fromtable)
                ->where('distcode', $office->distcode)
                ->where('deptcode', $office->deptcode)
                ->where('officecode', $office->officecode)->get();
            
            // Push fetched data into local MSSQL database

            $tableExists = Schema::connection($dynamicConnectionName)->hasTable($totable);

            if ($tableExists) {
                // The table exists
                $conn->table($totable)->where('distcode', $office->distcode)
                    ->where('deptcode', $office->deptcode)
                    ->where('officecode', $office->officecode)->delete();
            } else {


                $columns = [
                    //list of columns
                ];

                // Generate the SQL query for creating the table
                $query = "CREATE TABLE $totable (";

                foreach ($columns as $columnName => $columnDefinition) {
                    $query .= "$columnName $columnDefinition, ";
                }
                $query = rtrim($query, ', ') . ")";
                // Execute the query using the specified connection
                $conn->statement($query);
            }
            $x["p"] = 0;
            foreach ($remoteData as $data) {
                $conn->table($totable)->insert([
                    'distcode' => $data->distcode,
                    'class' => $data->class,
                    'Name' => $data->Name,
                    'FName' => $data->FName,
                    'rAddress' => $data->rAddress,
                    'HomeCons' => $data->HomeCons,
                    'cons' => $data->cons,
                    'PayScaleCode' => $data->PayScaleCode,
                    'basicPay' => $data->basicPay,
                    'office' => $data->office,
                    'category' => $data->category,
                    'DesigCode' => $data->DesigCode,
                    'excercisedElectionDuty' => $data->excercisedElectionDuty,
                    'longLeave' => $data->longLeave,
                    'handicap' => $data->handicap,
                    'Remarks' => $data->Remarks,
                    'sex' => $data->sex,
                    'del' => $data->del,
                    'dt' => $data->dt,
                    'deptcode' => $data->deptcode,
                    'officecode' => $data->officecode,
                    'cons_alot' => $data->cons_alot,
                    'nativecon' => $data->nativecon,
                    'mobileno' => $data->mobileno,
                    'emailid' => $data->emailid,
                    'dob' => $data->dob,
                    'retiredt' => $data->retiredt,
                    'deptslno' => $data->deptslno,
                    'AadhaarNo' => $data->AadhaarNo,
                    'BankId' => $data->BankId,
                    'BankAcNo' => $data->BankAcNo,
                    'IfscCode' => $data->IfscCode,
                    'EmpTypeId' => $data->EmpTypeId,
                    'ddocode' => $data->ddocode,
                    'hrmscode' => $data->hrmscode,
                    'hrmsdata'=>$data->hrmsdata,
                    'ifmscode' => $data->ifmscode,
                    'id' => $data->photoid,

                ]);
                $x["p"]++;
                
                 $e = $this->migratePollingDataPhoto($data);
                 if ($e) throw $e;
            }
            
             $x["per"] = $x["p"] * 100 / count($remoteData);
            return $x;
        } catch (\Exception $e) {
            dd($e);
            return $e;
        }
    }
    //internal function for porting of photo data
    public  function migratePollingDataPhoto($person)
    {
        try {
            $fromtable = "polling_data_photos";
            $totable = "Polling_Data_Photo";

            $dynamicConnectionName = $this->distcode . 'sqlsrv'; // Change this to a unique name
            config(["database.connections.$dynamicConnectionName" => $this->getConnection($this->distcode)[0]]);
            $conn = DB::connection($dynamicConnectionName);

            // Fetch data from remote PostgreSQL database
            $remoteData = DB::connection('pgsql')->table($fromtable)
                ->where('id', $person->photoid)->get();

            // Push fetched data into local MSSQL database

            $tableExists = Schema::connection($dynamicConnectionName)->hasTable($totable);

            if ($tableExists) {
                // The table exists
                 $conn->table($totable)->where('id',$person->photoid)->delete();
            } else {


                $columns = [
                    //list of columns
                ];

                // Generate the SQL query for creating the table
                $query = "CREATE TABLE $totable (";

                foreach ($columns as $columnName => $columnDefinition) {
                    $query .= "$columnName $columnDefinition, ";
                }
                $query = rtrim($query, ', ') . ")";
                // Execute the query using the specified connection
                $conn->statement($query);
            }

            foreach ($remoteData as $data) {
                $binaryImageData =base64_decode(stream_get_contents($data->empphoto));
                $hexImageData = bin2hex($binaryImageData);
                $msQuery = "INSERT INTO ".$totable." (id,empphoto,deptslno,PhotoFlag) VALUES ('$data->id',CONVERT(varbinary(max), 0x$hexImageData),'$data->deptslno','$data->PhotoFlag')";
                $conn->statement($msQuery);
            }
        } catch (\Exception $e) {
            return $e;
        }
    }

    public function migrateCompleteData($office)
    {

        try {
        
            /************ Bank **************** */
            $x = $this->migrateBank();
            if ($x)  throw $x;
           

            /************ EmpType ****************/
            $x = $this->migrateEmpType();
            if ($x)  throw $x;
           

            /************ Dept_masters ****************/
            $x = $this->migrateDepartmentMaster($office);
            if ($x)  throw $x;
            

            /************ SubDept_masters ****************/
            $x = $this->migrateSubDepartmentMaster($office);
            if ($x)  throw $x;
           

            /************ office_masters ****************/
            $x = $this->migrateOfficeMaster($office);
            if ($x)  throw $x;
            

            /************ designation_masters ****************/
            $x = $this->migrateDesignationMaster($office);
            if ($x)  throw $x;
           

            /************ Pay Scales ****************/
            $x = $this->migratePayScaleMaster($office);
            if ($x)  throw $x;
            

            /************ Cons List ****************/
            $x = $this->migrateConslist($office);
            if ($x)  throw $x;
            

            /************ Cons Dist ****************/
            $x = $this->migrateConsDist($office);
            if ($x)  throw $x;
           

            /************ election_infos ****************/
            $x = $this->migrateElectionInfo($office);
            if ($x)  throw $x;
           

            /************ Booth Locations ****************/
            $x = $this->migrateBoothLocation($office);
            if ($x)  throw $x;
           

            /************ Booth Stations ****************/
            $x = $this->migrateBoothStation($office);
            if ($x)  throw $x;
            

            /************ Polling Data ****************/
            $x = $this->migratePollingData($office);
            // throw new Exception("Something went wrong!");
            if (isset($x["per"])) {
                $this->progress = $x["per"];
            } else 
            if ($x)  throw $x;
            
           
        } catch (\Exception $e) {

            return array("code" => 404, "msg" => $e->getMessage());
        }
        return array("code" => 200, "msg" => "Data migration Completed", "count" => $x["p"] ?? 0);
    }
}
