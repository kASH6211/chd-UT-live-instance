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
        Schema::create('cons_dists', function (Blueprint $table) {
            $table->id();
            $table->integer('distcode');
            $table->foreign('distcode')->references('DistCode')->on('dist_masters')->onDelete('restrict');
            $table->integer('ac_no');
            $table->unique(['distcode','ac_no']);
            $table->string('ac_name',25);
            $table->string('admincontrol',1)->default('0');
            $table->integer('admindistcode')->default(0);
            $table->string('innerpcircle',50)->nullable();
            $table->string('innerpcirclef',50)->nullable();
            $table->integer('startpartyno')->default(1);
            $table->integer('locpartyno')->nullable();
            $table->integer('mostartpartyno')->default(1);
            $table->integer('molocpartyno')->nullable();
            $table->integer('mosurplus')->nullable();
            $table->string('del',1)->default('o');
            
           
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cons_dists');
    }
};
