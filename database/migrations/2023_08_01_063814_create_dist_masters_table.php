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
        Schema::create('dist_masters', function (Blueprint $table) {
            $table->id();
            $table->string('st_Code',4);
              $table->foreign('st_Code')->references('statecode')->on('state_masters')->onDelete('restrict');
            
            $table->integer('Division_No')->nullable();
            $table->integer('DistCode')->unique();
            //$table->unique(['st_Code', 'DistCode']);
            $table->string('DistName',60);
            $table->integer('pBooths')->nullable();
            $table->string('ActiveStatus',1);
            $table->string('finalcircle',60)->nullable();;
            $table->integer('o_id')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dist_masters');
    }
};
