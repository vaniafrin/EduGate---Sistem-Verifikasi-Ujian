<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Room extends Model
{
    use HasFactory;
    protected $fillable = ['nama_ruangan'];

    public function placements()
    {
        return $this->hasMany(Placement::class);
    }
}
