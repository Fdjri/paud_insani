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
        Schema::create('keuangans', function (Blueprint $table) {
            $table->id();
            $table->string('deskripsi');
            $table->enum('tipe', ['pemasukan', 'pengeluaran']);
            $table->date('tanggal');
            $table->integer('jumlah')->default(1);
            $table->decimal('biaya', 15, 2); // Total biaya/nominal
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('keuangans');
    }
};
