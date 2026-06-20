<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCouponsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coupons', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('promoCode')->uniqid();
            $table->integer('canBeUsed')->default('1');
            $table->integer('available')->default('1');
            $table->integer('availableFor')->comment('0=Customer, 1=Staff, 2=Both');
            $table->date('start_date');
            $table->date('end_date');
            $table->integer('discount_type');
            $table->string('discount_amount');
            $table->string('min_amount');
            $table->integer('status')->default('1');
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
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
        Schema::dropIfExists('coupons');
    }
}
