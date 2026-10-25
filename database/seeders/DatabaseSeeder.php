<?php

namespace Database\Seeders;

use App\Models\Membership;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Database\Seeders\CountrySeeder;
use Database\Seeders\MemberShips_Seeder;
use Database\Seeders\User_And_Role_Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            CountrySeeder::class,
            MemberShips_Seeder::class,
            User_And_Role_Seeder::class,

        ]);
    }
}
