@extends('frontend.layouts.master')
@section('title', 'User Guide & Income — U Super Shop')
@section('custom_css')
<style>
@import url('https://fonts.googleapis.com/css2?family=Hind+Siliguri:wght@400;600;700;800&display=swap');
.guide-page { font-family: 'Hind Siliguri', sans-serif; background: #f4f5f9; padding: 0 0 60px; }

/* Hero */
.guide-hero { background: linear-gradient(135deg, #0d1436 0%, #1e25fa 50%, #0d1436 100%); padding: 50px 20px; text-align: center; position: relative; overflow: hidden; }
.guide-hero::before { content: ''; position: absolute; inset: 0; background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none'%3E%3Cg fill='%23ffffff' fill-opacity='0.04'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E"); }
.guide-hero h1 { color: #fff; font-size: 28px; font-weight: 800; margin: 0 0 10px; position: relative; }
.guide-hero p { color: rgba(255,255,255,.82); font-size: 15px; margin: 0; position: relative; line-height: 1.7; }
.hero-badges { display: flex; justify-content: center; gap: 10px; flex-wrap: wrap; margin-top: 20px; position: relative; }
.hero-badge { background: rgba(255,255,255,.15); border: 1px solid rgba(255,255,255,.3); color: #fff; padding: 6px 16px; border-radius: 20px; font-size: 13px; font-weight: 700; }

/* Container */
.gc { max-width: 800px; margin: 0 auto; padding: 0 14px; }

/* Section title */
.sec-title { text-align: center; padding: 40px 0 20px; }
.sec-title h2 { font-size: 22px; font-weight: 800; color: #111; margin: 0 0 6px; }
.sec-title p { font-size: 14px; color: #666; margin: 0; }
.sec-line { width: 50px; height: 4px; border-radius: 2px; background: #e8001d; margin: 10px auto 0; }

/* Cards */
.cards-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 14px; margin-bottom: 14px; }
@media(max-width:500px){ .cards-grid { grid-template-columns: 1fr; } }
.guide-card { background: #fff; border-radius: 14px; padding: 20px; border: 1.5px solid #eee; box-shadow: 0 2px 10px rgba(0,0,0,.06); }
.guide-card .icon { font-size: 36px; margin-bottom: 10px; display: block; }
.guide-card h3 { font-size: 15px; font-weight: 800; color: #111; margin: 0 0 8px; }
.guide-card p { font-size: 13px; color: #555; line-height: 1.7; margin: 0; }
.guide-card.blue { border-color: #c7cafe; background: linear-gradient(135deg, #fff 60%, #f0f2ff); }
.guide-card.green { border-color: #c3f0db; background: linear-gradient(135deg, #fff 60%, #f0fff8); }
.guide-card.red { border-color: #fcd8da; background: linear-gradient(135deg, #fff 60%, #fff5f5); }
.guide-card.yellow { border-color: #fde8a0; background: linear-gradient(135deg, #fff 60%, #fffcf0); }

/* Steps */
.steps-list { background: #fff; border-radius: 14px; padding: 24px; box-shadow: 0 2px 10px rgba(0,0,0,.06); margin-bottom: 14px; }
.step-item { display: flex; gap: 16px; align-items: flex-start; margin-bottom: 20px; }
.step-item:last-child { margin-bottom: 0; }
.step-num { width: 36px; height: 36px; border-radius: 50%; background: #1e25fa; color: #fff; font-size: 15px; font-weight: 800; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
.step-content h4 { font-size: 14px; font-weight: 800; color: #111; margin: 0 0 4px; }
.step-content p { font-size: 13px; color: #555; margin: 0; line-height: 1.6; }

/* Package cards */
.pkg-grid { display: grid; grid-template-columns: repeat(3,1fr); gap: 12px; margin-bottom: 14px; }
@media(max-width:500px){ .pkg-grid { grid-template-columns: 1fr; } }
.pkg-card { border-radius: 14px; padding: 22px 16px; text-align: center; position: relative; overflow: hidden; }
.pkg-card.seller { background: linear-gradient(135deg, #f0f2ff, #fff); border: 2px solid #1e25fa; }
.pkg-card.vendor { background: linear-gradient(135deg, #f0fff8, #fff); border: 2px solid #00a855; }
.pkg-card.drop { background: linear-gradient(135deg, #fff5f5, #fff); border: 2px solid #e8001d; }
.pkg-badge { display: inline-block; padding: 3px 12px; border-radius: 20px; font-size:13px; font-weight: 800; letter-spacing: 1px; text-transform: uppercase; margin-bottom: 10px; }
.pkg-icon { font-size: 40px; margin-bottom: 8px; display: block; }
.pkg-name { font-size: 16px; font-weight: 800; margin: 0 0 4px; }
.pkg-price { font-size: 30px; font-weight: 800; margin: 8px 0; }
.pkg-price span { font-size: 14px; font-weight: 500; color: #888; }
.pkg-duration { font-size:14px; color: #888; margin: 0 0 14px; }
.pkg-features { list-style: none; padding: 0; margin: 0 0 16px; text-align: left; }
.pkg-features li { font-size:14px; color: #444; padding: 5px 0; border-bottom: 1px solid rgba(0,0,0,.05); display: flex; align-items: center; gap: 7px; }
.pkg-features li::before { content: '✓'; font-weight: 800; flex-shrink: 0; }
.pkg-btn { display: block; padding: 10px; border-radius: 30px; font-size: 13px; font-weight: 800; text-decoration: none; font-family: 'Hind Siliguri', sans-serif; transition: opacity .15s; }
.pkg-btn:hover { opacity: .88; }

/* Income banner */
.income-banner { background: linear-gradient(135deg, #f5c400, #e6a800); border-radius: 14px; padding: 24px 22px; margin-bottom: 14px; }
.income-banner h3 { font-size: 18px; font-weight: 800; color: #111; margin: 0 0 6px; }
.income-banner p { font-size: 13px; color: #333; margin: 0 0 16px; line-height: 1.7; }
.income-amount { display: flex; gap: 10px; flex-wrap: wrap; }
.income-amt-card { background: #fff; border-radius: 10px; padding: 12px 16px; flex: 1; min-width: 120px; text-align: center; }
.income-amt-card .amt { font-size: 22px; font-weight: 800; color: #e8001d; }
.income-amt-card .lbl { font-size:13px; color: #666; font-weight: 600; }

/* Refer section */
.refer-section { background: linear-gradient(135deg, #00a855, #007a3d); border-radius: 14px; padding: 26px 22px; margin-bottom: 14px; }
.refer-section h3 { font-size: 18px; font-weight: 800; color: #fff; margin: 0 0 6px; }
.refer-section p { font-size: 13px; color: rgba(255,255,255,.9); margin: 0 0 18px; line-height: 1.7; }
.refer-steps { display: grid; grid-template-columns: repeat(3,1fr); gap: 10px; }
@media(max-width:500px){ .refer-steps { grid-template-columns: 1fr; } }
.refer-step { background: rgba(255,255,255,.15); border-radius: 10px; padding: 14px; text-align: center; color: #fff; }
.refer-step .rs-num { font-size: 24px; font-weight: 800; display: block; margin-bottom: 5px; }
.refer-step .rs-txt { font-size:14px; line-height: 1.5; }
.refer-earn { background: rgba(255,255,255,.2); border-radius: 10px; padding: 14px 18px; margin-top: 14px; display: flex; align-items: center; gap: 14px; }
.refer-earn .earn-num { font-size: 32px; font-weight: 800; color: #fff; flex-shrink: 0; }
.refer-earn .earn-txt { font-size: 13px; color: rgba(255,255,255,.9); line-height: 1.6; }

/* Dashboard guide */
.dash-card { background: #fff; border-radius: 14px; padding: 20px; box-shadow: 0 2px 10px rgba(0,0,0,.06); margin-bottom: 14px; }
.dash-item { display: flex; gap: 14px; align-items: flex-start; margin-bottom: 16px; }
.dash-item:last-child { margin-bottom: 0; }
.dash-icon { font-size: 28px; flex-shrink: 0; width: 44px; text-align: center; }
.dash-info h4 { font-size: 14px; font-weight: 800; color: #111; margin: 0 0 3px; }
.dash-info p { font-size:14px; color: #666; margin: 0; line-height: 1.6; }

/* CTA */
.cta-section { background: linear-gradient(135deg, #e8001d, #b30015); border-radius: 14px; padding: 30px 22px; text-align: center; margin-bottom: 0; }
.cta-section h3 { color: #fff; font-size: 20px; font-weight: 800; margin: 0 0 8px; }
.cta-section p { color: rgba(255,255,255,.88); font-size: 14px; margin: 0 0 20px; line-height: 1.7; }
.cta-btns { display: flex; gap: 10px; justify-content: center; flex-wrap: wrap; }
.cta-btn { padding: 12px 24px; border-radius: 30px; font-size: 14px; font-weight: 800; text-decoration: none; font-family: 'Hind Siliguri', sans-serif; transition: transform .15s; }
.cta-btn:hover { transform: translateY(-2px); }
.cta-btn.white { background: #fff; color: #e8001d; }
.cta-btn.outline { background: transparent; border: 2px solid #fff; color: #fff; }
</style>
@endsection

@section('content')
<div class="guide-page">

{{-- Hero --}}
<div class="guide-hero">
  <h1>🚀 U Super Shop-এ আয় করুন</h1>
  <p>বাংলাদেশের সেরা অনলাইন মার্কেটপ্লেসে যোগ দিন<br>কেনাকাটা করুন, বিক্রি করুন এবং আনলিমিটেড আয় করুন</p>
  <div class="hero-badges">
    <span class="hero-badge">✅ 100% বৈধ ব্যবসা</span>
    <span class="hero-badge">💰 নিশ্চিত পেমেন্ট</span>
    <span class="hero-badge">🚀 সহজ শুরু</span>
    <span class="hero-badge">📱 মোবাইলেই করুন</span>
  </div>
</div>

<div class="gc">

  {{-- Who can join --}}
  <div class="sec-title">
    <h2>আপনি কীভাবে যোগ দেবেন?</h2>
    <p>4টি উপায়ে U Super Shop-এ যুক্ত হতে পারেন</p>
    <div class="sec-line"></div>
  </div>

  <div class="cards-grid">
    <div class="guide-card blue">
      <span class="icon">🛍️</span>
      <h3>ক্রেতা (Customer)</h3>
      <p>Account ছাড়াও কেনাকাটা করতে পারবেন। সেরা দামে মানসম্মত পণ্য পাবেন। 1,000 টাকার উপরে অর্ডারে ডেলিভারি সম্পূর্ণ বিনামূল্যে।</p>
    </div>
    <div class="guide-card green">
      <span class="icon">🏪</span>
      <h3>সেলার (Seller)</h3>
      <p>অন্যদের পণ্য আপনার Link দিয়ে বিক্রি করুন। প্রতিটি বিক্রয়ে Commission পাবেন। মাত্র 399 টাকায় শুরু করুন।</p>
    </div>
    <div class="guide-card yellow">
      <span class="icon">🏭</span>
      <h3>ভেন্ডর (Vendor)</h3>
      <p>নিজের পণ্য আপলোড করুন। আমরা বিক্রি করব। প্রতিটি বিক্রয়ের 80% আপনি পাবেন, মাত্র 20% Platform commission।</p>
    </div>
    <div class="guide-card red">
      <span class="icon">🚀</span>
      <h3>Dropshipper</h3>
      <p>স্টক ছাড়াই ব্যবসা করুন। পণ্যের দাম নিজে ঠিক করুন, পার্থক্যটাই আপনার profit। কোনো বিনিয়োগের ঝুঁকি নেই।</p>
    </div>
  </div>

  {{-- Packages --}}
  <div class="sec-title">
    <h2>💎 Subscription Package</h2>
    <p>মাত্র একবার পেমেন্ট করুন — 1 বছরের জন্য</p>
    <div class="sec-line"></div>
  </div>

  <div class="pkg-grid">

    {{-- Seller --}}
    <div class="pkg-card seller">
      <span class="pkg-badge" style="background:#eef1ff;color:#1e25fa;">STARTER</span>
      <span class="pkg-icon">🏪</span>
      <div class="pkg-name" style="color:#1e25fa;">Seller</div>
      <div class="pkg-price" style="color:#1e25fa;">৳399 <span>/বছর</span></div>
      <div class="pkg-duration">মেয়াদ: 1 বছর</div>
      <ul class="pkg-features">
        <li style="color:#1e25fa;">শেয়ার লিংকে বিক্রি করুন</li>
        <li>Admin-নির্ধারিত Commission</li>
        <li>Refer করে আয় করুন</li>
        <li>নিজস্ব Dashboard</li>
        <li>Withdrawal সুবিধা</li>
      </ul>
      <a href="{{ route('seller.signup') }}" class="pkg-btn" style="background:#1e25fa;color:#fff;">এখনই শুরু করুন</a>
    </div>

    {{-- Vendor --}}
    <div class="pkg-card vendor">
      <span class="pkg-badge" style="background:#edfff4;color:#00a855;">POPULAR</span>
      <span class="pkg-icon">🏭</span>
      <div class="pkg-name" style="color:#00a855;">Vendor</div>
      <div class="pkg-price" style="color:#00a855;">৳499 <span>/বছর</span></div>
      <div class="pkg-duration">মেয়াদ: 1 বছর</div>
      <ul class="pkg-features">
        <li style="color:#00a855;">নিজের পণ্য আপলোড</li>
        <li>বিক্রয়ের 80% আপনি পাবেন</li>
        <li>Refer করে আয় করুন</li>
        <li>নিজস্ব Shop Page</li>
        <li>Sales Analytics</li>
      </ul>
      <a href="{{ route('seller.signup') }}" class="pkg-btn" style="background:#00a855;color:#fff;">এখনই শুরু করুন</a>
    </div>

    {{-- Dropshipper --}}
    <div class="pkg-card drop">
      <span class="pkg-badge" style="background:#fff5f5;color:#e8001d;">BEST VALUE</span>
      <span class="pkg-icon">🚀</span>
      <div class="pkg-name" style="color:#e8001d;">Dropshipper</div>
      <div class="pkg-price" style="color:#e8001d;">৳999 <span>/বছর</span></div>
      <div class="pkg-duration">মেয়াদ: 1 বছর</div>
      <ul class="pkg-features">
        <li style="color:#e8001d;">Wholesale Price-এ কিনুন</li>
        <li>নিজে দাম নির্ধারণ করুন</li>
        <li>সীমাহীন Profit সম্ভাবনা</li>
        <li>Stock রাখতে হবে না</li>
        <li>Refer করে আয় করুন</li>
      </ul>
      <a href="{{ route('seller.signup') }}" class="pkg-btn" style="background:#e8001d;color:#fff;">এখনই শুরু করুন</a>
    </div>

  </div>

  <div style="background:#fff3cd;border-radius:10px;padding:14px 18px;margin-bottom:30px;font-size:13px;color:#856404;text-align:center;">
    ⚠️ মেয়াদ শেষ হওয়ার <strong>1 মাস আগে</strong> SMS Reminder পাবেন। সময়মতো Renew করলে কোনো সমস্যা হবে না।
  </div>

  {{-- How Seller works --}}
  <div class="sec-title">
    <h2>🏪 Seller হিসেবে কীভাবে আয় করবেন</h2>
    <p>Step-by-step গাইড</p>
    <div class="sec-line"></div>
  </div>

  <div class="steps-list">
    <div class="step-item">
      <div class="step-num">1</div>
      <div class="step-content">
        <h4>Register করুন ও Payment করুন</h4>
        <p>মাত্র 399 টাকা bKash-এ পেমেন্ট করুন। সাথে সাথে আপনার Seller Account Active হবে।</p>
      </div>
    </div>
    <div class="step-item">
      <div class="step-num">2</div>
      <div class="step-content">
        <h4>Dashboard-এ Login করুন</h4>
        <p>আপনার unique Referral Link পাবেন। এই link দিয়ে পণ্য প্রচার করুন।</p>
      </div>
    </div>
    <div class="step-item">
      <div class="step-num">3</div>
      <div class="step-content">
        <h4>Facebook/WhatsApp/Social Media-তে Share করুন</h4>
        <p>আপনার link দিয়ে কেউ পণ্য কিনলে Admin-নির্ধারিত হারে Commission পাবেন।</p>
      </div>
    </div>
    <div class="step-item">
      <div class="step-num">4</div>
      <div class="step-content">
        <h4>Order Delivered হলে Commission যোগ হবে</h4>
        <p>Admin Order Delivered করার পর আপনার Commission আপনার Balance-এ যোগ হবে।</p>
      </div>
    </div>
    <div class="step-item">
      <div class="step-num">5</div>
      <div class="step-content">
        <h4>Withdraw করুন</h4>
        <p>ন্যূনতম 200 টাকা হলে Withdrawal Request করুন। Admin Approve করলে আপনার bKash-এ টাকা পাবেন।</p>
      </div>
    </div>
  </div>

  {{-- How Vendor works --}}
  <div class="sec-title">
    <h2>🏭 Vendor হিসেবে কীভাবে আয় করবেন</h2>
    <div class="sec-line"></div>
  </div>

  <div class="steps-list">
    <div class="step-item">
      <div class="step-num">1</div>
      <div class="step-content">
        <h4>Register করুন — 499 টাকায়</h4>
        <p>Vendor Account তৈরি করুন। নিজের পণ্যের ছবি, দাম ও বিবরণ দিন।</p>
      </div>
    </div>
    <div class="step-item">
      <div class="step-num">2</div>
      <div class="step-content">
        <h4>পণ্য Upload করুন</h4>
        <p>আপনার পণ্য আমাদের Platform-এ দেখানো হবে। লক্ষ লক্ষ Customer দেখতে পাবে।</p>
      </div>
    </div>
    <div class="step-item">
      <div class="step-num">3</div>
      <div class="step-content">
        <h4>আমরা বিক্রি করব</h4>
        <p>Seller ও Dropshipper-রা আপনার পণ্য প্রচার করবে। আপনাকে মার্কেটিং করতে হবে না।</p>
      </div>
    </div>
    <div class="step-item">
      <div class="step-num">4</div>
      <div class="step-content">
        <h4>বিক্রয়ের 80% পাবেন</h4>
        <p>প্রতিটি বিক্রয়ে 20% Platform Fee কাটা হবে। বাকি 80% আপনার — Delivered হওয়ার পর যোগ হবে।</p>
      </div>
    </div>
  </div>

  {{-- How Dropshipper works --}}
  <div class="sec-title">
    <h2>🚀 Dropshipper হিসেবে কীভাবে আয় করবেন</h2>
    <div class="sec-line"></div>
  </div>

  <div class="steps-list">
    <div class="step-item">
      <div class="step-num">1</div>
      <div class="step-content">
        <h4>Register করুন — 999 টাকায়</h4>
        <p>Dropshipper হিসেবে যোগ দিন। Wholesale Price-এ সব পণ্য দেখতে পাবেন।</p>
      </div>
    </div>
    <div class="step-item">
      <div class="step-num">2</div>
      <div class="step-content">
        <h4>নিজে Selling Price ঠিক করুন</h4>
        <p>Wholesale Price-এর উপরে যেকোনো দামে পণ্য বিক্রি করুন। পার্থক্যটাই আপনার Profit।</p>
      </div>
    </div>
    <div class="step-item">
      <div class="step-num">3</div>
      <div class="step-content">
        <h4>Customer Order করলে আমরা Deliver করব</h4>
        <p>Stock রাখতে হবে না, প্যাকিং করতে হবে না। সব আমাদের — আপনি শুধু বিক্রি করুন।</p>
      </div>
    </div>
    <div class="step-item">
      <div class="step-num">4</div>
      <div class="step-content">
        <h4>Delivered হলে Profit Balance-এ যোগ হবে</h4>
        <p>Admin Delivered করার পর আপনার Profit আপনার Account-এ যোগ হবে। Withdraw করুন।</p>
      </div>
    </div>
  </div>

  {{-- Income example --}}
  <div class="income-banner" style="margin-top:6px;">
    <h3>💰 আয়ের উদাহরণ (Dropshipper)</h3>
    <p>Wholesale Price 500 টাকার পণ্য 700 টাকায় বিক্রি করলে:</p>
    <div class="income-amount">
      <div class="income-amt-card">
        <div class="amt">৳500</div>
        <div class="lbl">Wholesale Price</div>
      </div>
      <div class="income-amt-card" style="background:#1e25fa;">
        <div class="amt" style="color:#fff;">৳700</div>
        <div class="lbl" style="color:rgba(255,255,255,.8);">আপনার Selling Price</div>
      </div>
      <div class="income-amt-card" style="background:#e8001d;">
        <div class="amt" style="color:#fff;">৳200</div>
        <div class="lbl" style="color:rgba(255,255,255,.8);">আপনার Profit 🎉</div>
      </div>
    </div>
  </div>

  {{-- Refer Commission --}}
  <div class="sec-title">
    <h2>🎁 Refer করে আয় করুন</h2>
    <p>বন্ধুদের Refer করুন — প্রতিজনের জন্য আয় করুন</p>
    <div class="sec-line"></div>
  </div>

  <div class="refer-section">
    <h3>🔗 Refer করে আনলিমিটেড আয়!</h3>
    <p>আপনার Unique Refer Code দিয়ে কাউকে Seller, Vendor বা Dropshipper হিসেবে Register করান। তারা Payment করলেই আপনার Account-এ Refer Bonus যোগ হবে।</p>

    <div class="refer-steps">
      <div class="refer-step">
        <span class="rs-num">1</span>
        <span class="rs-txt">Dashboard থেকে আপনার Refer Code কপি করুন</span>
      </div>
      <div class="refer-step">
        <span class="rs-num">2</span>
        <span class="rs-txt">বন্ধু/পরিচিতকে সেই Code দিয়ে Register করতে বলুন</span>
      </div>
      <div class="refer-step">
        <span class="rs-num">3</span>
        <span class="rs-txt">তারা Payment করলেই আপনার Account-এ Bonus যোগ হবে</span>
      </div>
    </div>

    <div class="refer-earn">
      <div class="earn-num">৳200</div>
      <div class="earn-txt">
        <strong>প্রতিটি সফল Refer-এ 200 টাকা!</strong><br>
        যত বেশি Refer করবেন, তত বেশি আয় করবেন। কোনো সীমা নেই।
      </div>
    </div>
  </div>

  {{-- Dashboard Guide --}}
  <div class="sec-title">
    <h2>📊 Dashboard সম্পর্কে</h2>
    <p>আপনার Dashboard-এ যা যা পাবেন</p>
    <div class="sec-line"></div>
  </div>

  <div class="dash-card">
    <div class="dash-item">
      <div class="dash-icon">💰</div>
      <div class="dash-info">
        <h4>Balance & Earnings</h4>
        <p>আপনার মোট আয়, Commission Balance এবং Refer Bonus এক জায়গায় দেখতে পাবেন।</p>
      </div>
    </div>
    <div class="dash-item">
      <div class="dash-icon">📋</div>
      <div class="dash-info">
        <h4>Order Management</h4>
        <p>আপনার সব Order-এর status real-time-এ দেখতে পাবেন। Pending, Confirmed, Shipped, Delivered সব।</p>
      </div>
    </div>
    <div class="dash-item">
      <div class="dash-icon">🔗</div>
      <div class="dash-info">
        <h4>Referral Link & Code</h4>
        <p>আপনার unique Refer Code ও Link সহজেই Copy করে Share করতে পারবেন।</p>
      </div>
    </div>
    <div class="dash-item">
      <div class="dash-icon">💳</div>
      <div class="dash-info">
        <h4>Withdrawal Request</h4>
        <p>ন্যূনতম 200 টাকা balance হলে Withdrawal Request করুন। Admin Approve করলে bKash-এ টাকা পাবেন।</p>
      </div>
    </div>
    <div class="dash-item">
      <div class="dash-icon">📊</div>
      <div class="dash-info">
        <h4>Sales Analytics</h4>
        <p>কত টাকার বিক্রি হয়েছে, কত Commission এসেছে, Transaction History — সব details পাবেন।</p>
      </div>
    </div>
    <div class="dash-item">
      <div class="dash-icon">⏳</div>
      <div class="dash-info">
        <h4>Subscription Status</h4>
        <p>আপনার Package-এর মেয়াদ কতদিন আছে দেখতে পাবেন। মেয়াদ শেষের 1 মাস আগে SMS পাবেন।</p>
      </div>
    </div>
  </div>

  {{-- FAQ --}}
  <div class="sec-title">
    <h2>❓ সাধারণ প্রশ্ন</h2>
    <div class="sec-line"></div>
  </div>

  <div style="background:#fff;border-radius:14px;padding:20px;box-shadow:0 2px 10px rgba(0,0,0,.06);margin-bottom:14px;">
    @php
    $faqs = [
      ['q'=>'টাকা কখন পাব?', 'a'=>'Order Delivered হওয়ার পর Admin Approve করলে আপনার Balance-এ যোগ হবে। সাধারণত 1-3 কার্যদিবসের মধ্যে।'],
      ['q'=>'Withdrawal কীভাবে করব?', 'a'=>'Dashboard → Withdrawal Request করুন। ন্যূনতম 200 টাকা লাগবে। Admin Approve করলে আপনার bKash-এ পাবেন।'],
      ['q'=>'Order Cancel হলে Commission পাব?', 'a'=>'না। Order Cancel বা Return হলে Commission যোগ হবে না। আগে গেলেও ফেরত কাটা হবে।'],
      ['q'=>'Package শেষ হলে কী হবে?', 'a'=>'Account Suspend হয়ে যাবে। Renew করলে আবার Active হবে। মেয়াদ শেষের 1 মাস আগে SMS পাবেন।'],
      ['q'=>'কতজনকে Refer করতে পারব?', 'a'=>'কোনো সীমা নেই। যত বেশি Refer করবেন, তত বেশি আয় করবেন।'],
    ];
    @endphp
    @foreach($faqs as $i => $faq)
    <div style="border-bottom:{{ $i < count($faqs)-1 ? '1px solid #f0f0f0' : 'none' }};padding:14px 0;">
      <div style="font-size:14px;font-weight:800;color:#111;margin-bottom:5px;">❓ {{ $faq['q'] }}</div>
      <div style="font-size:13px;color:#555;line-height:1.7;">{{ $faq['a'] }}</div>
    </div>
    @endforeach
  </div>

  {{-- CTA --}}
  <div class="cta-section">
    <h3>🎯 আজই শুরু করুন!</h3>
    <p>হাজার হাজার মানুষ ইতিমধ্যে U Super Shop-এ আয় করছেন।<br>আপনিও দেরি না করে এখনই শুরু করুন।</p>
    <div class="cta-btns">
      <a href="{{ route('seller.signup') }}" class="cta-btn white">🚀 এখনই Register করুন</a>
      <a href="{{ route('product.list') }}" class="cta-btn outline">🛍️ পণ্য দেখুন</a>
    </div>
    <p style="color:rgba(255,255,255,.7);font-size:14px;margin:16px 0 0;">
      যেকোনো প্রশ্নে WhatsApp করুন: <strong style="color:#fff;">01816622128</strong>
    </p>
  </div>

</div>
</div>
@endsection
