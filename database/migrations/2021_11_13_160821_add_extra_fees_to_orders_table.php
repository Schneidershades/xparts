<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddExtraFeesToOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->float('delivery_fee')->nullable()->after('discount_amount');
            $table->float('extra_fee_cost')->nullable()->after('delivery_fee');
            $table->text('extra_fee_description')->nullable()->after('extra_fee_cost');
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
            $table->dropColumn(['delivery_fee', 'extra_fee_cost', 'extra_fee_description']);
        });
    }
}
