<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Illuminate\Support\Facades\Hash;

use App\Models\Country;

class CountrySeeder extends Seeder
{
    public function run(): void
    {
        // Path to the CSV file
        $filePath = database_path('seeders/data/countries.xlsx');

        // Check if the file exists
        $spreadsheet = IOFactory::load($filePath);
        $worksheet = $spreadsheet->getActiveSheet();
        $rows = $worksheet->toArray();

        // Read the CSV file using League CSV package
        array_shift($rows);

        $chunks = array_chunk($rows, 500);
        foreach ($chunks as $chunk) {
            $dataToInsert = [];
            foreach ($chunk as $row) {
                $dataToInsert[] = [
                    'name' => $row[0],  // Full country name
                    'code' => $row[2],  // 3-letter country code
                    'region' => $row[5], // Region
                ];
            }
            Country::insert($dataToInsert);
        }
    }
}

