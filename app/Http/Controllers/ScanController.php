<?php

namespace App\Http\Controllers;

use App\Models\Loan;
use Illuminate\Http\Request;

class ScanController extends Controller
{
    public function index()
    {
        return view('scan.index');
    }

    public function show($uuid)
    {
        $loan = Loan::where('uuid', $uuid)
            ->with('user', 'dosen', 'loanItems.equipmentUnit.equipment', 'fine')
            ->firstOrFail();

        $user = auth()->user();
        if ($loan->user_id !== auth()->id() && !in_array($user->role, ['super_admin', 'admin_lab'])) {
            abort(403);
        }

        return view('scan.show', compact('loan'));
    }

    public function process(Request $request)
    {
        $request->validate([
            'uuid' => ['required', 'string'],
        ]);

        $loan = Loan::where('uuid', $request->uuid)->first();

        if (!$loan) {
            return back()->with('error', 'Peminjaman tidak ditemukan.');
        }

        return redirect()->route('scan.show', $loan->uuid);
    }
}
