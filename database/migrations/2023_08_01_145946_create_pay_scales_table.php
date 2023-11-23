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
        Schema::create('pay_scales', function (Blueprint $table) {
            $table->id();
            $table->integer('distcode');
            $table->foreign('distcode')->references('DistCode')->on('dist_masters')->onDelete('restrict');
            $table->integer('PayScaleCode');
            $table->unique(['distcode','PayScaleCode']);
            $table->string('PayScale',50);
            $table->smallInteger('class');
            $table->integer('hrmsdata')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pay_scales');
    }
};
