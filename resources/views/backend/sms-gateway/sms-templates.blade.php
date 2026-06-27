@extends('backend.layouts.master')
@section('content')
<div class="content-wrapper">
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h5 class="m-0"><i class="fas fa-sms text-primary"></i> SMS Message Templates</h5>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item active">SMS Templates</li>
          </ol>
        </div>
      </div>
    </div>
  </div>

  <section class="content">
    <div class="container-fluid">

      @if(session('success'))
      <div class="alert alert-success alert-dismissible fade show">
        <i class="fas fa-check-circle"></i> {{ session('success') }}
        <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
      </div>
      @endif

      {{-- Variables Reference Card --}}
      <div class="card shadow-sm mb-3">
        <div class="card-header bg-info text-white">
          <h3 class="card-title"><i class="fas fa-code mr-2"></i>Available Variables — এগুলো message-এ ব্যবহার করতে পারবেন</h3>
          <div class="card-tools">
            <button class="btn btn-sm btn-light" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
          </div>
        </div>
        <div class="card-body">
          <div class="row">
            <div class="col-md-4">
              <h6 class="font-weight-bold text-primary">Order Messages</h6>
              <table class="table table-sm table-bordered">
                <tr><td><code>{name}</code></td><td>Customer-এর নাম</td></tr>
                <tr><td><code>{invoice}</code></td><td>Invoice Number (USP00044)</td></tr>
                <tr><td><code>{amount}</code></td><td>মোট টাকা</td></tr>
                <tr><td><code>{delivery_charge}</code></td><td>ডেলিভারি চার্জ</td></tr>
                <tr><td><code>{due_amount}</code></td><td>ডেলিভারিতে দিতে হবে</td></tr>
                <tr><td><code>{track_link}</code></td><td>Order tracking link</td></tr>
              </table>
            </div>
            <div class="col-md-4">
              <h6 class="font-weight-bold text-success">Registration Messages</h6>
              <table class="table table-sm table-bordered">
                <tr><td><code>{name}</code></td><td>Seller/Vendor নাম</td></tr>
                <tr><td><code>{invoice}</code></td><td>Invoice Number</td></tr>
                <tr><td><code>{phone}</code></td><td>ফোন নম্বর</td></tr>
                <tr><td><code>{password}</code></td><td>Login password</td></tr>
                <tr><td><code>{date}</code></td><td>Account তৈরির তারিখ</td></tr>
                <tr><td><code>{expire_date}</code></td><td>Subscription শেষ তারিখ</td></tr>
                <tr><td><code>{package}</code></td><td>Package নাম</td></tr>
              </table>
            </div>
            <div class="col-md-4">
              <h6 class="font-weight-bold text-warning">Other Messages</h6>
              <table class="table table-sm table-bordered">
                <tr><td><code>{days}</code></td><td>মেয়াদ শেষের দিন</td></tr>
                <tr><td><code>{expire_date}</code></td><td>Expire তারিখ</td></tr>
                <tr><td><code>{amount}</code></td><td>Withdraw amount</td></tr>
                <tr><td><code>{txn_id}</code></td><td>Transaction ID</td></tr>
                <tr><td><code>{method}</code></td><td>Payment method</td></tr>
                <tr><td><code>{date}</code></td><td>তারিখ</td></tr>
              </table>
            </div>
          </div>
          <div class="alert alert-warning mb-0 mt-2">
            <i class="fas fa-exclamation-triangle"></i>
            <strong>মনে রাখবেন:</strong> MimSMS-এ SMS character limit আছে। Message বড় হলে একাধিক SMS charge হবে।
          </div>
        </div>
      </div>

      {{-- Templates Form --}}
      <form action="{{ route('sms.templates.update') }}" method="POST">
        @csrf
        @method('PUT')

        @php
          $templates = [
            'order' => [
              ['key' => 'tpl_order_confirmed_cod_free', 'label' => 'Order Confirmed — COD + Free Delivery (≥১০০০ টাকা)', 'icon' => 'fa-check-circle text-success', 'badge' => 'success', 'badge_text' => 'Order'],
              ['key' => 'tpl_order_confirmed_cod_paid', 'label' => 'Order Confirmed — COD + Delivery Charge Paid (<১০০০ টাকা)', 'icon' => 'fa-check-circle text-success', 'badge' => 'success', 'badge_text' => 'Order'],
              ['key' => 'tpl_order_confirmed_bkash',   'label' => 'Order Confirmed — bKash Full Payment', 'icon' => 'fa-check-circle text-primary', 'badge' => 'primary', 'badge_text' => 'Order'],
              ['key' => 'tpl_order_processing', 'label' => 'Order Processing / Packaging ⏳', 'icon' => 'fa-spinner text-info', 'badge' => 'info', 'badge_text' => 'Order'],
              ['key' => 'tpl_order_shipped',    'label' => 'Order Shipped — পণ্য রওনা হয়েছে 🚚', 'icon' => 'fa-truck text-purple', 'badge' => 'secondary', 'badge_text' => 'Order'],
              ['key' => 'tpl_order_delivered',  'label' => 'Order Delivered — ডেলিভারি সম্পন্ন ✅', 'icon' => 'fa-box-open text-success', 'badge' => 'success', 'badge_text' => 'Order'],
              ['key' => 'tpl_order_cancelled',  'label' => 'Order Cancelled — বাতিল ❌', 'icon' => 'fa-times-circle text-danger', 'badge' => 'danger', 'badge_text' => 'Order'],
              ['key' => 'tpl_order_return',     'label' => 'Order Returned — রিটার্ন ↩️', 'icon' => 'fa-undo text-warning', 'badge' => 'warning', 'badge_text' => 'Order'],
            ],
            'member' => [
              ['key' => 'tpl_welcome_seller',       'label' => 'Welcome — নতুন Seller Registration', 'icon' => 'fa-store text-primary', 'badge' => 'primary', 'badge_text' => 'Member'],
              ['key' => 'tpl_welcome_vendor',       'label' => 'Welcome — নতুন Vendor Registration', 'icon' => 'fa-industry text-success', 'badge' => 'success', 'badge_text' => 'Member'],
              ['key' => 'tpl_welcome_dropshipper',  'label' => 'Welcome — নতুন Dropshipper Registration', 'icon' => 'fa-rocket text-danger', 'badge' => 'danger', 'badge_text' => 'Member'],
              ['key' => 'tpl_subscription_expiry',  'label' => 'Subscription Expiry Reminder ⚠️ (৩০ দিন আগে)', 'icon' => 'fa-bell text-warning', 'badge' => 'warning', 'badge_text' => 'Member'],
              ['key' => 'tpl_withdrawal_approved',  'label' => 'Withdrawal Approved — টাকা পাঠানো হয়েছে 💳', 'icon' => 'fa-money-bill-wave text-success', 'badge' => 'success', 'badge_text' => 'Wallet'],
              ['key' => 'tpl_password_reset',       'label' => 'Password Reset — পাসওয়ার্ড পরিবর্তন 🔐', 'icon' => 'fa-lock text-danger', 'badge' => 'danger', 'badge_text' => 'Security'],
            ],
          ];
        @endphp

        {{-- Order Notifications --}}
        <div class="card shadow-sm mb-3">
          <div class="card-header bg-primary text-white">
            <h3 class="card-title"><i class="fas fa-shopping-bag mr-2"></i>Order Status Notifications</h3>
          </div>
          <div class="card-body p-0">
            @foreach($templates['order'] as $i => $tpl)
            <div style="border-bottom: 1px solid #eee; padding: 20px 24px; {{ $i % 2 == 0 ? 'background:#fff;' : 'background:#fafafa;' }}">
              <div class="d-flex align-items-center mb-2">
                <i class="fas {{ $tpl['icon'] }} mr-2"></i>
                <strong style="font-size:14px">{{ $tpl['label'] }}</strong>
                <span class="badge badge-{{ $tpl['badge'] }} ml-2">{{ $tpl['badge_text'] }}</span>
              </div>
              <textarea
                name="{{ $tpl['key'] }}"
                rows="7"
                class="form-control"
                style="font-family: 'Courier New', monospace; font-size: 13px; line-height: 1.6; border-radius: 8px;"
                placeholder="SMS message লিখুন...">{{ old($tpl['key'], $smsSettings->{$tpl['key']} ?? '') }}</textarea>
              <small class="text-muted mt-1 d-block">
                <span class="char-count" id="count_{{ $tpl['key'] }}">0</span> characters
                | ~<span class="sms-parts" id="parts_{{ $tpl['key'] }}">1</span> SMS part(s)
              </small>
            </div>
            @endforeach
          </div>
        </div>

        {{-- Member Notifications --}}
        <div class="card shadow-sm mb-3">
          <div class="card-header bg-success text-white">
            <h3 class="card-title"><i class="fas fa-users mr-2"></i>Member & Wallet Notifications</h3>
          </div>
          <div class="card-body p-0">
            @foreach($templates['member'] as $i => $tpl)
            <div style="border-bottom: 1px solid #eee; padding: 20px 24px; {{ $i % 2 == 0 ? 'background:#fff;' : 'background:#fafafa;' }}">
              <div class="d-flex align-items-center mb-2">
                <i class="fas {{ $tpl['icon'] }} mr-2"></i>
                <strong style="font-size:14px">{{ $tpl['label'] }}</strong>
                <span class="badge badge-{{ $tpl['badge'] }} ml-2">{{ $tpl['badge_text'] }}</span>
              </div>
              <textarea
                name="{{ $tpl['key'] }}"
                rows="10"
                class="form-control"
                style="font-family: 'Courier New', monospace; font-size: 13px; line-height: 1.6; border-radius: 8px;"
                placeholder="SMS message লিখুন...">{{ old($tpl['key'], $smsSettings->{$tpl['key']} ?? '') }}</textarea>
              <small class="text-muted mt-1 d-block">
                <span class="char-count" id="count_{{ $tpl['key'] }}">0</span> characters
                | ~<span class="sms-parts" id="parts_{{ $tpl['key'] }}">1</span> SMS part(s)
              </small>
            </div>
            @endforeach
          </div>
        </div>

        <div class="d-flex gap-2 mb-4">
          <button type="submit" class="btn btn-primary btn-lg px-5">
            <i class="fas fa-save mr-2"></i> সব Templates Save করুন
          </button>
          <a href="{{ route('smsgateways.view') }}" class="btn btn-secondary btn-lg">
            <i class="fas fa-arrow-left mr-2"></i> Back
          </a>
        </div>
      </form>

    </div>
  </section>
</div>

@push('scripts')
<script>
document.querySelectorAll('textarea').forEach(function(ta) {
  var key = ta.name;
  var countEl = document.getElementById('count_' + key);
  var partsEl = document.getElementById('parts_' + key);

  function update() {
    var len = ta.value.length;
    if (countEl) countEl.textContent = len;
    if (partsEl) {
      var parts = len <= 160 ? 1 : Math.ceil(len / 153);
      partsEl.textContent = parts;
      partsEl.style.color = parts > 2 ? '#dc3545' : parts > 1 ? '#fd7e14' : '#28a745';
    }
  }
  ta.addEventListener('input', update);
  update();
});
</script>
@endpush
@endsection
