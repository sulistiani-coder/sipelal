<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("ALTER TABLE loans MODIFY COLUMN status ENUM('PENDING','DISETUJUI_DOSEN','DISETUJUI_ADMIN','DITOLAK','DIPINJAM','DIKEMBALIKAN','TERLAMBAT','DIBATALKAN') DEFAULT 'PENDING'");
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE loans MODIFY COLUMN status ENUM('PENDING','DISETUJUI','DITOLAK','DIPINJAM','DIKEMBALIKAN','TERLAMBAT','DIBATALKAN') DEFAULT 'PENDING'");
    }
};
