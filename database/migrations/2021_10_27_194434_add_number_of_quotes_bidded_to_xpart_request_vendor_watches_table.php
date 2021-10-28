<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNumberOfQuotesBiddedToXpartRequestVendorWatchesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('xpart_request_vendor_watches', function (Blueprint $table) {
            $table->unsignedBigInteger('number_of_bids')->default(0)->after('views');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('xpart_request_vendor_watches', function (Blueprint $table) {
            $table->dropColumn('number_of_bids');
        });
    }
}
