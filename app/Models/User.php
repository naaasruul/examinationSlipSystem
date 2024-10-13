<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

use App\Models\Subject;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'ic',             // Unique Identifier
        'name',           // User's name
        'password',       // User's password (make sure it's hashed)
        'role',           // Role identifier
        'phone_number',   // Optional phone number with a default value
        'address',      
        'year',  // Optional address with a default value
        'classCode',          // Optional class name with a default value
        'subject',        // Optional subject with a default value
    ];

    public function studentClass() {
        return $this->belongsTo(Myclass::class, 'classCode', 'id');
    }
    
    public function subjects()
    {
        return $this->belongsToMany(Subject::class,'subject_user', 'ic', 'subjectCode');
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];
}
