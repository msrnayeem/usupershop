<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTransactionBalanceToWalletsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumn('wallets', 'transaction_date')) {
            Schema::table('wallets', function (Blueprint $table) {
                $table->string('transaction_date')->nullable();
            });
        }

        if (!Schema::hasColumn('wallets', 'transaction_balance')) {
            Schema::table('wallets', function (Blueprint $table) {
                $table->double('transaction_balance')->nullable();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('wallets', function (Blueprint $table) {
            if (Schema::hasColumn('wallets', 'transaction_balance')) {
                $table->dropColumn('transaction_balance');
            }
            if (Schema::hasColumn('wallets', 'transaction_date')) {
                $table->dropColumn('transaction_date');
            }
        });
    }
}
