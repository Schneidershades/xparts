<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDescriptionFieldToXpartRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('xpart_requests', function (Blueprint $table) {
            $table->text('user_description')->nullable()->after('status');
            $table->text('admin_description')->nullable()->after('user_description');
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
            $table->dropColumn(['user_description', 'admin_description']);
        });
    }
}
