<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (Schema::hasTable('users') && !Schema::hasColumn('users', 'activated_at')) {
            Schema::table('users', function (Blueprint $table) {
                $table->timestamp('activated_at')->nullable()->after('status');
            });
        }

        if (Schema::hasTable('users') && Schema::hasColumn('users', 'activated_at')) {
            $activeUsers = DB::table('users')
                ->select('id', 'created_at')
                ->where('status', 1)
                ->whereNull('activated_at')
                ->get();

            foreach ($activeUsers as $activeUser) {
                DB::table('users')
                    ->where('id', $activeUser->id)
                    ->update([
                        'activated_at' => $activeUser->created_at ?? now(),
                    ]);
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('users') && Schema::hasColumn('users', 'activated_at')) {
            Schema::table('users', function (Blueprint $table) {
                $table->dropColumn('activated_at');
            });
        }
    }
};

