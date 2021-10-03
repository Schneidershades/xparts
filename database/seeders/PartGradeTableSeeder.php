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
            'name'             => 'Brand New (OEM)',
        ]);

        PartGrade::Create([
            'name'             => 'Brand New (Aftermarket)',
        ]);

        PartGrade::Create([
            'name'             => 'Brand New (China)',
        ]);

        PartGrade::Create([
            'name'             => 'Tokunbo',
        ]);

        PartGrade::Create([
            'name'             => 'Refurbished',
        ]);
    }
}
