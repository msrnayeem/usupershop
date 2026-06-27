<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class AddLivechatSettingsToSettingsTable extends Migration
{
    public function up()
    {
        Schema::table('settings', function (Blueprint $table) {
            if (!Schema::hasColumn('settings', 'livechat_enabled'))
                $table->tinyInteger('livechat_enabled')->default(1)->after('description');
            if (!Schema::hasColumn('settings', 'livechat_provider'))
                $table->string('livechat_provider', 20)->default('tawkto')->after('livechat_enabled');
            if (!Schema::hasColumn('settings', 'tawkto_property_id'))
                $table->string('tawkto_property_id', 100)->nullable()->after('livechat_provider');
            if (!Schema::hasColumn('settings', 'tawkto_widget_id'))
                $table->string('tawkto_widget_id', 100)->nullable()->after('tawkto_property_id');
            if (!Schema::hasColumn('settings', 'whatsapp_float_enabled'))
                $table->tinyInteger('whatsapp_float_enabled')->default(1)->after('tawkto_widget_id');
        });

        DB::table('settings')->where('id', 1)->update([
            'livechat_enabled'    => 1,
            'livechat_provider'   => 'tawkto',
            'tawkto_property_id'  => '67769592af5bfec1dbe5cfa4',
            'tawkto_widget_id'    => '1j8nukq3o',
            'whatsapp_float_enabled' => 1,
        ]);
    }

    public function down()
    {
        Schema::table('settings', function (Blueprint $table) {
            foreach (['livechat_enabled','livechat_provider','tawkto_property_id','tawkto_widget_id'] as $col)
                if (Schema::hasColumn('settings', $col)) $table->dropColumn($col);
        });
    }
}
