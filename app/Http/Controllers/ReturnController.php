<?php

namespace App\Http\Controllers;

use App\Models\Fine;
use App\Models\Loan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReturnController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $query = Loan::where('status', Loan::STATUS_DIPINJAM)
            ->with('user', 'loanItems.equipmentUnit.equipment');

        if ($user->role === 'admin_lab' && $user->lab_id) {
            $query->whereHas('loanItems.equipmentUnit.equipment', function ($q) use ($user) {
                $q->where('lab_id', $user->lab_id);
            });
        }

        $loans = $query->latest()->paginate(10);

        return view('admin.return.index', compact('loans'));
    }

    public function store(Request $request, Loan $loan)
    {
        if ($loan->status !== Loan::STATUS_DIPINJAM) {
            return back()->with('error', 'Hanya peminjaman dengan status DIPINJAM yang bisa dikembalikan.');
        }

        $user = Auth::user();
        if ($user->role === 'admin_lab' && $user->lab_id) {
            $hasLabEquipment = $loan->loanItems->contains(function ($item) use ($user) {
                return $item->equipmentUnit->equipment->lab_id === $user->lab_id;
            });
            if (!$hasLabEquipment) {
                abort(403, 'Peminjaman ini bukan untuk lab Anda.');
            }
        }

        $request->validate([
            'tgl_kembali_aktual' => ['required', 'date', 'after_or_equal:' . $loan->tgl_ambil->format('Y-m-d')],
            'catatan' => ['nullable', 'string'],
            'kondisi_kembali' => ['required', 'array'],
            'kondisi_kembali.*' => ['required', 'string', 'in:BAIK,PERLU_PERHATIAN,RUSAK_RINGAN,RUSAK_BERAT'],
        ]);

        $daysLate = Carbon::parse($request->tgl_kembali_aktual)->diffInDays($loan->tgl_kembali_rencana, false);
        $status = $daysLate > 0 ? Loan::STATUS_TERLAMBAT : Loan::STATUS_DIKEMBALIKAN;

        $loan->update([
            'tgl_kembali_aktual' => $request->tgl_kembali_aktual,
            'status' => $status,
        ]);

        foreach ($loan->loanItems as $index => $item) {
            $kondisi = $request->kondisi_kembali[$index] ?? 'BAIK';
            $item->update([
                'kondisi_saat_kembali' => $kondisi,
                'catatan_kerusakan' => $kondisi !== 'BAIK' ? $request->catatan : null,
            ]);

            if ($kondisi !== 'BAIK') {
                $item->equipmentUnit->update(['kondisi' => $kondisi]);
            }
        }

        if ($daysLate > 0) {
            Fine::create([
                'loan_id' => $loan->id,
                'jumlah_hari' => $daysLate,
                'jumlah_denda' => $daysLate * config('sipelal.denda_per_hari'),
                'is_paid' => false,
                'catatan_admin' => 'Terlambat ' . $daysLate . ' hari. ' . ($request->catatan ?? ''),
            ]);

            \App\Models\Notification::create([
                'user_id' => $loan->user_id,
                'title' => 'Denda Dikenakan',
                'message' => 'Peminjaman ' . $loan->kode_pinjam . ' terlambat ' . $daysLate . ' hari. Denda: Rp ' . number_format($daysLate * config('sipelal.denda_per_hari'), 0, ',', '.'),
                'read_at' => null,
            ]);
        }

        return back()->with('success', 'Pengembalian dicatat.');
    }
}
