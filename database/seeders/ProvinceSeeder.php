<?php

namespace Database\Seeders;

use App\Models\Province;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class ProvinceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $csvFile = base_path("database/seeds/provinces.csv");
        $data = File::get($csvFile);
        $rows = explode("\n", $data);
        array_shift($rows);

        foreach ($rows as $row) {
            $row = str_replace('"', '', $row);
            $fields = explode(";", $row);
            // var_dump(count($fields));

            // Pastikan setiap baris memiliki jumlah field yang sesuai
            if (count($fields) == 2) {
                Province::create([
                    'id' => strtoupper($fields[0]),
                    'name' => strtoupper($fields[1]),
                ]);
            }
        }
    }
}
