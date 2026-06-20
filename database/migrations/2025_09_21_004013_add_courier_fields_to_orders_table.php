<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->string('courier_id')->nullable()->after('status');
            $table->string('courier_priority')->default('normal')->after('courier_id');
            $table->text('courier_notes')->nullable()->after('courier_priority');
            $table->string('courier_tracking_id')->nullable()->after('courier_notes');
            $table->json('courier_response')->nullable()->after('courier_tracking_id');
            $table->timestamp('courier_assigned_at')->nullable()->after('courier_response');
  
            
            $table->index(['courier_id', 'status']);
            $table->index('courier_tracking_id');
         
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
   
            $table->dropIndex(['courier_id', 'status']);
            $table->dropIndex(['courier_tracking_id']);
            $table->dropColumn([
                'courier_id',
                'courier_priority', 
                'courier_notes',
                'courier_tracking_id',
                'courier_response',
                'courier_assigned_at',
                
            ]);
        });
    }
};