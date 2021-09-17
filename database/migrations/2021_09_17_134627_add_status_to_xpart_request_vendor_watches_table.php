<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStatusToXpartRequestVendorWatchesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('xpart_request_vendor_watches', function (Blueprint $table) {
            $table->string('status')->default('pending');
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
            $table->dropColumn('status');
        });
    }
}
