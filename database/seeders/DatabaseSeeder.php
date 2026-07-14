<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        if (\App\Models\User::count() === 0) {
            $this->call([
                UserSeeder::class,
                KategoriSeeder::class,
                LogAktivitasSeeder::class,
                SuratSeeder::class,
            ]);
        }
    }
}