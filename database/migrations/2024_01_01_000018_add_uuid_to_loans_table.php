<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('loans', function (Blueprint $table) {
            $table->uuid('uuid')->after('kode_pinjam')->nullable();
        });

        // Backfill existing rows with generated UUIDs
        $loans = DB::table('loans')->whereNull('uuid')->get();
        foreach ($loans as $loan) {
            DB::table('loans')->where('id', $loan->id)->update(['uuid' => Str::uuid()->toString()]);
        }

        Schema::table('loans', function (Blueprint $table) {
            $table->unique('uuid');
        });
    }

    public function down(): void
    {
        Schema::table('loans', function (Blueprint $table) {
            $table->dropColumn('uuid');
        });
    }
};
