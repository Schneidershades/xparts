<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PartCategory;
use App\Models\Part;

class PartCategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Part::Create([
            'title'             => 'electrical-303',
            'part_number'             => 'electrical-evniw',
        ]);

        Part::Create([
            'title'             => 'electrical-belt',
            'part_number'             => 'electrical-39302',
        ]);

        PartCategory::Create([
            'name'             => 'electrical',
        ]);
    }
}
