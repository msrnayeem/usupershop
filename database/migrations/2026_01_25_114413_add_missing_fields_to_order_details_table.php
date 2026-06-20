<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMissingFieldsToOrderDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('order_details', function (Blueprint $table) {
            // Add color_name and size_name if they don't exist
            if (!Schema::hasColumn('order_details', 'color_name')) {
                $table->string('color_name')->nullable()->after('color_id');
            }
            if (!Schema::hasColumn('order_details', 'size_name')) {
                $table->string('size_name')->nullable()->after('size_id');
            }
            // Add buy_price and sell_price if they don't exist
            if (!Schema::hasColumn('order_details', 'buy_price')) {
                $table->decimal('buy_price', 10, 2)->default(0)->after('quantity');
            }
            if (!Schema::hasColumn('order_details', 'sell_price')) {
                $table->decimal('sell_price', 10, 2)->default(0)->after('buy_price');
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('order_details', function (Blueprint $table) {
            $table->dropColumn(['color_name', 'size_name', 'buy_price', 'sell_price']);
        });
    }
}
