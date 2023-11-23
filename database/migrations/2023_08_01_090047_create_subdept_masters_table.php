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
        Schema::create('subdept_masters', function (Blueprint $table) {
            $table->id();
            $table->integer('distcode');
            $table->string('deptcode',4);
           
            $table->foreign(['distcode', 'deptcode'])
                ->references(['distcode', 'deptcode'])
                ->on('dept_masters');
            $table->string('subdeptcode',4);
            $table->string('subdept',60);
            $table->string('address',60);
            $table->string('subdeptcodekey',10);
            $table->integer('distcode_from');
            $table->integer('hrmsdata')->default(0);

            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subdept_masters');
    }
};
