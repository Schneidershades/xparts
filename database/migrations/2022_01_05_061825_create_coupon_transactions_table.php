<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCouponTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coupon_transactions', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->nullable()->constrained()->cascadeOnUpdate()->nullOnDelete();
            $table->integer('coupon_id')->nullable()->constrained()->cascadeOnUpdate()->nullOnDelete();
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
        Schema::dropIfExists('coupon_transactions');
    }
}
