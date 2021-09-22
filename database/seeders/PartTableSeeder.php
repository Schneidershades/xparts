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
  
        $json1 = File::get("database/json/parts.json");
        $countries1 = json_decode($json1);
  
        foreach ($countries1 as $key => $value) {
            Part::create([
                "name" => $value->DESCRIPTION,
                "slug" => Str::slug($value->DESCRIPTION, '-'),
            ]);
        }
    }
}