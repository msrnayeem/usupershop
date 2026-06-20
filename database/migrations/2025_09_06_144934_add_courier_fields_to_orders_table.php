<?php
// Create migration: php artisan make:migration add_courier_fields_to_orders_table

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
            $table->timestamp('courier_assigned_at')->nullable()->after('courier_notes');
            $table->unsignedBigInteger('courier_assigned_by')->nullable()->after('courier_assigned_at');
            $table->string('courier_tracking_number')->nullable()->after('courier_assigned_by');
            $table->string('courier_status')->default('pending')->after('courier_tracking_number');
            
            // Add foreign key constraint if you have users table
            $table->foreign('courier_assigned_by')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropForeign(['courier_assigned_by']);
            $table->dropColumn([
                'courier_id',
                'courier_priority', 
                'courier_notes',
                'courier_assigned_at',
                'courier_assigned_by',
                'courier_tracking_number',
                'courier_status'
            ]);
        });
    }
};