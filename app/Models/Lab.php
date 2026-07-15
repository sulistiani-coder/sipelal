<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lab extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'kode',
        'lokasi',
        'deskripsi',
    ];

    public function users()
    {
        return $this->hasMany(User::class, 'lab_id');
    }

    public function equipments()
    {
        return $this->hasMany(Equipment::class, 'lab_id');
    }

    public function adminLab()
    {
        return $this->hasOne(User::class, 'lab_id')->where('role', 'admin_lab');
    }
}
