<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class AddSeoSettingsToSettingsTable extends Migration
{
    public function up()
    {
        Schema::table('settings', function (Blueprint $table) {
            if (!Schema::hasColumn('settings', 'seo_site_title'))
                $table->string('seo_site_title', 200)->nullable();
            if (!Schema::hasColumn('settings', 'seo_meta_description'))
                $table->text('seo_meta_description')->nullable();
            if (!Schema::hasColumn('settings', 'seo_meta_keywords'))
                $table->text('seo_meta_keywords')->nullable();
            if (!Schema::hasColumn('settings', 'seo_og_image'))
                $table->string('seo_og_image', 300)->nullable();
            if (!Schema::hasColumn('settings', 'seo_google_verification'))
                $table->string('seo_google_verification', 200)->nullable();
            if (!Schema::hasColumn('settings', 'seo_schema_json'))
                $table->longText('seo_schema_json')->nullable();
            if (!Schema::hasColumn('settings', 'social_facebook'))
                $table->string('social_facebook', 300)->nullable();
            if (!Schema::hasColumn('settings', 'social_youtube'))
                $table->string('social_youtube', 300)->nullable();
            if (!Schema::hasColumn('settings', 'social_instagram'))
                $table->string('social_instagram', 300)->nullable();
            if (!Schema::hasColumn('settings', 'social_telegram'))
                $table->string('social_telegram', 300)->nullable();
            if (!Schema::hasColumn('settings', 'social_tiktok'))
                $table->string('social_tiktok', 300)->nullable();
            if (!Schema::hasColumn('settings', 'business_address'))
                $table->string('business_address', 300)->nullable();
            if (!Schema::hasColumn('settings', 'business_email'))
                $table->string('business_email', 200)->nullable();
            if (!Schema::hasColumn('settings', 'seo_favicon'))
                $table->string('seo_favicon', 300)->nullable();
            if (!Schema::hasColumn('settings', 'seo_logo'))
                $table->string('seo_logo', 300)->nullable();
            if (!Schema::hasColumn('settings', 'google_analytics_id'))
                $table->string('google_analytics_id', 50)->nullable();
        });

        DB::table('settings')->where('id', 1)->update([
            'seo_site_title'        => 'U Super Shop | Best Online Shop in Bangladesh',
            'seo_meta_description'  => 'U Super Shop | Best Online Shop — কেনাকাটা আর আয়ের সেরা ঠিকানা! সেরা ডিলে প্রিমিয়াম শপিং করুন অথবা সেলার ও ড্রপশিপার হয়ে ইনভেস্টমেন্ট ছাড়াই ব্যবসা শুরু করুন। দ্রুত ডেলিভারি ও বিশ্বস্ততার নিশ্চয়তা। আজই যোগ দিন | আনলিমিটেড রেফার বোনাসের সেরা প্ল্যাটফর্ম। এখনই ভিজিট করুন!',
            'seo_meta_keywords'     => 'U Super Shop, usuper.shop, online shop bangladesh, best online shopping bd, dropshipping bangladesh, reselling platform bd, সেলার, ভেন্ডর, ড্রপশিপার, অনলাইন শপ বাংলাদেশ, কেনাকাটা, আয়, রেফার বোনাস, zero investment business bd',
            'seo_google_verification'=> 'ADD_YOUR_VERIFICATION_CODE_HERE',
            'seo_schema_json'       => '',
            'social_facebook'       => 'https://www.facebook.com/share/1VjqK6xoDm/',
            'social_youtube'        => 'https://youtube.com/@usupershop?feature=shared',
            'social_instagram'      => 'https://www.instagram.com/usupershop?igsh=MXducXBidGE5NzRsNQ==',
            'social_telegram'       => 'https://t.me/usupershop1',
            'social_tiktok'         => 'https://tiktok.com/@usupershop',
            'business_address'      => 'Dhaka, Bangladesh',
            'business_email'        => 'usupershopbd@gmail.com',
        ]);
    }

    public function down()
    {
        Schema::table('settings', function (Blueprint $table) {
            foreach (['seo_site_title','seo_meta_description','seo_meta_keywords',
                'seo_og_image','seo_google_verification','seo_schema_json',
                'social_facebook','social_youtube','social_instagram',
                'social_telegram','social_tiktok','business_address','business_email'] as $col)
                if (Schema::hasColumn('settings', $col)) $table->dropColumn($col);
        });
    }
}
