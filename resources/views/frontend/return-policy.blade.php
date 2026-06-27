@extends('frontend.layouts.master')
@section('title', 'Return Policy — U Super Shop')
@section('content')
<div style="padding:30px 0 60px;background:#f6f7fb;min-height:60vh;">
<div class="container">
<div style="max-width:800px;margin:0 auto;background:#fff;border-radius:16px;box-shadow:0 2px 20px rgba(0,0,0,.07);overflow:hidden;">

  {{-- Header --}}
  <div style="background:linear-gradient(135deg,#e8001d,#b30015);padding:32px 30px;text-align:center;">
    <div style="font-size:48px;margin-bottom:10px;">📦</div>
    <h1 style="color:#fff;font-size:24px;font-weight:800;margin:0 0 6px;font-family:'Hind Siliguri',sans-serif;">রিটার্ন পলিসি</h1>
    <p style="color:rgba(255,255,255,.85);margin:0;font-size:13px;">U Super Shop — Return Policy</p>
  </div>

  <div style="padding:26px 26px 32px;font-family:'Hind Siliguri',sans-serif;color:#333;line-height:1.8;font-size:15px;">

    {{-- Critical Notice --}}
    <div style="background:#fff3cd;border:2px solid #f5c400;border-radius:12px;padding:18px 20px;margin-bottom:22px;display:flex;gap:14px;align-items:flex-start;">
      <span style="font-size:32px;flex-shrink:0;line-height:1.2;">⚠️</span>
      <div>
        <strong style="color:#856404;font-size:16px;display:block;margin-bottom:6px;">অত্যন্ত গুরুত্বপূর্ণ বিজ্ঞপ্তি</strong>
        <p style="color:#856404;margin:0;font-size:13px;line-height:1.8;">
          পণ্য গ্রহণের আগে <strong>ডেলিভারি ম্যান সামনে থাকা অবস্থায়</strong> অবশ্যই পণ্য ভালোভাবে চেক করুন। পেমেন্ট বুঝিয়ে দেওয়ার পর এবং ডেলিভারি ম্যান চলে যাওয়ার পর <strong>কোনো অভিযোগ বা রিটার্ন গ্রহণ করা হবে না।</strong>
        </p>
      </div>
    </div>

    {{-- Step 1: Check & Pay --}}
    <div style="background:#f8f9ff;border-radius:14px;padding:20px 22px;margin-bottom:14px;border:1.5px solid #dde0ff;position:relative;overflow:hidden;">
      <div style="position:absolute;top:0;left:0;width:4px;height:100%;background:#1e25fa;border-radius:4px 0 0 4px;"></div>
      <div style="display:flex;align-items:center;gap:12px;margin-bottom:13px;">
        <div style="width:40px;height:40px;background:#1e25fa;border-radius:50%;display:flex;align-items:center;justify-content:center;flex-shrink:0;color:#fff;font-size:18px;font-weight:800;">১</div>
        <strong style="color:#1e25fa;font-size:16px;">পণ্য গ্রহণের সময় অবশ্যই করুন</strong>
      </div>
      <ul style="margin:0;padding-left:22px;color:#444;font-size:14px;line-height:2.2;list-style:none;">
        <li style="display:flex;gap:10px;align-items:flex-start;margin-bottom:6px;"><span style="color:#1e25fa;font-weight:800;flex-shrink:0;">✔</span><span>ডেলিভারি ম্যানের সামনেই প্যাকেট খুলুন ও পণ্য ভালোভাবে চেক করুন</span></li>
        <li style="display:flex;gap:10px;align-items:flex-start;margin-bottom:6px;"><span style="color:#1e25fa;font-weight:800;flex-shrink:0;">✔</span><span>পণ্যের রঙ, সাইজ, সংখ্যা ও অবস্থা অর্ডারের সাথে মিলিয়ে দেখুন</span></li>
        <li style="display:flex;gap:10px;align-items:flex-start;margin-bottom:6px;"><span style="color:#1e25fa;font-weight:800;flex-shrink:0;">✔</span><span>সব ঠিক থাকলে ডেলিভারি ম্যানকে <strong>Payment বুঝিয়ে দিন</strong></span></li>
        <li style="display:flex;gap:10px;align-items:flex-start;"><span style="color:#1e25fa;font-weight:800;flex-shrink:0;">✔</span><span>Payment দেওয়ার পর আপনার Order সম্পন্ন বলে গণ্য হবে</span></li>
      </ul>

      {{-- Payment reminder box --}}
      <div style="background:#1e25fa;border-radius:10px;padding:12px 16px;margin-top:14px;display:flex;align-items:center;gap:12px;">
        <span style="font-size:24px;flex-shrink:0;">💳</span>
        <div>
          <strong style="color:#fff;font-size:13px;display:block;margin-bottom:2px;">Payment অবশ্যই ডেলিভারি ম্যানের সামনে</strong>
          <span style="color:rgba(255,255,255,.85);font-size:14px;">পণ্য চেক করার পর সন্তুষ্ট হলে তবেই Payment করুন — একবার Payment করলে আর ফেরত নেওয়া যাবে না।</span>
        </div>
      </div>
    </div>

    {{-- Step 2: Return process --}}
    <div style="background:#f0fff4;border-radius:14px;padding:20px 22px;margin-bottom:14px;border:1.5px solid #c3f0db;position:relative;overflow:hidden;">
      <div style="position:absolute;top:0;left:0;width:4px;height:100%;background:#00a855;border-radius:4px 0 0 4px;"></div>
      <div style="display:flex;align-items:center;gap:12px;margin-bottom:13px;">
        <div style="width:40px;height:40px;background:#00a855;border-radius:50%;display:flex;align-items:center;justify-content:center;flex-shrink:0;color:#fff;font-size:18px;font-weight:800;">২</div>
        <strong style="color:#00a855;font-size:16px;">রিটার্ন করতে চাইলে যা করবেন</strong>
      </div>
      <ul style="margin:0;padding-left:22px;color:#444;font-size:14px;line-height:2.2;list-style:none;">
        <li style="display:flex;gap:10px;align-items:flex-start;margin-bottom:6px;"><span style="color:#00a855;font-weight:800;flex-shrink:0;">✔</span><span>রিটার্ন করতে হলে <strong>ডেলিভারি ম্যান সামনে থাকা অবস্থায়</strong> পণ্য ফেরত দিতে হবে</span></li>
        <li style="display:flex;gap:10px;align-items:flex-start;margin-bottom:6px;"><span style="color:#00a855;font-weight:800;flex-shrink:0;">✔</span><span>ত্রুটিপূর্ণ বা ভুল পণ্য পেলে সাথে সাথে ভিডিও বা ছবি তুলুন প্রমাণ হিসেবে</span></li>
        <li style="display:flex;gap:10px;align-items:flex-start;margin-bottom:6px;"><span style="color:#00a855;font-weight:800;flex-shrink:0;">✔</span><span>ডেলিভারি ম্যানকে পণ্য বুঝিয়ে দিন — তিনি নিয়ে যাবেন</span></li>
        <li style="display:flex;gap:10px;align-items:flex-start;"><span style="color:#00a855;font-weight:800;flex-shrink:0;">✔</span><span>রিটার্নের কারণ স্পষ্টভাবে জানান</span></li>
      </ul>

      {{-- Delivery charge for return --}}
      <div style="background:#00a855;border-radius:10px;padding:12px 16px;margin-top:14px;display:flex;align-items:center;gap:12px;">
        <span style="font-size:24px;flex-shrink:0;">🚚</span>
        <div>
          <strong style="color:#fff;font-size:13px;display:block;margin-bottom:2px;">রিটার্নে ডেলিভারি চার্জ প্রযোজ্য</strong>
          <span style="color:rgba(255,255,255,.88);font-size:14px;">পণ্য রিটার্ন করতে হলে <strong style="color:#fff;">ডেলিভারি চার্জ দিয়ে রিটার্ন করতে হবে।</strong> পণ্যের মূল্য ফেরত দেওয়া হলেও ডেলিভারি চার্জ ফেরতযোগ্য নয়।</span>
        </div>
      </div>
    </div>

    {{-- Step 3: After delivery man leaves --}}
    <div style="background:#fff5f5;border-radius:14px;padding:20px 22px;margin-bottom:24px;border:1.5px solid #fcd8da;position:relative;overflow:hidden;">
      <div style="position:absolute;top:0;left:0;width:4px;height:100%;background:#e8001d;border-radius:4px 0 0 4px;"></div>
      <div style="display:flex;align-items:center;gap:12px;margin-bottom:13px;">
        <div style="width:40px;height:40px;background:#e8001d;border-radius:50%;display:flex;align-items:center;justify-content:center;flex-shrink:0;color:#fff;font-size:18px;font-weight:800;">৩</div>
        <strong style="color:#e8001d;font-size:16px;">ডেলিভারি ম্যান চলে যাওয়ার পর</strong>
      </div>
      <ul style="margin:0;padding-left:22px;color:#444;font-size:14px;line-height:2.2;list-style:none;">
        <li style="display:flex;gap:10px;align-items:flex-start;margin-bottom:6px;"><span style="color:#e8001d;font-weight:800;flex-shrink:0;">✗</span><span>ডেলিভারি ম্যান চলে যাওয়ার পর <strong>কোনো রিটার্ন, রিফান্ড বা অভিযোগ গ্রহণ করা হবে না</strong></span></li>
        <li style="display:flex;gap:10px;align-items:flex-start;margin-bottom:6px;"><span style="color:#e8001d;font-weight:800;flex-shrink:0;">✗</span><span>"পণ্য পছন্দ হয়নি" বা "মন পরিবর্তন" এই কারণে রিটার্ন গ্রহণযোগ্য নয়</span></li>
        <li style="display:flex;gap:10px;align-items:flex-start;"><span style="color:#e8001d;font-weight:800;flex-shrink:0;">✗</span><span>Payment দেওয়ার পর ও ডেলিভারি ম্যান চলে যাওয়ার পর Order সম্পন্ন বলে গণ্য হবে</span></li>
      </ul>

      <div style="background:#e8001d;border-radius:10px;padding:12px 16px;margin-top:14px;text-align:center;">
        <strong style="color:#fff;font-size:14px;">⚠️ পণ্য নেওয়ার আগেই সব চেক করুন — পরে কোনো সুযোগ নেই</strong>
      </div>
    </div>

    {{-- Divider --}}
    <div style="text-align:center;margin:24px 0;position:relative;">
      <div style="position:absolute;top:50%;left:0;right:0;height:1px;background:#eee;"></div>
      <span style="background:#fff;padding:0 14px;color:#aaa;font-size:13px;position:relative;">Customer Support</span>
    </div>

    {{-- WhatsApp Support --}}
    <div style="background:linear-gradient(135deg,#25d366,#128c3b);border-radius:14px;padding:22px 20px;margin-bottom:14px;text-align:center;">
      <div style="font-size:40px;margin-bottom:10px;">💬</div>
      <h3 style="color:#fff;font-size:17px;font-weight:800;margin:0 0 8px;font-family:'Hind Siliguri',sans-serif;">WhatsApp-এ যোগাযোগ করুন</h3>
      <p style="color:rgba(255,255,255,.9);font-size:13px;margin:0 0 18px;line-height:1.7;">
        আমরা <strong>WhatsApp-এর মাধ্যমে</strong> Customer Support প্রদান করি।<br>
        যেকোনো সমস্যায় সরাসরি WhatsApp-এ মেসেজ করুন।
      </p>
      <a href="https://wa.me/8801816622128?text=Hello%20U%20Super%20Shop%2C%20I%20need%20help."
         target="_blank"
         style="display:inline-flex;align-items:center;gap:10px;background:#fff;color:#128c3b;font-size:14px;font-weight:800;padding:12px 28px;border-radius:30px;text-decoration:none;font-family:'Hind Siliguri',sans-serif;box-shadow:0 4px 15px rgba(0,0,0,.15);">
        <span style="font-size:20px;">📲</span>
        WhatsApp-এ মেসেজ করুন
      </a>
      <p style="color:rgba(255,255,255,.85);font-size:13px;margin:14px 0 0;">
        নম্বর: <strong style="font-size:17px;letter-spacing:1px;">+880 1816-622128</strong>
      </p>
    </div>

    {{-- Support Hours --}}
    <div style="background:#f8f9fa;border-radius:12px;padding:16px 20px;margin-bottom:14px;border:1px solid #eee;">
      <div style="display:flex;align-items:center;gap:10px;margin-bottom:12px;">
        <span style="font-size:22px;">🕐</span>
        <strong style="color:#333;font-size:15px;">Support সময়সূচী</strong>
      </div>
      <div style="display:grid;grid-template-columns:1fr 1fr;gap:10px;font-size:13px;color:#555;">
        <div style="background:#fff;border-radius:8px;padding:10px 14px;border:1px solid #eee;text-align:center;">
          <div style="font-weight:800;color:#111;margin-bottom:3px;">📅 কার্যদিবস</div>
          <div>শনিবার – বৃহস্পতিবার</div>
        </div>
        <div style="background:#fff;border-radius:8px;padding:10px 14px;border:1px solid #eee;text-align:center;">
          <div style="font-weight:800;color:#111;margin-bottom:3px;">⏰ সময়</div>
          <div>সকাল ৯টা – রাত ১০টা</div>
        </div>
      </div>
      <p style="color:#999;font-size:14px;margin:10px 0 0;text-align:center;">
        * শুক্রবার সীমিত সময়ে support পাওয়া যাবে
      </p>
    </div>

    {{-- Email --}}
    <div style="background:#1e25fa;border-radius:12px;padding:14px 18px;display:flex;align-items:center;gap:14px;">
      <div style="flex:1;">
        <strong style="color:#fff;font-size:14px;display:block;margin-bottom:3px;">📧 ইমেইলেও যোগাযোগ করতে পারেন</strong>
        <span style="color:rgba(255,255,255,.82);font-size:13px;">usupershopbd@gmail.com</span>
      </div>
      <a href="mailto:usupershopbd@gmail.com"
         style="background:#fff;color:#1e25fa;font-size:14px;font-weight:800;padding:9px 18px;border-radius:20px;text-decoration:none;flex-shrink:0;font-family:'Hind Siliguri',sans-serif;white-space:nowrap;">
        ইমেইল করুন
      </a>
    </div>

  </div>
</div>
</div>
</div>
@endsection
