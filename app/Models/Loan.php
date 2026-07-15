<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Str;

class Loan extends Model
{
    use HasFactory;

    protected $fillable = [
        'uuid',
        'kode_pinjam',
        'user_id',
        'dosen_id',
        'tgl_ambil',
        'tgl_kembali_rencana',
        'tgl_kembali_aktual',
        'tujuan',
        'mata_kuliah',
        'dosen_pembimbing',
        'catatan',
        'status',
    ];

    protected $casts = [
        'tgl_ambil' => 'date',
        'tgl_kembali_rencana' => 'date',
        'tgl_kembali_aktual' => 'date',
    ];

    protected static function booted(): void
    {
        static::creating(function (Loan $loan) {
            if (empty($loan->uuid)) {
                $loan->uuid = Str::uuid()->toString();
            }
        });
    }

    const STATUS_PENDING = 'PENDING';
    const STATUS_DISETUJUI_DOSEN = 'DISETUJUI_DOSEN';
    const STATUS_DITOLAK = 'DITOLAK';
    const STATUS_DIPINJAM = 'DIPINJAM';
    const STATUS_DIKEMBALIKAN = 'DIKEMBALIKAN';
    const STATUS_TERLAMBAT = 'TERLAMBAT';
    const STATUS_DIBATALKAN = 'DIBATALKAN';

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function dosen(): BelongsTo
    {
        return $this->belongsTo(User::class, 'dosen_id');
    }

    public function units(): BelongsToMany
    {
        return $this->belongsToMany(EquipmentUnit::class, 'loan_items', 'loan_id', 'equipment_unit_id')
            ->withPivot(['kondisi_saat_pinjam', 'kondisi_saat_kembali', 'catatan_kerusakan'])
            ->withTimestamps();
    }

    public function loanItems(): HasMany
    {
        return $this->hasMany(LoanItem::class, 'loan_id');
    }

    public function fine(): HasOne
    {
        return $this->hasOne(Fine::class, 'loan_id');
    }

    public function isOverdue(): bool
    {
        return $this->status === self::STATUS_DIPINJAM
            && $this->tgl_kembali_rencana->isPast();
    }

    public function getStatusBadgeColorAttribute(): string
    {
        return match ($this->status) {
            self::STATUS_PENDING => 'yellow',
            self::STATUS_DISETUJUI_DOSEN => 'blue',
            self::STATUS_DITOLAK => 'red',
            self::STATUS_DIPINJAM => 'green',
            self::STATUS_DIKEMBALIKAN => 'emerald',
            self::STATUS_TERLAMBAT => 'orange',
            self::STATUS_DIBATALKAN => 'gray',
            default => 'gray',
        };
    }

    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            self::STATUS_PENDING => 'Menunggu Dosen',
            self::STATUS_DISETUJUI_DOSEN => 'Menunggu Admin',
            self::STATUS_DITOLAK => 'Ditolak',
            self::STATUS_DIPINJAM => 'Dipinjam',
            self::STATUS_DIKEMBALIKAN => 'Dikembalikan',
            self::STATUS_TERLAMBAT => 'Terlambat',
            self::STATUS_DIBATALKAN => 'Dibatalkan',
            default => $this->status,
        };
    }
}
