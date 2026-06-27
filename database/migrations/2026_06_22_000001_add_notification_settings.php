<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNotificationSettings extends Migration
{
    public function up()
    {
        Schema::table('settings', function (Blueprint $table) {
            if (!Schema::hasColumn('settings', 'callmebot_api_key')) {
                $table->string('callmebot_api_key')->nullable()->after('refer_commission');
            }
            if (!Schema::hasColumn('settings', 'admin_whatsapp_number')) {
                $table->string('admin_whatsapp_number')->nullable()->default('8801816622128')->after('callmebot_api_key');
            }
            if (!Schema::hasColumn('settings', 'whatsapp_notify_order')) {
                $table->boolean('whatsapp_notify_order')->default(1)->after('admin_whatsapp_number');
            }
            if (!Schema::hasColumn('settings', 'whatsapp_notify_member')) {
                $table->boolean('whatsapp_notify_member')->default(1)->after('whatsapp_notify_order');
            }
            if (!Schema::hasColumn('settings', 'sms_notify_enabled')) {
                $table->boolean('sms_notify_enabled')->default(1)->after('whatsapp_notify_member');
            }
        });
    }

    public function down()
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->dropColumnIfExists('callmebot_api_key');
            $table->dropColumnIfExists('admin_whatsapp_number');
            $table->dropColumnIfExists('whatsapp_notify_order');
            $table->dropColumnIfExists('whatsapp_notify_member');
            $table->dropColumnIfExists('sms_notify_enabled');
        });
    }
}
