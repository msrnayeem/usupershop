<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPerformanceIndexes extends Migration
{
    public function up()
    {
        // ── Products table indexes ───────────────────────────────────
        Schema::table('products', function (Blueprint $table) {
            $this->addIndexSafe($table, 'products', 'status');
            $this->addIndexSafe($table, 'products', 'category_id');
            $this->addIndexSafe($table, 'products', 'hot_deals');
            $this->addIndexSafe($table, 'products', 'featured');
            $this->addIndexSafe($table, 'products', 'special_offer');
            $this->addIndexSafe($table, 'products', 'special_deals');
            $this->addIndexSafe($table, 'products', 'user_id');
            // Composite index for homepage query
            if (!$this->indexExists('products', 'products_status_id_index')) {
                $table->index(['status', 'id'], 'products_status_id_index');
            }
        });

        // ── Orders table indexes ─────────────────────────────────────
        Schema::table('orders', function (Blueprint $table) {
            $this->addIndexSafe($table, 'orders', 'user_id');
            $this->addIndexSafe($table, 'orders', 'delivery_status');
            $this->addIndexSafe($table, 'orders', 'payment_method');
            if (!$this->indexExists('orders', 'orders_user_status_index')
                && Schema::hasColumn('orders', 'user_id')
                && Schema::hasColumn('orders', 'delivery_status')) {
                $table->index(['user_id', 'delivery_status'], 'orders_user_status_index');
            }
        });

        // ── Users table indexes ──────────────────────────────────────
        Schema::table('users', function (Blueprint $table) {
            $this->addIndexSafe($table, 'users', 'usertype');
            $this->addIndexSafe($table, 'users', 'status');
            $this->addIndexSafe($table, 'users', 'payment_status');
            $this->addIndexSafe($table, 'users', 'refer_code');
            $this->addIndexSafe($table, 'users', 'reseller_id');
            $this->addIndexSafe($table, 'users', 'login_blocked_at');
        });

        // ── Order details ────────────────────────────────────────────
        Schema::table('order_details', function (Blueprint $table) {
            $this->addIndexSafe($table, 'order_details', 'order_id');
            $this->addIndexSafe($table, 'order_details', 'product_id');
            $this->addIndexSafe($table, 'order_details', 'seller_id');
        });

        // ── Transactions ─────────────────────────────────────────────
        Schema::table('transactions', function (Blueprint $table) {
            $this->addIndexSafe($table, 'transactions', 'user_id');
            $this->addIndexSafe($table, 'transactions', 'tnx_type');
            $this->addIndexSafe($table, 'transactions', 'status');
        });

        // ── Coupons ──────────────────────────────────────────────────
        Schema::table('coupons', function (Blueprint $table) {
            $this->addIndexSafe($table, 'coupons', 'status');
            if (!$this->indexExists('coupons', 'coupons_promoCode_index'))
                $table->index('promoCode', 'coupons_promoCode_index');
        });

        // ── Categories ───────────────────────────────────────────────
        Schema::table('categories', function (Blueprint $table) {
            $this->addIndexSafe($table, 'categories', 'is_show');
        });
    }

    private function addIndexSafe(Blueprint $table, string $tableName, string $column): void
    {
        if (!Schema::hasColumn($tableName, $column)) {
            return; // column doesn't exist, skip
        }
        if (!$this->indexExists($tableName, "{$tableName}_{$column}_index")) {
            try {
                $table->index($column, "{$tableName}_{$column}_index");
            } catch (\Exception $e) {
                // Index already exists — ignore
            }
        }
    }

    private function indexExists(string $tableName, string $indexName): bool
    {
        try {
            $indexes = \DB::select("SHOW INDEX FROM `{$tableName}` WHERE Key_name = ?", [$indexName]);
            return !empty($indexes);
        } catch (\Exception $e) {
            return false;
        }
    }

    public function down()
    {
        // Indexes are safe to drop on rollback
        $tables = [
            'products'     => ['status','category_id','hot_deals','featured','special_offer','special_deals','user_id'],
            'orders'       => ['user_id','delivery_status','payment_method'],
            'users'        => ['usertype','status','payment_status','refer_code','reseller_id','login_blocked_at'],
            'order_details'=> ['order_id','product_id','seller_id'],
            'transactions' => ['user_id','tnx_type','status'],
            'coupons'      => ['status'],
            'categories'   => ['is_show'],
        ];
        foreach ($tables as $table => $cols) {
            Schema::table($table, function (Blueprint $t) use ($table, $cols) {
                foreach ($cols as $col) {
                    try { $t->dropIndex("{$table}_{$col}_index"); } catch (\Exception $e) {}
                }
            });
        }
    }
}
