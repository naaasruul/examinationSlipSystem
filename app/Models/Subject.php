<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
class Subject extends Model
{
    use HasFactory;
    use HasFactory;
    protected $fillable = [
        'subjectCode',
        'subjectName',
    ];

    public function slip(){
        return $this->belongsTo(Slip::class);
    }

    public function users(){
        return $this->belongsToMany(User::class, 'subject_user', 'subject_code', 'ic');
    }

}
