<?php

namespace Database\Seeders;

use App\Models\DeliveryRate;
use Illuminate\Database\Seeder;

class DeliveryRateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DeliveryRate::truncate();
        DeliveryRate::create( [
    		'type' =>'flat',
    		'amount'=> 0,
    	] );
    }
}
