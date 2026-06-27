<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class AddSmsTemplatesToSmsTable extends Migration
{
    public function up()
    {
        Schema::table('sms', function (Blueprint $table) {
            if (!Schema::hasColumn('sms', 'tpl_order_confirmed_cod_free'))
                $table->text('tpl_order_confirmed_cod_free')->nullable();
            if (!Schema::hasColumn('sms', 'tpl_order_confirmed_cod_paid'))
                $table->text('tpl_order_confirmed_cod_paid')->nullable();
            if (!Schema::hasColumn('sms', 'tpl_order_confirmed_bkash'))
                $table->text('tpl_order_confirmed_bkash')->nullable();
            if (!Schema::hasColumn('sms', 'tpl_order_processing'))
                $table->text('tpl_order_processing')->nullable();
            if (!Schema::hasColumn('sms', 'tpl_order_shipped'))
                $table->text('tpl_order_shipped')->nullable();
            if (!Schema::hasColumn('sms', 'tpl_order_delivered'))
                $table->text('tpl_order_delivered')->nullable();
            if (!Schema::hasColumn('sms', 'tpl_order_cancelled'))
                $table->text('tpl_order_cancelled')->nullable();
            if (!Schema::hasColumn('sms', 'tpl_order_return'))
                $table->text('tpl_order_return')->nullable();
            if (!Schema::hasColumn('sms', 'tpl_welcome_seller'))
                $table->text('tpl_welcome_seller')->nullable();
            if (!Schema::hasColumn('sms', 'tpl_welcome_vendor'))
                $table->text('tpl_welcome_vendor')->nullable();
            if (!Schema::hasColumn('sms', 'tpl_welcome_dropshipper'))
                $table->text('tpl_welcome_dropshipper')->nullable();
            if (!Schema::hasColumn('sms', 'tpl_subscription_expiry'))
                $table->text('tpl_subscription_expiry')->nullable();
            if (!Schema::hasColumn('sms', 'tpl_withdrawal_approved'))
                $table->text('tpl_withdrawal_approved')->nullable();
            if (!Schema::hasColumn('sms', 'tpl_password_reset'))
                $table->text('tpl_password_reset')->nullable();
        });

        // Insert default templates
        DB::table('sms')->where('id', 1)->update([
            'tpl_order_confirmed_cod_free' =>
                "🎉 অভিনন্দন {name}!\nআপনার অর্ডার নিশ্চিত হয়েছে ✅\n\n📦 Invoice: {invoice}\n💳 Payment: Cash on Delivery\n🚚 Delivery: FREE (বিনামূল্যে)\n💰 ডেলিভারিতে পরিশোধ: ৳{due_amount}\n\n🔎 অর্ডার ট্র্যাক করুন:\n{track_link}\n\nU Super Shop ❤️\nhttps://usuper.shop",

            'tpl_order_confirmed_cod_paid' =>
                "🎉 অভিনন্দন {name}!\nআপনার অর্ডার নিশ্চিত হয়েছে ✅\n\n📦 Invoice: {invoice}\n💳 Payment: Cash on Delivery\n🚚 Delivery Charge Paid: ৳{delivery_charge}\n💰 ডেলিভারিতে পরিশোধ: ৳{due_amount}\n\n🔎 অর্ডার ট্র্যাক করুন:\n{track_link}\n\nU Super Shop ❤️\nhttps://usuper.shop",

            'tpl_order_confirmed_bkash' =>
                "🎉 অভিনন্দন {name}!\nপেমেন্ট সম্পন্ন ও অর্ডার নিশ্চিত হয়েছে ✅\n\n📦 Invoice: {invoice}\n💳 Paid: ৳{amount}\n✅ Payment Status: Paid\n\n🔎 অর্ডার ট্র্যাক করুন:\n{track_link}\n\nU Super Shop ❤️\nhttps://usuper.shop",

            'tpl_order_processing' =>
                "📢 {name}, আপনার অর্ডার প্রক্রিয়াধীন ⏳\n\n📦 Invoice: {invoice}\n• Status: Processing\n\n🔎 অর্ডার ট্র্যাক করুন:\n{track_link}\n\nU Super Shop ❤️",

            'tpl_order_shipped' =>
                "🚚 {name}, আপনার পণ্য রওনা হয়েছে! ✅\n\n📦 Invoice: {invoice}\n• Status: Shipped 🚚\n\nডেলিভারি ম্যান সামনে থাকাকালীন পণ্য চেক করুন।\n\n🔎 ট্র্যাক করুন:\n{track_link}\n\nU Super Shop ❤️",

            'tpl_order_delivered' =>
                "🎉 {name}, পণ্য ডেলিভারি সম্পন্ন! ✅\n\n📦 Invoice: {invoice}\n• Status: Delivered ✅\n\nপণ্য পেয়ে সন্তুষ্ট হলে আমাদের Review দিন।\nযেকোনো সমস্যায়: wa.me/8801816622128\n\n🛒 আবার কেনাকাটা করুন:\nhttps://usuper.shop\nU Super Shop ❤️",

            'tpl_order_cancelled' =>
                "⚠️ {name}, আপনার অর্ডার বাতিল হয়েছে ❌\n\n📦 Invoice: {invoice}\n• Status: Cancelled\n\nকারণ হতে পারে:\n• Payment সম্পন্ন হয়নি\n• পণ্য stock নেই\n\nযোগাযোগ: wa.me/8801816622128\n🛒 https://usuper.shop",

            'tpl_order_return' =>
                "↩️ {name}, আপনার অর্ডার Return হয়েছে।\n\n📦 Invoice: {invoice}\n• Status: Returned ↩️\n\n⚠️ Return-এ ডেলিভারি চার্জ ৳{delivery_charge} ফেরতযোগ্য নয়।\nআরও বিস্তারিত জানতে:\nwa.me/8801816622128\n\n🔎 ট্র্যাক করুন:\n{track_link}\n\nU Super Shop ❤️",

            'tpl_welcome_seller' =>
                "🎉 Dear {name},\nWelcome to U Super Shop Seller Panel 🚀\nYour seller account has been created successfully. ✅\n\n📄 Account Details:\n• Invoice No: {invoice}\n• Create Date: {date}\n• Panel Expire Date: {expire_date}\n• Package: {package}\n\n🔐 Login:\n• Phone: {phone}\n• Password: {password}\n\n🖥 Login: https://usuper.shop/customer-login\n\nThank you for joining U Super Shop ❤️",

            'tpl_welcome_vendor' =>
                "🎉 Dear {name},\nWelcome to U Super Shop Vendor Panel 🚀\nYour vendor account has been created successfully. ✅\n\n📄 Account Details:\n• Invoice No: {invoice}\n• Create Date: {date}\n• Panel Expire Date: {expire_date}\n• Package: {package}\n\n🔐 Login:\n• Phone: {phone}\n• Password: {password}\n\n🖥 Login: https://usuper.shop/customer-login\n\nThank you for joining U Super Shop ❤️",

            'tpl_welcome_dropshipper' =>
                "✅ Dear {name},\nYour Dropshipper account is now active on U Super Shop 🚀\n\n📄 Account Information:\n• Invoice No: {invoice}\n• Account Create Date: {date}\n• Membership Expire Date: {expire_date}\n\n🔐 Panel Login:\nhttps://usuper.shop/customer-login\n\nThank you for becoming a partner of U Super Shop ❤️",

            'tpl_subscription_expiry' =>
                "⚠️ Subscription Expiry Reminder\n\nপ্রিয় {name},\nআপনার U Super Shop Subscription মেয়াদ\nশেষ হতে মাত্র {days} দিন বাকি।\n\n📅 Expire Date: {expire_date}\n🔄 Renew করুন: https://usuper.shop/pricing\n\nসময়মতো Renew না করলে account\nsuspend হয়ে যাবে।\n\nU Super Shop ❤️",

            'tpl_password_reset' =>
                "✅ {name}, আপনার পাসওয়ার্ড সফলভাবে পরিবর্তন হয়েছে।\n\n⚠️ আপনি যদি এই পরিবর্তন না করে থাকেন তাহলে এখনই যোগাযোগ করুন:\nwa.me/8801816622128\n\nU Super Shop ❤️",

            'tpl_withdrawal_approved' =>
                "🎉 Dear {name},\n\nWithdraw সফলভাবে সম্পন্ন হয়েছে ✅\n\n💳 PAYMENT INFORMATION\n• Amount: ৳{amount}\n• Transaction ID: {txn_id}\n• Method: {method}\n• Date: {date}\n\nTransaction ID সংরক্ষণ করুন।\n\n🛒 Website: https://usuper.shop\nU Super Shop ❤️",
        ]);
    }

    public function down()
    {
        Schema::table('sms', function (Blueprint $table) {
            $cols = ['tpl_order_confirmed_cod_free','tpl_order_confirmed_cod_paid',
                'tpl_order_confirmed_bkash','tpl_order_processing','tpl_order_shipped',
                'tpl_order_delivered','tpl_order_cancelled','tpl_order_return',
                'tpl_welcome_seller','tpl_welcome_vendor','tpl_welcome_dropshipper',
                'tpl_subscription_expiry','tpl_withdrawal_approved'];
            foreach ($cols as $col) {
                if (Schema::hasColumn('sms', $col)) $table->dropColumn($col);
            }
        });
    }
}
