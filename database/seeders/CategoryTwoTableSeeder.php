<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CategoryTwo;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class CategoryTwoTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        CategoryTwo::truncate();
  
        $json = File::get("database/category_2.json");
        $countries = json_decode($json);
  
        foreach ($countries as $key => $value) {
            CategoryTwo::create([
                "title" => $value->title,
                "slug" => Str::slug($value->title .' '. $value->category_1_id, '-'),
                "category_one_id" => $value->category_1_id,
            ]);
        }
    }
}
