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
        Schema::create('dept_masters', function (Blueprint $table) {
            $table->id();
            $table->integer('distcode');
            $table->foreign('distcode')->references('DistCode')->on('dist_masters')->onDelete('restrict');
            $table->string('deptcode',4);
            $table->unique(['distcode', 'deptcode']);
            $table->string('deptname',60);
            $table->string('address',60);
            $table->string('CentreState',1);
            $table->string('included',1)->default('Y');
            $table->integer('catcode');
            $table->foreign('catcode')->references('catcode')->on('dept_categs')->onDelete('restrict');
           
            $table->string('IncludedMo',1)->nullable();
            $table->string('IncludedCP',1)->nullable();
            $table->string('deptcodekey',6);
            $table->string('IncludedContractual',1)->nullable();
            $table->integer('hrmsdata')->default(0);
            $table->softDeletes();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dept_masters');
    }
};
