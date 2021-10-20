<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Part;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class PartTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Part::truncate();
  
        $json1 = File::get("database/json/parts.json");
        $countries1 = ($json1);
  
        foreach ($countries1 as $key => $value) {
            Part::create([
                "name" => $value->DESCRIPTION,
                "slug" => Str::slug($value->DESCRIPTION, '-'),
            ]);
        }

		DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}