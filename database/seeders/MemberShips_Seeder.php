<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Illuminate\Support\Facades\Hash;

use App\Models\Role;
use App\Models\User;
use App\Models\Membership;

// use 

class MemberShips_Seeder extends Seeder
{

    /**
     * Run the database seeds.
     */
    public function run(): void
    {   
        $filePath = database_path('seeders/data/membership.xlsx');

        $spreadsheet = IOFactory::load($filePath);
        $worksheet = $spreadsheet->getActiveSheet();
        $rows = $worksheet->toArray();

        // Remove the header row
        array_shift($rows);

        // // perfomance optimization by chunking the data
        $chunks = array_chunk($rows, 10);

        foreach ($chunks as $chunk) {
            foreach ($chunk as $row) {
                MemberShip::Create([
                    'title' => $row[0],
                    'mothly_limit' => $row[1],
                    'max_files_per_upload' => $row[2],
                ]);
            }
        }

    }
}
