@extends('frontend.layouts.master')
@section('title', 'Seller Registration')

@section('content')
<style>
.registration-wrapper * { box-sizing:border-box; margin:0; padding:0; }
.registration-wrapper {
    font-family:'Hind Siliguri',sans-serif;
    background:#c9c9c9;
    display:flex;
    align-items:flex-start;
    justify-content:center;
    padding:60px 15px;
    -webkit-font-smoothing:antialiased;
    min-height: calc(100vh - 200px);
}
.phone {
    width: 100%;
    max-width: 850px;
    background:#f4f5f9;
    border-radius:12px;
    overflow:hidden;
    box-shadow: 0 5px 25px rgba(0,0,0,0.1);
    margin: 0 auto;
}
.hdr{background:#fff;padding:15px 20px;display:flex;align-items:center;gap:10px;border-bottom:1px solid #eee}
.hdr-t{font-size:20px;font-weight:800;color:#111}
.hdr-s{font-size:14px;color:#888}
.reg-body{}
.type-banner{padding:25px 20px;text-align:center}
.type-banner.sel{background:linear-gradient(135deg,#1e25fa,#0d1280)}
.type-banner.ven{background:linear-gradient(135deg,#00a855,#005c30)}
.type-banner.dro{background:linear-gradient(135deg,#e8001d,#7a000d)}
.type-badge{display:inline-block;background:rgba(255,255,255,.2);color:#fff;font-size:13px;font-weight:800;padding:4px 14px;border-radius:20px;margin-bottom:10px}
.type-banner h1{color:#fff;font-size:22px;font-weight:800;margin-bottom:4px}
.type-banner p{color:rgba(255,255,255,.85);font-size:14px;line-height:1.6}
.price-pill{background:#fff;font-size:16px;font-weight:800;padding:6px 16px;border-radius:20px;display:inline-block;margin-top:8px}
.type-sel{display:grid;grid-template-columns:1fr 1fr 1fr;gap:12px;padding:20px 20px 0}
.topt{border:2px solid #eee;border-radius:12px;padding:15px 10px;text-align:center;cursor:pointer;transition:all .15s;background:#fff}
.topt.os{border-color:#1e25fa;background:#f0f2ff}
.topt.ov{border-color:#00a855;background:#f0fff8}
.topt.od{border-color:#e8001d;background:#fff5f5}
.topt .ti{font-size:28px;margin-bottom:4px}
.topt .tn{font-size:15px;font-weight:800;color:#111}
.topt .tp{font-size:13px;color:#888;margin-top:2px}
.fb{padding:20px}
.form-grid {
    display: grid;
    grid-template-columns: 1fr;
    gap: 15px;
    margin-bottom: 15px;
}
@media (min-width: 768px) {
    .form-grid {
        grid-template-columns: 1fr 1fr;
        gap: 20px;
    }
    .form-grid .full-width {
        grid-column: span 2;
    }
}
.fg{margin-bottom:0;}
.fg label{font-size:14px;font-weight:700;color:#333;display:block;margin-bottom:6px}
.fg input,.fg select{width:100%;padding:12px 14px;border:1.5px solid #e5e5e5;border-radius:10px;font-size:14px;font-family:'Hind Siliguri',sans-serif;outline:none;background:#fff;color:#111}
.fg input:focus,.fg select:focus{border-color:#e8001d}
.fg .error-text { color: #e8001d; font-size: 13px; margin-top: 4px; display: block; }
.feat-card{border-radius:14px;padding:14px;margin-bottom:14px}
.feat-card.fs{background:#f0f2ff;border:1.5px solid #c0c8ff}
.feat-card.fv{background:#f0fff8;border:1.5px solid #8dedc4}
.feat-card.fd{background:#fff5f5;border:1.5px solid #ffb3b3}
.feat-card h4{font-size:14px;font-weight:800;margin-bottom:8px}
.feat-card.fs h4{color:#1e25fa}
.feat-card.fv h4{color:#00a855}
.feat-card.fd h4{color:#e8001d}
.feat-card li{font-size:14px;color:#555;padding:4px 0;list-style:none;line-height:1.5}
.plan-tbl{background:#fff;border-radius:14px;border:1.5px solid #eee;overflow:hidden;margin-bottom:14px}
.plan-tbl table{width:100%;border-collapse:collapse}
.plan-tbl th{background:#f4f5f9;padding:10px 8px;font-size:13px;font-weight:800;text-align:center;color:#333}
.plan-tbl td{padding:9px 8px;font-size:13px;text-align:center;border-top:1px solid #f0f0f0;color:#555}
.plan-tbl td:first-child{text-align:left;font-weight:600;color:#333;padding-left:12px}
.tick{color:#00a855;font-size:16px;font-weight:800}
.cross{color:#aaa}
.terms-row{display:flex;align-items:flex-start;gap:10px;margin-bottom:14px}
.terms-row input[type="checkbox"]{width:18px;height:18px;margin-top:2px;accent-color:#e8001d;flex-shrink:0}
.terms-row label{font-size:14px;color:#555;line-height:1.6}
.terms-row a{color:#1e25fa;font-weight:700}
.sub-btn{width:100%;padding:15px;border:none;border-radius:12px;font-size:16px;font-weight:800;cursor:pointer;font-family:'Hind Siliguri',sans-serif}
.sub-btn.bs{background:#1e25fa;color:#fff}
.sub-btn.bv{background:#00a855;color:#fff}
.sub-btn.bd{background:#e8001d;color:#fff}
.login-lnk{text-align:center;margin-top:14px;font-size:14px;color:#666}
.login-lnk a{color:#e8001d;font-weight:700;text-decoration:none}
.pw-wrap{position:relative}
.pw-wrap input{padding-right:48px}
.pw-eye{position:absolute;right:14px;top:50%;transform:translateY(-50%);cursor:pointer;font-size:18px;background:none;border:none;color:#888}
/* OTP Delivery Radios */
.otp-methods { display: flex; flex-direction: column; gap: 8px; margin-top: 5px; }
.otp-methods label { font-weight: normal; font-size: 14px; display: flex; align-items: center; gap: 8px; margin: 0; cursor: pointer; color: #555; }
.otp-methods input[type="radio"] { width: 18px; height: 18px; accent-color: #e8001d; margin:0; padding:0; flex-shrink: 0;}
</style>

<div class="registration-wrapper">
    <div class="phone">
        <div class="hdr">
            <div>
                <div class="hdr-t">Registration</div>
                <div class="hdr-s" id="hS">Seller Registration</div>
            </div>
        </div>

        <div class="reg-body">
            <div class="type-banner sel" id="tB">
                <div class="type-badge" id="tBg">🏪 SELLER</div>
                <h1 id="tT">Seller হয়ে আয় করুন</h1>
                <p id="tP">নিজের শপ খুলুন, পণ্য বিক্রি করুন ও রেফার বোনাস পান।</p>
                <div class="price-pill" id="tPr" style="color:#1e25fa">৳399 / বছর</div>
            </div>

            <div class="type-sel">
                <div class="topt os" id="tS" onclick="selType('seller')">
                    <div class="ti">🏪</div><div class="tn">Seller</div><div class="tp">৳399/বছর</div>
                </div>
                <div class="topt" id="tV" onclick="selType('vendor')">
                    <div class="ti">🏭</div><div class="tn">Vendor</div><div class="tp">৳499/বছর</div>
                </div>
                <div class="topt" id="tD" onclick="selType('dropshipper')">
                    <div class="ti">🚀</div><div class="tn">Dropshipper</div><div class="tp">৳999/বছর</div>
                </div>
            </div>

            <div class="fb">
                <div class="feat-card fs" id="fC">
                    <h4 id="fT">🏪 Seller হিসেবে পাবেন:</h4>
                    <ul id="fL">
                        <li>✅ নিজের অনলাইন শপ</li>
                        <li>✅ প্রতি বিক্রয়ে 10% commission</li>
                        <li>✅ প্রতিটি Refer-এ ৳200 বোনাস</li>
                        <li>✅ Shop Page & Share Link</li>
                        <li>✅ Withdrawal যেকোনো সময়</li>
                    </ul>
                </div>

                <form id="signupForm" action="{{ route('seller.store') }}" method="POST">
                    @csrf
                    
                    {{-- Hidden fields required by backend --}}
                    <input type="hidden" name="account_type" id="account_type" value="{{ old('account_type', 'seller') }}">
                    <input type="hidden" name="subscription_plan" value="{{ date('d M Y') }}">

                    <div class="form-grid">
                        <div class="fg">
                            <label>পূর্ণ নাম <span style="color:#e8001d">*</span></label>
                            <input type="text" name="name" value="{{ old('name') }}" placeholder="আপনার পূর্ণ নাম" required>
                            @error('name')<span class="error-text">❌ {{ $message }}</span>@enderror
                        </div>

                        <div class="fg">
                            <label>Shop Name <span style="color:#e8001d">*</span></label>
                            <input type="text" name="shop_name" value="{{ old('shop_name') }}" placeholder="আপনার Shop-এর নাম" required>
                            @error('shop_name')<span class="error-text">❌ {{ $message }}</span>@enderror
                        </div>

                        <div class="fg">
                            <label>Email Address <span style="color:#e8001d">*</span></label>
                            <input type="email" name="email" value="{{ old('email') }}" placeholder="email@example.com" required>
                            @error('email')<span class="error-text">❌ {{ $message }}</span>@enderror
                        </div>

                        <div class="fg">
                            <label>মোবাইল নম্বর <span style="color:#e8001d">*</span></label>
                            <input type="tel" name="mobile" value="{{ old('mobile') }}" placeholder="01XXXXXXXXX" required>
                            @error('mobile')<span class="error-text">❌ {{ $message }}</span>@enderror
                        </div>

                        <div class="fg">
                            <label>OTP পাবেন কোথায় <span style="color:#e8001d">*</span></label>
                            <div class="otp-methods">
                                <label>
                                    <input type="radio" name="otp_delivery_method" value="both" {{ old('otp_delivery_method', 'both') === 'both' ? 'checked' : '' }}>
                                    ইমেইল এবং ফোন নম্বর
                                </label>
                                <label>
                                    <input type="radio" name="otp_delivery_method" value="email" {{ old('otp_delivery_method') === 'email' ? 'checked' : '' }}>
                                    শুধু ইমেইল
                                </label>
                                <label>
                                    <input type="radio" name="otp_delivery_method" value="sms" {{ old('otp_delivery_method') === 'sms' ? 'checked' : '' }}>
                                    শুধু ফোন নম্বর
                                </label>
                            </div>
                            @error('otp_delivery_method')<span class="error-text">❌ {{ $message }}</span>@enderror
                        </div>

                        <div class="fg">
                            <label>Address <span style="color:#e8001d">*</span></label>
                            <input type="text" name="address" value="{{ old('address') }}" placeholder="আপনার পূর্ণ ঠিকানা" required>
                            @error('address')<span class="error-text">❌ {{ $message }}</span>@enderror
                        </div>

                        <div class="fg">
                            <label style="font-size:14px;font-weight:700;color:#333;margin-bottom:6px;display:block">
                                🔗 Refer Code
                                <span style="background:#e8f5e9;color:#2e7d32;font-size:11px;font-weight:700;padding:2px 8px;border-radius:10px;margin-left:6px">Optional</span>
                            </label>
                            <div style="position:relative">
                                <input type="text" name="refer_code" value="{{ request()->has('refer') ? request()->refer : old('refer_code') }}" 
                                    placeholder="কারো Refer Code থাকলে এখানে দিন" 
                                    @if(request()->has('refer')) readonly @endif
                                    style="width:100%;padding:13px 14px 13px 42px;border:2px solid #e0e0e0;border-radius:10px;font-size:14px;font-family:'Hind Siliguri',sans-serif;outline:none;transition:border-color .2s"
                                    onfocus="this.style.borderColor='#1e25fa'" onblur="this.style.borderColor='#e0e0e0'">
                                <span style="position:absolute;left:14px;top:50%;transform:translateY(-50%);font-size:17px">🔗</span>
                            </div>
                            <div style="font-size:13px;color:#888;margin-top:5px">✨ Refer Code দিলে <strong style="color:#00a855">উভয়ই ৳200 বোনাস</strong> পাবেন</div>
                            @error('refer_code')<span class="error-text">❌ {{ $message }}</span>@enderror
                        </div>

                        <div class="fg">
                            <label style="font-size:14px;font-weight:700;color:#333;margin-bottom:6px;display:block">
                                🎟️ Coupon Code
                                <span style="background:#fff8e1;color:#856404;font-size:11px;font-weight:700;padding:2px 8px;border-radius:10px;margin-left:6px;border:1px solid #ffd54f">Optional</span>
                            </label>
                            <div style="display:flex;gap:8px;align-items:center">
                                <div style="position:relative;flex:1">
                                    <input type="text" name="coupon_code" id="coupInp" value="{{ old('coupon_code') }}" placeholder="Coupon code থাকলে এখানে দিন"
                                        style="width:100%;padding:13px 14px 13px 42px;border:2px solid #e0e0e0;border-radius:10px;font-size:14px;font-family:'Hind Siliguri',sans-serif;outline:none;transition:border-color .2s"
                                        onfocus="this.style.borderColor='#e8001d'" onblur="this.style.borderColor='#e0e0e0'">
                                    <span style="position:absolute;left:14px;top:50%;transform:translateY(-50%);font-size:17px">🎟️</span>
                                </div>
                                <button type="button" onclick="chkCoup()" style="background:#e8001d;color:#fff;border:none;padding:0 18px;border-radius:10px;font-size:14px;font-weight:700;cursor:pointer;font-family:'Hind Siliguri',sans-serif;height:48px;flex-shrink:0">Check</button>
                            </div>
                            <div id="cFb" style="font-size:13px;margin-top:6px;padding:8px 12px;border-radius:8px;display:none"></div>
                            <div style="font-size:13px;color:#888;margin-top:5px">🏷️ সঠিক Coupon দিলে <strong style="color:#e8001d">Registration-এ ছাড়</strong> পাবেন</div>
                            @error('coupon_code')<span class="error-text">❌ {{ $message }}</span>@enderror
                        </div>

                        <div class="fg">
                            <label>Password <span style="color:#e8001d">*</span></label>
                            <div class="pw-wrap">
                                <input type="password" name="password" id="p1" placeholder="কমপক্ষে ৬ অক্ষর" required>
                                <button type="button" class="pw-eye" onclick="tp('p1')">👁️</button>
                            </div>
                            @error('password')<span class="error-text">❌ {{ $message }}</span>@enderror
                        </div>

                        <div class="fg">
                            <label>Confirm Password <span style="color:#e8001d">*</span></label>
                            <div class="pw-wrap">
                                <input type="password" name="confirmation_password" id="p2" placeholder="আবার password দিন" required>
                                <button type="button" class="pw-eye" onclick="tp('p2')">👁️</button>
                            </div>
                            @error('confirmation_password')<span class="error-text">❌ {{ $message }}</span>@enderror
                        </div>
                    </div>

                    <div class="plan-tbl">
                        <table>
                            <thead><tr><th>Feature</th><th style="color:#1e25fa">Seller ৳399</th><th style="color:#00a855">Vendor ৳499</th><th style="color:#e8001d">Drop ৳999</th></tr></thead>
                            <tbody>
                                <tr><td>পণ্য বিক্রি</td><td><span class="tick">✓</span></td><td><span class="tick">✓</span></td><td><span class="tick">✓</span></td></tr>
                                <tr><td>নিজস্ব পণ্য যোগ</td><td><span class="cross">—</span></td><td><span class="tick">✓</span></td><td><span class="cross">—</span></td></tr>
                                <tr><td>নিজে দাম ঠিক</td><td><span class="cross">—</span></td><td><span class="cross">—</span></td><td><span class="tick">✓</span></td></tr>
                                <tr><td>Commission</td><td>10%</td><td>80%</td><td>Profit</td></tr>
                                <tr><td>Refer Bonus</td><td><span class="tick">৳200</span></td><td><span class="tick">৳200</span></td><td><span class="tick">৳200</span></td></tr>
                                <tr><td>Shop Page</td><td><span class="tick">✓</span></td><td><span class="tick">✓</span></td><td><span class="cross">—</span></td></tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="terms-row">
                        <input type="checkbox" name="terms" value="yes" id="tc" required>
                        <label for="tc">আমি <a href="{{ route('terms.and.condition') }}">Terms and Conditions</a> ও <a href="#">Privacy Policy</a>-এর সাথে একমত</label>
                    </div>
                    @error('terms')<span class="error-text" style="display:block;margin-bottom:15px;margin-top:-10px;">❌ {{ $message }}</span>@enderror

                    <button type="submit" class="sub-btn bs" id="sB">🏪 Seller হিসেবে Register করুন</button>
                </form>

                <div class="login-lnk">ইতিমধ্যে Account আছে? <a href="{{ route('customer.login') }}">এখানে Login করুন</a></div>
            </div>
        </div>
    </div>
</div>

<script>
var types = {
    seller: {bc:'sel',bg:'🏪 SELLER',tt:'Seller হয়ে আয় করুন',tp:'নিজের শপ খুলুন, পণ্য বিক্রি করুন ও রেফার বোনাস পান।',pr:'৳399 / বছর',pc:'#1e25fa',fc:'fs',ft:'🏪 Seller হিসেবে পাবেন:',fl:['✅ নিজের অনলাইন শপ','✅ প্রতি বিক্রয়ে 10% commission','✅ প্রতিটি Refer-এ ৳200 বোনাস','✅ Shop Page & Share Link','✅ Withdrawal যেকোনো সময়'],bc2:'bs',bt:'🏪 Seller হিসেবে Register করুন',hs:'Seller Registration'},
    vendor: {bc:'ven',bg:'🏭 VENDOR',tt:'Vendor হয়ে আয় করুন',tp:'নিজের পণ্য যোগ করুন ও প্রতিটি বিক্রয়ে 80% আয় করুন।',pr:'৳499 / বছর',pc:'#00a855',fc:'fv',ft:'🏭 Vendor হিসেবে পাবেন:',fl:['✅ নিজের পণ্য upload করুন','✅ প্রতি বিক্রয়ে 80% আয়','✅ নিজস্ব Vendor Dashboard','✅ প্রতিটি Refer-এ ৳200 বোনাস','✅ Shop Page & Share Link'],bc2:'bv',bt:'🏭 Vendor হিসেবে Register করুন',hs:'Vendor Registration'},
    dropshipper: {bc:'dro',bg:'🚀 DROPSHIPPER',tt:'Dropshipping করুন',tp:'বিনা বিনিয়োগে ব্যবসা! নিজে দাম ঠিক করুন, পার্থক্যই আপনার লাভ।',pr:'৳999 / বছর',pc:'#e8001d',fc:'fd',ft:'🚀 Dropshipper হিসেবে পাবেন:',fl:['✅ Wholesale দামে পণ্য নিন','✅ নিজে Selling Price ঠিক করুন','✅ পার্থক্যই আপনার মুনাফা','✅ Stock রাখতে হবে কাটবে না','✅ প্রতিটি Refer-এ ৳200 বোনাস'],bc2:'bd',bt:'🚀 Dropshipper হিসেবে Register করুন',hs:'Dropshipper Registration'}
};

function selType(t){
    var d = types[t];
    document.getElementById('tB').className = 'type-banner ' + d.bc;
    document.getElementById('tBg').textContent = d.bg;
    document.getElementById('tT').textContent = d.tt;
    document.getElementById('tP').textContent = d.tp;
    document.getElementById('tPr').textContent = d.pr;
    document.getElementById('tPr').style.color = d.pc;
    document.getElementById('fC').className = 'feat-card ' + d.fc;
    document.getElementById('fT').textContent = d.ft;
    document.getElementById('fL').innerHTML = d.fl.map(function(f){return'<li>'+f+'</li>'}).join('');
    document.getElementById('sB').className = 'sub-btn ' + d.bc2;
    document.getElementById('sB').textContent = d.bt;
    document.getElementById('hS').textContent = d.hs;
    document.getElementById('tS').className = 'topt' + (t === 'seller' ? ' os' : '');
    document.getElementById('tV').className = 'topt' + (t === 'vendor' ? ' ov' : '');
    document.getElementById('tD').className = 'topt' + (t === 'dropshipper' ? ' od' : '');
    
    // Update hidden input for backend submission
    document.getElementById('account_type').value = t;
}

// Restore selected type on validation failure
@if(old('account_type'))
    selType("{{ old('account_type') }}");
@else 
    selType('seller');
@endif

function tp(id){
    var i = document.getElementById(id);
    i.type = i.type === 'password' ? 'text' : 'password';
}

function chkCoup(){
    var code = document.getElementById('coupInp').value.trim();
    var fb = document.getElementById('cFb');
    fb.style.display = 'block';
    
    if(!code){
        fb.style.background = '#fff5f5';
        fb.style.border = '1px solid #ffb3b3';
        fb.textContent = '❌ Coupon code লিখুন।';
        return;
    }
    
    fb.style.background = '#f8f8f8';
    fb.style.border = '1px solid #eee';
    fb.textContent = '⏳ যাচাই করা হচ্ছে...';
    
    setTimeout(function(){
        // Demo simulation
        if(code.toUpperCase() === 'SAVE100' || code.toUpperCase() === 'WELCOME'){
            fb.style.background = '#e8f5e9';
            fb.style.border = '1px solid #a5d6a7';
            fb.textContent = '✅ কুপন সঠিক! Registration-এ ছাড় পাবেন।';
        } else {
            fb.style.background = '#fff5f5';
            fb.style.border = '1px solid #ffb3b3';
            fb.textContent = '❌ এই Coupon code সঠিক নয়।';
            document.getElementById('coupInp').value = '';
        }
    }, 800);
}
</script>
@endsection
