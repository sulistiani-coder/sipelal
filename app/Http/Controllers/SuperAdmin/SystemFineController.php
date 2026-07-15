<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Fine;
use Illuminate\Http\Request;

class SystemFineController extends Controller
{
    public function index(Request $request)
    {
        $query = Fine::with('loan.user');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('loan', function ($q) use ($search) {
                $q->where('kode_pinjam', 'like', "%{$search}%")
                  ->orWhereHas('user', function ($q2) use ($search) {
                      $q2->where('name', 'like', "%{$search}%");
                  });
            });
        }

        if ($request->filled('status')) {
            $query->where('is_paid', $request->status === 'paid');
        }

        $fines = $query->latest()->paginate(15)->withQueryString();

        return view('super-admin.fines.index', compact('fines'));
    }

    public function markPaid(Fine $fine)
    {
        if ($fine->is_paid) {
            return back()->with('error', 'Denda ini sudah lunas.');
        }

        $fine->update([
            'is_paid' => true,
            'catatan_admin' => ($fine->catatan_admin ? $fine->catatan_admin . ' ' : '') . 'Ditandai lunas oleh ' . auth()->user()->name . ' pada ' . now()->format('d/m/Y H:i'),
        ]);

        return back()->with('success', 'Denda berhasil ditandai lunas.');
    }
}
