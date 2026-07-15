<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Lab;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserManagementController extends Controller
{
    public function index(Request $request)
    {
        $query = User::with('lab');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('nim', 'like', "%{$search}%");
            });
        }

        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $users = $query->latest()->paginate(15)->withQueryString();

        return view('super-admin.users.index', compact('users'));
    }

    public function create()
    {
        $labs = Lab::orderBy('nama')->get();
        return view('super-admin.users.create', compact('labs'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'role' => ['required', Rule::in(['admin_lab', 'dosen', 'mahasiswa'])],
            'status' => ['required', Rule::in(['ACTIVE', 'PENDING', 'SUSPENDED'])],
            'nim' => ['nullable', 'string', 'max:20', 'unique:users,nim'],
            'prodi' => ['nullable', 'string', 'max:255'],
            'angkatan' => ['nullable', 'integer', 'min:2000', 'max:' . (date('Y') + 1)],
            'lab_id' => ['required_if:role,admin_lab', 'nullable', 'exists:labs,id'],
        ]);

        $data['password'] = Hash::make($data['password']);
        $data['email_verified_at'] = now();

        $user = User::create($data);
        $user->assignRole($data['role']);

        return redirect()->route('super-admin.users.index')->with('success', 'User berhasil dibuat.');
    }

    public function edit(User $user)
    {
        $labs = Lab::orderBy('nama')->get();
        return view('super-admin.users.edit', compact('user', 'labs'));
    }

    public function update(Request $request, User $user)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
            'role' => ['required', Rule::in(['admin_lab', 'dosen', 'mahasiswa'])],
            'status' => ['required', Rule::in(['ACTIVE', 'PENDING', 'SUSPENDED'])],
            'nim' => ['nullable', 'string', 'max:20', 'unique:users,nim,' . $user->id],
            'prodi' => ['nullable', 'string', 'max:255'],
            'angkatan' => ['nullable', 'integer', 'min:2000', 'max:' . (date('Y') + 1)],
            'lab_id' => ['required_if:role,admin_lab', 'nullable', 'exists:labs,id'],
        ]);

        if (!empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }

        $oldRole = $user->role;
        $user->update($data);

        if ($oldRole !== $data['role']) {
            $user->syncRoles([$data['role']]);
        }

        return redirect()->route('super-admin.users.index')->with('success', 'User berhasil diperbarui.');
    }

    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Tidak bisa menghapus akun sendiri.');
        }

        if ($user->role === 'super_admin') {
            return back()->with('error', 'Tidak bisa menghapus akun Super Admin.');
        }

        $user->delete();

        return redirect()->route('super-admin.users.index')->with('success', 'User berhasil dihapus.');
    }

    public function toggleStatus(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Tidak bisa mengubah status akun sendiri.');
        }

        if ($user->role === 'super_admin') {
            return back()->with('error', 'Tidak bisa mengubah status akun Super Admin.');
        }

        $user->status = $user->status === 'ACTIVE' ? 'SUSPENDED' : 'ACTIVE';
        $user->save();

        return back()->with('success', 'Status user berhasil diubah ke ' . $user->status . '.');
    }
}
