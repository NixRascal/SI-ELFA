<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Admin::create([
            'nama' => 'Administrator',
            'email' => 'admin@mail.com',
            'password' => bcrypt('password123'),
            'email_terverifikasi' => now(),
        ]);
    }
}
