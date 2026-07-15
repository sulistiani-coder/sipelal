<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    public function create(): View
    {
        return view('auth.register');
    }

    public function store(RegisterRequest $request): RedirectResponse
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'nim' => $request->nim,
            'prodi' => $request->prodi ?? null,
            'angkatan' => $request->angkatan ?? null,
            'role' => 'mahasiswa',
            'status' => 'ACTIVE',
            'email_verified_at' => now(),
        ]);

        $user->assignRole('mahasiswa');

        event(new Registered($user));

        Auth::login($user);

        return redirect()->route('dashboard');
    }
}
