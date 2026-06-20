<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BackfillOrderTimestampsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // For pending orders - they already have created_at
        // No need to set anything else
        
        // For confirmed orders - set confirmed_at
        DB::table('orders')
            ->where('status', 'confirmed')
            ->whereNull('confirmed_at')
            ->update(['confirmed_at' => DB::raw('updated_at')]);
        
        $this->command->info('Updated confirmed orders timestamps');
        
        // For packaging orders - set confirmed_at and packaging_at
        DB::table('orders')
            ->where('status', 'packaging')
            ->whereNull('packaging_at')
            ->update([
                'confirmed_at' => DB::raw('CASE WHEN confirmed_at IS NULL THEN updated_at ELSE confirmed_at END'),
                'packaging_at' => DB::raw('updated_at')
            ]);
        
        $this->command->info('Updated packaging orders timestamps');
        
        // For shipment orders - set confirmed_at, packaging_at, and shipment_at
        DB::table('orders')
            ->where('status', 'shipment')
            ->whereNull('shipment_at')
            ->update([
                'confirmed_at' => DB::raw('CASE WHEN confirmed_at IS NULL THEN updated_at ELSE confirmed_at END'),
                'packaging_at' => DB::raw('CASE WHEN packaging_at IS NULL THEN updated_at ELSE packaging_at END'),
                'shipment_at' => DB::raw('updated_at')
            ]);
        
        $this->command->info('Updated shipment orders timestamps');
        
        // For delivered orders - set all timestamps
        DB::table('orders')
            ->where('status', 'delivered')
            ->whereNull('delivered_at')
            ->update([
                'confirmed_at' => DB::raw('CASE WHEN confirmed_at IS NULL THEN updated_at ELSE confirmed_at END'),
                'packaging_at' => DB::raw('CASE WHEN packaging_at IS NULL THEN updated_at ELSE packaging_at END'),
                'shipment_at' => DB::raw('CASE WHEN shipment_at IS NULL THEN updated_at ELSE shipment_at END'),
                'delivered_at' => DB::raw('updated_at')
            ]);
        
        $this->command->info('Updated delivered orders timestamps');
        
        // For returned orders - set returned_at
        DB::table('orders')
            ->where('status', 'return')
            ->whereNull('returned_at')
            ->update([
                'confirmed_at' => DB::raw('CASE WHEN confirmed_at IS NULL THEN updated_at ELSE confirmed_at END'),
                'packaging_at' => DB::raw('CASE WHEN packaging_at IS NULL THEN updated_at ELSE packaging_at END'),
                'shipment_at' => DB::raw('CASE WHEN shipment_at IS NULL THEN updated_at ELSE shipment_at END'),
                'delivered_at' => DB::raw('CASE WHEN delivered_at IS NULL THEN updated_at ELSE delivered_at END'),
                'returned_at' => DB::raw('updated_at')
            ]);
        
        $this->command->info('Updated returned orders timestamps');
        
        // For canceled orders - set canceled_at
        DB::table('orders')
            ->where('status', 'canceled')
            ->whereNull('canceled_at')
            ->update(['canceled_at' => DB::raw('updated_at')]);
        
        $this->command->info('Updated canceled orders timestamps');
        
        $this->command->info('✅ All order timestamps have been backfilled successfully!');
    }
}
