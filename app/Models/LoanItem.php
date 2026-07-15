<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoanItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'loan_id',
        'equipment_unit_id',
        'kondisi_saat_pinjam',
        'kondisi_saat_kembali',
        'catatan_kerusakan',
    ];

    public function loan()
    {
        return $this->belongsTo(Loan::class, 'loan_id');
    }

    public function equipmentUnit()
    {
        return $this->belongsTo(EquipmentUnit::class, 'equipment_unit_id');
    }
}
