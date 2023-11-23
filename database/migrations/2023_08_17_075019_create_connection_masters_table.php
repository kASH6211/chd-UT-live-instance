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
        Schema::create('connection_masters', function (Blueprint $table) {
            $table->id();
            $table->foreignId('distcode')->constrained('dist_masters')->onDelete('restrict')->comment('District Connection String will be deleted');
            $table->string('driver')->default('sqlsrv');
            $table->string('host');
            $table->string('port')->default('1433');
            $table->string('database');
            $table->string('username');
            $table->string('password');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('connection_masters');
    }
};
