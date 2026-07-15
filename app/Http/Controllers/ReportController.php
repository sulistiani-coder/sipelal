<?php

namespace App\Http\Controllers;

use App\Models\Loan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\PeminjamanExport;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $query = Loan::with('user', 'loanItems.equipmentUnit.equipment');

        if ($user->role === 'admin_lab' && $user->lab_id) {
            $query->whereHas('loanItems.equipmentUnit.equipment', function ($q) use ($user) {
                $q->where('lab_id', $user->lab_id);
            });
        }

        if (request()->filled('dari')) {
            $query->where('tgl_ambil', '>=', request('dari'));
        }
        if (request()->filled('sampai')) {
            $query->where('tgl_ambil', '<=', request('sampai'));
        }

        $loans = $query->latest()->paginate(15)->withQueryString();

        return view('admin.report.index', compact('loans'));
    }

    public function export(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'dari' => 'nullable|date',
            'sampai' => 'nullable|date|after_or_equal:dari',
        ]);

        $query = Loan::with('user', 'dosen', 'loanItems.equipmentUnit.equipment', 'fine');

        if ($user->role === 'admin_lab' && $user->lab_id) {
            $query->whereHas('loanItems.equipmentUnit.equipment', function ($q) use ($user) {
                $q->where('lab_id', $user->lab_id);
            });
        }

        if ($request->filled('dari')) {
            $query->where('tgl_ambil', '>=', $request->dari);
        }
        if ($request->filled('sampai')) {
            $query->where('tgl_ambil', '<=', $request->sampai);
        }

        $loans = $query->latest()->get();
        $periode = $request->filled('dari')
            ? Carbon::parse($request->dari)->translatedFormat('d F Y') . ' - ' . ($request->sampai ? Carbon::parse($request->sampai)->translatedFormat('d F Y') : 'Sekarang')
            : 'Semua Data';

        $pdf = Pdf::loadView('admin.report.export', compact('loans', 'periode'));

        return $pdf->download('laporan-peminjaman-' . Carbon::now()->format('Y-m-d') . '.pdf');
    }

    public function exportExcel(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'dari' => 'nullable|date',
            'sampai' => 'nullable|date|after_or_equal:dari',
        ]);

        $query = Loan::with('user', 'dosen', 'loanItems.equipmentUnit.equipment', 'fine');

        if ($user->role === 'admin_lab' && $user->lab_id) {
            $query->whereHas('loanItems.equipmentUnit.equipment', function ($q) use ($user) {
                $q->where('lab_id', $user->lab_id);
            });
        }

        if ($request->filled('dari')) {
            $query->where('tgl_ambil', '>=', $request->dari);
        }
        if ($request->filled('sampai')) {
            $query->where('tgl_ambil', '<=', $request->sampai);
        }

        $loans = $query->latest()->get();

        return Excel::download(new PeminjamanExport($loans), 'laporan-peminjaman-' . Carbon::now()->format('Y-m-d') . '.xlsx');
    }
}
