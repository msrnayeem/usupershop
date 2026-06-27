@extends('frontend.layouts.master')
@section('title', 'OTP Verify — U Super Shop')
@section('content')

<style>
.otp-page { background:#f4f5f9; min-height:60vh; padding:40px 0 60px; }
.otp-card { max-width:440px; margin:0 auto; background:#fff; border-radius:16px; box-shadow:0 4px 24px rgba(0,0,0,.08); overflow:hidden; font-family:'Hind Siliguri',sans-serif; }
.otp-header { background:linear-gradient(135deg,#e8001d,#b30015); padding:28px 24px; text-align:center; }
.otp-header .icon { font-size:48px; margin-bottom:8px; }
.otp-header h2 { color:#fff; font-size:20px; font-weight:800; margin:0 0 5px; }
.otp-header p { color:rgba(255,255,255,.85); font-size:13px; margin:0; }
.otp-body { padding:26px 24px 28px; }
.otp-inputs { display:flex; gap:10px; justify-content:center; margin:20px 0; }
.otp-inputs input { width:48px; height:54px; border-radius:10px; border:2px solid #e5e5e5; text-align:center; font-size:22px; font-weight:800; font-family:'Hind Siliguri',monospace; color:#111; outline:none; transition:border-color .2s; }
.otp-inputs input:focus { border-color:#e8001d; box-shadow:0 0 0 3px rgba(232,0,29,.1); }
.otp-inputs input.filled { border-color:#e8001d; background:#fff5f5; }
.otp-submit { width:100%; background:#e8001d; color:#fff; border:none; padding:14px; border-radius:12px; font-size:15px; font-weight:800; cursor:pointer; font-family:'Hind Siliguri',sans-serif; transition:background .15s; margin-top:6px; }
.otp-submit:hover { background:#c20019; }
.otp-submit:disabled { background:#ccc; cursor:not-allowed; }
.resend-section { text-align:center; margin-top:18px; padding-top:18px; border-top:1px solid #f0f0f0; }
.countdown { font-size:13px; color:#888; font-family:'Hind Siliguri',sans-serif; }
.countdown span { color:#e8001d; font-weight:800; font-size:14px; }
.resend-btn { background:none; border:none; color:#e8001d; font-size:13px; font-weight:700; cursor:pointer; font-family:'Hind Siliguri',sans-serif; text-decoration:underline; padding:0; display:none; }
.resend-btn:disabled { color:#bbb; cursor:not-allowed; text-decoration:none; }
.resend-attempts { font-size:13px; color:#aaa; margin-top:5px; display:block; }
.alert-box { border-radius:10px; padding:12px 16px; margin-bottom:14px; font-size:13px; font-family:'Hind Siliguri',sans-serif; }
.alert-success-box { background:#d4edda; color:#155724; border:1px solid #c3e6cb; }
.alert-error-box { background:#f8d7da; color:#721c24; border:1px solid #f5c6cb; }
.info-row { display:flex; align-items:center; gap:10px; background:#f8f9fb; border-radius:10px; padding:12px 14px; margin-bottom:16px; }
.info-row .num { font-size:15px; font-weight:800; color:#333; font-family:monospace; }
.info-row .lbl { font-size:14px; color:#888; }
.change-link { font-size:14px; color:#e8001d; text-decoration:none; margin-left:auto; font-weight:700; }
</style>

<div class="otp-page">
<div class="container">
<div class="otp-card">

  {{-- Header --}}
  <div class="otp-header">
    <div class="icon">🔐</div>
    <h2>OTP যাচাই করুন</h2>
    <p>আপনার ফোনে পাঠানো ৬ সংখ্যার কোড দিন</p>
  </div>

  <div class="otp-body">

    {{-- Alerts --}}
    @if(session('success'))
    <div class="alert-box alert-success-box">✅ {{ session('success') }}</div>
    @endif
    @if(session('message') && session('message') !== session('success'))
    <div class="alert-box" style="background:#fff3cd;color:#856404;border:1px solid #ffeeba">
      ⚠️ {{ session('message') }}
    </div>
    @endif
    @if($errors->any())
    <div class="alert-box alert-error-box">
      ❌ {{ $errors->first() }}
    </div>
    @endif

    {{-- Sent to info --}}
    @if(Session::get('verify_content'))
    <div class="info-row">
      <div>
        <div class="lbl">OTP পাঠানো হয়েছে:</div>
        <div class="num">{{ Session::get('verify_content') }}</div>
      </div>
      <a href="{{ route('forget.email') }}" class="change-link">পরিবর্তন করুন</a>
    </div>
    @endif

    {{-- OTP Form --}}
    <form action="{{ route('forget.verify.otp') }}" method="POST" id="otpForm">
      @csrf
      <input type="hidden" name="context" value="{{ Session::get('verify_content') }}">

      <p style="font-size:13px;color:#666;text-align:center;margin-bottom:4px;font-family:'Hind Siliguri',sans-serif;">
        ৫ মিনিটের মধ্যে কোড দিন। কারো সাথে শেয়ার করবেন না।
      </p>

      {{-- 6 separate input boxes --}}
      <div class="otp-inputs" id="otpInputs">
        <input type="text" class="otp-digit" maxlength="1" inputmode="numeric" pattern="[0-9]" autocomplete="off">
        <input type="text" class="otp-digit" maxlength="1" inputmode="numeric" pattern="[0-9]" autocomplete="off">
        <input type="text" class="otp-digit" maxlength="1" inputmode="numeric" pattern="[0-9]" autocomplete="off">
        <input type="text" class="otp-digit" maxlength="1" inputmode="numeric" pattern="[0-9]" autocomplete="off">
        <input type="text" class="otp-digit" maxlength="1" inputmode="numeric" pattern="[0-9]" autocomplete="off">
        <input type="text" class="otp-digit" maxlength="1" inputmode="numeric" pattern="[0-9]" autocomplete="off">
      </div>
      <input type="hidden" name="otp" id="otpHidden">

      <button type="submit" class="otp-submit" id="submitBtn" disabled>
        ✅ যাচাই করুন
      </button>
    </form>

    {{-- Resend Section --}}
    <div class="resend-section">
      <div class="countdown" id="countdownMsg">
        OTP পাননি? <span id="timerDisplay">2:00</span> পরে আবার পাঠাতে পারবেন
      </div>
      <button class="resend-btn" id="resendBtn" onclick="resendOtp()">
        🔄 নতুন OTP পাঠান
      </button>
      <span class="resend-attempts" id="attemptsMsg"></span>
    </div>

    {{-- Back link --}}
    <div style="text-align:center;margin-top:16px">
      <a href="{{ route('forget.email') }}"
         style="font-size:14px;color:#aaa;text-decoration:none;font-family:'Hind Siliguri',sans-serif">
        ← শুরুতে ফিরে যান
      </a>
    </div>

  </div>
</div>
</div>
</div>

<script>
// ── OTP Input auto-advance ──────────────────────────────────────────────
var digits = document.querySelectorAll('.otp-digit');
var hidden = document.getElementById('otpHidden');
var submitBtn = document.getElementById('submitBtn');

digits.forEach(function(input, idx) {
  input.addEventListener('input', function() {
    this.value = this.value.replace(/[^0-9]/g, '');
    if (this.value && idx < digits.length - 1) digits[idx + 1].focus();
    updateHidden();
    this.classList.toggle('filled', this.value !== '');
  });

  input.addEventListener('keydown', function(e) {
    if (e.key === 'Backspace' && !this.value && idx > 0) {
      digits[idx - 1].focus();
      digits[idx - 1].value = '';
      digits[idx - 1].classList.remove('filled');
      updateHidden();
    }
  });

  input.addEventListener('paste', function(e) {
    e.preventDefault();
    var paste = (e.clipboardData || window.clipboardData).getData('text').replace(/\D/g, '');
    paste.split('').forEach(function(ch, i) {
      if (digits[idx + i]) { digits[idx + i].value = ch; digits[idx + i].classList.add('filled'); }
    });
    var next = Math.min(idx + paste.length, digits.length - 1);
    digits[next].focus();
    updateHidden();
  });
});

function updateHidden() {
  var val = Array.from(digits).map(function(d) { return d.value; }).join('');
  hidden.value = val;
  submitBtn.disabled = val.length !== 6;
}

// ── Countdown Timer ─────────────────────────────────────────────────────
var RESEND_SECONDS = 120; // 2 minutes
var timerEl     = document.getElementById('timerDisplay');
var countdownMsg = document.getElementById('countdownMsg');
var resendBtn   = document.getElementById('resendBtn');
var attemptsMsg = document.getElementById('attemptsMsg');
var resendCount = 0;
var maxResend   = 3;
var timerInterval;

function startTimer(seconds) {
  clearInterval(timerInterval);
  resendBtn.style.display = 'none';
  countdownMsg.style.display = 'block';

  timerInterval = setInterval(function() {
    seconds--;
    var m = Math.floor(seconds / 60);
    var s = seconds % 60;
    timerEl.textContent = m + ':' + (s < 10 ? '0' : '') + s;

    if (seconds <= 0) {
      clearInterval(timerInterval);
      countdownMsg.style.display = 'none';
      if (resendCount < maxResend) {
        resendBtn.style.display = 'inline-block';
      } else {
        countdownMsg.style.display = 'block';
        countdownMsg.innerHTML = '৩ বারের বেশি OTP পাঠানো যাবে না। ১০ মিনিট পরে আবার চেষ্টা করুন।';
      }
    }
  }, 1000);
}

function resendOtp() {
  resendBtn.disabled = true;
  resendBtn.textContent = 'পাঠানো হচ্ছে...';

  fetch('{{ route("forget.otp.resend") }}', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
      'X-CSRF-TOKEN': '{{ csrf_token() }}'
    },
    body: JSON.stringify({})
  })
  .then(function(r) { return r.json(); })
  .then(function(data) {
    resendCount++;
    resendBtn.disabled = false;

    var msgBox = document.createElement('div');
    msgBox.className = 'alert-box ' + (data.status ? 'alert-success-box' : 'alert-error-box');
    msgBox.textContent = (data.status ? '✅ ' : '❌ ') + data.message;
    document.getElementById('otpForm').prepend(msgBox);
    setTimeout(function() { msgBox.remove(); }, 5000);

    if (data.status) {
      // Clear existing inputs
      digits.forEach(function(d) { d.value = ''; d.classList.remove('filled'); });
      digits[0].focus();
      updateHidden();
      startTimer(RESEND_SECONDS);
      attemptsMsg.textContent = 'বাকি: ' + data.remaining + ' বার';
    } else {
      resendBtn.disabled = false;
      if (data.remaining !== undefined && data.remaining <= 0) {
        resendBtn.style.display = 'none';
        countdownMsg.style.display = 'block';
        countdownMsg.innerHTML = '৩ বারের বেশি OTP পাঠানো যাবে না।';
      }
    }
  })
  .catch(function() {
    resendBtn.disabled = false;
    resendBtn.textContent = '🔄 নতুন OTP পাঠান';
  });
}

// Start timer on page load
startTimer(RESEND_SECONDS);
// Focus first input
digits[0].focus();
</script>
@endsection
