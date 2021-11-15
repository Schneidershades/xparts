<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDeliveryToQuotesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('quotes', function (Blueprint $table) {
            $table->float('margin')->nullable()->after('description');
            $table->float('delivery_fee')->nullable()->after('margin');
            $table->float('extra_fee_cost')->nullable()->after('delivery_fee');
            $table->text('extra_fee_description')->nullable()->after('extra_fee_cost');
            $table->foreignId('admin_id')->nullable()->constrained('users')->after('extra_fee_description');
            $table->foreignId('approving_admin_id')->nullable()->constrained('users')->after('admin_id');
            $table->string('payment_method')->nullable()->after('approving_admin_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('quotes', function (Blueprint $table) {
            $table->dropForeign('admin_id');
            $table->dropForeign('approving_admin_id');
            $table->dropColumn(['admin_id', 'approving_admin_id', 'payment_method', 'margin', 'delivery_fee', 'extra_fee_cost', 'extra_fee_description']);
        });
    }
}
