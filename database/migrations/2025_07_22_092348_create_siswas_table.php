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
        Schema::create('siswas', function (Blueprint $table) {
            $table->id();
            $table->string('foto')->nullable();
            $table->string('nis')->unique(); // Nomor Induk Siswa, harus unik
            $table->string('nik')->unique()->nullable(); // NIK siswa
            $table->string('no_kk')->nullable(); // Nomor Kartu Keluarga
            $table->string('nama_lengkap');
            $table->string('nama_panggilan')->nullable();
            $table->enum('jenis_kelamin', ['Laki-laki', 'Perempuan']);
            $table->date('tanggal_lahir');
            $table->string('agama')->nullable();
            $table->string('kewarganegaraan')->default('Indonesia');
            $table->integer('anak_ke')->nullable();
            $table->integer('jumlah_saudara_kandung')->nullable();
            $table->string('bahasa_sehari_hari')->nullable();
            $table->float('berat_badan')->nullable();
            $table->float('tinggi_badan')->nullable();
            $table->string('golongan_darah')->nullable();
            $table->text('penyakit_yang_pernah_diderita')->nullable();
            $table->text('alamat_tempat_tinggal');
            $table->string('nomor_telp')->nullable();
            $table->string('jarak_tempat_tinggal_ke_sekolah')->nullable();

            // Data Ayah
            $table->string('nama_ayah_kandung')->nullable();
            $table->string('pendidikan_ayah')->nullable();
            $table->string('pekerjaan_ayah')->nullable();

            // Data Ibu
            $table->string('nama_ibu_kandung')->nullable();
            $table->string('pendidikan_ibu')->nullable();
            $table->string('pekerjaan_ibu')->nullable();

            // Data Wali (jika ada)
            $table->string('nama_wali')->nullable();
            $table->string('pendidikan_wali')->nullable();
            $table->string('pekerjaan_wali')->nullable();
            $table->string('hubungan_wali')->nullable();

            // Status Siswa
            $table->enum('tipe_murid', ['Siswa Baru', 'Mutasi']);
            $table->foreignId('kelas_id')->nullable()->constrained('kelas'); // Akan diisi otomatis oleh sistem
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('siswas');
    }
};
