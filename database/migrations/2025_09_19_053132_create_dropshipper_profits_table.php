<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('dropshipper_profits', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('dropshipper_id');
            $table->unsignedBigInteger('order_id');
            $table->decimal('total_profit', 10, 2);
            $table->enum('status', ['pending', 'approved', 'paid'])->default('pending');
            $table->timestamp('paid_at')->nullable();
            $table->timestamps();

            $table->foreign('dropshipper_id')
                  ->references('id')->on('users')
                  ->onDelete('cascade');

            $table->foreign('order_id')
                  ->references('id')->on('orders')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('dropshipper_profits');
    }
};
