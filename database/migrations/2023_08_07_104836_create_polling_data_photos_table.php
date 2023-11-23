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
        Schema::create('polling_data_photos', function (Blueprint $table) {
            $table->string('id',14)->unique();
            $table->binary('empphoto');
            $table->integer('deptslno')->nullable();
            $table->string('PhotoFlag',1)->nullable();
            $table->foreign('id')->references('photoid')->on('polling_data')->onDelete('restrict');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('polling_data_photos');
    }
};
