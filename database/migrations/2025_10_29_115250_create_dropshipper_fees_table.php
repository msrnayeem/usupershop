<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDropshipperFeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('dropshipper_fees')) {
            Schema::create('dropshipper_fees', function (Blueprint $table) {
                $table->id();
                $table->string('account_type_of_dropshipper')->nullable();
                $table->double('subscription_fees', 8, 2)->nullable();
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dropshipper_fees');
    }
}
