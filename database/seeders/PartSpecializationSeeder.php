<?php

namespace Database\Seeders;

use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use App\Models\PartSpecialization;

class PartSpecializationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        PartSpecialization::create([
            "name" => 'Accessories',
            "slug" => Str::slug('Accessories', '-'),
        ]);
        PartSpecialization::create([
            "name" => 'Belt Drive',
            "slug" => Str::slug('Belt Drive', '-'),
        ]);
        PartSpecialization::create([
            "name" => 'Body & Lamp Assembly',
            "slug" => Str::slug('Body & Lamp Assembly', '-'),
        ]);
        PartSpecialization::create([
            "name" => 'Brake & Wheel Hub',
            "slug" => Str::slug('Brake & Wheel Hub', '-'),
        ]);
        PartSpecialization::create([
            "name" => 'Cooling System',
            "slug" => Str::slug('Cooling System', '-'),
        ]);
        PartSpecialization::create([
            "name" => 'Drivetrain',
            "slug" => Str::slug('Drivetrain', '-'),
        ]);
        PartSpecialization::create([
            "name" => 'Electrical Components',
            "slug" => Str::slug('Electrical Components', '-'),
        ]);
        PartSpecialization::create([
            "name" => 'Electrical-Module, Switch & Relay',
            "slug" => Str::slug('Electrical-Module, Switch & Relay', '-'),
        ]);
        PartSpecialization::create([
            "name" => 'Engine',
            "slug" => Str::slug('Engine', '-'),
        ]);
        PartSpecialization::create([
            "name" => 'Exhaust & Emission',
            "slug" => Str::slug('Exhaust & Emission', '-'),
        ]);
        PartSpecialization::create([
            "name" => 'Fuel & Air',
            "slug" => Str::slug('Fuel & Air', '-'),
        ]);
        PartSpecialization::create([
            "name" => 'Heat & Air Conditioning',
            "slug" => Str::slug('Heat & Air Conditioning', '-'),
        ]);
        PartSpecialization::create([
            "name" => 'Hoses/Lines & Clamps',
            "slug" => Str::slug('Hoses/Lines & Clamps', '-'),
        ]);
        PartSpecialization::create([
            "name" => 'Ignition',
            "slug" => Str::slug('Ignition', '-'),
        ]);
        PartSpecialization::create([
            "name" => 'Interior',
            "slug" => Str::slug('Interior', '-'),
        ]);
        PartSpecialization::create([
            "name" => 'Steering',
            "slug" => Str::slug('Steering', '-'),
        ]);
        PartSpecialization::create([
            "name" => 'Suspension',
            "slug" => Str::slug('Suspension', '-'),
        ]);
        PartSpecialization::create([
            "name" => 'Transmission-Automatic',
            "slug" => Str::slug('Transmission-Automatic', '-'),
        ]);
        PartSpecialization::create([
            "name" => 'Transmission-Manual',
            "slug" => Str::slug('Transmission-Manual', '-'),
        ]);
        PartSpecialization::create([
            "name" => 'Wheel',
            "slug" => Str::slug('Wheel', '-'),
        ]);
        PartSpecialization::create([
            "name" => 'Wiper & Washer',
            "slug" => Str::slug('Wiper & Washer', '-'),
        ]);
    }
}
