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
        Schema::create('office_locks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('office_id')->constrained('office_masters')->onDelete('restrict')->comment('office  has lock info first remove lock');
            //$table->foreignId('distcode')->constrained('dist_masters')->onDelete('restrict')->comment('District  has lock info first remove lock');
            $table->integer('distcode');
            $table->foreign('distcode')->references('DistCode')->on('dist_masters')->onDelete('restrict')->comment('District  has lock info first remove lock');
            
            $table->integer("imported")->default(0);
            $table->integer("finalized")->default(0);
            $table->integer("employeesfinalized")->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('office_locks');
    }
};
