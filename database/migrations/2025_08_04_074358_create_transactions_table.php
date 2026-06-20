<?php

use App\utilities\Constant;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('transactions')) {
            Schema::create('transactions', function (Blueprint $table) {
                $table->id();
                $table->string('user_id')->nullable();
                $table->string('from_user_id')->nullable();
                $table->string('payment_id')->nullable();
                $table->tinyInteger('wallet_type')->default(Constant::WALLET_TYPE['none']);
                $table->tinyInteger('tnx_type')->default(Constant::TRANSACTION_TYPE['none']);
                $table->decimal('credit', 10, 2)->default(0);
                $table->decimal('debit', 10, 2)->default(0);
                $table->string('note')->nullable();
                $table->longText('description')->nullable();
                $table->tinyInteger('status')->default(Constant::STATUS['pending']);
                $table->tinyInteger('in_status')->default(Constant::IN_STATUS['active']);
                $table->string('date', 100);
                $table->timestamps();
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
        Schema::dropIfExists('transactions');
    }
}
