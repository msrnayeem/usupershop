<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommissionLedgersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('commission_ledgers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('reseller_id')->nullable();
            $table->unsignedBigInteger('order_id')->nullable();
            $table->decimal('debit_balance')->nullable();
            $table->decimal('credit_balance')->nullable();
            $table->string('payment_mood')->nullable();
            $table->string('reference')->nullable();
            $table->date('entry_date')->nullable();
            $table->tinyInteger('status')->nullable();
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
        Schema::dropIfExists('commission_ledgers');
    }
}
