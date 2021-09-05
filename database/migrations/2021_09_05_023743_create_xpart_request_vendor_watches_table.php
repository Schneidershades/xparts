<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateXpartRequestVendorWatchesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('xpart_request_vendor_watches', function (Blueprint $table) {
            $table->id();
            $table->foreignId('xpart_request_id')->nullable()->constrained();
            $table->foreignId('vendor_id')->nullable()->constrained('users');
            $table->unsignedBigInteger('views')->default(1);
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
        Schema::dropIfExists('xpart_request_vendor_watches');
    }
}
