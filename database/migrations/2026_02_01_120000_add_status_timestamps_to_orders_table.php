<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStatusTimestampsToOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->timestamp('confirmed_at')->nullable()->after('status');
            $table->timestamp('packaging_at')->nullable()->after('confirmed_at');
            $table->timestamp('shipment_at')->nullable()->after('packaging_at');
            $table->timestamp('delivered_at')->nullable()->after('shipment_at');
            $table->timestamp('returned_at')->nullable()->after('delivered_at');
            $table->timestamp('canceled_at')->nullable()->after('returned_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn([
                'confirmed_at',
                'packaging_at',
                'shipment_at',
                'delivered_at',
                'returned_at',
                'canceled_at'
            ]);
        });
    }
}
