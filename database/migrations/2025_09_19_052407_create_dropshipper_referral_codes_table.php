<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('dropshipper_referral_codes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('dropshipper_id');
            $table->string('referral_code', 20)->unique();
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->foreign('dropshipper_id')
                  ->references('id')->on('users')
                  ->onDelete('cascade');

            $table->index('referral_code');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('dropshipper_referral_codes');
    }
};
