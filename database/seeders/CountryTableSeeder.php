<?php

use Illuminate\Database\Seeder;
use App\Models\Country;

class CountryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Country::create( [
    		'id'=>1,
    		'name'=>'Nigeria',
            'code'=>'234',
            'currency'=>'NGN',
    	] );
    }
}
