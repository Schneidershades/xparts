<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAdminRemarksToOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->foreignId('delivery_rate_id')->nullable()->constrained()->after('payment_charge_id');

            $table->string('payment_transfer_status')->nullable()->after('payment_status');
            $table->string('payment_recipient_code')->nullable()->after('payment_transfer_status');
            $table->string('payment_transfer_code')->nullable()->after('payment_recipient_code');
            $table->string('payment_transfer_remarks')->nullable()->after('payment_transfer_code');
            $table->string('payment_gateway_remarks')->nullable()->after('payment_transfer_remarks');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('payment_transfer_status');
            $table->dropColumn('payment_recipient_code');
            $table->dropColumn('payment_transfer_code');
            $table->dropColumn('payment_transfer_remarks');
            $table->dropColumn('payment_gateway_remarks');
            $table->dropColumn('delivery_rate_id');
        });
    }
}
