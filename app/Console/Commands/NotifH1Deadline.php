<?php

namespace App\Console\Commands;

use App\Models\Loan;
use App\Models\Notification;
use Carbon\Carbon;
use Illuminate\Console\Command;

class NotifH1Deadline extends Command
{
    protected $signature = 'notif:h1-deadline';
    protected $description = 'Kirim notifikasi pengingat H-1 deadline pengembalian';

    public function handle(): int
    {
        $tomorrow = Carbon::tomorrow();

        $loans = Loan::where('status', Loan::STATUS_DIPINJAM)
            ->where('tgl_kembali_rencana', $tomorrow)
            ->get();

        $count = 0;
        foreach ($loans as $loan) {
            Notification::create([
                'user_id' => $loan->user_id,
                'title' => 'Pengingat Pengembalian',
                'message' => 'Peminjaman ' . $loan->kode_pinjam . ' harus dikembalikan besok (' . $tomorrow->format('d M Y') . '). Mohon siapkan pengembalian.',
                'read_at' => null,
            ]);
            $count++;
        }

        $this->info("Berhasil mengirim {$count} notifikasi pengingat.");
        return 0;
    }
}
