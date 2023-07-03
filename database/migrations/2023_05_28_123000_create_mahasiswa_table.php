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
        if (!Schema::hasTable('mahasiswa')) {
            Schema::create('mahasiswa', function (Blueprint $table) {
                $table->string('nim', 15)->primary();
                $table->string('nama', 255);
                $table->integer('angkatan');
                $table->integer('semester');
                $table->double('ipk');
                $table->string('email', 255);
                $table->string('telepon', 15);
                $table->timestamps();
            });
        }
        // Schema::create('mahasiswa', function (Blueprint $table) {
        //     $table->string('nim', 15)->primary();
        //     $table->string('nama', 255);
        //     $table->unsignedBigInteger('angkatan');
        //     $table->unsignedBigInteger('semester');
        //     $table->double('ipk');
        //     $table->string('email', 255);
        //     $table->string('telepon', 15);
        // $table->timestamps();
        // });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mahasiswa');
    }
};