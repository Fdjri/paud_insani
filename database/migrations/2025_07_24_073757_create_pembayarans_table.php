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
        Schema::create('pembayarans', function (Blueprint $table) {
            $table->id();
            // Relasi ke siswa yang melakukan pembayaran
            $table->foreignId('siswa_id')->constrained('siswas')->onDelete('cascade');
            
            // Relasi ke user bendahara yang mengonfirmasi (opsional tapi bagus)
            $table->foreignId('user_id')->nullable()->constrained('users');

            $table->string('jenis_pembayaran')->default('SPP'); // Bisa untuk 'SPP', 'Uang Pangkal', dll.
            $table->year('tahun_ajaran'); // Misal: 2024
            $table->string('bulan_pembayaran'); // Misal: 'Januari', 'Februari'
            $table->decimal('jumlah_bayar', 10, 2); // Angka dengan 2 desimal
            $table->date('tanggal_bayar');
            $table->enum('status', ['Lunas', 'Belum Lunas', 'Cicil'])->default('Lunas');
            $table->text('keterangan')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pembayarans');
    }
};
