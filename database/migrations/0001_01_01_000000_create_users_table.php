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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('nik')->unique();
            $table->string('username')->unique();
            $table->string('password');
            $table->string('foto')->nullable();
            $table->date('tanggal_lahir');
            $table->string('nomor_anggota')->unique()->nullable();
            $table->string('pendidikan')->nullable();
            $table->string('npwp')->nullable();
            $table->string('periode')->nullable();
            $table->enum('role', ['kepala sekolah', 'bendahara', 'operator', 'guru']);
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
