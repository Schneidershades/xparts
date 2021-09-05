<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PartCategory;
use Illuminate\Support\Facades\File;

class PartCategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        PartCategory::Create([
            'name'             => 'electrical',
        ]);
    }
}
