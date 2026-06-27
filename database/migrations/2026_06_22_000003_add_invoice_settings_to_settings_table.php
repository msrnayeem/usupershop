<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class AddInvoiceSettingsToSettingsTable extends Migration
{
    public function up()
    {
        Schema::table('settings', function (Blueprint $table) {
            if (!Schema::hasColumn('settings', 'invoice_prefix'))
                $table->string('invoice_prefix', 20)->default('USP')->after('description');
            if (!Schema::hasColumn('settings', 'invoice_digits'))
                $table->tinyInteger('invoice_digits')->default(5)->after('invoice_prefix');
            if (!Schema::hasColumn('settings', 'invoice_start_no'))
                $table->unsignedInteger('invoice_start_no')->default(1)->after('invoice_digits');
            if (!Schema::hasColumn('settings', 'invoice_show_date'))
                $table->tinyInteger('invoice_show_date')->default(0)->after('invoice_start_no');
            if (!Schema::hasColumn('settings', 'invoice_footer_note'))
                $table->text('invoice_footer_note')->nullable()->after('invoice_show_date');
            if (!Schema::hasColumn('settings', 'invoice_thank_you'))
                $table->string('invoice_thank_you', 255)->nullable()->after('invoice_footer_note');
        });

        // Set defaults
        DB::table('settings')->where('id', 1)->update([
            'invoice_prefix'     => 'USP',
            'invoice_digits'     => 5,
            'invoice_start_no'   => 1,
            'invoice_show_date'  => 0,
            'invoice_footer_note'=> 'পণ্য গ্রহণের সময় ডেলিভারি ম্যানের সামনেই চেক করুন। যেকোনো সমস্যায় WhatsApp করুন: 01816622128',
            'invoice_thank_you'  => 'ধন্যবাদ U Super Shop-এ কেনাকাটার জন্য! আপনার সন্তুষ্টিই আমাদের লক্ষ্য।',
        ]);
    }

    public function down()
    {
        Schema::table('settings', function (Blueprint $table) {
            foreach (['invoice_prefix','invoice_digits','invoice_start_no',
                      'invoice_show_date','invoice_footer_note','invoice_thank_you'] as $col) {
                if (Schema::hasColumn('settings', $col)) $table->dropColumn($col);
            }
        });
    }
}
