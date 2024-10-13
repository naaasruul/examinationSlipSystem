<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash; // for security

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        User::create([
            'ic'=>'111',
            'name'=>'Admin 1',
            'password'=>Hash::make('admin'),
            'role'=>2,
        ]);
        
        User::create([
            'ic'=>'222',
            'name'=>'Admin 2',
            'password'=>Hash::make('admin'),
            'role'=>2
        ]);
    }
}
