<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMarkupPricingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('markup_pricings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->float('min_value', 40, 2)->default(0);
            $table->float('max_value', 40, 2)->default(0);
            $table->integer('percentage');
            $table->string('type')->nullable();
            $table->string('status')->default('inactive');
            $table->softDeletes();
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
        Schema::dropIfExists('markup_pricings');
    }
}
