<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Lietotajs;

class LietotajiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (!\App\Models\Lietotajs::where('epasts', 'admin@example.com')->exists()) {
            \App\Models\Lietotajs::create([
                'vards' => 'Admin',
                'uzvards' => 'User',
                'epasts' => 'admin@example.com',
                'email' => 'admin@example.com',
                'parole' => bcrypt('password'),
                'password' => bcrypt('password'),
                'loma' => 'Admin',
            ]);
        }

        if (!\App\Models\Lietotajs::where('epasts', 'darbinieks@example.com')->exists()) {
            \App\Models\Lietotajs::create([
                'vards' => 'Darbinieks',
                'uzvards' => 'User',
                'epasts' => 'darbinieks@example.com',
                'email' => 'darbinieks@example.com',
                'email' => 'darbinieks@example.com',                'parole' => bcrypt('password'),                'password' => bcrypt('password'),
                'loma' => 'Darbinieks',
            ]);
        }

        if (!\App\Models\Lietotajs::where('epasts', 'lietotajs@example.com')->exists()) {
            \App\Models\Lietotajs::create([
                'vards' => 'Lietotajs',
                'uzvards' => 'User',
                'epasts' => 'lietotajs@example.com',
                'email' => 'lietotajs@example.com',
                'email' => 'lietotajs@example.com',                'parole' => bcrypt('password'),                'password' => bcrypt('password'),
                'loma' => 'Lietotajs',
            ]);
        }
    }
}