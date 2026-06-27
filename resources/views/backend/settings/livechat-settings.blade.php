@extends('backend.layouts.master')
@section('content')
<div class="content-wrapper">
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h5 class="m-0"><i class="fas fa-comments text-success"></i> Live Chat Settings</h5>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item active">Live Chat</li>
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

      <div class="row">
        <div class="col-md-7">
          <form action="{{ route('settings.livechat.update') }}" method="POST">
            @csrf @method('PUT')

            {{-- ON/OFF Toggle --}}
            <div class="card shadow-sm mb-3">
              <div class="card-header {{ ($setting->livechat_enabled ?? 1) ? 'bg-success' : 'bg-secondary' }} text-white">
                <h3 class="card-title">
                  <i class="fas fa-comment-dots mr-2"></i>
                  Live Chat (Tawk.to) —
                  <strong>{{ ($setting->livechat_enabled ?? 1) ? 'ACTIVE ✅' : 'INACTIVE ❌' }}</strong>
                </h3>
              </div>
              <div class="card-body">
                <div class="d-flex align-items-center" style="gap:16px">
                  <div>
                    <h5 class="mb-1">Tawk.to Live Chat {{ ($setting->livechat_enabled ?? 1) ? 'চালু আছে' : 'বন্ধ আছে' }}</h5>
                    <p class="text-muted mb-0" style="font-size:13px">
                      Inactive করলে website থেকে Tawk.to chat widget সম্পূর্ণ hide হয়ে যাবে।
                    </p>
                  </div>
                  <div style="margin-left:auto">
                    <div class="custom-control custom-switch custom-switch-lg">
                      <input type="checkbox" class="custom-control-input"
                        id="livechatToggle" name="livechat_enabled" value="1"
                        {{ ($setting->livechat_enabled ?? 1) ? 'checked' : '' }}>
                      <label class="custom-control-label" for="livechatToggle"
                        style="cursor:pointer;font-size:15px;font-weight:700">
                        {{ ($setting->livechat_enabled ?? 1) ? 'ON' : 'OFF' }}
                      </label>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            {{-- ── WhatsApp Float Button Toggle ───────────────────── --}}
            <div class="card shadow-sm mb-3">
              <div class="card-header {{ ($setting->whatsapp_float_enabled ?? 1) ? 'bg-success' : 'bg-secondary' }} text-white">
                <h3 class="card-title">
                  <i class="fab fa-whatsapp mr-2"></i>
                  WhatsApp Float Button —
                  <strong>{{ ($setting->whatsapp_float_enabled ?? 1) ? 'ACTIVE ✅' : 'INACTIVE ❌' }}</strong>
                </h3>
              </div>
              <div class="card-body">
                <div class="d-flex align-items-center" style="gap:16px">
                  <div>
                    <h5 class="mb-1">
                      WhatsApp Float Button
                      @if($setting->whatsapp_float_enabled ?? 1)
                        <span class="badge badge-success">চালু আছে</span>
                      @else
                        <span class="badge badge-secondary">বন্ধ আছে</span>
                      @endif
                    </h5>
                    <p class="text-muted mb-0" style="font-size:13px">
                      Website-এর ডান পাশে সবুজ WhatsApp বাটন দেখাবে।
                      Inactive করলে বাটনটি সম্পূর্ণ hide হয়ে যাবে।
                    </p>
                  </div>
                  <div style="margin-left:auto">
                    <div class="custom-control custom-switch custom-switch-lg">
                      <input type="checkbox" class="custom-control-input"
                        id="waToggle" name="whatsapp_float_enabled" value="1"
                        {{ ($setting->whatsapp_float_enabled ?? 1) ? 'checked' : '' }}>
                      <label class="custom-control-label" for="waToggle"
                        style="cursor:pointer;font-size:15px;font-weight:700">
                        {{ ($setting->whatsapp_float_enabled ?? 1) ? 'ON' : 'OFF' }}
                      </label>
                    </div>
                  </div>
                </div>

                {{-- Preview --}}
                <div style="background:#f8f9fb;border-radius:10px;padding:14px;margin-top:12px;display:flex;align-items:center;gap:12px">
                  <div style="width:48px;height:48px;background:#25d366;border-radius:50%;display:flex;align-items:center;justify-content:center;flex-shrink:0;box-shadow:0 4px 12px rgba(37,211,102,.4)">
                    <i class="fab fa-whatsapp" style="color:#fff;font-size:24px"></i>
                  </div>
                  <div style="font-size:13px;color:#555">
                    <strong>Position:</strong> ডান পাশে, tawk.to chat-এর উপরে<br>
                    <strong>Number:</strong> +8801816622128<br>
                    <small class="text-muted">Button-এ click করলে WhatsApp chat খুলবে</small>
                  </div>
                </div>

              </div>
            </div>

            {{-- Tawk.to Settings --}}
            <div class="card shadow-sm mb-3">
              <div class="card-header bg-primary text-white">
                <h3 class="card-title"><i class="fab fa-tiktok mr-2"></i>Tawk.to Configuration</h3>
              </div>
              <div class="card-body">

                <div class="alert alert-info" style="font-size:13px">
                  <i class="fas fa-info-circle"></i>
                  <strong>Tawk.to Property ID ও Widget ID কোথায় পাবেন?</strong><br>
                  tawk.to → Dashboard → Administration → Chat Widget → Direct Chat Link-এ দেখবেন:<br>
                  <code>https://embed.tawk.to/<strong>{Property ID}</strong>/<strong>{Widget ID}</strong></code>
                </div>

                <div class="form-group">
                  <label class="font-weight-bold">Property ID</label>
                  <input type="text" name="tawkto_property_id"
                    value="{{ $setting->tawkto_property_id ?? '67769592af5bfec1dbe5cfa4' }}"
                    class="form-control"
                    style="font-family:monospace"
                    placeholder="যেমন: 67769592af5bfec1dbe5cfa4">
                  <small class="text-muted">tawk.to-তে আপনার Property-র unique ID</small>
                </div>

                <div class="form-group">
                  <label class="font-weight-bold">Widget ID</label>
                  <input type="text" name="tawkto_widget_id"
                    value="{{ $setting->tawkto_widget_id ?? '1j8nukq3o' }}"
                    class="form-control"
                    style="font-family:monospace"
                    placeholder="যেমন: 1j8nukq3o">
                  <small class="text-muted">tawk.to-তে Chat Widget-এর ID</small>
                </div>

                {{-- Live preview --}}
                <div style="background:#f8f9fb;border-radius:10px;padding:14px;margin-top:10px">
                  <label style="font-size:14px;font-weight:700;color:#555">Script Preview:</label>
                  <code style="display:block;font-size:14px;color:#333;word-break:break-all;margin-top:5px">
                    https://embed.tawk.to/<span id="previewProp">{{ $setting->tawkto_property_id ?? '...' }}</span>/<span id="previewWidget">{{ $setting->tawkto_widget_id ?? '...' }}</span>
                  </code>
                </div>
              </div>
            </div>

            <button type="submit" class="btn btn-primary btn-lg px-5">
              <i class="fas fa-save mr-2"></i> Settings Save করুন
            </button>
          </form>
        </div>

        {{-- Info Panel --}}
        <div class="col-md-5">
          <div class="card shadow-sm">
            <div class="card-header bg-dark text-white">
              <h3 class="card-title"><i class="fas fa-question-circle mr-2"></i>Live Chat কী?</h3>
            </div>
            <div class="card-body" style="font-size:13px;line-height:1.8">
              <p><strong>Tawk.to</strong> একটি বিনামূল্যের Live Chat সেবা।</p>
              <ul style="padding-left:18px">
                <li>Customer সরাসরি আপনার সাথে chat করতে পারবে</li>
                <li>Mobile ও Desktop উভয়েই কাজ করে</li>
                <li>আপনি tawk.to app থেকে reply করতে পারবেন</li>
              </ul>
              <hr>
              <div style="background:#e8f5e9;border-radius:8px;padding:10px 12px;margin-bottom:8px">
                <strong style="color:#2e7d32">✅ Active করলে:</strong><br>
                Website-এর ডান নিচে Chat বাটন দেখাবে।
              </div>
              <div style="background:#ffebee;border-radius:8px;padding:10px 12px">
                <strong style="color:#b71c1c">❌ Inactive করলে:</strong><br>
                Chat বাটন সম্পূর্ণ hide হয়ে যাবে।
              </div>
            </div>
          </div>

          {{-- Current status card --}}
          <div class="card shadow-sm mt-3">
            <div class="card-body text-center" style="padding:20px">
              <div style="font-size:48px;margin-bottom:8px">
                {{ ($setting->livechat_enabled ?? 1) ? '💬' : '🔇' }}
              </div>
              <h4 style="font-size:16px;font-weight:800;color:{{ ($setting->livechat_enabled ?? 1) ? '#2e7d32' : '#b71c1c' }}">
                Live Chat {{ ($setting->livechat_enabled ?? 1) ? 'চালু আছে' : 'বন্ধ আছে' }}
              </h4>
              <p style="font-size:14px;color:#888;margin:0">
                {{ ($setting->livechat_enabled ?? 1) ? 'Customers এখন আপনার সাথে chat করতে পারছে' : 'Chat widget website থেকে hidden' }}
              </p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>

@push('scripts')
<script>
document.querySelector('[name="tawkto_property_id"]').addEventListener('input', function() {
  document.getElementById('previewProp').textContent = this.value || '...';
});
document.querySelector('[name="tawkto_widget_id"]').addEventListener('input', function() {
  document.getElementById('previewWidget').textContent = this.value || '...';
});
document.getElementById('livechatToggle').addEventListener('change', function() {
  document.querySelector('.custom-control-label').textContent = this.checked ? 'ON' : 'OFF';
});
</script>
@endpush
@endsection
