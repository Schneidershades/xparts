<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('receipt_number')->nullable();
            $table->string('title')->nullable();
            $table->string('details')->nullable();
            $table->foreignId('user_id')->nullable()->constrained();  
            $table->foreignId('address_id')->nullable()->constrained();       
            $table->integer('vat_id')->index()->unsigned()->nullable();
            $table->integer('discount_id')->index()->unsigned()->nullable();
            $table->integer('payment_method_id')->index()->unsigned()->nullable();
            $table->integer('payment_charge_id')->index()->unsigned()->nullable();
            $table->float('subtotal')->nullable();
            $table->string('orderable_type')->nullable();
            $table->integer('orderable_id')->nullable();
            $table->float('total')->nullable();
            $table->float('amount_paid')->nullable();
            $table->float('discount_amount')->nullable();
            $table->string('action')->nullable();
            $table->integer('currency_id')->nullable();
            $table->string('currency')->nullable();
            $table->string('payment_method')->nullable();
            $table->string('payment_gateway')->nullable();
            $table->float('payment_gateway_charged_percentage')->nullable();
            $table->float('payment_gateway_expected_charged_percentage')->nullable();
            $table->string('payment_reference')->nullable();
            $table->float('payment_gateway_charge')->default(0);
            $table->float('payment_gateway_remittance')->default(0);
            $table->string('payment_code')->nullable();
            $table->string('payment_message')->nullable();
            $table->string('payment_status')->default('pending');
            $table->string('platform_initiated')->nullable();
            $table->string('transaction_initiated_date')->nullable();
            $table->string('transaction_initiated_time')->nullable();
            $table->string('transaction_type')->nullable();
            $table->date('date_time_paid')->nullable();
            $table->date('date_cancelled')->nullable();
            $table->text('cancelled_cancel')->nullable();
            $table->string('service_status')->default('pending');
            $table->string('status')->default('pending');
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
        Schema::dropIfExists('orders');
    }
}
