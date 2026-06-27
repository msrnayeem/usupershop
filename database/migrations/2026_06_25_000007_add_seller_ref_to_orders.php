<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSellerRefToOrders extends Migration
{
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            if (!Schema::hasColumn('orders', 'seller_ref_id'))
                $table->unsignedBigInteger('seller_ref_id')->nullable()->after('user_id')
                      ->comment('Seller who shared the link — gets commission on delivery');
            if (!Schema::hasColumn('orders', 'seller_ref_commission'))
                $table->decimal('seller_ref_commission', 10, 2)->default(0)->after('seller_ref_id')
                      ->comment('Commission amount credited to referring seller');
            if (!Schema::hasColumn('orders', 'seller_ref_paid'))
                $table->tinyInteger('seller_ref_paid')->default(0)->after('seller_ref_commission')
                      ->comment('0=pending, 1=paid on delivery');
        });
    }

    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            foreach (['seller_ref_id','seller_ref_commission','seller_ref_paid'] as $col)
                if (Schema::hasColumn('orders', $col)) $table->dropColumn($col);
        });
    }
}
