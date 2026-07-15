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
        Schema::table('users', function (Blueprint $table) {
            $table->enum('role', ['super_admin', 'admin_lab', 'dosen', 'mahasiswa'])
                ->default('mahasiswa')
                ->after('id');
            $table->enum('status', ['PENDING', 'ACTIVE', 'SUSPENDED'])
                ->default('PENDING')
                ->after('role');
            $table->string('nim', 8)
                ->unique()
                ->nullable()
                ->after('status');
            $table->string('prodi')
                ->nullable()
                ->after('nim');
            $table->year('angkatan')
                ->nullable()
                ->after('prodi');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['angkatan', 'prodi', 'nim', 'status', 'role']);
        });
    }
};
