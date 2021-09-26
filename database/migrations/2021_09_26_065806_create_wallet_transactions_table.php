<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWalletTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wallet_transactions', function (Blueprint $table) {
            $table->id();
            $table->string('receipt_number')->nullable();
            $table->string('title')->nullable();
            $table->foreignId('user_id')->nullable()->constrained();
            $table->text('details')->nullable();
            $table->decimal('amount', 40, 2)->default(0);
            $table->decimal('amount_paid', 40, 2)->default(0);
            $table->string('category')->nullable();
            $table->string('remarks')->nullable();
            $table->string('transaction_type')->nullable();
            $table->string('status')->default('pending');
            $table->decimal('balance', 40, 2)->default(0);
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
        Schema::dropIfExists('wallet_transactions');
    }
}
