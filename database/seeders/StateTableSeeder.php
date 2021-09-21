<?php

use Illuminate\Database\Seeder;
use App\Models\State;

class StateTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	State::create( [
    		'id'=>1,
    		'name'=>'Abia',
            'country_id'=>1
    	] );

    	State::create( [
    		'id'=>2,
    		'name'=>'Adamawa',
            'country_id'=>1
    	] );

    	State::create( [
    		'id'=>3,
    		'name'=>'Akwa Ibom',
            'country_id'=>1
    	] );

    	State::create( [
    		'id'=>4,
    		'name'=>'Anambra',
            'country_id'=>1
    	] );

    	State::create( [
    		'id'=>5,
    		'name'=>'Bauchi',
            'country_id'=>1
    	] );

    	State::create( [
    		'id'=>6,
    		'name'=>'Bayelsa',
            'country_id'=>1
    	] );

    	State::create( [
    		'id'=>7,
    		'name'=>'Benue',
            'country_id'=>1
    	] );

    	State::create( [
    		'id'=>8,
    		'name'=>'Borno',
            'country_id'=>1
    	] );

    	State::create( [
    		'id'=>9,
    		'name'=>'Cross River',
            'country_id'=>1
    	] );

    	State::create( [
    		'id'=>10,
    		'name'=>'Delta',
            'country_id'=>1
    	] );

    	State::create( [
    		'id'=>11,
    		'name'=>'Ebonyi',
            'country_id'=>1
    	] );

    	State::create( [
    		'id'=>12,
    		'name'=>'Edo',
            'country_id'=>1
    	] );

    	State::create( [
    		'id'=>13,
    		'name'=>'Ekiti',
            'country_id'=>1
    	] );

    	State::create( [
    		'id'=>14,
    		'name'=>'Enugu',
            'country_id'=>1
    	] );

    	State::create( [
    		'id'=>15,
    		'name'=>'FCT',
            'country_id'=>1
    	] );

    	State::create( [
    		'id'=>16,
    		'name'=>'Gombe',
            'country_id'=>1
    	] );

    	State::create( [
    		'id'=>17,
    		'name'=>'Imo',
            'country_id'=>1
    	] );

    	State::create( [
    		'id'=>18,
    		'name'=>'Jigawa',
            'country_id'=>1
    	] );

    	State::create( [
    		'id'=>19,
    		'name'=>'Kaduna',
            'country_id'=>1
    	] );

    	State::create( [
    		'id'=>20,
    		'name'=>'Kano',
            'country_id'=>1
    	] );

    	State::create( [
    		'id'=>21,
    		'name'=>'Katsina',
            'country_id'=>1
    	] );

    	State::create( [
    		'id'=>22,
    		'name'=>'Kebbi',
            'country_id'=>1
    	] );

    	State::create( [
    		'id'=>23,
    		'name'=>'Kogi',
            'country_id'=>1
    	] );

    	State::create( [
    		'id'=>24,
    		'name'=>'Kwara',
            'country_id'=>1
    	] );

    	State::create( [
    		'id'=>25,
    		'name'=>'Lagos',
            'country_id'=>1
    	] );

    	State::create( [
    		'id'=>26,
    		'name'=>'Nasarawa',
            'country_id'=>1
    	] );

    	State::create( [
    		'id'=>27,
    		'name'=>'Niger',
            'country_id'=>1
    	] );

    	State::create( [
    		'id'=>28,
    		'name'=>'Ogun',
            'country_id'=>1
    	] );

    	State::create( [
    		'id'=>29,
    		'name'=>'Ondo',
            'country_id'=>1
    	] );

    	State::create( [
    		'id'=>30,
    		'name'=>'Osun',
            'country_id'=>1
    	] );

    	State::create( [
    		'id'=>31,
    		'name'=>'Oyo',
            'country_id'=>1
    	] );

    	State::create( [
    		'id'=>32,
    		'name'=>'Plateau',
            'country_id'=>1
    	] );

    	State::create( [
    		'id'=>33,
    		'name'=>'Rivers',
            'country_id'=>1
    	] );

    	State::create( [
    		'id'=>34,
    		'name'=>'Sokoto',
            'country_id'=>1
    	] );

    	State::create( [
    		'id'=>35,
    		'name'=>'Taraba',
            'country_id'=>1
    	] );

    	State::create( [
    		'id'=>36,
    		'name'=>'Yobe',
            'country_id'=>1
    	] );

    	State::create( [
    		'id'=>37,
    		'name'=>'Zamfara',
            'country_id'=>1
    	] );
    }
}
