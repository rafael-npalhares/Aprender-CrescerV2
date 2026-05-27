<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'SixSeven',
            'email' => 'admin@aprendercrescer.com',
            'password' => Hash::make('12345678'),
            'role' => 'admin',
        ]);
    }
}
