<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EquipmentController;
use App\Http\Controllers\EquipmentUnitController;
use App\Http\Controllers\FineController;
use App\Http\Controllers\LoanController;
use App\Http\Controllers\EquipmentCategoryController;
use App\Http\Controllers\ReturnController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\DosenApprovalController;
use App\Http\Controllers\ScanController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Auth\VerifyEmailController;
use App\Http\Controllers\Auth\RegisteredUserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NotificationController;

// === LANDING PAGE ===
Route::get('/', function () {
    if (auth()->check()) {
        return redirect()->route('dashboard');
    }
    return view('welcome');
})->name('home');

// === AUTH ===
Route::middleware('guest')->group(function () {
    Route::get('login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('login', [AuthenticatedSessionController::class, 'store']);
    Route::get('register', [RegisteredUserController::class, 'create'])->name('register');
    Route::post('register', [RegisteredUserController::class, 'store']);
});

Route::middleware('auth')->group(function () {
    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
});

// === EMAIL VERIFICATION ===
Route::middleware(['auth', 'ensure.active'])->group(function () {
    Route::get('verify-email', EmailVerificationPromptController::class)->name('verification.notice');
    Route::post('email/verification-notification', [EmailVerificationPromptController::class, 'store'])->name('verification.send');
    Route::get('verify-email/{id}/{hash}', VerifyEmailController::class)->middleware(['signed'])->name('verification.verify');
});

// === ROUTE SETELAH LOGIN ===
Route::middleware(['auth', 'ensure.active'])->group(function () {
    // Dashboard redirect sesuai role
    Route::get('dashboard', function () {
        $role = auth()->user()->getRoleNames()->first();
        return match($role) {
            'super_admin' => redirect()->route('super-admin.dashboard'),
            'admin_lab' => redirect()->route('admin.dashboard'),
            'dosen' => redirect()->route('dosen.dashboard'),
            'mahasiswa' => redirect()->route('mahasiswa.dashboard'),
            default => abort(403),
        };
    })->name('dashboard');

    // Katalog (publik setelah login)
    Route::get('katalog', [EquipmentController::class, 'index'])->name('katalog.index');
    Route::get('katalog/{kode}', [EquipmentController::class, 'show'])->name('katalog.show');

    // Pengajuan Peminjaman (Mahasiswa + Dosen)
    Route::get('pinjam', [LoanController::class, 'create'])->name('pinjam.create');
    Route::post('pinjam', [LoanController::class, 'store'])->name('pinjam.store');

    // Riwayat
    Route::get('riwayat', [LoanController::class, 'index'])->name('riwayat.index');
    Route::get('riwayat/{loan}', [LoanController::class, 'show'])->name('riwayat.show');

    // Scan QR
    Route::get('scan', [ScanController::class, 'index'])->name('scan.index');
    Route::post('scan', [ScanController::class, 'process'])->name('scan.process');
    Route::get('scan/{uuid}', [ScanController::class, 'show'])->name('scan.show');

    // Denda
    Route::get('denda', [FineController::class, 'index'])->name('denda.index');

    // Notifikasi
    Route::get('/notifikasi', [NotificationController::class, 'index'])->name('notifikasi');
    Route::post('/notifikasi/read-all', [NotificationController::class, 'markAllRead'])->name('notifikasi.read-all');
});

// === SUPER ADMIN ===
Route::middleware(['auth', 'ensure.active', 'role:super_admin'])->prefix('super-admin')->name('super-admin.')->group(function () {
    Route::get('dashboard', [DashboardController::class, 'superAdminIndex'])->name('dashboard');
    Route::get('activity-log', [\App\Http\Controllers\ActivityLogController::class, 'index'])->name('activity-log');
    Route::resource('users', \App\Http\Controllers\SuperAdmin\UserManagementController::class)->except(['show']);
    Route::post('users/{user}/toggle-status', [\App\Http\Controllers\SuperAdmin\UserManagementController::class, 'toggleStatus'])->name('users.toggle-status');
    Route::get('loans', [\App\Http\Controllers\SuperAdmin\SystemLoanController::class, 'index'])->name('loans.index');
    Route::get('loans/{loan}', [\App\Http\Controllers\SuperAdmin\SystemLoanController::class, 'show'])->name('loans.show');
    Route::get('fines', [\App\Http\Controllers\SuperAdmin\SystemFineController::class, 'index'])->name('fines.index');
    Route::post('fines/{fine}/mark-paid', [\App\Http\Controllers\SuperAdmin\SystemFineController::class, 'markPaid'])->name('fines.mark-paid');
});

// === ADMIN LAB ===
Route::middleware(['auth', 'ensure.active', 'role:admin_lab|super_admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('dashboard', [DashboardController::class, 'adminLabIndex'])->name('dashboard');
    Route::resource('alat', EquipmentController::class)->except(['show']);
    Route::resource('unit', EquipmentUnitController::class)->except(['show']);
    Route::get('approval', [LoanController::class, 'approval'])->name('approval.index');
    Route::post('approval/{loan}/approve', [LoanController::class, 'approve'])->name('approval.approve');
    Route::post('approval/{loan}/reject', [LoanController::class, 'reject'])->name('approval.reject');
    Route::post('serah-terima/{loan}', [LoanController::class, 'handover'])->name('approval.handover');
    Route::get('pengembalian', [ReturnController::class, 'index'])->name('pengembalian.index');
    Route::post('pengembalian/{loan}', [ReturnController::class, 'store'])->name('pengembalian.store');
    Route::get('laporan', [ReportController::class, 'index'])->name('laporan.index');
    Route::get('laporan/export', [ReportController::class, 'export'])->name('laporan.export');
    Route::get('laporan/export-excel', [ReportController::class, 'exportExcel'])->name('laporan.export-excel');
    Route::resource('kategori', EquipmentCategoryController::class)->except(['show']);
});

// === DOSEN ===
Route::middleware(['auth', 'ensure.active', 'role:dosen|super_admin'])->prefix('dosen')->name('dosen.')->group(function () {
    Route::get('dashboard', [DashboardController::class, 'dosenIndex'])->name('dashboard');
    Route::get('approval', [DosenApprovalController::class, 'index'])->name('approval.index');
    Route::post('approval/{loan}/approve', [DosenApprovalController::class, 'approve'])->name('approval.approve');
    Route::post('approval/{loan}/reject', [DosenApprovalController::class, 'reject'])->name('approval.reject');
});

// === MAHASISWA ===
Route::middleware(['auth', 'ensure.active', 'role:mahasiswa|super_admin'])->prefix('mahasiswa')->name('mahasiswa.')->group(function () {
    Route::get('dashboard', [DashboardController::class, 'mahasiswaIndex'])->name('dashboard');
});

Route::fallback(function () {
    if (auth()->check()) {
        return redirect()->route('dashboard');
    }
    return redirect()->route('home');
});
