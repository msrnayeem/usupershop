@extends('backend.layouts.master')
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        {{-- Page Header --}}
        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:22px;flex-wrap:wrap;gap:12px;">
            <div>
                <h1 style="font-size:22px;font-weight:800;color:#0f172a;margin:0;">
                    <i class="fas fa-comments" style="color:#6366f1;margin-right:8px;"></i>
                    Live Chat Settings
                </h1>
                <p style="color:#64748b;font-size:13px;margin:2px 0 0;">
                    <a href="{{ route('home') }}" style="color:#6366f1;text-decoration:none;">Home</a>
                    <span style="margin:0 6px;color:#cbd5e1;">/</span>
                    Live Chat Configurations
                </p>
            </div>
        </div>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" style="border:none;border-radius:8px;background:#f0fdf4;color:#15803d;margin-bottom:20px;">
                        <i class="fas fa-check-circle"></i> {{ session('success') }}
                        <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
                    </div>
                @endif

                <div class="row">
                    {{-- Form Configuration Column --}}
                    <div class="col-md-7">
                        <form action="{{ route('settings.livechat.update') }}" method="POST">
                            @csrf
                            @method('PUT')

                            {{-- Tawk.to ON/OFF Switch --}}
                            <div class="card mb-4">
                                <div class="card-header d-flex align-items-center justify-content-between {{ ($setting->livechat_enabled ?? 1) ? 'bg-light' : 'bg-light' }}" style="border-bottom:1px solid #e2e8f0;">
                                    <span class="card-title font-weight-bold text-dark mb-0">
                                        <i class="fas fa-comment-dots mr-2" style="color:#6366f1;"></i>
                                        Tawk.to Chat Widget Status
                                    </span>
                                    <span class="badge {{ ($setting->livechat_enabled ?? 1) ? 'badge-success' : 'badge-secondary' }}" style="padding:6px 12px;border-radius:6px;font-weight:700;">
                                        {{ ($setting->livechat_enabled ?? 1) ? 'Active' : 'Disabled' }}
                                    </span>
                                </div>
                                <div class="card-body">
                                    <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
                                        <div>
                                            <h6 class="font-weight-bold mb-1" style="color:#0f172a;">Live Customer Chat Support</h6>
                                            <p class="text-muted mb-0" style="font-size:12px;">When disabled, the chat popover disappears from customer storefront pages.</p>
                                        </div>
                                        <div class="custom-control custom-switch custom-switch-lg">
                                            <input type="checkbox" class="custom-control-input" id="livechatToggle" name="livechat_enabled" value="1" {{ ($setting->livechat_enabled ?? 1) ? 'checked' : '' }} style="cursor:pointer;">
                                            <label class="custom-control-label font-weight-bold" for="livechatToggle" style="cursor:pointer;font-size:14px;color:#0f172a;">{{ ($setting->livechat_enabled ?? 1) ? 'ON' : 'OFF' }}</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- WhatsApp Floating Status Switch --}}
                            <div class="card mb-4">
                                <div class="card-header d-flex align-items-center justify-content-between" style="border-bottom:1px solid #e2e8f0;">
                                    <span class="card-title font-weight-bold text-dark mb-0">
                                        <i class="fab fa-whatsapp mr-2" style="color:#22c55e;font-size:18px;"></i>
                                        WhatsApp Float Icon Button
                                    </span>
                                    <span class="badge {{ ($setting->whatsapp_float_enabled ?? 1) ? 'badge-success' : 'badge-secondary' }}" style="padding:6px 12px;border-radius:6px;font-weight:700;{{ ($setting->whatsapp_float_enabled ?? 1) ? 'background:#22c55e;' : '' }}">
                                        {{ ($setting->whatsapp_float_enabled ?? 1) ? 'Active' : 'Disabled' }}
                                    </span>
                                </div>
                                <div class="card-body">
                                    <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
                                        <div>
                                            <h6 class="font-weight-bold mb-1" style="color:#0f172a;">Floating WhatsApp Helpdesk Option</h6>
                                            <p class="text-muted mb-0" style="font-size:12px;">Draws a floating helpdesk quick link trigger at bottom right corner.</p>
                                        </div>
                                        <div class="custom-control custom-switch custom-switch-lg">
                                            <input type="checkbox" class="custom-control-input" id="waToggle" name="whatsapp_float_enabled" value="1" {{ ($setting->whatsapp_float_enabled ?? 1) ? 'checked' : '' }} style="cursor:pointer;">
                                            <label class="custom-control-label font-weight-bold" for="waToggle" style="cursor:pointer;font-size:14px;color:#0f172a;">{{ ($setting->whatsapp_float_enabled ?? 1) ? 'ON' : 'OFF' }}</label>
                                        </div>
                                    </div>

                                    {{-- WhatsApp Details Preview --}}
                                    <div style="background:#f8fafc;border-radius:10px;padding:15px;margin-top:15px;display:flex;align-items:center;gap:12px;border:1px solid #e2e8f0;">
                                        <div style="width:44px;height:44px;background:#22c55e;border-radius:50%;display:flex;align-items:center;justify-content:center;box-shadow:0 4px 10px rgba(34,197,94,0.3);flex-shrink:0;">
                                            <i class="fab fa-whatsapp" style="color:#fff;font-size:22px;"></i>
                                        </div>
                                        <div style="font-size:13px;color:#475569;">
                                            <strong>Float alignment:</strong> Bottom Right relative corner spacing.<br>
                                            <strong>Target Call Number:</strong> +8801816622128 (configured on settings).
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Tawk.to Credential Config --}}
                            <div class="card mb-4">
                                <div class="card-header">
                                    <span class="card-title">
                                        <i class="fas fa-key" style="color:#6366f1;margin-right:6px;"></i>
                                        Tawk.to API Embed Configurations
                                    </span>
                                </div>
                                <div class="card-body">
                                    <div class="alert alert-info border-0" style="font-size:13px;background:#f0f9ff;color:#0369a1;border-radius:8px;padding:15px;line-height:1.6;margin-bottom:20px;">
                                        <i class="fas fa-info-circle mr-1"></i>
                                        <strong>Finding your Widget Embed ID:</strong><br>
                                        Navigate inside Tawk.to portal → Settings → Administration → Chat Widget. Copy keys from the Direct Chat embed URL snippet:<br>
                                        <code>https://embed.tawk.to/<strong>{Property ID}</strong>/<strong>{Widget ID}</strong></code>
                                    </div>

                                    <div class="form-group">
                                        <label for="tawkto_property_id" style="font-weight:600;color:#334155;font-size:13px;">Tawk.to Property ID</label>
                                        <input type="text" name="tawkto_property_id" id="tawkto_property_id" value="{{ $setting->tawkto_property_id ?? '67769592af5bfec1dbe5cfa4' }}" class="form-control" style="font-family:monospace;font-size:14px;" placeholder="e.g. 67769592af5bfec1dbe5cfa4" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="tawkto_widget_id" style="font-weight:600;color:#334155;font-size:13px;">Tawk.to Widget ID</label>
                                        <input type="text" name="tawkto_widget_id" id="tawkto_widget_id" value="{{ $setting->tawkto_widget_id ?? '1j8nukq3o' }}" class="form-control" style="font-family:monospace;font-size:14px;" placeholder="e.g. 1j8nukq3o" required>
                                    </div>

                                    {{-- Embed URL Code preview --}}
                                    <div style="background:#f8fafc;border-radius:10px;padding:15px;margin-top:15px;border:1px solid #e2e8f0;font-size:13px;color:#475569;">
                                        <strong>Embed Endpoint Route Preview:</strong>
                                        <code style="display:block;margin-top:6px;word-break:break-all;color:#4f46e5;font-size:13px;">
                                            https://embed.tawk.to/<span id="previewProp">{{ $setting->tawkto_property_id ?? '...' }}</span>/<span id="previewWidget">{{ $setting->tawkto_widget_id ?? '...' }}</span>
                                        </code>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group" style="margin-bottom:40px;">
                                <button type="submit" class="btn btn-primary" style="background:#6366f1;border:none;padding:12px 30px;border-radius:8px;font-weight:600;box-shadow: 0 4px 6px -1px rgba(99,102,241,0.2);">
                                    <i class="fas fa-save mr-2"></i> Save Live Chat Configurations
                                </button>
                            </div>
                        </form>
                    </div>

                    {{-- Information Column --}}
                    <div class="col-md-5">
                        <div class="card mb-4">
                            <div class="card-header bg-dark">
                                <span class="card-title font-weight-bold text-white"><i class="fas fa-question-circle mr-1"></i> Live Chat Mechanism</span>
                            </div>
                            <div class="card-body" style="font-size:13px;line-height:1.7;color:#475569;">
                                <p><strong>Tawk.to Widget Integration</strong> provides direct online helper channels at no extra licensing cost. Active support helps conversion rates by answering client inquiries on pre-sales instantly.</p>
                                <ul style="padding-left:18px;margin-bottom:0;line-height:1.8;">
                                    <li>Track user interactions on web sessions.</li>
                                    <li>Provide direct chat triggers inside android apps.</li>
                                    <li>Auto trigger welcoming message templates.</li>
                                </ul>
                            </div>
                        </div>

                        <div class="card text-center mb-4">
                            <div class="card-body" style="padding:24px;">
                                <div style="font-size:44px;margin-bottom:10px;">
                                    {{ ($setting->livechat_enabled ?? 1) ? '💬' : '🔇' }}
                                </div>
                                <h6 class="font-weight-bold mb-1" style="color:{{ ($setting->livechat_enabled ?? 1) ? '#16a34a' : '#64748b' }};">
                                    Widget status: {{ ($setting->livechat_enabled ?? 1) ? 'ONLINE' : 'OFFLINE' }}
                                </h6>
                                <p class="text-muted mb-0" style="font-size:12px;">
                                    {{ ($setting->livechat_enabled ?? 1) ? 'Chat triggers are active and loaded for users.' : 'Chat is hidden across all page layouts.' }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('scripts')
    <script>
        document.getElementById('tawkto_property_id').addEventListener('input', function() {
            document.getElementById('previewProp').textContent = this.value || '...';
        });
        document.getElementById('tawkto_widget_id').addEventListener('input', function() {
            document.getElementById('previewWidget').textContent = this.value || '...';
        });
        document.getElementById('livechatToggle').addEventListener('change', function() {
            document.querySelector("label[for='livechatToggle']").textContent = this.checked ? 'ON' : 'OFF';
        });
        document.getElementById('waToggle').addEventListener('change', function() {
            document.querySelector("label[for='waToggle']").textContent = this.checked ? 'ON' : 'OFF';
        });
    </script>
@endpush
