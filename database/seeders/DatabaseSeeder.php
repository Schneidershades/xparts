<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        $this->call(PermissionSeeder::class);
        $this->call(PartGradeTableSeeder::class);
        $this->call(BankTableSeeder::class);
        $this->call(CountryTableSeeder::class);
        $this->call(StateTableSeeder::class);
        $this->call(CityTableSeeder::class);
        $this->call(PartSpecializationSeeder::class);
        $this->call(VehicleSpecializationSeeder::class);
        $this->call(PartTableSeeder::class);
		DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
