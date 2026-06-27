@extends('backend.layouts.master')
@section('content')
<div class="content-wrapper">
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h5 class="m-0"><i class="fas fa-bell text-primary"></i> Notification Settings</h5>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('settings.view') }}">Settings</a></li>
            <li class="breadcrumb-item active">Notification Settings</li>
          </ol>
        </div>
      </div>
    </div>
  </div>

  <section class="content">
    <div class="container-fluid">

      @if(session('success'))
      <div class="alert alert-success alert-dismissible">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        {{ session('success') }}
      </div>
      @endif

      @if(session('error'))
      <div class="alert alert-danger alert-dismissible">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        {{ session('error') }}
      </div>
      @endif

      <form action="{{ route('settings.notification.update') }}" method="POST">
        @csrf
        <div class="row">

          {{-- ═══ WhatsApp (CallMeBot) Settings ═══ --}}
          <div class="col-md-6">
            <div class="card card-primary card-outline shadow-sm">
              <div class="card-header">
                <h3 class="card-title">
                  <i class="fab fa-whatsapp text-success mr-2"></i>
                  WhatsApp Admin Notification
                </h3>
              </div>
              <div class="card-body">

                {{-- How to setup --}}
                <div class="callout callout-info mb-4">
                  <h5><i class="fas fa-info-circle"></i> Setup করুন (মাত্র একবার)</h5>
                  <p class="mb-2"><strong>Step 1:</strong> আপনার WhatsApp থেকে এই নম্বরে message করুন:</p>
                  <div class="bg-light p-2 rounded mb-2" style="font-family:monospace;font-size:15px;font-weight:700">
                    +34 644 65 21 68
                  </div>
                  <p class="mb-2"><strong>Step 2:</strong> এই message পাঠান:</p>
                  <div class="bg-light p-2 rounded mb-2" style="font-family:monospace">
                    I allow callmebot to send me messages
                  </div>
                  <p class="mb-0"><strong>Step 3:</strong> Reply-তে API Key পাবেন → নিচে দিন ✅</p>
                </div>

                {{-- WhatsApp Number --}}
                <div class="form-group">
                  <label><i class="fas fa-phone text-success"></i> Admin WhatsApp Number</label>
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="fab fa-whatsapp text-success"></i></span>
                    </div>
                    <input type="text" name="admin_whatsapp_number"
                      class="form-control"
                      value="{{ $setting->admin_whatsapp_number ?? '8801816622128' }}"
                      placeholder="8801816622128">
                  </div>
                  <small class="text-muted">Country code সহ দিন (যেমন: 8801816622128)</small>
                </div>

                {{-- CallMeBot API Key --}}
                <div class="form-group">
                  <label><i class="fas fa-key text-warning"></i> CallMeBot API Key</label>
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="fas fa-key"></i></span>
                    </div>
                    <input type="text" name="callmebot_api_key"
                      class="form-control" id="callmebot_key"
                      value="{{ $setting->callmebot_api_key ?? '' }}"
                      placeholder="যেমন: 1234567">
                    <div class="input-group-append">
                      <button type="button" class="btn btn-outline-secondary"
                        onclick="toggleKey()">
                        <i class="fas fa-eye" id="eyeIcon"></i>
                      </button>
                    </div>
                  </div>
                  @if(empty($setting->callmebot_api_key))
                  <small class="text-danger">
                    <i class="fas fa-exclamation-triangle"></i>
                    API Key এখনো দেওয়া হয়নি — WhatsApp notification কাজ করবে না।
                  </small>
                  @else
                  <small class="text-success">
                    <i class="fas fa-check-circle"></i>
                    API Key সেট আছে।
                  </small>
                  @endif
                </div>

                {{-- WhatsApp Notifications toggles --}}
                <div class="form-group">
                  <label><i class="fas fa-toggle-on text-primary"></i> WhatsApp Notification চালু/বন্ধ</label>
                  <div class="card bg-light p-3">
                    <div class="custom-control custom-switch mb-2">
                      <input type="checkbox" class="custom-control-input" id="wa_order"
                        name="whatsapp_notify_order" value="1"
                        {{ ($setting->whatsapp_notify_order ?? 1) ? 'checked' : '' }}>
                      <label class="custom-control-label" for="wa_order">
                        🛒 নতুন Order হলে WhatsApp notify
                      </label>
                    </div>
                    <div class="custom-control custom-switch">
                      <input type="checkbox" class="custom-control-input" id="wa_member"
                        name="whatsapp_notify_member" value="1"
                        {{ ($setting->whatsapp_notify_member ?? 1) ? 'checked' : '' }}>
                      <label class="custom-control-label" for="wa_member">
                        🎉 নতুন Seller/Vendor/Dropshipper payment হলে notify
                      </label>
                    </div>
                  </div>
                </div>

                {{-- Test WhatsApp --}}
                <div class="form-group mb-0">
                  <a href="{{ route('whatsapp.test') }}" class="btn btn-success btn-sm" target="_blank">
                    <i class="fab fa-whatsapp"></i> Test WhatsApp Send
                  </a>
                  <small class="text-muted ml-2">Save করার পর test করুন</small>
                </div>

              </div>
            </div>
          </div>

          {{-- ═══ MimSMS Settings ═══ --}}
          <div class="col-md-6">
            <div class="card card-success card-outline shadow-sm">
              <div class="card-header">
                <h3 class="card-title">
                  <i class="fas fa-sms text-success mr-2"></i>
                  MimSMS — Customer SMS Notification
                </h3>
              </div>
              <div class="card-body">

                <div class="callout callout-success mb-4">
                  <h5><i class="fas fa-info-circle"></i> MimSMS Setup</h5>
                  <p class="mb-1">MimSMS API credentials Admin Panel-এর <strong>SMS Gateway</strong> section-এ দিতে হবে।</p>
                  <a href="{{ route('smsgateways.view') }}" class="btn btn-sm btn-success mt-2">
                    <i class="fas fa-cog"></i> SMS Gateway Settings
                  </a>
                </div>

                {{-- SMS Enable/Disable --}}
                <div class="form-group">
                  <label><i class="fas fa-toggle-on text-success"></i> Customer SMS Notification</label>
                  <div class="card bg-light p-3">
                    <div class="custom-control custom-switch">
                      <input type="checkbox" class="custom-control-input" id="sms_enabled"
                        name="sms_notify_enabled" value="1"
                        {{ ($setting->sms_notify_enabled ?? 1) ? 'checked' : '' }}>
                      <label class="custom-control-label" for="sms_enabled">
                        📱 Customer SMS notification চালু রাখুন
                      </label>
                    </div>
                  </div>
                  <small class="text-muted">বন্ধ করলে কোনো SMS যাবে না</small>
                </div>

                {{-- SMS Events Info --}}
                <div class="form-group">
                  <label><i class="fas fa-list text-primary"></i> কোন কোন সময়ে SMS যাবে</label>
                  <div class="table-responsive">
                    <table class="table table-sm table-bordered">
                      <thead class="bg-light">
                        <tr>
                          <th>ঘটনা</th>
                          <th>SMS Content</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <td><span class="badge badge-success">Order Confirmed</span></td>
                          <td><small>Invoice, COD/Paid, tracking link</small></td>
                        </tr>
                        <tr>
                          <td><span class="badge badge-info">Processing</span></td>
                          <td><small>Packing notification</small></td>
                        </tr>
                        <tr>
                          <td><span class="badge badge-primary">Shipped</span></td>
                          <td><small>On the way notification</small></td>
                        </tr>
                        <tr>
                          <td><span class="badge badge-success">Delivered</span></td>
                          <td><small>Delivery complete</small></td>
                        </tr>
                        <tr>
                          <td><span class="badge badge-danger">Cancelled</span></td>
                          <td><small>Cancel notification</small></td>
                        </tr>
                        <tr>
                          <td><span class="badge badge-warning">Registration</span></td>
                          <td><small>Welcome + Invoice</small></td>
                        </tr>
                        <tr>
                          <td><span class="badge badge-secondary">Subscription</span></td>
                          <td><small>30-day expiry reminder</small></td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>

                {{-- Test SMS --}}
                <div class="form-group mb-0">
                  <a href="{{ route('smsgateways.view') }}" class="btn btn-sm btn-outline-success">
                    <i class="fas fa-paper-plane"></i> Test SMS পাঠান
                  </a>
                </div>

              </div>
            </div>
          </div>

        </div>

        {{-- Save Button --}}
        <div class="row">
          <div class="col-12">
            <div class="card card-outline card-dark shadow-sm">
              <div class="card-body d-flex align-items-center justify-content-between flex-wrap gap-2">
                <div>
                  <h6 class="mb-1"><i class="fas fa-save text-primary"></i> Settings Save করুন</h6>
                  <small class="text-muted">Save করার পর পরিবর্তন সাথে সাথে কার্যকর হবে।</small>
                </div>
                <button type="submit" class="btn btn-primary btn-lg">
                  <i class="fas fa-save mr-2"></i> Save Settings
                </button>
              </div>
            </div>
          </div>
        </div>

      </form>

    </div>
  </section>
</div>

@push('scripts')
<script>
function toggleKey() {
  var input = document.getElementById('callmebot_key');
  var icon = document.getElementById('eyeIcon');
  if (input.type === 'password') {
    input.type = 'text';
    icon.className = 'fas fa-eye-slash';
  } else {
    input.type = 'password';
    icon.className = 'fas fa-eye';
  }
}

// Initialize as text (visible by default for settings page)
document.getElementById('callmebot_key').type = 'text';
</script>
@endpush
@endsection
