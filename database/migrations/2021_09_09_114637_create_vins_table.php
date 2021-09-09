<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVinsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vins', function (Blueprint $table) {
            $table->id();
            $table->string('vin_number');
            $table->string('make')->nullable();
            $table->string('manufacturer')->nullable();
            $table->string('model')->nullable();
            $table->string('model_year')->nullable();
            $table->string('plant_company_name')->nullable();
            $table->string('plant_country')->nullable();
            $table->string('plant_state')->nullable();
            $table->string('series')->nullable();
            $table->string('series_description')->nullable();
            $table->string('vehicle_type')->nullable();
            $table->string('trim')->nullable();
            $table->string('body_class')->nullable();
            $table->string('engine_configuration')->nullable();
            $table->string('engine_cylinders')->nullable();
            $table->string('engine_hp')->nullable();
            $table->string('engine_kw')->nullable();
            $table->string('engine_model')->nullable();
            $table->string('fuel_type')->nullable();
            $table->string('doors')->nullable();
            $table->string('driver_type')->nullable();
            $table->timestamps();
        });
    }
   

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vins');
    }
}
