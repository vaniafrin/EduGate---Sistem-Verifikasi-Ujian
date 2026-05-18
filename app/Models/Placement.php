<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Placement extends Model
{
    use HasFactory;
    protected $fillable = [
        'student_id', 
        'examp_id', 
        'room_id'];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function examp()
    {
        return $this->belongsTo(Examp::class);
    }

    public function room()
    {
        return $this->belongsTo(Room::class);
    }
}
