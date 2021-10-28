<?php

namespace Database\Seeders;

use App\Models\DeliverySetting;
use Illuminate\Database\Seeder;

class DeliverySettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DeliverySetting::create( [
    		'type' =>'flat',
    		'amount'=> 2000,
    	] );
    }
}