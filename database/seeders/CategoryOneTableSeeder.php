<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CategoryOne;
use Illuminate\Support\Facades\File;

class CategoryOneTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        CategoryOne::truncate();
  
        $json = File::get("database/category_one.json");
        $countries = json_decode($json);
  
        foreach ($countries as $key => $value) {
            CategoryOne::create([
                "id" => $value->id,
                "title" => $value->title
            ]);
        }
    }
}
