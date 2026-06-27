<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class UpdateCouriersTable extends Migration
{
    public function up()
    {
        Schema::table('couriers', function (Blueprint $table) {
            if (!Schema::hasColumn('couriers', 'secret_key'))
                $table->string('secret_key', 300)->nullable()->after('api_key');
            if (!Schema::hasColumn('couriers', 'username'))
                $table->string('username', 200)->nullable()->after('secret_key');
            if (!Schema::hasColumn('couriers', 'password'))
                $table->string('password', 300)->nullable()->after('username');
            if (!Schema::hasColumn('couriers', 'base_url'))
                $table->string('base_url', 300)->nullable()->after('password');
            if (!Schema::hasColumn('couriers', 'is_sandbox'))
                $table->tinyInteger('is_sandbox')->default(0)->after('base_url');
            if (!Schema::hasColumn('couriers', 'notes'))
                $table->text('notes')->nullable()->after('is_sandbox');
        });

        // Insert Steadfast
        if (!DB::table('couriers')->where('name', 'Steadfast')->exists()) {
            DB::table('couriers')->insert([
                'name'        => 'Steadfast',
                'api_key'     => '',
                'secret_key'  => '',
                'base_url'    => 'https://portal.packzy.com/api/v1',
                'is_active'   => 0,
                'is_sandbox'  => 0,
                'notes'       => 'Steadfast Courier — Bangladesh-এর জনপ্রিয় courier। portal.packzy.com থেকে API Key ও Secret Key পাবেন।',
                'created_at'  => now(),
                'updated_at'  => now(),
            ]);
        }

        // Insert Pathao
        if (!DB::table('couriers')->where('name', 'Pathao')->exists()) {
            DB::table('couriers')->insert([
                'name'          => 'Pathao',
                'client_id'     => '',
                'client_secret' => '',
                'username'      => '',
                'password'      => '',
                'store_id'      => '',
                'base_url'      => 'https://courier-api.pathao.com',
                'is_active'     => 0,
                'is_sandbox'    => 0,
                'notes'         => 'Pathao Courier — courier.pathao.com থেকে Client ID, Client Secret, Username ও Password পাবেন।',
                'created_at'    => now(),
                'updated_at'    => now(),
            ]);
        }
    }

    public function down()
    {
        Schema::table('couriers', function (Blueprint $table) {
            foreach (['secret_key','username','password','base_url','is_sandbox','notes'] as $col)
                if (Schema::hasColumn('couriers', $col)) $table->dropColumn($col);
        });
    }
}
