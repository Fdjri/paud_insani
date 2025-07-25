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
        Schema::create('absensis', function (Blueprint $table) {
            $table->id();
            // Relasi ke siswa yang bersangkutan
            $table->foreignId('siswa_id')->constrained('siswas')->onDelete('cascade');
            
            $table->date('tanggal_absensi');
            $table->enum('status', ['Hadir', 'Sakit', 'Izin', 'Alpa']);
            $table->text('keterangan')->nullable(); // Untuk catatan, misal "Izin acara keluarga"
            
            $table->timestamps();

            // Membuat setiap siswa hanya bisa memiliki satu record absensi per hari
            $table->unique(['siswa_id', 'tanggal_absensi']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('absensis');
    }
};
