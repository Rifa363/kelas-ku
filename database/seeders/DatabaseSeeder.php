<?php

namespace Database\Seeders;

use App\Models\Mahasiswa;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        if (! Mahasiswa::where('email', 'admin@tple006.com')->exists()) {
            Mahasiswa::factory()->administrator()->create([
                'nama' => 'Administrator',
                'nim' => '0000000000',
                'email' => 'admin@tple006.com',
                'password' => bcrypt('password'),
            ]);
        }

        if (Mahasiswa::count() < 11) {
            Mahasiswa::factory(10)->create();
        }
    }
}
