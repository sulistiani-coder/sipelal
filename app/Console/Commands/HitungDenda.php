<?php

namespace App\Console\Commands;

use App\Models\Fine;
use App\Models\Loan;
use App\Models\Notification;
use Carbon\Carbon;
use Illuminate\Console\Command;

class HitungDenda extends Command
{
    protected $signature = 'denda:hitung';
    protected $description = 'Hitung denda otomatis untuk peminjaman yang terlambat';

    public function handle(): int
    {
        $terlambat = Loan::where('status', Loan::STATUS_DIPINJAM)
            ->where('tgl_kembali_rencana', '<', Carbon::today())
            ->whereDoesntHave('fine')
            ->get();

        $count = 0;
        foreach ($terlambat as $loan) {
            $hariTerlambat = $loan->tgl_kembali_rencana->diffInDays(Carbon::today());
            $dendaPerHari = config('sipelal.denda_per_hari', 5000);

            Fine::create([
                'loan_id' => $loan->id,
                'jumlah_hari' => $hariTerlambat,
                'jumlah_denda' => $hariTerlambat * $dendaPerHari,
                'is_paid' => false,
                'catatan_admin' => 'Denda otomatis: ' . $hariTerlambat . ' hari keterlambatan.',
            ]);

            $loan->update(['status' => Loan::STATUS_TERLAMBAT]);

            Notification::create([
                'user_id' => $loan->user_id,
                'title' => 'Denda Dikenakan',
                'message' => 'Peminjaman ' . $loan->kode_pinjam . ' terlambat ' . $hariTerlambat . ' hari. Denda: Rp ' . number_format($hariTerlambat * $dendaPerHari, 0, ',', '.'),
                'read_at' => null,
            ]);

            $count++;
        }

        $this->info("Berhasil membuat {$count} denda baru.");
        return 0;
    }
}
