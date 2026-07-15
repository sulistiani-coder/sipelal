<?php

namespace App\Http\Controllers;

use App\Models\Equipment;
use App\Models\EquipmentCategory;
use App\Models\EquipmentUnit;
use App\Models\Loan;
use App\Models\User;

class DashboardController extends Controller
{
    public function superAdminIndex()
    {
        $totalEquipment = Equipment::count();
        $totalUnits = EquipmentUnit::count();
        $totalUsers = User::count();
        $totalLoans = Loan::count();
        $pendingLoans = Loan::where('status', 'PENDING')->count();
        $activeLoans = Loan::where('status', 'DIPINJAM')->count();
        $totalCategories = EquipmentCategory::count();
        $recentLoans = Loan::with('user')->latest()->take(5)->get();

        return view('super-admin.dashboard', compact(
            'totalEquipment', 'totalUnits', 'totalUsers', 'totalLoans',
            'pendingLoans', 'activeLoans', 'totalCategories', 'recentLoans'
        ));
    }

    public function adminLabIndex()
    {
        $user = auth()->user();
        $labId = $user->lab_id;

        $totalEquipment = $labId ? Equipment::where('lab_id', $labId)->count() : 0;
        $totalUnits = $labId
            ? EquipmentUnit::whereIn('equipment_id', Equipment::where('lab_id', $labId)->pluck('id'))->count()
            : 0;

        $loanQuery = function ($query) use ($labId) {
            if ($labId) {
                $query->whereHas('loanItems.equipmentUnit.equipment', function ($q) use ($labId) {
                    $q->where('lab_id', $labId);
                });
            }
        };

        $pendingLoans = Loan::where('status', Loan::STATUS_DISETUJUI_DOSEN)
            ->when($labId, $loanQuery)
            ->count();
        $activeLoans = Loan::where('status', Loan::STATUS_DIPINJAM)
            ->when($labId, $loanQuery)
            ->count();
        $totalCategories = EquipmentCategory::count();
        $recentLoans = Loan::with('user')
            ->where('status', Loan::STATUS_DISETUJUI_DOSEN)
            ->when($labId, $loanQuery)
            ->latest()->take(5)->get();

        return view('admin-lab.dashboard', compact(
            'totalEquipment', 'totalUnits', 'pendingLoans', 'activeLoans',
            'totalCategories', 'recentLoans'
        ));
    }

    public function dosenIndex()
    {
        $dosenId = auth()->id();
        $pendingApprovals = Loan::where('dosen_id', $dosenId)->where('status', Loan::STATUS_PENDING)->count();
        $approvedLoans = Loan::where('dosen_id', $dosenId)->where('status', Loan::STATUS_DISETUJUI_DOSEN)->count();
        $recentLoans = Loan::where('dosen_id', $dosenId)->with('user')->latest()->take(5)->get();

        return view('dosen.dashboard', compact('pendingApprovals', 'approvedLoans', 'recentLoans'));
    }

    public function mahasiswaIndex()
    {
        $myLoans = Loan::where('user_id', auth()->id())->count();
        $activeLoans = Loan::where('user_id', auth()->id())
            ->whereIn('status', [Loan::STATUS_PENDING, Loan::STATUS_DISETUJUI_DOSEN, Loan::STATUS_DIPINJAM])
            ->count();
        $recentLoans = Loan::where('user_id', auth()->id())->with('loanItems.equipmentUnit.equipment', 'dosen')->latest()->take(5)->get();
        $myFines = auth()->user()->fines()->where('is_paid', false)->count();

        return view('mahasiswa.dashboard', compact('myLoans', 'activeLoans', 'recentLoans', 'myFines'));
    }
}
