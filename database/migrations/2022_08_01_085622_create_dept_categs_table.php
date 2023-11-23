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
        Schema::create('dept_categs', function (Blueprint $table) {
            $table->id();
            $table->integer('catcode')->unique();
            $table->string('category',50);
            $table->string('centrestate',1);
            $table->integer('CatAge');


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dept_categs');
    }
};
