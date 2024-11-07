<?php

namespace Database\Seeders;

use App\Models\District;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class DistrictSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $csvFile = base_path("database/seeds/districts.csv");
        $data = File::get($csvFile);
        $rows = explode("\n", $data);
        array_shift($rows);

        foreach ($rows as $row) {
            $row = str_replace('"', '', $row);
            $fields = explode(";", $row);
            // var_dump(count($fields));

            // Pastikan setiap baris memiliki jumlah field yang sesuai
            if (count($fields) == 3) {
                District::create([
                    'id' => $fields[0],
                    'regency_id' => $fields[1],
                    'name' => strtoupper($fields[2]),
                ]);
            }
        }
    }
}
