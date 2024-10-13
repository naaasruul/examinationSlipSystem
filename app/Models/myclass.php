<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
class myclass extends Model
{
    use HasFactory;
    protected $fillable = [
        'classCode',
        'className',
    ];
    public function users()
    {
        return $this->hasMany(User::class, 'classCode', 'classCode'); // Adjusted the foreign and local key
    }
}
