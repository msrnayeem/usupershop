<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('dropshipper_product_prices', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('dropshipper_id');
            $table->unsignedBigInteger('product_id');
            $table->decimal('selling_price', 10, 2);
            $table->timestamps();

            $table->foreign('dropshipper_id')
                  ->references('id')->on('users')
                  ->onDelete('cascade');

            $table->foreign('product_id')
                  ->references('id')->on('products')
                  ->onDelete('cascade');

            $table->unique(['dropshipper_id', 'product_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('dropshipper_product_prices');
    }
};
