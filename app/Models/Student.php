<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Student extends Model
{
    use HasFactory;

    // 1. Mendaftarkan kolom mana saja yang boleh diisi
    protected $fillable = [
        'nisn',
        'nama',
        'kelas',
        'rfid_uid',
        'photo_path',
        'face_descriptor',
    ];

    // 2. Memberitahu Laravel untuk mengubah JSON menjadi Array secara otomatis
    protected $casts = [
        'face_descriptor' => 'array',
    ];

    public function attendances(): HasMany
    {
    return $this->hasMany(Attendance::class);
    }

    public function placements()
    {
        return $this->hasMany(Placement::class);
    }
}
