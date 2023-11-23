<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('polling_data', function (Blueprint $table) {
            $table->id();
            $table->integer('distcode');
            $table->foreign('distcode')->references('DistCode')->on('dist_masters')->onDelete('restrict');
            //$table->integer('rno')->nullable();
            $table->smallInteger('class')->nullable();
            $table->foreign('class')->references('class')->on('class_masters')->onDelete('restrict');
            $table->string('Name',60)->nullable();  
            $table->string('FName',60)->nullable();
            $table->string('rAddress',60)->nullable();
            $table->integer('HomeCons')->nullable();
            $table->foreign('HomeCons')->references('AC_NO')->on('cons_lists')->onDelete('restrict');
            $table->integer('cons')->nullable();
            $table->foreign('cons')->references('AC_NO')->on('cons_lists')->onDelete('restrict');
            $table->integer('PayScaleCode')->nullable();
            $table->foreign(['distcode','PayScaleCode'])->references(['distcode','PayScaleCode'])->on('pay_scales')->onDelete('restrict');
            $table->integer('basicPay')->nullable();
            $table->string('office',60)->nullable();
            $table->string('category',1)->nullable();
            $table->integer('DesigCode')->nullable();
            $table->foreign(['distcode', 'DesigCode'])->references(['distcode', 'DesigCode'])->on('designation_masters')->onDelete('restrict');
            // $table->string('SpouseWorking',1)->nullable();
            $table->string('excercisedElectionDuty',20)->nullable();
            $table->string('longLeave',1)->nullable();
            $table->string('handicap',1)->nullable();
            // $table->string('DOR',1)->nullable();
            // $table->string('BLO',1)->nullable();
            $table->string('Remarks',60)->nullable();
            // $table->string('id',14);
            // $table->string('login',50)->nullable();
            $table->string('sex',1)->nullable();
            $table->string('del',1)->nullable();
            $table->dateTime('dt')->nullable();
            $table->string('deptcode',4)->nullable();
            $table->foreign(['distcode', 'deptcode'])->references(['distcode', 'deptcode'])->on('dept_masters')->onDelete('restrict');
            $table->string('officecode',4)->nullable();
            $table->foreign(['distcode','deptcode','officecode'])->references(['distcode','deptcode', 'officecode'])->on('office_masters')->onDelete('restrict');
           // $table->integer('PartyNo')->nullable();
            //$table->string('POSNo',4)->nullable();
            //$table->string('reserve',1)->nullable();
            $table->integer('cons_alot')->nullable();
            //$table->string('StateCentre',1)->nullable();
            //$table->string('sendtoother',1)->nullable();
            //$table->integer('sendreceivedist')->nullable(); 
            //$table->integer('oldrno')->nullable();
            //$table->integer('newpartyno')->nullable();
            //$table->string('selected',1)->nullable();
            $table->integer('nativecon')->nullable();
            $table->string('transferred','1')->nullable();
            //$table->integer('letterno');
            $table->string('epicno',50)->nullable();
            //$table->integer('centrecode')->nullable();  
            $table->string('mobileno',15)->nullable();
            $table->string('emailid',100)->nullable();
            $table->string('serialno',20)->nullable();
            $table->string('partno',20)->nullable();        
            //$table->string('pan',20)->nullable();
            $table->date('dob')->nullable();
            $table->date('retiredt')->nullable();
            $table->integer('deptslno')->nullable();
            //$table->string('exportdata',1)->nullable();
            //$table->integer('lotno')->nullable();
            //$table->string('MachineSerialNumber',50)->nullable();
            //$table->string('MachineName',50)->nullable();
            //$table->string('ProcessorID',50)->nullable();
            //$table->dateTime('DataImportDate')->nullable();
            $table->integer('RegdVoterCons')->nullable();
            $table->string('AadhaarNo',12)->nullable();
            //$table->string('EpicName',60)->nullable();
            //$table->string('EpicFhName',60)->nullable();
            //$table->string('EpicAadhaarNo',12)->nullable();
            $table->integer('BankId')->nullable();
            $table->string('BankAcNo',20)->nullable();
            $table->string('IfscCode',20)->nullable();      
            $table->integer('EmpTypeId')->nullable();
            $table->string('ddocode',12)->nullable();
            $table->string('hrmscode',6)->nullable();
            $table->string('ifmscode',16)->nullable();
            $table->string('photoid',14)->unique();
            $table->unique(['Name', 'FName','dob','DesigCode'],'unique_column_name_case_insensitive');
            $table->integer('hrmsdata')->default(0);
            $table->integer('completed')->default(0);
            $table->index(['distcode','deptcode','officecode']);
            $table->index(['hrmscode']);
            
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('polling_data');
    }
};
