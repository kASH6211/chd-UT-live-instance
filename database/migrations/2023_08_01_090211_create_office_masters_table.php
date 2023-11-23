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
        Schema::create('office_masters', function (Blueprint $table) {
            $table->id();
            
            $table->integer('distcode');
            $table->string('deptcode',4);
            $table->foreign(['distcode', 'deptcode'])
                ->references(['distcode', 'deptcode'])
                ->on('dept_masters');
           $table->string('officecode',4);
           $table->unique(['distcode', 'deptcode','officecode']);
            $table->string('office',60)->nullable();
            $table->string('address',60)->nullable();
            $table->integer('office_ac')->nullable();
            $table->integer('sno')->nullable();
            $table->string('subdeptcode',4)->nullable();
            $table->string('officecodekey',10)->nullable();
            $table->string('subdeptcodekey',10)->nullable();
            $table->integer('distcode_from')->nullable();
            $table->string('EmailID',50)->nullable();
            $table->integer('hrmsdata')->default(0);
            $table->integer('user_created')->default(0);

            $table->softDeletes();

            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('office_masters');
    }
};
