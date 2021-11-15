<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAdminActionFieldsToWalletTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('wallet_transactions', function (Blueprint $table) {
            $table->foreignId('admin_id')->nullable()->constrained('users')->after('user_id');
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
        Schema::table('wallet_transactions', function (Blueprint $table) {
            $table->dropForeign('admin_id');
            $table->dropColumn(['admin_id', 'payment_method']);
        });
    }
}
