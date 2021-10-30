<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsToPaymentMethodsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('payment_methods', function (Blueprint $table) {
            $table->string('type')->nullable()->after('name');
            $table->string('connect')->nullable()->after('type');
            $table->string('payment_gateway')->nullable()->after('connect');
            $table->string('stage')->nullable()->after('payment_gateway');
            $table->string('public_key')->nullable()->after('stage');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('payment_methods', function (Blueprint $table) {
            $table->dropColumn('type');
            $table->dropColumn('connect');
            $table->dropColumn('stage');
            $table->dropColumn('public_key');
        });
    }
}
