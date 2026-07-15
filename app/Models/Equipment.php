<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Equipment extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'equipments';

    protected $fillable = [
        'category_id',
        'lab_id',
        'kode',
        'name',
        'merk',
        'model',
        'spesifikasi',
        'foto',
    ];

    protected $casts = [
        'foto' => 'array',
    ];

    public function scopeForLab(Builder $query, ?int $labId): Builder
    {
        if (is_null($labId)) {
            return $query;
        }
        return $query->where('lab_id', $labId);
    }

    public function scopeForAdminLab(Builder $query): Builder
    {
        $user = auth()->user();
        if ($user && $user->role === 'admin_lab' && $user->lab_id) {
            return $query->where('lab_id', $user->lab_id);
        }
        return $query;
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logOnly(['name', 'kode', 'category_id']);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(EquipmentCategory::class, 'category_id');
    }

    public function lab(): BelongsTo
    {
        return $this->belongsTo(Lab::class, 'lab_id');
    }

    public function units(): HasMany
    {
        return $this->hasMany(EquipmentUnit::class, 'equipment_id');
    }

    public function availableUnits()
    {
        return $this->units()->where('is_active', true)->where('kondisi', 'BAIK');
    }
}
