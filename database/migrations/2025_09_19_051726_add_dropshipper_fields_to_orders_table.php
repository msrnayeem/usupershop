<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDropshipperFieldsToOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::table('orders', function (Blueprint $table) {
    $table->unsignedBigInteger('dropshipper_id')->nullable()->after('user_id');
    $table->decimal('dropshipper_profit', 10, 2)->default(0)->after('grand_total');
    $table->enum('order_type', ['regular', 'dropship_referral'])->default('regular')->after('status');
    
    $table->foreign('dropshipper_id')->references('id')->on('users')->onDelete('set null');
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
        $table->dropForeign(['dropshipper_id']);
        $table->dropColumn(['dropshipper_id', 'dropshipper_profit', 'order_type']);
    });
}
}
