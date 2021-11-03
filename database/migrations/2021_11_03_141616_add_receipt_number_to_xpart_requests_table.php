<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddReceiptNumberToXpartRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('xpart_requests', function (Blueprint $table) {
            $table->foreignId('order_id')->nullable()->constrained()->after('status'); 
            $table->string('receipt_number')->nullable()->after('order_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('xpart_requests', function (Blueprint $table) {
            $table->dropForeign(['order_id']);
            $table->dropColumn(['receipt_number', 'order_id']);
        });
    }
}