<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPlanFeaturesToSellerFeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('seller_fees', function (Blueprint $table) {
            if (!Schema::hasColumn('seller_fees', 'plan_features')) {
                $table->longText('plan_features')->nullable()->after('subscription_fees');
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
        Schema::table('seller_fees', function (Blueprint $table) {
            if (Schema::hasColumn('seller_fees', 'plan_features')) {
                $table->dropColumn('plan_features');
            }
        });
    }
}
