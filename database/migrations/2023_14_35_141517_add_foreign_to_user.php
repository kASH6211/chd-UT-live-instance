<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
             $table->string('user_id',13)->unique();
            $table->foreignId('role_id')->constrained('roles')->onDelete('restrict')->comment('Role of user in state/group');
            $table->string('st_Code',4)->nullable();
            $table->foreign('st_Code')->references('statecode')->on('state_masters')->onDelete('restrict');
            $table->string('mobileno',10)->nullable();
            $table->integer('distcode')->nullable();
            
            $table->string('deptcode',4)->nullable();
            
            $table->string('subdeptcode',4)->nullable();
            $table->string('officecode',4)->nullable();
            $table->foreign(['distcode', 'deptcode','officecode'])
            ->references(['distcode', 'deptcode','officecode'])
            ->on('office_masters');
           
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign('users_role_id_foreign');
           

            $table->dropColumn('role_id');

            
            $table->dropForeign(['st_Code']);
           

            $table->dropColumn('st_Code');

            $table->dropForeign(['distcode', 'deptcode','officecode']);
           

            $table->dropColumn('distcode');

            
           

            $table->dropColumn('deptcode');

            
           

            $table->dropColumn('subdeptcode');

        
           

            $table->dropColumn('officecode');
          
        

        });
    }
};
