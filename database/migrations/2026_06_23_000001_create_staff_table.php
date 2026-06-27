<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStaffTable extends Migration
{
    public function up()
    {
        // Staff members table
        Schema::create('staff', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('role', 30)->default('employee'); // 'manager' or 'employee'
            $table->json('permissions')->nullable(); // array of allowed modules
            $table->tinyInteger('is_active')->default(1);
            $table->foreignId('created_by')->constrained('users')->onDelete('cascade'); // always main admin
            $table->timestamps();
        });

        // Add staff role to users usertype enum isn't reliable - use separate staff table
        // usertype = 'staff' for all staff members
    }

    public function down()
    {
        Schema::dropIfExists('staff');
    }
}
