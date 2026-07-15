<?php

namespace App\Http\Controllers;

use App\Models\Equipment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EquipmentController extends Controller
{
    public function index()
    {
        if (request()->routeIs('admin.alat.*')) {
            $equipments = Equipment::with('category', 'units')
                ->forAdminLab()
                ->latest()
                ->paginate(15);
            return view('admin.equipment.index', compact('equipments'));
        }

        $equipments = Equipment::with('category', 'units')->paginate(12);
        return view('equipment.index', compact('equipments'));
    }

    public function show($kode)
    {
        $equipment = Equipment::with('category', 'units')
            ->where('kode', $kode)
            ->firstOrFail();

        return view('equipment.show', compact('equipment'));
    }

    public function create()
    {
        $user = Auth::user();
        $labs = \App\Models\Lab::orderBy('nama')->get();
        return view('admin.equipment.create', compact('labs'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();

        $data = $request->validate([
            'category_id' => ['required', 'exists:equipment_categories,id'],
            'lab_id' => ['required', 'exists:labs,id'],
            'kode' => ['required', 'string', 'max:50', 'unique:equipments,kode'],
            'name' => ['required', 'string', 'max:255'],
            'merk' => ['nullable', 'string', 'max:255'],
            'model' => ['nullable', 'string', 'max:255'],
            'spesifikasi' => ['nullable', 'string'],
            'foto' => ['nullable', 'array', 'max:5'],
            'foto.*' => ['image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ]);

        if ($user->role === 'admin_lab') {
            $data['lab_id'] = $user->lab_id;
        }

        $fotoPaths = [];
        if ($request->hasFile('foto')) {
            foreach ($request->file('foto') as $file) {
                $fotoPaths[] = $file->store('alat', 'public');
            }
        }
        $data['foto'] = $fotoPaths;

        Equipment::create($data);

        return redirect()->route('admin.alat.index')->with('success', 'Peralatan berhasil ditambahkan.');
    }

    public function edit(Equipment $alat)
    {
        if (auth()->user()->role === 'admin_lab' && $alat->lab_id !== auth()->user()->lab_id) {
            abort(403, 'Anda tidak memiliki akses ke alat ini.');
        }

        $labs = \App\Models\Lab::orderBy('nama')->get();
        return view('admin.equipment.edit', compact('alat', 'labs'));
    }

    public function update(Request $request, Equipment $alat)
    {
        if (auth()->user()->role === 'admin_lab' && $alat->lab_id !== auth()->user()->lab_id) {
            abort(403, 'Anda tidak memiliki akses ke alat ini.');
        }

        $data = $request->validate([
            'category_id' => ['required', 'exists:equipment_categories,id'],
            'lab_id' => ['required', 'exists:labs,id'],
            'kode' => ['required', 'string', 'max:50', 'unique:equipments,kode,' . $alat->id],
            'name' => ['required', 'string', 'max:255'],
            'merk' => ['nullable', 'string', 'max:255'],
            'model' => ['nullable', 'string', 'max:255'],
            'spesifikasi' => ['nullable', 'string'],
            'foto' => ['nullable', 'array', 'max:5'],
            'foto.*' => ['image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'hapus_foto' => ['nullable', 'array'],
        ]);

        if (auth()->user()->role === 'admin_lab') {
            $data['lab_id'] = auth()->user()->lab_id;
        }

        $fotoPaths = $alat->foto ?? [];
        if ($request->hasFile('foto')) {
            foreach ($request->file('foto') as $file) {
                $fotoPaths[] = $file->store('alat', 'public');
            }
        }

        if ($request->has('hapus_foto')) {
            foreach ($request->hapus_foto as $oldFoto) {
                if (in_array($oldFoto, $fotoPaths)) {
                    \Storage::disk('public')->delete($oldFoto);
                    $fotoPaths = array_values(array_diff($fotoPaths, [$oldFoto]));
                }
            }
        }

        $data['foto'] = $fotoPaths;
        unset($data['hapus_foto']);

        $alat->update($data);

        return redirect()->route('admin.alat.index')->with('success', 'Peralatan berhasil diperbarui.');
    }

    public function destroy(Equipment $alat)
    {
        if (auth()->user()->role === 'admin_lab' && $alat->lab_id !== auth()->user()->lab_id) {
            abort(403, 'Anda tidak memiliki akses ke alat ini.');
        }

        if ($alat->units()->whereHas('loanItems', function ($q) {
            $q->whereHas('loan', function ($q2) {
                $q2->whereIn('status', [\App\Models\Loan::STATUS_PENDING, \App\Models\Loan::STATUS_DISETUJUI_DOSEN, \App\Models\Loan::STATUS_DIPINJAM]);
            });
        })->exists()) {
            return back()->with('error', 'Tidak bisa menghapus alat yang sedang dipinjam atau dalam proses peminjaman.');
        }

        if ($alat->foto) {
            foreach ($alat->foto as $foto) {
                \Storage::disk('public')->delete($foto);
            }
        }

        $alat->delete();

        return redirect()->route('admin.alat.index')->with('success', 'Peralatan berhasil dihapus.');
    }
}
