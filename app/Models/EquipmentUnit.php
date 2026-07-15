<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EquipmentUnit extends Model
{
    use HasFactory;

    protected $fillable = [
        'equipment_id',
        'unit_code',
        'kondisi',
        'lokasi',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function equipment()
    {
        return $this->belongsTo(Equipment::class, 'equipment_id');
    }

    public function loanItems()
    {
        return $this->hasMany(LoanItem::class, 'equipment_unit_id');
    }
}
