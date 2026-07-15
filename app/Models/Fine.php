<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fine extends Model
{
    use HasFactory;

    protected $fillable = [
        'loan_id',
        'jumlah_hari',
        'jumlah_denda',
        'is_paid',
        'catatan_admin',
    ];

    protected $casts = [
        'is_paid' => 'boolean',
    ];

    public function loan()
    {
        return $this->belongsTo(Loan::class, 'loan_id');
    }
}
