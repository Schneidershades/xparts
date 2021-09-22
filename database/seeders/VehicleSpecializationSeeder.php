<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use App\Models\VehicleSpecialization;

class VehicleSpecializationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        VehicleSpecialization::truncate();
  
        $json = File::get("database/json/vehiclespec.json");
        $countries = json_decode($json);
  
        foreach ($countries as $key => $value) {
            VehicleSpecialization::create([
                "name" => $value->VEHICLE_SPEC,
                "slug" => Str::slug($value->VEHICLE_SPEC, '-'),
            ]);
        }
    }
}
