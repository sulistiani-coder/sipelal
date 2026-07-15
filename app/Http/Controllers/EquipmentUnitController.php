<?php

namespace App\Http\Controllers;

use App\Models\EquipmentUnit;
use App\Models\Equipment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EquipmentUnitController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $query = EquipmentUnit::with('equipment');

        if ($user->role === 'admin_lab' && $user->lab_id) {
            $query->whereHas('equipment', fn($q) => $q->where('lab_id', $user->lab_id));
        }

        $units = $query->latest()->paginate(15);
        return view('admin.unit.index', compact('units'));
    }

    public function create()
    {
        $user = Auth::user();
        $query = Equipment::orderBy('name');

        if ($user->role === 'admin_lab' && $user->lab_id) {
            $query->where('lab_id', $user->lab_id);
        }

        $equipments = $query->get();
        return view('admin.unit.create', compact('equipments'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();

        $data = $request->validate([
            'equipment_id' => ['required', 'exists:equipments,id'],
            'unit_code' => ['required', 'string', 'unique:equipment_units,unit_code'],
            'kondisi' => ['required', 'string', 'in:BAIK,PERLU_PERHATIAN,RUSAK_RINGAN,RUSAK_BERAT,TIDAK_BISA_DIPINJAM'],
            'lokasi' => ['nullable', 'string'],
        ]);

        $equipment = Equipment::findOrFail($data['equipment_id']);
        if ($user->role === 'admin_lab' && $equipment->lab_id !== $user->lab_id) {
            abort(403, 'Anda tidak memiliki akses ke alat ini.');
        }

        $data['is_active'] = true;
        EquipmentUnit::create($data);

        return redirect()->route('admin.unit.index')->with('success', 'Unit berhasil ditambahkan.');
    }

    public function edit(EquipmentUnit $unit)
    {
        $user = Auth::user();
        $unit->load('equipment');

        if ($user->role === 'admin_lab' && $unit->equipment->lab_id !== $user->lab_id) {
            abort(403, 'Anda tidak memiliki akses ke unit ini.');
        }

        $query = Equipment::orderBy('name');
        if ($user->role === 'admin_lab' && $user->lab_id) {
            $query->where('lab_id', $user->lab_id);
        }
        $equipments = $query->get();

        return view('admin.unit.edit', compact('unit', 'equipments'));
    }

    public function update(Request $request, EquipmentUnit $unit)
    {
        $user = Auth::user();
        $unit->load('equipment');

        if ($user->role === 'admin_lab' && $unit->equipment->lab_id !== $user->lab_id) {
            abort(403, 'Anda tidak memiliki akses ke unit ini.');
        }

        $data = $request->validate([
            'equipment_id' => ['required', 'exists:equipments,id'],
            'unit_code' => ['required', 'string', 'unique:equipment_units,unit_code,' . $unit->id],
            'kondisi' => ['required', 'string', 'in:BAIK,PERLU_PERHATIAN,RUSAK_RINGAN,RUSAK_BERAT,TIDAK_BISA_DIPINJAM'],
            'lokasi' => ['nullable', 'string'],
            'is_active' => ['boolean'],
        ]);

        $equipment = Equipment::findOrFail($data['equipment_id']);
        if ($user->role === 'admin_lab' && $equipment->lab_id !== $user->lab_id) {
            abort(403, 'Anda tidak memiliki akses ke alat ini.');
        }

        $unit->update($data);
        return redirect()->route('admin.unit.index')->with('success', 'Unit berhasil diperbarui.');
    }

    public function destroy(EquipmentUnit $unit)
    {
        $user = Auth::user();
        $unit->load('equipment');

        if ($user->role === 'admin_lab' && $unit->equipment->lab_id !== $user->lab_id) {
            abort(403, 'Anda tidak memiliki akses ke unit ini.');
        }

        $hasActiveLoan = $unit->loanItems()->whereHas('loan', function ($q) {
            $q->whereIn('status', [\App\Models\Loan::STATUS_PENDING, \App\Models\Loan::STATUS_DISETUJUI_DOSEN, \App\Models\Loan::STATUS_DIPINJAM]);
        })->exists();

        if ($hasActiveLoan) {
            return back()->with('error', 'Tidak bisa menghapus unit yang sedang dipinjam atau dalam proses peminjaman.');
        }

        $unit->delete();
        return redirect()->route('admin.unit.index')->with('success', 'Unit berhasil dihapus.');
    }
}
