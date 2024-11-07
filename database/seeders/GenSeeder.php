<?php

namespace Database\Seeders;

use App\Models\Gen;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Gen::create([
            'name' => 'Alqatras 30',
            'logo' => 'gen/alqatras.png',
            'year' => 2021,
            'leader' => 'Muhammad Firmansyah',
        ]);

        Gen::create([
            'name' => 'Barzada 31',
            'logo' => 'gen/barzada.png',
            'year' => 2022,
            'leader' => 'Asra Rizqolla',
        ]);

        Gen::create([
            'name' => 'Szarvas 32',
            'logo' => 'gen/szarvas.png',
            'year' => 2023,
            'leader' => 'Muhammad Izzan',
        ]);

        Gen::create([
            'name' => 'Manzigard 33',
            'logo' => 'gen/manzigard.png',
            'year' => 2024,
            'leader' => 'Muhammad Daud Yusuf',
        ]);
    }
}
