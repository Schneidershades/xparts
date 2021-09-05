<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PartSubcategory;
use File;

class PartSubcategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        PartSubcategory::Create([
            'name'             => 'gadget',
        ]);
    }
}
