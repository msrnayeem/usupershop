<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLinkToSlidersTable extends Migration
{
    public function up()
    {
        Schema::table('sliders', function (Blueprint $table) {
            if (!Schema::hasColumn('sliders', 'slider_link'))
                $table->string('slider_link', 500)->nullable()->after('image');
            if (!Schema::hasColumn('sliders', 'link_target'))
                $table->string('link_target', 10)->default('_self')->after('slider_link');
        });
    }

    public function down()
    {
        Schema::table('sliders', function (Blueprint $table) {
            if (Schema::hasColumn('sliders', 'slider_link')) $table->dropColumn('slider_link');
            if (Schema::hasColumn('sliders', 'link_target')) $table->dropColumn('link_target');
        });
    }
}
