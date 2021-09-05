<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CategoryThree;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class CategoryThreeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        CategoryThree::truncate();
  
        $json = File::get("database/json/category_3.json");
        $countries = json_decode($json);
  
        foreach ($countries as $key => $value) {
            CategoryThree::create([
                "title" => $value->title,
                "slug" => Str::slug($value->title .' '. $value->category_2, '-'),
                "image" => $value->_image,
                "category_two_id" => $value->category_2_id,
                "category_two_name" => $value->category_2,
            ]);
        }
    }
}
