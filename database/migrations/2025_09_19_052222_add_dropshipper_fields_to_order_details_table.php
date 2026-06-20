<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('order_details', function (Blueprint $table) {
            $table->decimal('dropshipper_sell_price', 10, 2)->nullable()->after('sell_price');
            $table->decimal('dropshipper_profit', 10, 2)->default(0)->after('dropshipper_sell_price');
        });
    }

    public function down(): void
    {
        Schema::table('order_details', function (Blueprint $table) {
            $table->dropColumn(['dropshipper_sell_price', 'dropshipper_profit']);
        });
    }
};
