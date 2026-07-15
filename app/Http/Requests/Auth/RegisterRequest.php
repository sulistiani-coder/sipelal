<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'nim' => ['nullable', 'string', 'max:20', 'unique:users,nim'],
            'prodi' => ['nullable', 'string', 'max:255'],
            'angkatan' => ['nullable', 'integer', 'min:2000', 'max:' . (date('Y') + 1)],
        ];
    }
}
