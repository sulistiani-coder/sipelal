<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $emailDomain = config('sipelal.email_domain', 'student.ac.id');

        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->userName() . '@' . $emailDomain,
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
            'remember_token' => Str::random(10),
            'role' => 'mahasiswa',
            'status' => 'ACTIVE',
            'nim' => fake()->unique()->numerify(str_repeat('#', config('sipelal.nim_length', 8))),
            'prodi' => fake()->randomElement(['Teknik Informatika', 'Sistem Informasi', 'Teknik Komputer']),
            'angkatan' => fake()->year(),
        ];
    }

    public function superAdmin(): static
    {
        return $this->state(fn (array $attributes) => [
            'role' => 'super_admin',
            'status' => 'ACTIVE',
        ]);
    }

    public function adminLab(): static
    {
        return $this->state(fn (array $attributes) => [
            'role' => 'admin_lab',
            'status' => 'ACTIVE',
        ]);
    }

    public function dosen(): static
    {
        return $this->state(fn (array $attributes) => [
            'role' => 'dosen',
            'status' => 'ACTIVE',
        ]);
    }

    public function mahasiswa(): static
    {
        return $this->state(fn (array $attributes) => [
            'role' => 'mahasiswa',
            'status' => 'ACTIVE',
        ]);
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
