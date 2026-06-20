<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentGatewaysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payment_gateways', function (Blueprint $table) {
            $table->id();
            $table->boolean('active_status')->default(0);
            $table->string('BKASH_USERNAME')->nullable();
            $table->string('BKASH_PASSWORD')->nullable();
            $table->string('BKASH_API_KEY')->nullable();
            $table->string('BKASH_SECRET_KEY')->nullable();
            $table->string('NAGAD_USERNAME')->nullable();
            $table->string('NAGAD_PASSWORD')->nullable();
            $table->string('NAGAD_API_KEY')->nullable();
            $table->string('NAGAD_SECRET_KEY')->nullable();
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
        Schema::dropIfExists('payment_gateways');
    }
}
