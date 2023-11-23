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
        Schema::create('cons_lists', function (Blueprint $table) {
            $table->id();
            $table->string('ST_CODE',3);
            
            $table->integer('Division_No')->nullable();
            $table->integer('distCode');
            $table->integer('AC_NO')->unique();
            $table->string('AC_NAME',25);
            $table->integer('AC_TYPE');
            $table->integer('PC_NO');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cons_lists');
    }
};
