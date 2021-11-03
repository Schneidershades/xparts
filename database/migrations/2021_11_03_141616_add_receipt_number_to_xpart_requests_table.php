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
            $table->string('receipt_number')->nullable()->after('vin_id');
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
            $table->dropColumn('receipt_number');
        });
    }
}
