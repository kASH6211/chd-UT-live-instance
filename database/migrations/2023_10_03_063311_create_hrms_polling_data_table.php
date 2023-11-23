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
        Schema::create('hrms_polling_data', function (Blueprint $table) {
            $table->string('HRMSCODE',60);
            $table->string('NAME',60);
            $table->string('FATHER_HUSBAND',60);
            $table->string('DOB',60);
            $table->string('DOR',60);
            $table->string('DEPTCODE',60);
            $table->string('OFFICECODE',60);
            $table->string('DESIGCODE',60);
            $table->string('GENDER',60);
            $table->string('CLASS',60);
            $table->string('PAYLEVEL',60);
            $table->string('BASICPAY',60);
            $table->string('OFFICENAME',200);
            $table->string('DISTRICT',60);
            $table->string('DISTCODE',60);
            $table->string('MOBILE',60);
            $table->string('EMAIL',60);
            $table->string('BANKNAME',60);
            $table->string('IFSCCODE',60);
            $table->string('ACCOUNTNO',60);
            $table->string('STATUS',60);
            $table->string('EMPLOYEETYPE',60);
            $table->string('DDO_CODE',60);
            $table->string('IFMSPAYEECODE',60);
            $table->string('HANDICAPPED',60);
            $table->string('ONLEAVE',60);
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hrms_polling_data');
    }
};
