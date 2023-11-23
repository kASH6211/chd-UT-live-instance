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
        Schema::create('election_infos', function (Blueprint $table) {
            $table->id();
$table->integer('Distcode');
$table->foreign('Distcode')->references('DistCode')->on('dist_masters')->onDelete('restrict');
            

$table->string('DCName',60);
$table->string('pBooths',5);
$table->string('ElectionDate',12);
$table->string('ElectionStartTime',10);
$table->string('ElectionEndTime',10);
$table->boolean('AssemblyElection');
$table->boolean('ParliamentaryElection');
$table->boolean('installed');
$table->string('Electionname',60);
$table->integer('pc_no');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('election_infos');
    }
};
