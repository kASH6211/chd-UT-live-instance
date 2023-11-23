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
        Schema::create('pro_apro_blo__mobile_no_masters', function (Blueprint $table) {
            
            $table->string('id',14)->primary();
            $table->string('MobileNo',10);
            $table->string('Name',60)->nullable();
            $table->foreign('id')->references('photoid')->on('polling_data')->onDelete('restrict');

            $table->string('Desig',60)->nullable();
            $table->string('ElectDuty',20)->nullable();
            $table->integer('DistCode');
            $table->integer('ConsCode');
            
            $table->string('BoothNo',3);
            $table->foreign(['DistCode', 'ConsCode','BoothNo'])
            ->references(['DISTCODE', 'CONSCODE','BOOTHNO'])
            ->on('booths');
            $table->string('BoothNoA',1)->nullable();
            $table->datetime('DataEntryDate')->nullable();
            $table->string('del',1)->nullable();
            $table->string('ps_id',9)->nullable();
            $table->integer('DeptSlNo')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pro_apro_blo__mobile_no_masters');
    }
};
