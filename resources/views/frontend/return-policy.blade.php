@extends('frontend.layouts.master')
@section('title', 'Return Policy — U Super Shop')
@section('content')
<div style="padding: 30px 0 60px; background:#f6f7fb; min-height:60vh;">
<div class="container">
<div style="max-width:780px; margin:0 auto; background:#fff; border-radius:16px; box-shadow:0 2px 20px rgba(0,0,0,.07); overflow:hidden;">

  {{-- Header --}}
  <div style="background:linear-gradient(135deg,#e8001d,#b30015); padding:28px 30px; text-align:center;">
    <div style="font-size:42px; margin-bottom:8px;">📦</div>
    <h1 style="color:#fff; font-size:22px; font-weight:700; margin:0;">Return Policy</h1>
    <p style="color:rgba(255,255,255,.85); margin:6px 0 0; font-size:14px;">রিটার্ন পলিসি — U Super Shop</p>
  </div>

  {{-- Alert Box --}}
  <div style="background:#fff8e1; border-left:5px solid #f5c400; margin:24px 24px 0; border-radius:8px; padding:16px 18px; display:flex; gap:12px; align-items:flex-start;">
    <span style="font-size:24px; flex-shrink:0;">⚠️</span>
    <div>
      <strong style="color:#856404; font-size:15px; display:block; margin-bottom:4px;">গুরুত্বপূর্ণ বিজ্ঞপ্তি</strong>
      <p style="color:#856404; margin:0; font-size:13px; line-height:1.7;">
        পণ্য গ্রহণের সময় <strong>ডেলিভারি ম্যান সামনে থাকা অবস্থায়</strong> অবশ্যই পণ্য খুলে চেক করুন।
        ডেলিভারি ম্যান চলে যাওয়ার পর কোনো অভিযোগ গ্রহণযোগ্য হবে না।
      </p>
    </div>
  </div>

  {{-- Rules --}}
  <div style="padding:24px 24px 30px;">

    {{-- Rule 1 --}}
    <div style="background:#f8f9ff; border-radius:12px; padding:18px 20px; margin-bottom:16px; border:1px solid #e8eaff;">
      <div style="display:flex; align-items:center; gap:12px; margin-bottom:10px;">
        <div style="width:38px; height:38px; background:#1e25fa; border-radius:50%; display:flex; align-items:center; justify-content:center; flex-shrink:0; color:#fff; font-size:18px;">✅</div>
        <strong style="color:#1e25fa; font-size:15px;">ডেলিভারি ম্যান সামনে থাকাকালীন চেক করুন</strong>
      </div>
      <ul style="margin:0; padding-left:18px; color:#444; font-size:13px; line-height:2;">
        <li>পণ্য পাওয়ার সাথে সাথে ডেলিভারি ম্যানের সামনে প্যাকেট খুলুন</li>
        <li>পণ্যের সংখ্যা, রঙ, সাইজ ও অবস্থা যাচাই করুন</li>
        <li>কোনো সমস্যা থাকলে তাৎক্ষণিকভাবে জানান</li>
        <li>পণ্য ঠিক থাকলে ডেলিভারি নিশ্চিত করুন</li>
      </ul>
    </div>

    {{-- Rule 2 --}}
    <div style="background:#fff5f5; border-radius:12px; padding:18px 20px; margin-bottom:16px; border:1px solid #fcd8da;">
      <div style="display:flex; align-items:center; gap:12px; margin-bottom:10px;">
        <div style="width:38px; height:38px; background:#e8001d; border-radius:50%; display:flex; align-items:center; justify-content:center; flex-shrink:0; color:#fff; font-size:18px;">🚫</div>
        <strong style="color:#e8001d; font-size:15px;">ডেলিভারি ম্যান চলে যাওয়ার পর</strong>
      </div>
      <ul style="margin:0; padding-left:18px; color:#444; font-size:13px; line-height:2;">
        <li>ডেলিভারি ম্যান চলে যাওয়ার পর <strong>কোনো অভিযোগ গ্রহণ করা হবে না</strong></li>
        <li>পণ্য গ্রহণের পর কোনো রিটার্ন বা রিফান্ড প্রযোজ্য নয়</li>
        <li>ডেলিভারি নিশ্চিত করার পর অর্ডার সম্পন্ন বলে গণ্য হবে</li>
      </ul>
    </div>

    {{-- Rule 3 - Damaged/Wrong --}}
    <div style="background:#f0fff4; border-radius:12px; padding:18px 20px; margin-bottom:16px; border:1px solid #c3f0db;">
      <div style="display:flex; align-items:center; gap:12px; margin-bottom:10px;">
        <div style="width:38px; height:38px; background:#00a855; border-radius:50%; display:flex; align-items:center; justify-content:center; flex-shrink:0; color:#fff; font-size:18px;">🔄</div>
        <strong style="color:#00a855; font-size:15px;">ত্রুটিপূর্ণ বা ভুল পণ্য পেলে</strong>
      </div>
      <ul style="margin:0; padding-left:18px; color:#444; font-size:13px; line-height:2;">
        <li>ডেলিভারি ম্যানের সামনেই ভিডিও/ছবি তুলুন</li>
        <li>সঙ্গে সঙ্গে আমাদের হেল্পলাইনে যোগাযোগ করুন: <strong style="color:#1e25fa;">01816622128</strong></li>
        <li>প্রমাণসহ অভিযোগ জানালে দ্রুত ব্যবস্থা নেওয়া হবে</li>
      </ul>
    </div>

    {{-- Contact --}}
    <div style="background:#1e25fa; border-radius:12px; padding:18px 20px; text-align:center; color:#fff;">
      <div style="font-size:24px; margin-bottom:6px;">📞</div>
      <strong style="font-size:15px; display:block; margin-bottom:4px;">যেকোনো সমস্যায় যোগাযোগ করুন</strong>
      <p style="margin:0; font-size:22px; font-weight:700; letter-spacing:1px;">01816622128</p>
      <p style="margin:4px 0 0; font-size:12px; color:rgba(255,255,255,.8);">সকাল ৯টা — রাত ১০টা (শনি–বৃহস্পতি)</p>
    </div>

  </div>
</div>
</div>
</div>
@endsection
