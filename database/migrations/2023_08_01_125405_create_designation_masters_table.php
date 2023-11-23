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
        Schema::create('designation_masters', function (Blueprint $table) {
            $table->id();
            $table->integer('distcode');
            $table->foreign('distcode')->references('DistCode')->on('dist_masters')->onDelete('restrict');
            $table->integer('DesigCode');
            $table->string('Designation',50);
            $table->unique(['distcode', 'DesigCode']);
            $table->smallInteger('class');
            $table->string('SelectedCP',1);
            $table->foreign('SelectedCP')->references('code')->on('selected_c_p_masters')->onDelete('restrict');
            $table->string('desigcodekey',6);
            $table->integer('distcode_from');
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
        Schema::dropIfExists('designation_masters');
    }
};
