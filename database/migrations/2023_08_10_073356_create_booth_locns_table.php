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
        Schema::create('booth_locns', function (Blueprint $table) {
            $table->id();
            $table->integer('DISTCODE');
            $table->integer('CONSCODE');
            $table->integer('PS_LOCN_NO');
            //$table->foreign('DISTCODE')->references('DistCode')->on('dist_masters')->onDelete('restrict');
            
            $table->foreign(['DISTCODE','CONSCODE'])
            ->references(['distcode','ac_no'])
            ->on('cons_dists');          
            $table->unique(['DISTCODE', 'CONSCODE','PS_LOCN_NO']);
            $table->string('LOCN_BLDG_EN',150)->nullable();
            $table->integer('TOTAL_PS')->nullable();
            $table->string('LOCN_CATY',1)->nullable();
            $table->boolean('URBAN')->nullable();
            $table->integer('DISTCODE_FROM')->nullable();
            $table->string('DEL',1)->nullable();
            $table->string('PS_LOCN_NO_KEY',11)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('booth_locns');
    }
};
