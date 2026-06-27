@extends('frontend.layouts.master')
@section('title', 'Order Track — U Super Shop')
@section('content')

<div style="background:#f4f5f9;min-height:60vh;padding:30px 0 60px;">
<div class="container">
<div style="max-width:500px;margin:0 auto;">

  {{-- Header --}}
  <div style="text-align:center;margin-bottom:28px;">
    <div style="font-size:56px;margin-bottom:10px;">📦</div>
    <h1 style="font-size:22px;font-weight:800;color:#111;margin:0 0 6px;font-family:'Hind Siliguri',sans-serif;">অর্ডার ট্র্যাক করুন</h1>
    <p style="color:#888;font-size:14px;margin:0;">আপনার Invoice Number দিয়ে অর্ডার ট্র্যাক করুন</p>
  </div>

  {{-- Error --}}
  @if(isset($error) || session('error'))
  <div style="background:#f8d7da;border:1.5px solid #f5c6cb;border-radius:12px;padding:14px 18px;margin-bottom:18px;color:#721c24;font-size:14px;font-family:'Hind Siliguri',sans-serif;">
    ⚠️ {{ $error ?? session('error') }}
  </div>
  @endif

  {{-- Search Form --}}
  <div style="background:#fff;border-radius:16px;padding:28px 24px;box-shadow:0 4px 20px rgba(0,0,0,.08);">
    <form action="{{ route('order.tracksave') }}" method="POST">
      @csrf
      <div style="margin-bottom:18px;">
        <label style="font-size:13px;font-weight:700;color:#333;display:block;margin-bottom:8px;font-family:'Hind Siliguri',sans-serif;">
          📋 Invoice Number
        </label>
        <input type="text" name="invoice_no"
          value="{{ request('invoice') ?? old('invoice_no') }}"
          placeholder="উদাহরণ: USP00044"
          style="width:100%;padding:14px 16px;border-radius:12px;border:2px solid #e5e5e5;font-size:15px;font-family:'Hind Siliguri',sans-serif;outline:none;transition:border-color .2s;"
          onfocus="this.style.borderColor='#e8001d'"
          onblur="this.style.borderColor='#e5e5e5'"
          required autofocus>
        <p style="font-size:13px;color:#aaa;margin:6px 0 0;">SMS-এ পাঠানো Invoice Number দিন (যেমন: USP00044)</p>
      </div>

      <button type="submit"
        style="width:100%;background:#e8001d;color:#fff;border:none;padding:14px;border-radius:12px;font-size:15px;font-weight:800;font-family:'Hind Siliguri',sans-serif;cursor:pointer;transition:background .2s;"
        onmouseover="this.style.background='#c20019'"
        onmouseout="this.style.background='#e8001d'">
        🔍 ট্র্যাক করুন
      </button>
    </form>
  </div>

  {{-- Help --}}
  <div style="background:#fff;border-radius:14px;padding:18px 20px;margin-top:16px;box-shadow:0 2px 10px rgba(0,0,0,.06);">
    <h3 style="font-size:14px;font-weight:800;color:#111;margin:0 0 12px;font-family:'Hind Siliguri',sans-serif;">📌 Invoice Number কোথায় পাবেন?</h3>
    <ul style="margin:0;padding-left:18px;color:#555;font-size:13px;line-height:2;font-family:'Hind Siliguri',sans-serif;">
      <li>অর্ডার দেওয়ার পর SMS-এ Invoice Number পাঠানো হয়</li>
      <li>Format: <strong style="color:#1e25fa;font-family:monospace;">USP00044</strong></li>
      <li>আপনার dashboard-এ Order list-এ দেখতে পাবেন</li>
    </ul>
  </div>

  {{-- WhatsApp Support --}}
  <div style="text-align:center;margin-top:20px;">
    <p style="color:#888;font-size:13px;margin:0 0 10px;font-family:'Hind Siliguri',sans-serif;">সাহায্যের জন্য:</p>
    <a href="https://wa.me/8801816622128?text=আমার%20অর্ডার%20ট্র্যাক%20করতে%20সাহায্য%20করুন"
       target="_blank"
       style="display:inline-flex;align-items:center;gap:8px;background:#25d366;color:#fff;padding:10px 22px;border-radius:20px;text-decoration:none;font-size:13px;font-weight:700;font-family:'Hind Siliguri',sans-serif;">
      💬 WhatsApp করুন
    </a>
  </div>

</div>
</div>
</div>
@endsection
