<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Student;
use App\Models\Subject;

class Slip extends Model
{
    use HasFactory;
    protected $fillable = [
        'slipId',
        'student_id',
        'teacher_id',
        'rank',
        'percentage',
        'result', // LULUS KE GAGAL
    ];

    public function student(){
        return $this->belongsTo(User::class);
    }

    public function subjects(){
        return $this->hasMany(Subject::class);
    }
}
