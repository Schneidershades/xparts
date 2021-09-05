<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(CategoryOneTableSeeder::class);
        $this->call(CategoryTwoTableSeeder::class);
        $this->call(CategoryThreePartTableSeeder::class);
        $this->call(CategoryThreeTableSeeder::class);
        $this->call(CategoryThreePartTableSeeder::class);
        $this->call(PartCategoryTableSeeder::class);
        $this->call(PartConditionTableSeeder::class);
        $this->call(PartGradeTableSeeder::class);
        $this->call(PartSubcategoryTableSeeder::class);
        $this->call(PartTableSeeder::class);
        // $this->call(RoleTableSeeder::class);
        // $this->call(UsersTableSeeder::class);
        $this->call(PermissionSeeder::class);
    }
}
