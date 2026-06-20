<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateColorSettingsTable extends Migration
{
    public function up()
    {
        Schema::create('color_settings', function (Blueprint $table) {
            $table->id();
            $table->string('element_name'); 
            $table->string('color_code'); 
            $table->string('display_name'); 
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('color_settings');
    }
}