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
        Schema::create('booths', function (Blueprint $table) {
            $table->id();

            $table->integer('DISTCODE');
$table->string('BOOTHNO',3);
$table->string('BOOTHNOA',1)->nullable();
$table->integer('CONSCODE');
$table->unique(['DISTCODE','CONSCODE','BOOTHNO']);
$table->foreign(['DISTCODE', 'CONSCODE'])
->references(['distcode','ac_no'])
->on('cons_dists');  
$table->string('VILLAGE',60)->nullable();
$table->string('POLLBUILD',150)->nullable();
$table->string('POLLAREA',200)->nullable();
$table->string('TYPE',20)->nullable();
$table->integer('TOTALVOTE')->nullable();
$table->integer('MALEVOTE')->nullable();
$table->integer('FEMALEVOTE')->nullable();
$table->boolean('URBAN');
$table->boolean('FEMALEPARTY');
$table->integer('NOOFOFFICER')->nullable();
$table->integer('RNO')->nullable();
$table->string('PROCESSED',1)->nullable();
$table->boolean('PARDANASHIN');
$table->integer('CUNO')->nullable();
$table->integer('BUNO')->nullable();
$table->integer('CUNO1')->nullable();
$table->integer('BUNO1')->nullable();
$table->string('MOREQUIRED',1)->nullable();
$table->string('MOPROCESSED',1)->nullable();
$table->integer('PS_LOCN_NO')->nullable();
$table->string('PHONE',15)->nullable();
$table->integer('DISTCODE_FROM')->nullable();
$table->string('DEL',1)->nullable();
$table->string('PS_LOCN_NO_KEY',11)->nullable();
$table->string('PS_ID',9)->nullable();
$table->integer('OtherVote')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('booths');
    }
};
