<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentChargesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payment_charges', function (Blueprint $table) {
            $table->id();
            $table->integer('gateway')->nullable();
            $table->string('type')->defaule('percentage');
            $table->integer('percentage_gateway_charge')->nullable();
            $table->integer('percentage_company_charge')->nullable();
            $table->integer('amount_gateway_charge')->nullable();
            $table->integer('amount_company_charge')->nullable();
            $table->boolean('active')->default(true);
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
        Schema::dropIfExists('payment_charges');
    }
}
