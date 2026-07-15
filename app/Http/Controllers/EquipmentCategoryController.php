<?php

namespace App\Http\Controllers;

use App\Models\EquipmentCategory;
use Illuminate\Http\Request;

class EquipmentCategoryController extends Controller
{
    public function index()
    {
        $categories = EquipmentCategory::withCount('equipments')->latest()->paginate(15);
        return view('admin.category.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.category.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:equipment_categories,name'],
            'description' => ['nullable', 'string'],
        ]);

        EquipmentCategory::create($data);
        return redirect()->route('admin.kategori.index')->with('success', 'Kategori berhasil ditambahkan.');
    }

    public function edit(EquipmentCategory $kategori)
    {
        return view('admin.category.edit', compact('kategori'));
    }

    public function update(Request $request, EquipmentCategory $kategori)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:equipment_categories,name,' . $kategori->id],
            'description' => ['nullable', 'string'],
        ]);

        $kategori->update($data);
        return redirect()->route('admin.kategori.index')->with('success', 'Kategori berhasil diperbarui.');
    }

    public function destroy(EquipmentCategory $kategori)
    {
        if ($kategori->equipments()->count() > 0) {
            return back()->with('error', 'Tidak bisa menghapus kategori yang masih memiliki alat.');
        }

        $kategori->delete();
        return redirect()->route('admin.kategori.index')->with('success', 'Kategori berhasil dihapus.');
    }
}
