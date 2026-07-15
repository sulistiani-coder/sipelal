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
        Schema::create('loan_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('loan_id')->constrained('loans')->cascadeOnDelete();
            $table->foreignId('equipment_unit_id')->constrained('equipment_units')->cascadeOnDelete();
            $table->enum('kondisi_saat_pinjam', ['BAIK', 'PERLU_PERHATIAN', 'RUSAK_RINGAN', 'RUSAK_BERAT', 'TIDAK_BISA_DIPINJAM']);
            $table->enum('kondisi_saat_kembali', ['BAIK', 'PERLU_PERHATIAN', 'RUSAK_RINGAN', 'RUSAK_BERAT', 'TIDAK_BISA_DIPINJAM'])->nullable();
            $table->text('catatan_kerusakan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('loan_items');
    }
};
