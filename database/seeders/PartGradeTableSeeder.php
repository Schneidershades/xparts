<?php

namespace Database\Seeders;

use App\Models\PartGrade;
use Illuminate\Database\Seeder;

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
            'name'             => 'Tokunbo',
        ]);

        PartGrade::Create([
            'name'             => 'OEM',
        ]);

        PartGrade::Create([
            'name'             => 'Aftermarket',
        ]);

        PartGrade::Create([
            'name'             => 'China',
        ]);

        PartGrade::Create([
            'name'             => 'New',
        ]);
    }
}
