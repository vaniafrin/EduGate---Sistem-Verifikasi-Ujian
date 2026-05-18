<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Attendance extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'scanned_at',
        'status',
        'confidence_score',
        'verify_photo_path',
    ];

    // Relasi: Satu catatan kehadiran dimiliki oleh satu Siswa
    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }
}
