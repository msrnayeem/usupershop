<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentLogsTable extends Migration
{
    public function up()
    {
        if (!Schema::hasTable('payment_logs')) {
            Schema::create('payment_logs', function (Blueprint $table) {
                $table->id();
                $table->string('payment_id', 100)->index();      // bKash paymentID
                $table->string('trx_id', 100)->nullable()->index(); // bKash trxID
                $table->string('invoice_no', 100)->nullable();
                $table->string('payment_type', 50);               // customer_order / user_subscription
                $table->string('status', 20);                     // success / fail / cancel / duplicate
                $table->decimal('amount', 12, 2)->default(0);
                $table->string('ip_address', 50)->nullable();
                $table->string('user_agent', 300)->nullable();
                $table->text('notes')->nullable();
                $table->timestamps();
            });
        }
    }

    public function down()
    {
        Schema::dropIfExists('payment_logs');
    }
}
