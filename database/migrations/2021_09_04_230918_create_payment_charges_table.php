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
            $table->integer('payment_method_id')->nullable()->constrained();
            $table->string('gateway')->nullable();
            $table->string('type')->default('percentage');
            $table->integer('percentage_gateway_charge')->nullable();
            $table->integer('percentage_company_charge')->nullable();
            $table->integer('amount_gateway_charge')->nullable();
            $table->integer('amount_company_charge')->nullable();
            $table->string('currency')->nullable();
            $table->string('currency_symbol')->nullable();
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
