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
        $this->call(CategoryOneTableSeeder::class);
        $this->call(CategoryTwoTableSeeder::class);
        $this->call(CategoryThreePartTableSeeder::class);
        $this->call(CategoryThreeTableSeeder::class);
        $this->call(CategoryThreePartTableSeeder::class);
        $this->call(PartCategoryTableSeeder::class);
        $this->call(PartConditionTableSeeder::class);
        $this->call(PartGradeTableSeeder::class);
        $this->call(PartSubcategoryTableSeeder::class);
        $this->call(BankTableSeeder::class);
        $this->call(PartTableSeeder::class);
		DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
