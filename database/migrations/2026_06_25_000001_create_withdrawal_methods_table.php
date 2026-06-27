<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateWithdrawalMethodsTable extends Migration
{
    public function up()
    {
        Schema::create('withdrawal_methods', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);              // bKash, Nagad, Rocket, Bank
            $table->string('logo_emoji', 10)->nullable(); // 💳🏦
            $table->string('logo_color', 20)->nullable(); // #e8001d
            $table->string('account_label', 100)->default('Mobile Number'); // "Mobile Number" or "Account Number"
            $table->string('account_placeholder', 200)->default('01XXXXXXXXX');
            $table->string('account_regex', 200)->nullable(); // validation pattern
            $table->tinyInteger('is_active')->default(1);
            $table->integer('sort_order')->default(0);
            $table->text('instructions')->nullable(); // How to use
            $table->timestamps();
        });

        // Default methods
        DB::table('withdrawal_methods')->insert([
            [
                'name'               => 'bKash',
                'logo_emoji'         => '💳',
                'logo_color'         => '#e8001d',
                'account_label'      => 'bKash নম্বর',
                'account_placeholder'=> '01XXXXXXXXX (bKash Personal/Agent)',
                'account_regex'      => '^01[3-9][0-9]{8}$',
                'is_active'          => 1,
                'sort_order'         => 1,
                'instructions'       => 'বিকাশ Personal বা Agent নম্বর দিন। Send Money charge প্রযোজ্য।',
                'created_at'         => now(),
                'updated_at'         => now(),
            ],
            [
                'name'               => 'Nagad',
                'logo_emoji'         => '🟠',
                'logo_color'         => '#f57c00',
                'account_label'      => 'Nagad নম্বর',
                'account_placeholder'=> '01XXXXXXXXX (Nagad Personal)',
                'account_regex'      => '^01[3-9][0-9]{8}$',
                'is_active'          => 1,
                'sort_order'         => 2,
                'instructions'       => 'নগদ Personal নম্বর দিন।',
                'created_at'         => now(),
                'updated_at'         => now(),
            ],
            [
                'name'               => 'Rocket',
                'logo_emoji'         => '🚀',
                'logo_color'         => '#7b1fa2',
                'account_label'      => 'Rocket নম্বর',
                'account_placeholder'=> '01XXXXXXXXX-X (Rocket নম্বর)',
                'account_regex'      => '^01[1][0-9]{8,9}$',
                'is_active'          => 1,
                'sort_order'         => 3,
                'instructions'       => 'Dutch-Bangla Rocket নম্বর দিন।',
                'created_at'         => now(),
                'updated_at'         => now(),
            ],
        ]);
    }

    public function down()
    {
        Schema::dropIfExists('withdrawal_methods');
    }
}
