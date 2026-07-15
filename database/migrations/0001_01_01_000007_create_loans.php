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
        Schema::create('loans', function (Blueprint $table) {
            $table->id();
            $table->string('kode_pinjam')->unique();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->date('tgl_ambil');
            $table->date('tgl_kembali_rencana');
            $table->date('tgl_kembali_aktual')->nullable();
            $table->enum('tujuan', [
                'Praktikum Terjadwal',
                'Tugas Mandiri',
                'Penelitian Skripsi/Tesis',
                'Kegiatan Organisasi',
                'Lainnya',
            ]);
            $table->string('mata_kuliah')->nullable();
            $table->string('dosen_pembimbing')->nullable();
            $table->string('catatan', 500)->nullable();
            $table->enum('status', ['PENDING', 'DISETUJUI', 'DITOLAK', 'DIPINJAM', 'DIKEMBALIKAN', 'TERLAMBAT', 'DIBATALKAN'])
                ->default('PENDING');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('loans');
    }
};
