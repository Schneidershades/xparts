<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PartCondition;
use Illuminate\Support\Facades\File;

class PartConditionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        PartCondition::Create([
            'name'             => 'new',
        ]);

        PartCondition::Create([
            'name'             => 'old',
        ]);

        PartCondition::Create([
            'name'             => 'repairs',
        ]);
    }
}
