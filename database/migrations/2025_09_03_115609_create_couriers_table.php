<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCouriersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
   public function up()
    {
    Schema::create('couriers', function (Blueprint $table) {
        $table->id();
        $table->string('name'); // Pathao, Steadfast, RedX
        $table->string('client_id')->nullable();
        $table->string('client_secret')->nullable();
        $table->string('api_key')->nullable();
        $table->string('store_id')->nullable();
        $table->boolean('is_active')->default(0); // Active/Inactive
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('couriers');
    }
}
