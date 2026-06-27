@extends('backend.layouts.master')
@section('content')
<div class="content-wrapper">
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6"><h5 class="m-0"><i class="fas fa-truck text-primary"></i> Courier API Settings</h5></div>
        <div class="col-sm-6"><ol class="breadcrumb float-sm-right"><li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li><li class="breadcrumb-item active">Couriers</li></ol></div>
      </div>
    </div>
  </div>

  <section class="content"><div class="container-fluid">

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show"><i class="fas fa-check-circle"></i> {{ session('success') }}<button type="button" class="close" data-dismiss="alert"><span>&times;</span></button></div>
    @endif
    @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show"><i class="fas fa-times-circle"></i> {{ session('error') }}<button type="button" class="close" data-dismiss="alert"><span>&times;</span></button></div>
    @endif

    @php
      $steadfast = $couriers->where('name', 'Steadfast')->first();
      $pathao    = $couriers->where('name', 'Pathao')->first();
    @endphp

    <div class="row">

      {{-- ── STEADFAST ─────────────────────────────────────── --}}
      <div class="col-md-6">
        <div class="card shadow-sm mb-4">
          <div class="card-header d-flex align-items-center" style="background:linear-gradient(135deg,#e8001d,#a00014)">
            <div style="font-size:24px;margin-right:10px">🚚</div>
            <div class="mr-auto">
              <h3 class="card-title text-white mb-0" style="font-size:16px">Steadfast Courier</h3>
              <small class="text-white-50">portal.packzy.com</small>
            </div>
            <span class="badge badge-{{ $steadfast?->is_active ? 'success' : 'secondary' }} ml-2">
              {{ $steadfast?->is_active ? '✅ Active' : '❌ Inactive' }}
            </span>
          </div>
          <form action="{{ route('couriers.update', $steadfast?->id ?? 0) }}" method="POST">
            @csrf @method('PUT')
            <div class="card-body">

              <div class="alert alert-light border" style="font-size:12px">
                <strong>📋 কোথায় পাবেন:</strong><br>
                1. <a href="https://portal.packzy.com" target="_blank">portal.packzy.com</a> → Login<br>
                2. Settings → API Integration → API Key & Secret Key copy করুন
              </div>

              <div class="form-group">
                <label class="font-weight-bold">API Key <span class="text-danger">*</span></label>
                <div class="input-group">
                  <input type="text" name="api_key" class="form-control" id="sfApiKey"
                    value="{{ old('api_key', $steadfast?->api_key) }}"
                    placeholder="আপনার Steadfast API Key"
                    style="font-family:monospace;font-size:13px">
                  <div class="input-group-append">
                    <button type="button" class="btn btn-outline-secondary" onclick="toggleVisible('sfApiKey')"><i class="fas fa-eye"></i></button>
                  </div>
                </div>
              </div>

              <div class="form-group">
                <label class="font-weight-bold">Secret Key <span class="text-danger">*</span></label>
                <div class="input-group">
                  <input type="password" name="secret_key" class="form-control" id="sfSecretKey"
                    value="{{ old('secret_key', $steadfast?->secret_key) }}"
                    placeholder="আপনার Steadfast Secret Key"
                    style="font-family:monospace;font-size:13px">
                  <div class="input-group-append">
                    <button type="button" class="btn btn-outline-secondary" onclick="toggleVisible('sfSecretKey')"><i class="fas fa-eye"></i></button>
                  </div>
                </div>
              </div>

              <div class="form-group">
                <label class="font-weight-bold">API Base URL</label>
                <input type="text" name="base_url" class="form-control"
                  value="{{ old('base_url', $steadfast?->base_url ?? 'https://portal.packzy.com/api/v1') }}"
                  style="font-family:monospace;font-size:12px">
                <small class="text-muted">সাধারণত পরিবর্তন করার দরকার নেই</small>
              </div>

              <div class="form-check mb-3">
                <input type="checkbox" class="form-check-input" name="is_active" id="sfActive" value="1" {{ $steadfast?->is_active ? 'checked' : '' }}>
                <label class="form-check-label font-weight-bold" for="sfActive">Steadfast Active রাখুন</label>
              </div>

            </div>
            <div class="card-footer d-flex" style="gap:8px">
              <button type="submit" class="btn btn-danger"><i class="fas fa-save mr-2"></i>Save করুন</button>
              <button type="button" class="btn btn-outline-secondary btn-sm" onclick="testCourier('steadfast')">
                <i class="fas fa-plug mr-1"></i>Connection Test
              </button>
            </div>
          </form>
        </div>
      </div>

      {{-- ── PATHAO ──────────────────────────────────────────── --}}
      <div class="col-md-6">
        <div class="card shadow-sm mb-4">
          <div class="card-header d-flex align-items-center" style="background:linear-gradient(135deg,#e8001d,#7a0010)">
            <div style="font-size:24px;margin-right:10px">🔴</div>
            <div class="mr-auto">
              <h3 class="card-title text-white mb-0" style="font-size:16px">Pathao Courier</h3>
              <small class="text-white-50">courier.pathao.com</small>
            </div>
            <span class="badge badge-{{ $pathao?->is_active ? 'success' : 'secondary' }} ml-2">
              {{ $pathao?->is_active ? '✅ Active' : '❌ Inactive' }}
            </span>
          </div>
          <form action="{{ route('couriers.update', $pathao?->id ?? 0) }}" method="POST">
            @csrf @method('PUT')
            <div class="card-body">

              <div class="alert alert-light border" style="font-size:12px">
                <strong>📋 কোথায় পাবেন:</strong><br>
                1. <a href="https://courier.pathao.com" target="_blank">courier.pathao.com</a> → Login<br>
                2. API Credentials → Client ID ও Client Secret<br>
                3. একই email/password দিন যা দিয়ে login করেন
              </div>

              <div class="form-row">
                <div class="col-md-6 form-group">
                  <label class="font-weight-bold">Client ID <span class="text-danger">*</span></label>
                  <div class="input-group">
                    <input type="text" name="client_id" class="form-control" id="ptClientId"
                      value="{{ old('client_id', $pathao?->client_id) }}"
                      placeholder="Client ID" style="font-family:monospace;font-size:12px">
                    <div class="input-group-append"><button type="button" class="btn btn-outline-secondary btn-sm" onclick="toggleVisible('ptClientId')"><i class="fas fa-eye"></i></button></div>
                  </div>
                </div>
                <div class="col-md-6 form-group">
                  <label class="font-weight-bold">Client Secret <span class="text-danger">*</span></label>
                  <div class="input-group">
                    <input type="password" name="client_secret" class="form-control" id="ptSecret"
                      value="{{ old('client_secret', $pathao?->client_secret) }}"
                      placeholder="Client Secret" style="font-family:monospace;font-size:12px">
                    <div class="input-group-append"><button type="button" class="btn btn-outline-secondary btn-sm" onclick="toggleVisible('ptSecret')"><i class="fas fa-eye"></i></button></div>
                  </div>
                </div>
              </div>

              <div class="form-row">
                <div class="col-md-6 form-group">
                  <label class="font-weight-bold">Username (Email) <span class="text-danger">*</span></label>
                  <input type="email" name="username" class="form-control"
                    value="{{ old('username', $pathao?->username) }}"
                    placeholder="login@email.com">
                </div>
                <div class="col-md-6 form-group">
                  <label class="font-weight-bold">Password <span class="text-danger">*</span></label>
                  <div class="input-group">
                    <input type="password" name="password" class="form-control" id="ptPw"
                      value="{{ old('password', $pathao?->password) }}"
                      placeholder="Pathao account password">
                    <div class="input-group-append"><button type="button" class="btn btn-outline-secondary btn-sm" onclick="toggleVisible('ptPw')"><i class="fas fa-eye"></i></button></div>
                  </div>
                </div>
              </div>

              <div class="form-group">
                <label class="font-weight-bold">Store ID <span style="background:#f0f0f0;color:#888;font-size:11px;padding:1px 6px;border-radius:8px;margin-left:4px">Optional — Auto detect করবে</span></label>
                <input type="text" name="store_id" class="form-control"
                  value="{{ old('store_id', $pathao?->store_id) }}"
                  placeholder="Store ID (খালি রাখলে auto fetch হবে)"
                  style="font-family:monospace;font-size:13px">
              </div>

              <div class="form-row">
                <div class="col-md-8 form-group">
                  <label class="font-weight-bold">API Base URL</label>
                  <input type="text" name="base_url" class="form-control"
                    value="{{ old('base_url', $pathao?->base_url ?? 'https://courier-api.pathao.com') }}"
                    style="font-family:monospace;font-size:12px">
                </div>
                <div class="col-md-4 form-group">
                  <label class="font-weight-bold">Mode</label>
                  <select name="is_sandbox" class="form-control" onchange="updatePathaoUrl(this.value)">
                    <option value="0" {{ ($pathao?->is_sandbox ?? 0) == 0 ? 'selected' : '' }}>🔴 Production</option>
                    <option value="1" {{ ($pathao?->is_sandbox ?? 0) == 1 ? 'selected' : '' }}>🟡 Sandbox</option>
                  </select>
                </div>
              </div>

              <div class="form-check mb-3">
                <input type="checkbox" class="form-check-input" name="is_active" id="ptActive" value="1" {{ $pathao?->is_active ? 'checked' : '' }}>
                <label class="form-check-label font-weight-bold" for="ptActive">Pathao Active রাখুন</label>
              </div>

            </div>
            <div class="card-footer d-flex" style="gap:8px">
              <button type="submit" class="btn btn-danger"><i class="fas fa-save mr-2"></i>Save করুন</button>
              <button type="button" class="btn btn-outline-secondary btn-sm" onclick="testCourier('pathao')">
                <i class="fas fa-plug mr-1"></i>Connection Test
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>

    {{-- Test result --}}
    <div id="testResult" style="display:none;margin-top:-10px" class="alert alert-info alert-dismissible">
      <button type="button" class="close" onclick="document.getElementById('testResult').style.display='none'"><span>&times;</span></button>
      <span id="testMsg"></span>
    </div>

    {{-- How it works --}}
    <div class="card shadow-sm">
      <div class="card-header bg-dark text-white"><h3 class="card-title"><i class="fas fa-info-circle mr-2"></i>কীভাবে কাজ করে</h3></div>
      <div class="card-body" style="font-size:13px">
        <div class="row">
          <div class="col-md-6">
            <h6>📦 Order Dispatch করতে:</h6>
            <ol style="padding-left:16px;line-height:2">
              <li>Admin → Orders → Order-এ যান</li>
              <li>"Send to Courier" বাটন click করুন</li>
              <li>Steadfast বা Pathao বেছে নিন</li>
              <li>Submit করুন — Tracking ID পাবেন</li>
            </ol>
          </div>
          <div class="col-md-6">
            <h6>🔑 API Key কোথায় পাবেন:</h6>
            <ul style="padding-left:16px;line-height:2">
              <li><strong>Steadfast:</strong> <a href="https://portal.packzy.com" target="_blank">portal.packzy.com</a> → API Integration</li>
              <li><strong>Pathao:</strong> <a href="https://courier.pathao.com" target="_blank">courier.pathao.com</a> → Developer Settings</li>
            </ul>
          </div>
        </div>
      </div>
    </div>

  </div></section>
</div>

@push('scripts')
<script>
function toggleVisible(id) {
  var inp = document.getElementById(id);
  inp.type = inp.type === 'password' ? 'text' : 'password';
}

function updatePathaoUrl(sandbox) {
  var urlInp = document.querySelector('input[name=base_url]');
  if (!urlInp) return;
  urlInp.value = sandbox == '1'
    ? 'https://courier-api-sandbox.pathao.com'
    : 'https://courier-api.pathao.com';
}

function testCourier(type) {
  var btn = event.currentTarget;
  btn.disabled = true;
  btn.innerHTML = '<i class="fas fa-spinner fa-spin mr-1"></i>Testing...';

  fetch('{{ route("couriers.test") }}', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
    body: JSON.stringify({ courier: type })
  })
  .then(r => r.json())
  .then(data => {
    var el = document.getElementById('testResult');
    var msg = document.getElementById('testMsg');
    el.style.display = 'block';
    el.className = 'alert alert-dismissible ' + (data.success ? 'alert-success' : 'alert-danger');
    msg.textContent = data.message;
    btn.disabled = false;
    btn.innerHTML = '<i class="fas fa-plug mr-1"></i>Connection Test';
  })
  .catch(() => {
    document.getElementById('testMsg').textContent = '❌ সংযোগ সমস্যা। আবার চেষ্টা করুন।';
    document.getElementById('testResult').style.display = 'block';
    btn.disabled = false;
    btn.innerHTML = '<i class="fas fa-plug mr-1"></i>Connection Test';
  });
}
</script>
@endpush
@endsection
