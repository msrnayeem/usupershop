<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateWithdrawMethodsTable extends Migration
{
    public function up()
    {
        Schema::create('withdraw_methods', function (Blueprint $table) {
            $table->id();
            $table->string('name', 50);           // bKash, Nagad, Rocket, Bank
            $table->string('logo_icon', 10)->nullable(); // emoji
            $table->string('color', 20)->nullable();     // brand color
            $table->string('number_label', 100)->default('মোবাইল নম্বর'); // label for number field
            $table->string('number_placeholder', 100)->default('01XXXXXXXXX');
            $table->tinyInteger('is_active')->default(1);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });

        // Default withdraw methods
        $now = now();
        $methods = [
            ['name'=>'bKash',  'logo_icon'=>'💗', 'color'=>'#E2136E', 'number_label'=>'bKash নম্বর',  'number_placeholder'=>'01XXXXXXXXX', 'is_active'=>1, 'sort_order'=>1],
            ['name'=>'Nagad',  'logo_icon'=>'🟠', 'color'=>'#F7941D', 'number_label'=>'Nagad নম্বর',  'number_placeholder'=>'01XXXXXXXXX', 'is_active'=>1, 'sort_order'=>2],
            ['name'=>'Rocket', 'logo_icon'=>'🟣', 'color'=>'#8B008B', 'number_label'=>'Rocket নম্বর', 'number_placeholder'=>'01XXXXXXXXX', 'is_active'=>1, 'sort_order'=>3],
            ['name'=>'Bank',   'logo_icon'=>'🏦', 'color'=>'#1a5276', 'number_label'=>'Account Number / Branch', 'number_placeholder'=>'Bank Account নম্বর', 'is_active'=>0, 'sort_order'=>4],
        ];

        foreach ($methods as $m) {
            DB::table('withdraw_methods')->insert(array_merge($m, ['created_at'=>$now,'updated_at'=>$now]));
        }
    }

    public function down()
    {
        Schema::dropIfExists('withdraw_methods');
    }
}
