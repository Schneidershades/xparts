<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuotesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quotes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('xpart_request_id')->nullable()->constrained();
            $table->foreignId('vendor_id')->nullable()->constrained('users');
            $table->foreignId('part_grade_id')->nullable()->constrained();
            $table->foreignId('part_category_id')->nullable()->constrained();
            $table->foreignId('part_subcategory_id')->nullable()->constrained();
            $table->foreignId('part_condition_id')->nullable()->constrained();
            $table->string('brand')->nullable();
            $table->integer('quantity')->nullable();
            $table->string('part_number')->nullable();
            $table->integer('part_warranty')->nullable();
            $table->float('price')->nullable();
            $table->string('measurement')->nullable();
            $table->text('description')->nullable();
            $table->string('status')->default('active');
            $table->foreignId('markup_pricing_id')->nullable()->constrained('markup_pricings');
            $table->float('markup_price')->nullable();
            $table->integer('city_id')->index()->unsigned()->nullable();
            $table->integer('state_id')->index()->unsigned()->nullable();
            $table->integer('country_id')->index()->unsigned()->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('quotes');
    }
}
