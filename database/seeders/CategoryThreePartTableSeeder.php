<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CategoryThreePart;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class CategoryThreePartTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        CategoryThreePart::truncate();
  
        $json = File::get("database/category_3_x_part.json");
        $countries = json_decode($json);
  
        foreach ($countries as $key => $value) {
            CategoryThreePart::create([
                "category_three_id" => $value->category_3_id,
                "part_id" => $value->part_id,
            ]);
        }
    }
}