<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Part;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class PartTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Part::truncate();
  
        $json1 = File::get("database/json/parts/json/part-1.json");
        $json2 = File::get("database/json/parts/json/part-2.json");
        $json3 = File::get("database/json/parts/json/part-3.json");
        $json4 = File::get("database/json/parts/json/part-4.json");
        $json5 = File::get("database/json/parts/json/part-5.json");
        $countries1 = json_decode($json1);
        $countries2 = json_decode($json2);
        $countries3 = json_decode($json3);
        $countries4 = json_decode($json4);
        $countries5 = json_decode($json5);
  
        foreach ($countries1 as $key => $value) {
            Part::create([
                "id" => $value->id,
                "title" => $value->title,
                "image" => $value->image,
                "part_number" => $value->part_number,
                "slug" => Str::slug($value->title .' '. $value->part_number, '-'),
            ]);
        }

        foreach ($countries2 as $key => $value) {
            Part::create([
                "id" => $value->id,
                "title" => $value->title,
                "image" => $value->image,
                "part_number" => $value->part_number,
                "slug" => Str::slug($value->title .' '. $value->part_number, '-'),
            ]);
        }

        foreach ($countries3 as $key => $value) {
            Part::create([
                "id" => $value->id,
                "title" => $value->title,
                "image" => $value->image,
                "part_number" => $value->part_number,
                "slug" => Str::slug($value->title .' '. $value->part_number, '-'),
            ]);
        }

        foreach ($countries4 as $key => $value) {
            Part::create([
                "id" => $value->id,
                "title" => $value->title,
                "image" => $value->image,
                "part_number" => $value->part_number,
                "slug" => Str::slug($value->title .' '. $value->part_number, '-'),
            ]);
        }

        foreach ($countries5 as $key => $value) {
            Part::create([
                "id" => $value->id,
                "title" => $value->title,
                "image" => $value->image,
                "part_number" => $value->part_number,
                "slug" => Str::slug($value->title .' '. $value->part_number, '-'),
            ]);
        }
    }
}