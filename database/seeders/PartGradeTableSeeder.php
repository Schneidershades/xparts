<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PartGrade;
use Illuminate\Support\Facades\File;

class PartGradeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        PartGrade::Create([
            'name'             => 'tokunbo',
        ]);
    }
}
