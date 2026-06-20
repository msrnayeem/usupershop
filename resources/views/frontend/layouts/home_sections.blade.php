{{-- ===================================================================
     U Super Shop — Homepage Sections (Image-exact layout)
     Image 1: Header branding
     Image 2: 3 Role cards + 4 Trust badges
     Image 3: Dropship dark banner + Income teaser
     =================================================================== --}}

<style>
/* ── Google Font ─────────────────────────── */
@import url('https://fonts.googleapis.com/css2?family=Hind+Siliguri:wght@400;500;600;700;800&display=swap');
.home-sec * { font-family: 'Hind Siliguri', sans-serif; }

/* ── Role Cards (3 cards, image 2) ──────── */
.role-section { padding: 14px 0 8px; }
.role-grid-3 {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 10px;
}
.role-card {
    border-radius: 14px;
    padding: 14px 8px 12px;
    text-align: center;
    text-decoration: none !important;
    display: flex; flex-direction: column;
    align-items: center; gap: 6px;
    transition: transform .18s, box-shadow .18s;
    min-height: 110px;
}
.role-card:hover { transform: translateY(-3px); box-shadow: 0 8px 20px rgba(0,0,0,.10); }
.role-card:active { transform: scale(.97); }

.role-card.buyer  { background: #e4f3ff; border: 2px solid #b3d8ff; }
.role-card.seller { background: #e4fff2; border: 2px solid #8dedc4; }
.role-card.drop   { background: #ffe4e4; border: 2px solid #ffb3b3; }

.role-icon { font-size: 34px; line-height: 1; }
.role-title {
    font-size: 13px; font-weight: 700; color: #111;
    line-height: 1.35; margin-bottom: 2px;
}
.role-title .accent-blue  { color: #0070d2; }
.role-title .accent-green { color: #00875a; }
.role-title .accent-red   { color: #e8001d; }
.role-sub { font-size: 10px; color: #666; line-height: 1.4; }

/* ── Trust Badges (4 badges, image 2) ───── */
.trust-section { padding: 8px 0 10px; }
.trust-grid-4 {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 8px;
}
.trust-badge {
    background: #fff;
    border: 1px solid #e8e8e8;
    border-radius: 12px;
    padding: 12px 4px 10px;
    text-align: center;
    text-decoration: none !important;
    box-shadow: 0 1px 5px rgba(0,0,0,.05);
    transition: transform .15s;
    display: flex; flex-direction: column; align-items: center; gap: 5px;
}
.trust-badge:hover { transform: translateY(-2px); }
.trust-icon { font-size: 26px; line-height: 1; display: block; }
.trust-text { font-size: 10px; color: #333; font-weight: 600; line-height: 1.4; }

/* ── Dropship CTA Banner (image 3 dark) ─── */
.drop-banner {
    background: linear-gradient(135deg, #0d1436 0%, #1a2565 55%, #0a1228 100%);
    border-radius: 18px;
    padding: 22px 20px 20px;
    position: relative; overflow: hidden;
    margin: 12px 0 14px;
}
.drop-banner::after {
    content: '🚀';
    position: absolute; right: 10px; bottom: -8px;
    font-size: 90px; opacity: .10; line-height: 1;
    pointer-events: none;
}
.drop-tag {
    display: inline-flex; align-items: center; gap: 5px;
    background: #e8001d; color: #fff;
    font-size: 10px; font-weight: 700;
    letter-spacing: 1.2px; text-transform: uppercase;
    padding: 5px 12px; border-radius: 20px;
    margin-bottom: 12px;
}
.drop-banner h2 {
    color: #fff; font-size: 20px; font-weight: 800;
    margin: 0 0 6px; line-height: 1.3;
}
.drop-banner p {
    color: rgba(255,255,255,.78);
    font-size: 13px; margin: 0 0 16px; line-height: 1.65;
}
.drop-btn-row { display: flex; gap: 10px; flex-wrap: wrap; }
.drop-btn {
    padding: 11px 22px; border-radius: 30px;
    font-size: 13px; font-weight: 700;
    text-decoration: none !important;
    transition: transform .15s, box-shadow .15s;
    display: inline-block;
    font-family: 'Hind Siliguri', sans-serif;
}
.drop-btn:hover { transform: translateY(-2px); box-shadow: 0 6px 16px rgba(0,0,0,.3); }
.drop-btn.btn-white { background: #fff; color: #1e25fa !important; }
.drop-btn.btn-blue  { background: #1e25fa; color: #fff !important; }

/* ── Income Teaser (image 3 bottom) ─────── */
.income-teaser { padding: 4px 0 16px; }
.income-head {
    display: flex; align-items: baseline; gap: 8px; margin-bottom: 12px;
}
.income-head h3 {
    font-size: 18px; font-weight: 800; color: #111; margin: 0;
}
.income-head span { font-size: 12px; color: #888; }

.income-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 10px;
}
.income-card {
    border-radius: 13px; padding: 14px 12px;
    text-decoration: none !important;
    transition: transform .15s;
    border: 1.5px solid transparent;
}
.income-card:hover { transform: translateY(-2px); }
.income-card.ref  { background: #fff9e6; border-color: #f5c400; }
.income-card.sell { background: #edfff5; border-color: #00c96e; }
.income-card.drop { background: #eef1ff; border-color: #1e25fa; }
.income-card.aff  { background: #fff3f3; border-color: #e8001d; }

.income-icon  { font-size: 26px; margin-bottom: 5px; display: block; }
.income-title { font-size: 13px; font-weight: 700; color: #111; margin-bottom: 3px; }
.income-sub   { font-size: 11px; color: #666; line-height: 1.5; }

/* ── Responsive ──────────────────────────── */
@media (max-width: 480px) {
    .role-grid-3 { gap: 7px; }
    .role-card { padding: 12px 5px 10px; min-height: 100px; border-radius: 12px; }
    .role-icon { font-size: 28px; }
    .role-title { font-size: 11.5px; }
    .role-sub { font-size: 9.5px; }

    .trust-grid-4 { gap: 5px; }
    .trust-badge { padding: 10px 2px 8px; border-radius: 10px; }
    .trust-icon { font-size: 22px; }
    .trust-text { font-size: 9px; }

    .drop-banner { padding: 18px 16px 16px; border-radius: 14px; }
    .drop-banner h2 { font-size: 17px; }
    .drop-banner p { font-size: 12px; }
    .drop-btn { padding: 9px 16px; font-size: 12px; }

    .income-grid { gap: 8px; }
    .income-card { padding: 12px 10px; }
    .income-icon { font-size: 22px; }
    .income-title { font-size: 12px; }
    .income-sub { font-size: 10px; }
}
@media (max-width: 360px) {
    .role-title { font-size: 10.5px; }
    .drop-banner h2 { font-size: 15px; }
}
</style>

<div class="home-sec">

{{-- ── Role Cards (3 cards — ক্রেতা / সেলার / Dropshipper) ────── --}}
<div class="role-section">
    <div class="role-grid-3">

        {{-- ক্রেতা --}}
        <a href="{{ route('product.list') }}" class="role-card buyer">
            <div class="role-icon">🛍️</div>
            <div>
                <div class="role-title">
                    <span class="accent-blue">ক্রেতা</span> কেনাকাটা করুন
                </div>
                <div class="role-sub">সেরা দামে মানসম্মত পণ্য কিনুন</div>
            </div>
        </a>

        {{-- সেলার --}}
        <a href="{{ route('seller.signup') }}" class="role-card seller">
            <div class="role-icon">🏪</div>
            <div>
                <div class="role-title">
                    <span class="accent-green">সেলার</span> পণ্য বিক্রি করুন
                </div>
                <div class="role-sub">আপনার শপ খুলুন ও আয় করুন</div>
            </div>
        </a>

        {{-- Dropshipper --}}
        <a href="{{ route('seller.signup') }}" class="role-card drop">
            <div class="role-icon">🚀</div>
            <div>
                <div class="role-title">
                    <span class="accent-red">Dropshipper</span> ইনভেস্টমেন্ট
                </div>
                <div class="role-sub">স্টক ছাড়াই ব্যবসা শুরু করুন</div>
            </div>
        </a>

    </div>
</div>

{{-- ── Trust Badges (4 badges) ──────────────────────────────────── --}}
<div class="trust-section">
    <div class="trust-grid-4">

        <div class="trust-badge">
            <span class="trust-icon">🚚</span>
            <div class="trust-text">দ্রত ডেলিভারি</div>
        </div>

        <div class="trust-badge">
            <span class="trust-icon">🛡️</span>
            <div class="trust-text">১০০% অথেনটিক</div>
        </div>

        <a href="{{ route('return.policy') }}" class="trust-badge" style="color:inherit;">
            <span class="trust-icon">↩️</span>
            <div class="trust-text">Return Policy</div>
        </a>

        <div class="trust-badge">
            <span class="trust-icon">📞</span>
            <div class="trust-text">২৪/৭ সাপোর্ট</div>
        </div>

    </div>
</div>

{{-- ── Dropship CTA Banner (dark navy, image 3) ─────────────────── --}}
<div class="drop-banner">
    <div class="drop-tag">🚀 DROPSHIPPING PLATFORM</div>
    <h2>ইনভেস্টমেন্ট ছাড়াই ব্যবসা!</h2>
    <p>পণ্য নিজের দামে বিক্রি করুন। স্টক ও ডেলিভারি আমাদের।</p>
    <div class="drop-btn-row">
        <a href="{{ route('seller.signup') }}" class="drop-btn btn-white">Dropshipper হন</a>
        <a href="{{ route('seller.signup') }}" class="drop-btn btn-blue">সেলার হন</a>
    </div>
</div>

{{-- ── Income Teaser (image 3 bottom) ──────────────────────────── --}}
<div class="income-teaser">
    <div class="income-head">
        <h3>💰 আয় করুন</h3>
        <span>বিভিন্ন উপায়ে</span>
    </div>
    <div class="income-grid">

        <a href="{{ route('seller.signup') }}" class="income-card ref">
            <span class="income-icon">🎁</span>
            <div class="income-title">রেফার বোনাস</div>
            <div class="income-sub">বন্ধুদের রেফার করে আনলিমিটেড আয়</div>
        </a>

        <a href="{{ route('seller.signup') }}" class="income-card sell">
            <span class="income-icon">🏪</span>
            <div class="income-title">পণ্য বিক্রি</div>
            <div class="income-sub">সেলার বা ভেন্ডর হয়ে আয় করুন</div>
        </a>

        <a href="{{ route('seller.signup') }}" class="income-card drop">
            <span class="income-icon">🚀</span>
            <div class="income-title">ড্রপশিপিং</div>
            <div class="income-sub">ইনভেস্টমেন্ট ছাড়া ব্যবসা করুন</div>
        </a>

        <a href="{{ route('product.list') }}" class="income-card aff">
            <span class="income-icon">🔗</span>
            <div class="income-title">শেয়ার কমিশন</div>
            <div class="income-sub">লিংক শেয়ার করে কমিশন পান</div>
        </a>

    </div>
</div>

</div>{{-- .home-sec --}}
