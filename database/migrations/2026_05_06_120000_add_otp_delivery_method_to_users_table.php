<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddOtpDeliveryMethodToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('users') && !Schema::hasColumn('users', 'otp_delivery_method')) {
            Schema::table('users', function (Blueprint $table) {
                $table->string('otp_delivery_method', 20)->default('both')->after('email_verified_at');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasTable('users') && Schema::hasColumn('users', 'otp_delivery_method')) {
            Schema::table('users', function (Blueprint $table) {
                $table->dropColumn('otp_delivery_method');
            });
        }
    }
}