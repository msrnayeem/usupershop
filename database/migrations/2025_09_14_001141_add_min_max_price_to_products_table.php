<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMinMaxPriceToProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
    Schema::table('products', function (Blueprint $table) {
        $table->decimal('min_price', 10, 2)->nullable()->after('sale_price');
        $table->decimal('max_price', 10, 2)->nullable()->after('min_price');
    });
}

    public function down()
    {
    Schema::table('products', function (Blueprint $table) {
        $table->dropColumn(['min_price', 'max_price']);
    });
}
}
