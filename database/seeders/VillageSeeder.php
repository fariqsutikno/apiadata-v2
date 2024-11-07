<?php

namespace Database\Seeders;

use App\Models\Village;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class VillageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $csvFile = base_path("database/seeds/villages.csv");
        $data = File::get($csvFile);
        $rows = explode("\n", $data);
        array_shift($rows);

        foreach ($rows as $row) {
            $row = str_replace('"', '', $row);
            $fields = explode(";", $row);
            // var_dump(count($fields));

            // Pastikan setiap baris memiliki jumlah field yang sesuai
            if (count($fields) == 3) {
                Village::create([
                    'id' => $fields[0],
                    'district_id' => $fields[1],
                    'name' => strtoupper($fields[2]),
                ]);
            }
        }
    }
}
