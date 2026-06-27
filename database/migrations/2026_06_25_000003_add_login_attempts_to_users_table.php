<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLoginAttemptsToUsersTable extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'failed_login_attempts'))
                $table->tinyInteger('failed_login_attempts')->default(0)->after('status');
            if (!Schema::hasColumn('users', 'login_blocked_at'))
                $table->timestamp('login_blocked_at')->nullable()->after('failed_login_attempts');
            if (!Schema::hasColumn('users', 'login_blocked_reason'))
                $table->string('login_blocked_reason', 300)->nullable()->after('login_blocked_at');
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            foreach (['failed_login_attempts','login_blocked_at','login_blocked_reason'] as $col)
                if (Schema::hasColumn('users', $col)) $table->dropColumn($col);
        });
    }
}
