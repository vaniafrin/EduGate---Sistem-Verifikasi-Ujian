<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Examp extends Model
{
    use HasFactory;
    protected $fillable = [
        'mata_pelajaran',
        'sesi', 
        'tanggal', 
        'waktu_mulai', 
        'waktu_selesai'];

    public function placements()
    {
        return $this->hasMany(Placement::class);
    }
}
