<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Illuminate\Support\Facades\Hash;

use App\Models\Role;
use App\Models\User;

use App\Services\user\UserCreationService;

class User_And_Role_Seeder extends Seeder
{
    protected UserCreationService $userCreationService;
    public function __construct(UserCreationService $userCreationService)
    {
        $this->userCreationService = $userCreationService;
    }
    /**
     * Run the database seeds.
     */
    public function run(): void
    {   
        Role::Create(['name' => 'administrator']);
        Role::Create(['name' => 'manager']);
        Role::Create(['name' => 'editor']);
        Role::Create(['name' => 'employee']);
        Role::Create(['name' => 'subscriber']);

        $filePath = database_path('seeders/data/users.xlsx');

        $spreadsheet = IOFactory::load($filePath);
        $worksheet = $spreadsheet->getActiveSheet();
        $rows = $worksheet->toArray();

        // Remove the header row
        array_shift($rows);

        // perfomance optimization by chunking the data
        $chunks = array_chunk($rows, 500);

        foreach ($chunks as $chunk) {
            $dataToInsert = [];

            foreach ($chunk as $row) {
                $userData = [
                    'email' => $row[0],
                    'password' => $row[1] ?? 'password123',
                ];
                $this->userCreationService->registerNewUser($userData);
            }
        }
        
        User::query()->where('id', '=', 1)
            ->update(['role_id' => 1]);

    }
}
