@extends('frontend.layouts.master')
@section('title', 'Checkout | ' . config('app.name'))

@push('meta')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endpush

@section('content')
<style>
/* ===== CHECKOUT STEPS - shared style (same as cart page) ===== */
.checkout-steps {
    background: #fff;
    padding: 12px 20px;
    display: flex;
    align-items: center;
    border-radius: 12px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    margin-bottom: 15px;
    margin-top: 65px;
    font-family: 'Hind Siliguri', sans-serif;
    justify-content: space-between;
}
.checkout-steps .stp { display: flex; align-items: center; gap: 6px; }
.checkout-steps .sc {
    width: 26px; height: 26px; border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    font-size: 12px; font-weight: 800; flex-shrink: 0;
}
.checkout-steps .sc.on  { background: #e8001d; color: #fff; }
.checkout-steps .sc.off { background: #eee; color: #aaa; }
.checkout-steps .sc.d   { background: #00a855; color: #fff; }
.checkout-steps .sl { font-size: 13px; font-weight: 700; }
.checkout-steps .sl.on  { color: #e8001d; }
.checkout-steps .sl.off { color: #bbb; }
.checkout-steps .sl.d   { color: #00a855; }
.checkout-steps .sl-line { flex: 1; height: 2px; background: #eee; margin: 0 10px; }
.checkout-steps .sl-line.d { background: #00a855; }

@media (max-width: 480px) {
    .checkout-steps { padding: 10px; }
    .checkout-steps .sl { display: none; }
    .checkout-steps .stp { gap: 0; }
    .checkout-steps .sl-line { margin: 0 5px; }
}
@media (min-width: 400px) and (max-width: 480px) {
    .checkout-steps .sl { display: block; font-size: 11px; }
    .checkout-steps .stp { gap: 4px; }
}

/* ===== CHECKOUT CONTENT ===== */
.checkout-content { font-family: 'Hind Siliguri', sans-serif; -webkit-font-smoothing: antialiased; }
.checkout-content * { box-sizing: border-box; }
.chk-card { background: #fff; border-radius: 14px; padding: 16px; margin-bottom: 15px; border: 1.5px solid #eee; }
.chk-card .card-ttl { font-size: 16px; font-weight: 800; color: #111; margin-bottom: 12px; display: flex; align-items: center; gap: 8px; }
.oi { display: flex; align-items: center; gap: 12px; padding: 12px 0; border-bottom: 1px solid #f5f5f5; }
.oi:last-child { border-bottom: none; padding-bottom: 0; }
.oi-img { width: 60px; height: 60px; border-radius: 10px; background: #f4f5f9; display: flex; align-items: center; justify-content: center; flex-shrink: 0; border: 1px solid #eee; overflow: hidden; }
.oi-img img { width: 100%; height: 100%; object-fit: cover; }
.oi-name { font-size: 15px; font-weight: 700; color: #111; margin-bottom: 2px; }
.oi-var { font-size: 13px; color: #999; margin-bottom: 2px; }
.oi-p { font-size: 15px; font-weight: 800; color: #e8001d; }
.oi-qty { background: #f4f5f9; color: #555; font-size: 12px; font-weight: 700; padding: 3px 8px; border-radius: 6px; display: inline-block; }
.fg { margin-bottom: 15px; }
.fg label { font-size: 14px; font-weight: 700; color: #333; display: block; margin-bottom: 6px; }
.fg input, .fg select, .fg textarea { width: 100%; padding: 12px 14px; border: 1.5px solid #e5e5e5; border-radius: 10px; font-size: 14px; font-family: 'Hind Siliguri', sans-serif; outline: none; background: #fff; color: #111; transition: border-color 0.2s; }
.fg input:focus, .fg select:focus, .fg textarea:focus { border-color: #e8001d; }
.fg textarea { resize: vertical; line-height: 1.5; }
.fb { background: linear-gradient(90deg,#00a855,#007a3d); border-radius: 12px; padding: 12px 15px; display: flex; align-items: center; gap: 10px; margin-bottom: 15px; }
.fb .ico { font-size: 24px; flex-shrink: 0; }
.fb .txt strong { color: #fff; font-size: 15px; font-weight: 800; display: block; }
.fb .txt span { color: rgba(255,255,255,.85); font-size: 13px; }
.fb .pill { background: #fff; color: #00a855; font-size: 12px; font-weight: 800; padding: 4px 10px; border-radius: 20px; margin-left: auto; flex-shrink: 0; }
.wb { background: #fff8e1; border: 1.5px solid #ffd54f; border-radius: 12px; padding: 12px 15px; margin-bottom: 15px; font-size: 14px; color: #856404; line-height: 1.6; }
.coupon-wrap { display: flex; gap: 8px; margin-bottom: 5px; }
.coupon-inp { flex: 1; padding: 12px 14px; border: 1.5px solid #e5e5e5; border-radius: 10px; font-size: 14px; font-family: 'Hind Siliguri', sans-serif; outline: none; }
.coupon-btn { background: #e8001d; color: #fff; border: none; padding: 12px 20px; border-radius: 10px; font-size: 14px; font-weight: 700; cursor: pointer; font-family: 'Hind Siliguri', sans-serif; white-space: nowrap; transition: background 0.2s; }
.coupon-btn:hover { background: #cc0019; }
.sr { display: flex; justify-content: space-between; padding: 8px 0; font-size: 15px; border-bottom: 1px solid #f5f5f5; }
.sr:last-child { border-bottom: none; font-size: 16px; font-weight: 800; padding-top: 12px; }
.sr .lbl { color: #666; } .sr .val { font-weight: 700; color: #333; } .sr .g { color: #00a855; font-weight: 800; } .sr .r { color: #e8001d; }
.pay-card { border: 2px solid #eee; background: #fff; border-radius: 14px; padding: 16px; cursor: pointer; margin-bottom: 12px; display: flex; align-items: center; gap: 15px; transition: all .2s; }
.pay-card:hover { border-color: #ccc; }
.pay-card.cod-on { border-color: #00a855; background: #f0fff8; }
.pay-card.bk-on { border-color: #e8001d; background: #fff5f5; }
.pay-tit { font-size: 15px; font-weight: 800; color: #1a1a1a; line-height: 1.4; }
.pay-sub { font-size: 13px; color: #666; margin-top: 3px; line-height: 1.5; }
.pay-sub.r { color: #e8001d; font-weight: 700; }
.chk { margin-left: auto; width: 24px; height: 24px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 13px; font-weight: 800; flex-shrink: 0; }
.chk.g { background: #00a855; color: #fff; } .chk.r { background: #e8001d; color: #fff; } .chk.off { border: 2px solid #ddd; }
.bk-tag { background: #e8001d; color: #fff; font-size: 14px; font-weight: 800; border-radius: 8px; padding: 8px 14px; flex-shrink: 0; }
.btn-g { width: 100%; background: #00a855; color: #fff; border: none; padding: 16px; border-radius: 12px; font-size: 16px; font-weight: 800; cursor: pointer; font-family: 'Hind Siliguri', sans-serif; margin-top: 5px; transition: transform 0.1s; }
.btn-g:active { transform: scale(0.98); }
.btn-r { width: 100%; background: #e8001d; color: #fff; border: none; padding: 16px; border-radius: 12px; font-size: 16px; font-weight: 800; cursor: pointer; font-family: 'Hind Siliguri', sans-serif; margin-top: 5px; transition: transform 0.1s; }
.btn-r:active { transform: scale(0.98); }
.error-msg { color: #e8001d; font-size: 13px; margin-top: 5px; display: none; font-weight: 600; }
.input-error { border-color:#e8001d !important; background:#fff5f5 !important; }
@media (min-width: 768px) {
    .address-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 15px 20px;
        margin-top: 10px;
    }
    .address-grid .fg {
        margin-bottom: 0;
    }
}
</style>

<div class="body-content outer-top-xs">
    <div class="container">
        <div class="row">
            <div class="col-md-12 checkout-content">

                <!-- STEP PROGRESS BAR -->
                <div class="checkout-steps">
                    <div class="stp"><div class="sc d">✓</div><div class="sl d">Cart</div></div>
                    <div class="sl-line d"></div>
                    <div class="stp"><div class="sc on">2</div><div class="sl on">Checkout</div></div>
                    <div class="sl-line"></div>
                    <div class="stp"><div class="sc off">3</div><div class="sl off">Done</div></div>
                </div>

                @php $isFreeDelivery = ($order_total_amount >= 1000); @endphp

            @if($isFreeDelivery)
                <!-- FREE DELIVERY SCENE -->
                <div class="fb">
                    <div class="ico">🎉</div>
                    <div class="txt">
                        <strong>FREE DELIVERY পেয়েছেন!</strong>
                        <span>১,০০০ টাকার উপরে — বিনামূল্যে ডেলিভারি</span>
                    </div>
                    <div class="pill">FREE ✅</div>
                </div>
            @else
                <!-- PAID SCENE -->
                <div class="wb">
                    ⚠️ ১,০০০ টাকার কম — ডেলিভারি চার্জ <strong>bKash-এ আগে</strong> পরিশোধ করতে হবে।
                </div>
            @endif

            <form id="checkoutForm" onsubmit="submitOrder(event)">
                <div class="row">
                    <div class="col-md-7">
                        <div class="chk-card">
                            <div class="card-ttl">📍 ডেলিভারি ঠিকানা</div>
                            <div class="address-grid">
                                <div class="fg">
                                    <label>পূর্ণ নাম <span style="color:#e8001d">*</span></label>
                                    <input type="text" id="cust_name" placeholder="আপনার পূর্ণ নাম" value="{{ auth()->check() ? auth()->user()->name : '' }}">
                                    <div class="error-msg" id="err_name">আপনার পূর্ণ নাম দিন।</div>
                                </div>
                                <div class="fg">
                                    <label>মোবাইল নম্বর <span style="color:#e8001d">*</span></label>
                                    <input type="tel" id="cust_mobile" placeholder="01XXXXXXXXX" value="{{ auth()->check() ? auth()->user()->mobile : '' }}">
                                    <div class="error-msg" id="err_mobile">সঠিক মোবাইল নম্বর দিন।</div>
                                </div>
                                <div class="fg">
                                    <label>ডেলিভারি ঠিকানা <span style="color:#e8001d">*</span></label>
                                    <textarea id="cust_address" rows="3" placeholder="বাড়ি নম্বর, রাস্তা, এলাকা, পাড়া/মহল্লা...">{{ auth()->check() ? auth()->user()->address : '' }}</textarea>
                                    <div class="error-msg" id="err_address">ডেলিভারি ঠিকানা দিন।</div>
                                </div>
                                <div class="fg" style="position:relative;">
                                    <label>Delivery Area <span style="color:#e8001d">*</span></label>
                                    @php
                                        $deliveryZones = \App\Models\DeliveryZone::orderBy('zone_charge','asc')->get();
                                    @endphp

                                    {{-- Hidden real input for form submission --}}
                                    <input type="hidden" id="delivery_zone" name="delivery_zone">

                                    {{-- Custom dropdown trigger --}}
                                    <div id="zone-trigger" onclick="toggleZoneDropdown()"
                                         style="width:100%;padding:12px 14px;border:1.5px solid #e5e5e5;border-radius:10px;font-size:14px;font-family:'Hind Siliguri',sans-serif;background:#fff;color:#aaa;cursor:pointer;display:flex;justify-content:space-between;align-items:center;user-select:none;">
                                        <span id="zone-label">— Delivery Area বেছে নিন —</span>
                                        <span id="zone-arrow" style="transition:transform 0.2s;">▾</span>
                                    </div>

                                    {{-- Custom dropdown list --}}
                                    <div id="zone-list" style="display:none;position:absolute;top:calc(100% + 4px);left:0;right:0;background:#fff;border:1.5px solid #e5e5e5;border-radius:10px;box-shadow:0 8px 24px rgba(0,0,0,0.12);z-index:9999;overflow:hidden;max-height:220px;overflow-y:auto;">
                                        @foreach($deliveryZones as $zone)
                                        <div class="zone-option"
                                             data-id="{{ $zone->id }}"
                                             data-charge="{{ $zone->zone_charge }}"
                                             onclick="selectZone(this)"
                                             style="padding:13px 16px;font-size:14px;font-family:'Hind Siliguri',sans-serif;cursor:pointer;display:flex;justify-content:space-between;border-bottom:1px solid #f5f5f5;transition:background 0.15s;">
                                            <span>{{ $zone->zone_area }}</span>
                                            <span style="color:#e8001d;font-weight:700;">৳{{ $zone->zone_charge }}</span>
                                        </div>
                                        @endforeach
                                    </div>

                                    <div class="error-msg" id="err_zone">Delivery Area অবশ্যই বেছে নিতে হবে।</div>
                                    @if(!$isFreeDelivery)
                                        <small style="color:#888;font-size:13px;display:block;margin-top:6px">✅ ১,০০০ টাকার উপরে Delivery FREE</small>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-5">
                        <!-- Removed coupon code section temporarily as the CustomerOrderCheckout method doesn't accept coupon logic currently. It can be added later! -->

                        <div class="chk-card">
                            <div class="card-ttl">💰 সারসংক্ষেপ</div>
                            <div class="sr">
                                <span class="lbl">পণ্যের মোট</span>
                                <span class="val">৳{{ number_format($order_total_amount) }}</span>
                            </div>
                            @if($isFreeDelivery)
                                <div class="sr">
                                    <span class="lbl">ডেলিভারি চার্জ</span>
                                    <span class="g">🎉 বিনামূল্যে</span>
                                </div>
                                <div class="sr">
                                    <span class="lbl">সর্বমোট</span>
                                    <span class="r">৳{{ number_format($order_total_amount) }}</span>
                                </div>
                            @else
                                <div class="sr">
                                    <span class="lbl" style="color:#e8001d">ডেলিভারি চার্জ</span>
                                    <span class="r" id="lbl_del_charge">৳0</span>
                                </div>
                                <div class="sr">
                                    <span class="lbl">সর্বমোট</span>
                                    <span class="r" id="lbl_grand_total">৳{{ number_format($order_total_amount) }}</span>
                                </div>
                            @endif
                        </div>

                        <div class="chk-card">
                            <div class="card-ttl">💳 পেমেন্ট পদ্ধতি:</div>
                            
                            <input type="hidden" id="selected_payment" value="cod">

                            @if($isFreeDelivery)
                                <div class="pay-card cod-on" id="card_cod" onclick="selectPayment('cod')">
                                    <div style="font-size:32px">🏠</div>
                                    <div>
                                        <div class="pay-tit">Cash on Delivery-তে অর্ডার করুন</div>
                                        <div class="pay-sub">পণ্য পেয়ে দরজায় পেমেন্ট করুন</div>
                                    </div>
                                    <div class="chk g" id="chk_cod">✓</div>
                                </div>
                                <div class="pay-card" id="card_bkash" onclick="selectPayment('bkash')">
                                    <div class="bk-tag">bKash</div>
                                    <div>
                                        <div class="pay-tit">Full Payment করে অর্ডার করুন</div>
                                        <div class="pay-sub">bKash-এ এখনই সম্পূর্ণ পেমেন্ট</div>
                                    </div>
                                    <div class="chk off" id="chk_bkash"></div>
                                </div>
                                <button type="submit" class="btn-g" id="btn_submit">✅ Cash on Delivery-তে Order করুন</button>
                            @else
                                <div class="pay-card cod-on" id="card_cod" onclick="selectPayment('cod')">
                                    <div style="font-size:32px">🏠</div>
                                    <div>
                                        <div class="pay-tit">Cash on Delivery-তে অর্ডার করতে</div>
                                        <div class="pay-sub r" id="sub_cod_b">ডেলিভারি চার্জ (৳0) bKash-এ পে করুন</div>
                                    </div>
                                    <div class="chk g" id="chk_cod">✓</div>
                                </div>
                                <div class="pay-card" id="card_bkash" onclick="selectPayment('bkash')">
                                    <div class="bk-tag">bKash</div>
                                    <div>
                                        <div class="pay-tit">Full Payment করে অর্ডার করতে</div>
                                        <div class="pay-sub" id="sub_bkash_b">সম্পূর্ণ ৳{{ number_format($order_total_amount) }} bKash-এ পে করুন</div>
                                    </div>
                                    <div class="chk off" id="chk_bkash"></div>
                                </div>
                                <button type="submit" class="btn-g" id="btn_submit">💳 ডেলিভারি চার্জ ৳0 bKash-এ পে করুন</button>
                            @endif
                        </div>
                    </div>
                </div>
            </form>

<script>
    const isFreeDelivery = {{ $isFreeDelivery ? 'true' : 'false' }};
    const orderTotal = {{ $order_total_amount }};

    // ===== Custom Zone Dropdown =====
    let selectedZoneCharge = 0;

    function toggleZoneDropdown() {
        const list = document.getElementById('zone-list');
        const arrow = document.getElementById('zone-arrow');
        const isOpen = list.style.display !== 'none';
        list.style.display = isOpen ? 'none' : 'block';
        arrow.style.transform = isOpen ? 'rotate(0deg)' : 'rotate(180deg)';
    }

    function selectZone(el) {
        const id = el.getAttribute('data-id');
        const charge = parseInt(el.getAttribute('data-charge')) || 0;
        const label = el.querySelector('span:first-child').textContent + ' (৳' + charge + ')';

        document.getElementById('delivery_zone').value = id;
        document.getElementById('zone-label').textContent = label;
        document.getElementById('zone-label').style.color = '#111';
        document.getElementById('zone-trigger').style.borderColor = '#e5e5e5';

        // Highlight selected
        document.querySelectorAll('.zone-option').forEach(o => o.style.background = '');
        el.style.background = '#fff5f5';

        selectedZoneCharge = charge;
        document.getElementById('zone-list').style.display = 'none';
        document.getElementById('zone-arrow').style.transform = 'rotate(0deg)';
        document.getElementById('err_zone').style.display = 'none';

        updateCartTotal(charge);
    }

    // Close dropdown when clicking outside
    document.addEventListener('click', function(e) {
        const trigger = document.getElementById('zone-trigger');
        const list = document.getElementById('zone-list');
        if (!trigger.contains(e.target) && !list.contains(e.target)) {
            list.style.display = 'none';
            document.getElementById('zone-arrow').style.transform = 'rotate(0deg)';
        }
    });

    function updateCartTotal(charge) {
        if (isFreeDelivery) return;
        charge = charge !== undefined ? charge : selectedZoneCharge;
        const grandTotal = orderTotal + charge;
        const delEl = document.getElementById('lbl_del_charge');
        const totEl = document.getElementById('lbl_grand_total');
        const stickyEl = document.getElementById('sticky_total');
        if (delEl) delEl.textContent = '৳' + charge;
        if (totEl) totEl.textContent = '৳' + grandTotal;
        if (stickyEl) stickyEl.textContent = '৳' + grandTotal;

        document.getElementById('sub_cod_b').textContent = 'ডেলিভারি চার্জ (৳' + charge + ') bKash-এ পে করুন';
        document.getElementById('sub_bkash_b').textContent = 'সম্পূর্ণ ৳' + grandTotal + ' bKash-এ পে করুন';

        // Re-run selectPayment to update button text
        selectPayment(document.getElementById('selected_payment').value);
    }

    function selectPayment(method) {
        document.getElementById('selected_payment').value = method;
        const btn = document.getElementById('btn_submit');
        
        if (method === 'cod') {
            document.getElementById('card_cod').className = 'pay-card cod-on';
            document.getElementById('card_bkash').className = 'pay-card';
            document.getElementById('chk_cod').className = 'chk g';
            document.getElementById('chk_cod').textContent = '✓';
            document.getElementById('chk_bkash').className = 'chk off';
            document.getElementById('chk_bkash').textContent = '';

            if (isFreeDelivery) {
                btn.textContent = '✅ Cash on Delivery-তে Order করুন';
                btn.className = 'btn-g';
            } else {
                const charge = selectedZoneCharge || 0;
                btn.textContent = '💳 ডেলিভারি চার্জ ৳' + charge + ' bKash-এ পে করুন';
                btn.className = 'btn-g';
            }
        } else {
            document.getElementById('card_bkash').className = 'pay-card bk-on';
            document.getElementById('card_cod').className = 'pay-card';
            document.getElementById('chk_bkash').className = 'chk r';
            document.getElementById('chk_bkash').textContent = '✓';
            document.getElementById('chk_cod').className = 'chk off';
            document.getElementById('chk_cod').textContent = '';

            if (isFreeDelivery) {
                btn.textContent = '💳 Full Payment করে Order করুন';
                btn.className = 'btn-r';
            } else {
                const charge = selectedZoneCharge || 0;
                const grandTotal = orderTotal + charge;
                btn.textContent = '💳 Full Payment ৳' + grandTotal + ' bKash-এ পে করুন';
                btn.className = 'btn-r';
            }
        }
    }

    async function submitOrder(e) {
        e.preventDefault();
        const btn = document.getElementById('btn_submit');

        // Reset errors
        document.querySelectorAll('.error-msg').forEach(el => el.style.display = 'none');
        document.querySelectorAll('.input-error').forEach(el => el.classList.remove('input-error'));

        const name = document.getElementById('cust_name').value.trim();
        const mobile = document.getElementById('cust_mobile').value.trim();
        const address = document.getElementById('cust_address').value.trim();
        const zone = document.getElementById('delivery_zone').value;
        const payment = document.getElementById('selected_payment').value;

        let hasError = false;
        if (!name) { document.getElementById('err_name').style.display = 'block'; document.getElementById('cust_name').classList.add('input-error'); hasError = true; }
        if (!mobile) { document.getElementById('err_mobile').style.display = 'block'; document.getElementById('cust_mobile').classList.add('input-error'); hasError = true; }
        if (!address) { document.getElementById('err_address').style.display = 'block'; document.getElementById('cust_address').classList.add('input-error'); hasError = true; }
        if (!zone) { document.getElementById('err_zone').style.display = 'block'; document.getElementById('zone-trigger').style.borderColor = '#e8001d'; hasError = true; }

        if (hasError) {
            window.scrollTo({top: 0, behavior: 'smooth'});
            return;
        }

        btn.disabled = true;
        const oldText = btn.textContent;
        btn.textContent = 'অপেক্ষা করুন...';

        try {
            const formData = new FormData();
            formData.append('guest_checkout', '1');
            formData.append('name', name);
            formData.append('mobile', mobile);
            formData.append('address', address);
            formData.append('delivery_zone', zone);
            formData.append('payment_method', payment);

            const response = await fetch("{{ route('guest.order.checkout') }}", {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json'
                },
                body: formData
            });

            if (response.status === 422) {
                const errData = await response.json();
                const errors = errData.errors || {};
                const fieldMap = {'name':'err_name','mobile':'err_mobile','address':'err_address','delivery_zone':'err_zone','payment_method':'err_payment'};
                Object.keys(errors).forEach(field => {
                    const elId = fieldMap[field];
                    if (elId) { const el = document.getElementById(elId); if (el) { el.textContent = errors[field][0]; el.style.display = 'block'; } }
                    if (field === 'delivery_zone') { const zt = document.getElementById('zone-trigger'); if (zt) zt.style.borderColor = '#e8001d'; }
                });
                btn.disabled = false;
                btn.textContent = oldText;
                return;
            }

            const result = await response.json();
            if (result.status) {
                window.location.href = result.url;
            } else {
                alert(result.message || 'একটি ত্রুটি ঘটেছে! আবার চেষ্টা করুন।');
                btn.disabled = false;
                btn.textContent = oldText;
            }
        } catch (error) {
            console.error(error);
            alert('সার্ভার ত্রুটি! দয়া করে আবার চেষ্টা করুন।');
            btn.disabled = false;
            btn.textContent = oldText;
        }
    }
</script>

            </div><!-- /.col-md-12 -->
        </div><!-- /.row -->
    </div><!-- /.container -->
</div><!-- /.body-content -->

@endsection
