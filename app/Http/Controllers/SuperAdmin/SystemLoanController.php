<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Loan;
use Illuminate\Http\Request;

class SystemLoanController extends Controller
{
    public function index(Request $request)
    {
        $query = Loan::with('user', 'dosen', 'loanItems.equipmentUnit.equipment', 'fine');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('kode_pinjam', 'like', "%{$search}%")
                  ->orWhereHas('user', function ($q2) use ($search) {
                      $q2->where('name', 'like', "%{$search}%");
                  });
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $loans = $query->latest()->paginate(15)->withQueryString();

        return view('super-admin.loans.index', compact('loans'));
    }

    public function show(Loan $loan)
    {
        $loan->load('user', 'dosen', 'loanItems.equipmentUnit.equipment', 'fine');

        return view('super-admin.loans.show', compact('loan'));
    }
}
