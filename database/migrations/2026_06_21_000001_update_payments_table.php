<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdatePaymentsTable extends Migration
{
    public function up()
    {
        Schema::table('payments', function (Blueprint $table) {
            if (!Schema::hasColumn('payments', 'payment_amount')) {
                $table->decimal('payment_amount', 10, 2)->default(0)->after('transaction_no');
            }
            if (!Schema::hasColumn('payments', 'payment_date')) {
                $table->timestamp('payment_date')->nullable()->after('payment_amount');
            }
            if (!Schema::hasColumn('payments', 'payment_status')) {
                $table->string('payment_status', 50)->default('pending')->after('payment_date');
            }
        });
    }

    public function down()
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->dropColumnIfExists('payment_amount');
            $table->dropColumnIfExists('payment_date');
            $table->dropColumnIfExists('payment_status');
        });
    }
}
