<?php

namespace Database\Seeders;

use App\Models\Equipment;
use App\Models\EquipmentCategory;
use App\Models\EquipmentUnit;
use App\Models\Lab;
use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class SipelalSeeder extends Seeder
{
    public function run(): void
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $permissions = [
            // Super Admin: semua permission (wildcard handled di role assign)
            'verifikasi-peminjaman',
            'kelola-alat',
            'proses-pengembalian',
            'laporan-lab',
            'kelola-maintenance',
            'ajukan-peminjaman',
            'approve-mahasiswa',
            'cetak-surat',
            'view-katalog',
            'view-riwayat-sendiri',
            'bayar-denda',
            'manage-users',
            'manage-roles',
            'manage-lab',
            'manage-kategori',
            'manage-lokasi',
            'laporan-global',
            'view-activity-log',
            'manage-config-denda',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        $roles = [
            'super_admin' => $permissions, // semua permission
            'admin_lab' => [
                'verifikasi-peminjaman',
                'kelola-alat',
                'proses-pengembalian',
                'laporan-lab',
                'kelola-maintenance',
                'view-katalog',
            ],
            'dosen' => [
                'ajukan-peminjaman',
                'approve-mahasiswa',
                'cetak-surat',
                'view-katalog',
            ],
            'mahasiswa' => [
                'ajukan-peminjaman',
                'view-riwayat-sendiri',
                'bayar-denda',
                'view-katalog',
            ],
        ];

        foreach ($roles as $roleName => $rolePermissions) {
            $role = Role::firstOrCreate(['name' => $roleName]);
            $role->syncPermissions($rolePermissions);
        }

        // === LABS ===
        $labTI = Lab::firstOrCreate(['kode' => 'LAB-TI'], [
            'nama' => 'Laboratorium Teknologi Informasi',
            'lokasi' => 'Gedung A Lantai 2',
            'deskripsi' => 'Lab untuk praktikum pemrograman, jaringan, dan mikrokontroler',
        ]);

        $labSI = Lab::firstOrCreate(['kode' => 'LAB-SI'], [
            'nama' => 'Laboratorium Sistem Informasi',
            'lokasi' => 'Gedung A Lantai 3',
            'deskripsi' => 'Lab untuk praktikum basis data dan sistem informasi',
        ]);

        // === SUPER ADMIN ===
        $superAdmin = User::firstOrCreate(
            ['email' => 'admin@sipelal.test'],
            [
                'name' => 'Super Admin',
                'password' => bcrypt('password'),
                'role' => 'super_admin',
                'status' => 'ACTIVE',
                'nim' => null,
                'email_verified_at' => now(),
            ]
        );
        $superAdmin->assignRole('super_admin');

        // === ADMIN LAB ===
        $adminUsers = [
            ['name' => 'Admin Lab TI', 'email' => 'admin1@sipelal.test', 'lab_id' => $labTI->id],
            ['name' => 'Admin Lab SI', 'email' => 'admin2@sipelal.test', 'lab_id' => $labSI->id],
        ];

        foreach ($adminUsers as $u) {
            $admin = User::firstOrCreate(
                ['email' => $u['email']],
                [
                    'name' => $u['name'],
                    'password' => bcrypt('password'),
                    'role' => 'admin_lab',
                    'status' => 'ACTIVE',
                    'nim' => null,
                    'lab_id' => $u['lab_id'],
                    'email_verified_at' => now(),
                ]
            );
            $admin->assignRole('admin_lab');
        }

        // === DOSEN ===
        $dosenUsers = [
            ['name' => 'Dr. Ahmad Fauzi, M.Kom', 'email' => 'dosen1@sipelal.test'],
            ['name' => 'Dr. Siti Rahmawati, M.T', 'email' => 'dosen2@sipelal.test'],
        ];

        foreach ($dosenUsers as $u) {
            $dosen = User::firstOrCreate(
                ['email' => $u['email']],
                [
                    'name' => $u['name'],
                    'password' => bcrypt('password'),
                    'role' => 'dosen',
                    'status' => 'ACTIVE',
                    'nim' => null,
                    'email_verified_at' => now(),
                ]
            );
            $dosen->assignRole('dosen');
        }

        // === MAHASISWA ===
        $demoMahasiswa = User::firstOrCreate(
            ['email' => 'mahasiswa1@sipelal.test'],
            [
                'name' => 'Ahmad Mahasiswa',
                'password' => bcrypt('password'),
                'role' => 'mahasiswa',
                'status' => 'ACTIVE',
                'nim' => '12345678',
                'prodi' => 'Teknik Informatika',
                'angkatan' => 2022,
                'email_verified_at' => now(),
            ]
        );
        $demoMahasiswa->assignRole('mahasiswa');

        $existingMahasiswa = User::role('mahasiswa')->count();
        if ($existingMahasiswa < 5) {
            $toCreate = 5 - $existingMahasiswa;
            $mahasiswas = User::factory()->count($toCreate)->mahasiswa()->create();
            foreach ($mahasiswas as $mahasiswa) {
                $mahasiswa->assignRole('mahasiswa');
            }
        }

        // === KATEGORI ===
        $categories = collect([
            'Elektronik',
            'Komputer',
            'Jaringan',
            'Mikrokontroler',
            'Multimedia',
        ])->map(fn ($name) => EquipmentCategory::firstOrCreate(
            ['name' => $name],
            ['description' => "Kategori $name"]
        ));

        // === EQUIPMENT ===
        $equipmentData = [
            ['name' => 'Laptop ASUS', 'merk' => 'ASUS', 'model' => 'VivoBook 14', 'spesifikasi' => 'Intel i5, 8GB RAM, 512GB SSD'],
            ['name' => 'Laptop Lenovo', 'merk' => 'Lenovo', 'model' => 'IdeaPad 3', 'spesifikasi' => 'Intel i3, 4GB RAM, 256GB SSD'],
            ['name' => 'Desktop PC', 'merk' => 'HP', 'model' => 'ProDesk 400', 'spesifikasi' => 'Intel i5, 8GB RAM, 1TB HDD'],
            ['name' => 'Monitor LED 24"', 'merk' => 'Samsung', 'model' => 'S24F350', 'spesifikasi' => '24 inch FHD IPS'],
            ['name' => 'Keyboard Mechanical', 'merk' => 'Logitech', 'model' => 'G413', 'spesifikasi' => 'RGB Backlit, Mechanical Switch'],
            ['name' => 'Mouse Wireless', 'merk' => 'Logitech', 'model' => 'M185', 'spesifikasi' => 'Wireless 2.4GHz, 1000 DPI'],
            ['name' => 'Router MikroTik', 'merk' => 'MikroTik', 'model' => 'RB750Gr3', 'spesifikasi' => '5 port Gigabit Ethernet'],
            ['name' => 'Switch Cisco', 'merk' => 'Cisco', 'model' => 'SF-110D', 'spesifikasi' => '8 Port 10/100 Mbps'],
            ['name' => 'Arduino Uno R3', 'merk' => 'Arduino', 'model' => 'Uno R3', 'spesifikasi' => 'ATmega328P, 14 digital I/O'],
            ['name' => 'ESP32 DevKit', 'merk' => 'Espressif', 'model' => 'ESP32-WROOM', 'spesifikasi' => 'WiFi + Bluetooth, Dual Core'],
            ['name' => 'Raspberry Pi 4', 'merk' => 'Raspberry Pi', 'model' => '4B', 'spesifikasi' => '4GB RAM, BCM2711'],
            ['name' => 'Oscilloscope', 'merk' => 'Rigol', 'model' => 'DS1054Z', 'spesifikasi' => '4 Channel, 50MHz'],
            ['name' => 'Printer 3D', 'merk' => 'Creality', 'model' => 'Ender 3', 'spesifikasi' => '220x220x250mm build volume'],
            ['name' => 'Proyektor Epson', 'merk' => 'Epson', 'model' => 'EB-X51', 'spesifikasi' => '3800 Lumens, XGA'],
            ['name' => 'Webcam HD', 'merk' => 'Logitech', 'model' => 'C920', 'spesifikasi' => '1080p HD, Auto-focus'],
        ];

        $kodeIndex = 1;
        foreach ($equipmentData as $i => $eq) {
            $category = $categories->random();
            $kode = 'KD-LAB-' . str_pad($kodeIndex++, 3, '0', STR_PAD_LEFT);

            $equipment = Equipment::firstOrCreate(
                ['kode' => $kode],
                [
                    'category_id' => $category->id,
                    'lab_id' => $labTI->id,
                    'name' => $eq['name'],
                    'merk' => $eq['merk'],
                    'model' => $eq['model'],
                    'spesifikasi' => $eq['spesifikasi'],
                    'foto' => [],
                ]
            );

            $unitCount = rand(1, 3);
            foreach (range(1, $unitCount) as $unitIndex) {
                $unitCode = $kode . '-' . chr(64 + $unitIndex);
                EquipmentUnit::firstOrCreate(
                    ['unit_code' => $unitCode],
                    [
                        'equipment_id' => $equipment->id,
                        'kondisi' => 'BAIK',
                        'lokasi' => 'Rak ' . chr(64 + $category->id),
                        'is_active' => true,
                    ]
                );
            }
        }
    }
}
