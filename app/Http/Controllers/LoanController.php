<?php

namespace App\Http\Controllers;

use App\Models\EquipmentUnit;
use App\Models\Loan;
use App\Models\LoanItem;
use App\Models\User;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Carbon\Carbon;

class LoanController extends Controller
{
    public function index()
    {
        $loans = Auth::user()->loans()
            ->with('loanItems.equipmentUnit.equipment', 'dosen')
            ->latest()
            ->paginate(10);

        return view('loan.index', compact('loans'));
    }

    public function show(Loan $loan)
    {
        $loan->load('user', 'dosen', 'loanItems.equipmentUnit.equipment', 'fine');

        $user = Auth::user();
        if ($loan->user_id !== Auth::id() && !in_array($user->role, ['super_admin', 'admin_lab'])) {
            abort(403);
        }

        if ($user->role === 'admin_lab' && $user->lab_id) {
            $hasLabEquipment = $loan->loanItems->contains(function ($item) use ($user) {
                return $item->equipmentUnit->equipment->lab_id === $user->lab_id;
            });
            if (!$hasLabEquipment) {
                abort(403);
            }
        }

        return view('loan.show', compact('loan'));
    }

    public function create()
    {
        $units = EquipmentUnit::where('is_active', true)
            ->where('kondisi', 'BAIK')
            ->with('equipment')
            ->get();

        $dosenList = User::role('dosen')->orderBy('name')->get();
        $tujuanOptions = config('sipelal.tujuan_options');
        $mataKuliahOptions = config('sipelal.mata_kuliah_options');

        return view('loan.create', compact('units', 'dosenList', 'tujuanOptions', 'mataKuliahOptions'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'tgl_ambil' => ['required', 'date', 'after_or_equal:today'],
            'tgl_kembali_rencana' => ['required', 'date', 'after_or_equal:tgl_ambil'],
            'tujuan' => ['required', 'string', Rule::in([
                'Praktikum Terjadwal',
                'Tugas Mandiri',
                'Penelitian Skripsi/Tesis',
                'Kegiatan Organisasi',
                'Lainnya',
            ])],
            'mata_kuliah' => ['nullable', 'string'],
            'dosen_id' => ['required', 'exists:users,id'],
            'catatan' => ['nullable', 'string'],
            'units' => ['required', 'array', 'min:1', 'max:' . config('sipelal.max_items_per_loan')],
            'units.*' => ['required', 'exists:equipment_units,id'],
        ]);

        $dosen = User::findOrFail($data['dosen_id']);
        if (!$dosen->hasRole('dosen')) {
            return back()->withInput()->withErrors(['dosen_id' => 'Pilih dosen yang valid.']);
        }

        foreach ($data['units'] as $unitId) {
            $unit = EquipmentUnit::findOrFail($unitId);
            if (!$unit->is_active || $unit->kondisi !== 'BAIK') {
                return back()->withInput()->withErrors(['units' => "Unit {$unit->unit_code} tidak tersedia."]);
            }
        }

        $maxLoanDays = Auth::user()->hasRole('dosen')
            ? config('sipelal.max_loan_days_dosen')
            : config('sipelal.max_loan_days_mahasiswa');

        $requestedDays = Carbon::parse($data['tgl_ambil'])
            ->diffInDays(Carbon::parse($data['tgl_kembali_rencana']), false);

        if ($requestedDays > $maxLoanDays) {
            return back()->withInput()->withErrors(['tgl_kembali_rencana' => "Maksimal $maxLoanDays hari."]);
        }

        if (Auth::user()->hasRole('mahasiswa')) {
            $activeLoanCount = Auth::user()->loans()
                ->whereIn('status', [Loan::STATUS_PENDING, Loan::STATUS_DISETUJUI_DOSEN, Loan::STATUS_DIPINJAM])
                ->count();

            if ($activeLoanCount >= config('sipelal.max_active_loans_mahasiswa')) {
                return back()->withInput()->withErrors(['units' => 'Batas peminjaman aktif tercapai.']);
            }
        }

        $loan = Loan::create([
            'kode_pinjam' => 'LPJ-' . Str::upper(Str::random(8)),
            'user_id' => Auth::id(),
            'dosen_id' => $data['dosen_id'],
            'tgl_ambil' => $data['tgl_ambil'],
            'tgl_kembali_rencana' => $data['tgl_kembali_rencana'],
            'tujuan' => $data['tujuan'],
            'mata_kuliah' => $data['mata_kuliah'],
            'catatan' => $data['catatan'],
            'status' => Loan::STATUS_PENDING,
        ]);

        foreach ($data['units'] as $unitId) {
            $unit = EquipmentUnit::findOrFail($unitId);
            LoanItem::create([
                'loan_id' => $loan->id,
                'equipment_unit_id' => $unitId,
                'kondisi_saat_pinjam' => $unit->kondisi,
            ]);
        }

        Notification::create([
            'user_id' => $data['dosen_id'],
            'title' => 'Peminjaman Baru',
            'message' => Auth::user()->name . ' mengajukan peminjaman ' . $loan->kode_pinjam . '. Mohon review.',
            'read_at' => null,
        ]);

        return redirect()->route('riwayat.index')->with('success', 'Peminjaman berhasil diajukan. Menunggu persetujuan Dosen.');
    }

    public function approval()
    {
        $user = Auth::user();

        $query = Loan::where('status', Loan::STATUS_DISETUJUI_DOSEN)
            ->with('user', 'loanItems.equipmentUnit.equipment');

        if ($user->role === 'admin_lab' && $user->lab_id) {
            $query->whereHas('loanItems.equipmentUnit.equipment', function ($q) use ($user) {
                $q->where('lab_id', $user->lab_id);
            });
        }

        $loans = $query->latest()->paginate(10);

        return view('admin.approval.index', compact('loans'));
    }

    public function approve(Loan $loan)
    {
        if ($loan->status !== Loan::STATUS_DISETUJUI_DOSEN) {
            return back()->with('error', 'Peminjaman ini belum disetujui dosen.');
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

        $loan->update(['status' => Loan::STATUS_DIPINJAM]);

        Notification::create([
            'user_id' => $loan->user_id,
            'title' => 'Disetujui Admin',
            'message' => 'Peminjaman ' . $loan->kode_pinjam . ' telah disetujui. Silakan ambil alat di lab.',
            'read_at' => null,
        ]);

        return back()->with('success', 'Peminjaman disetujui. Silakan serahkan alat.');
    }

    public function reject(Loan $loan)
    {
        if (!in_array($loan->status, [Loan::STATUS_DISETUJUI_DOSEN, Loan::STATUS_PENDING])) {
            return back()->with('error', 'Status peminjaman tidak valid untuk ditolak.');
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

        $loan->update(['status' => Loan::STATUS_DITOLAK]);

        Notification::create([
            'user_id' => $loan->user_id,
            'title' => 'Peminjaman Ditolak',
            'message' => 'Peminjaman ' . $loan->kode_pinjam . ' ditolak oleh Admin Lab.',
            'read_at' => null,
        ]);

        return back()->with('success', 'Peminjaman ditolak.');
    }

    public function handover(Loan $loan)
    {
        if ($loan->status !== Loan::STATUS_DIPINJAM) {
            return back()->with('error', 'Hanya peminjaman dengan status DIPINJAM yang bisa diserahkan.');
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

        Notification::create([
            'user_id' => $loan->user_id,
            'title' => 'Alat Diserahkan',
            'message' => 'Alat untuk peminjaman ' . $loan->kode_pinjam . ' telah diserahkan. Gunakan dengan baik.',
            'read_at' => null,
        ]);

        return back()->with('success', 'Serah terima alat berhasil dicatat.');
    }
}
