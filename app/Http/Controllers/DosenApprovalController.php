<?php

namespace App\Http\Controllers;

use App\Models\Loan;
use App\Models\User;
use App\Models\Notification;
use Illuminate\Http\Request;

class DosenApprovalController extends Controller
{
    public function index()
    {
        $dosenId = auth()->id();
        $loans = Loan::where('dosen_id', $dosenId)
            ->where('status', Loan::STATUS_PENDING)
            ->with('user', 'loanItems.equipmentUnit.equipment')
            ->latest()
            ->paginate(10);

        return view('dosen.approval', compact('loans'));
    }

    public function approve(Loan $loan)
    {
        if ($loan->dosen_id !== auth()->id()) {
            abort(403, 'Anda tidak memiliki akses untuk menyetujui peminjaman ini.');
        }

        if ($loan->status !== Loan::STATUS_PENDING) {
            return back()->with('error', 'Peminjaman ini sudah diproses.');
        }

        $loan->update(['status' => Loan::STATUS_DISETUJUI_DOSEN]);

        Notification::create([
            'user_id' => $loan->user_id,
            'title' => 'Disetujui Dosen',
            'message' => 'Peminjaman ' . $loan->kode_pinjam . ' telah disetujui oleh dosen. Menunggu persetujuan Admin Lab.',
            'read_at' => null,
        ]);

        return back()->with('success', 'Peminjaman berhasil disetujui. Menunggu konfirmasi Admin Lab.');
    }

    public function reject(Loan $loan)
    {
        if ($loan->dosen_id !== auth()->id()) {
            abort(403, 'Anda tidak memiliki akses untuk menolak peminjaman ini.');
        }

        if ($loan->status !== Loan::STATUS_PENDING) {
            return back()->with('error', 'Peminjaman ini sudah diproses.');
        }

        $loan->update(['status' => Loan::STATUS_DITOLAK]);

        Notification::create([
            'user_id' => $loan->user_id,
            'title' => 'Ditolak Dosen',
            'message' => 'Peminjaman ' . $loan->kode_pinjam . ' ditolak oleh dosen pembimbing.',
            'read_at' => null,
        ]);

        return back()->with('success', 'Peminjaman ditolak.');
    }
}
