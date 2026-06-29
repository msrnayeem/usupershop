@extends('backend.layouts.master')
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        {{-- Page Header --}}
        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:22px;flex-wrap:wrap;gap:12px;">
            <div>
                <h1 style="font-size:22px;font-weight:800;color:#0f172a;margin:0;">
                    <i class="fas fa-bell" style="color:#6366f1;margin-right:8px;"></i>
                    Notification Settings
                </h1>
                <p style="color:#64748b;font-size:13px;margin:2px 0 0;">
                    <a href="{{ route('home') }}" style="color:#6366f1;text-decoration:none;">Home</a>
                    <span style="margin:0 6px;color:#cbd5e1;">/</span>
                    <a href="{{ route('settings.view') }}" style="color:#6366f1;text-decoration:none;">Settings</a>
                    <span style="margin:0 6px;color:#cbd5e1;">/</span>
                    Notifications
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
                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" style="border:none;border-radius:8px;background:#fef2f2;color:#b91c1c;margin-bottom:20px;">
                        <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
                        <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
                    </div>
                @endif

                <form action="{{ route('settings.notification.update') }}" method="POST">
                    @csrf
                    <div class="row">
                        {{-- WhatsApp Admin Notification --}}
                        <div class="col-md-6 mb-4">
                            <div class="card h-100">
                                <div class="card-header d-flex align-items-center" style="background:#f0fdf4;">
                                    <span class="card-title font-weight-bold" style="color:#16a34a;">
                                        <i class="fab fa-whatsapp mr-2" style="font-size:20px;"></i>
                                        WhatsApp Admin Notification
                                    </span>
                                </div>
                                <div class="card-body">
                                    {{-- Setup Info --}}
                                    <div class="callout callout-info mb-4" style="border-left-color:#6366f1;background:#f8fafc;padding:15px;border-radius:8px;">
                                        <h6 class="font-weight-bold mb-2" style="color:#0f172a;"><i class="fas fa-info-circle mr-1" style="color:#6366f1;"></i> WhatsApp Connection setup</h6>
                                        <p style="font-size:13px;color:#475569;margin-bottom:8px;"><strong>Step 1:</strong> Send message from WhatsApp to recipient bot number:</p>
                                        <div style="font-family:monospace;font-size:15px;font-weight:700;color:#0f172a;background:#e2e8f0;padding:6px 12px;border-radius:6px;display:inline-block;margin-bottom:10px;">
                                            +34 644 65 21 68
                                        </div>
                                        <p style="font-size:13px;color:#475569;margin-bottom:8px;"><strong>Step 2:</strong> Type and send the activation text:</p>
                                        <div style="font-family:monospace;font-size:13px;color:#475569;background:#e2e8f0;padding:6px 12px;border-radius:6px;display:inline-block;margin-bottom:10px;">
                                            I allow callmebot to send me messages
                                        </div>
                                        <p style="font-size:13px;color:#475569;margin-bottom:0;"><strong>Step 3:</strong> Save the returned API key in inputs below.</p>
                                    </div>

                                    {{-- WhatsApp Number --}}
                                    <div class="form-group">
                                        <label for="admin_whatsapp_number" style="font-weight:600;color:#334155;font-size:13px;">Admin WhatsApp Number</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" style="background:#22c55e;color:#fff;border:none;"><i class="fab fa-whatsapp"></i></span>
                                            </div>
                                            <input type="text" name="admin_whatsapp_number" class="form-control" value="{{ $setting->admin_whatsapp_number ?? '8801816622128' }}" placeholder="e.g. 8801816622128" required style="border-top-right-radius:6px;border-bottom-right-radius:6px;">
                                        </div>
                                        <small class="text-muted mt-1 d-block">Must include country code (e.g. 8801XXXXXXXXX)</small>
                                    </div>

                                    {{-- CallMeBot API Key --}}
                                    <div class="form-group">
                                        <label for="callmebot_key" style="font-weight:600;color:#334155;font-size:13px;">CallMeBot API Key</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" style="background:#e2e8f0;"><i class="fas fa-key"></i></span>
                                            </div>
                                            <input type="password" name="callmebot_api_key" class="form-control" id="callmebot_key" value="{{ $setting->callmebot_api_key ?? '' }}" placeholder="Enter Bot API Key" required>
                                            <div class="input-group-append">
                                                <button type="button" class="btn btn-outline-secondary" onclick="toggleKey()" style="border-top-right-radius:6px;border-bottom-right-radius:6px;">
                                                    <i class="fas fa-eye" id="eyeIcon"></i>
                                                </button>
                                            </div>
                                        </div>
                                        @if(empty($setting->callmebot_api_key))
                                            <small class="text-danger mt-1 d-block"><i class="fas fa-exclamation-triangle mr-1"></i> API Key not configured. Notifications disabled.</small>
                                        @else
                                            <small class="text-success mt-1 d-block"><i class="fas fa-check-circle mr-1"></i> API Key configured.</small>
                                        @endif
                                    </div>

                                    {{-- WhatsApp Toggles --}}
                                    <div class="form-group mb-4">
                                        <label style="font-weight:600;color:#334155;font-size:13px;">WhatsApp Notifications Activity</label>
                                        <div style="background:#f8fafc;border-radius:8px;padding:15px;border:1px solid #e2e8f0;">
                                            <div class="custom-control custom-switch mb-3">
                                                <input type="checkbox" class="custom-control-input" id="wa_order" name="whatsapp_notify_order" value="1" {{ ($setting->whatsapp_notify_order ?? 1) ? 'checked' : '' }}>
                                                <label class="custom-control-label" for="wa_order" style="cursor:pointer;font-size:13px;color:#334155;">🛒 Notify Admin on New Orders</label>
                                            </div>
                                            <div class="custom-control custom-switch mb-0">
                                                <input type="checkbox" class="custom-control-input" id="wa_member" name="whatsapp_notify_member" value="1" {{ ($setting->whatsapp_notify_member ?? 1) ? 'checked' : '' }}>
                                                <label class="custom-control-label" for="wa_member" style="cursor:pointer;font-size:13px;color:#334155;">🎉 Notify Admin on Seller/Vendor Registrations</label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group mb-0">
                                        <a href="{{ route('whatsapp.test') }}" class="btn btn-sm btn-success" target="_blank" style="background:#22c55e;border:none;border-radius:6px;font-weight:600;padding:6px 16px;">
                                            <i class="fab fa-whatsapp mr-1"></i> Send Test Message
                                        </a>
                                        <small class="text-muted ml-2">Click after saving settings changes</small>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- MimSMS Settings --}}
                        <div class="col-md-6 mb-4">
                            <div class="card h-100">
                                <div class="card-header d-flex align-items-center" style="background:#eff6ff;">
                                    <span class="card-title font-weight-bold" style="color:#2563eb;">
                                        <i class="fas fa-sms mr-2" style="font-size:20px;"></i>
                                        MimSMS Customer Alerts Settings
                                    </span>
                                </div>
                                <div class="card-body">
                                    <div class="callout callout-success mb-4" style="border-left-color:#22c55e;background:#f8fafc;padding:15px;border-radius:8px;">
                                        <h6 class="font-weight-bold mb-2" style="color:#0f172a;"><i class="fas fa-shield-alt mr-1" style="color:#22c55e;"></i> API Credentials Config</h6>
                                        <p style="font-size:13px;color:#475569;margin-bottom:8px;">Configure the gateway username and keys inside SMS configuration portal first.</p>
                                        <a href="{{ route('smsgateways.view') }}" class="btn btn-xs btn-primary" style="background:#6366f1;border:none;border-radius:6px;font-weight:600;padding:6px 12px;">
                                            <i class="fas fa-cog mr-1"></i> SMS Gateway Configurations
                                        </a>
                                    </div>

                                    {{-- SMS Toggle --}}
                                    <div class="form-group mb-4">
                                        <label style="font-weight:600;color:#334155;font-size:13px;">Customer SMS Status</label>
                                        <div style="background:#f8fafc;border-radius:8px;padding:15px;border:1px solid #e2e8f0;">
                                            <div class="custom-control custom-switch">
                                                <input type="checkbox" class="custom-control-input" id="sms_enabled" name="sms_notify_enabled" value="1" {{ ($setting->sms_notify_enabled ?? 1) ? 'checked' : '' }}>
                                                <label class="custom-control-label font-weight-bold" for="sms_enabled" style="cursor:pointer;font-size:13px;color:#334155;">📱 Enable SMS dispatch for Customers</label>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Info Events Table --}}
                                    <div class="form-group mb-0">
                                        <label style="font-weight:600;color:#334155;font-size:13px;">SMS Dispatch Trigger Events</label>
                                        <div class="table-responsive">
                                            <table class="table table-sm table-bordered" style="font-size:12px;color:#475569;">
                                                <thead class="bg-light">
                                                    <tr>
                                                        <th>Trigger Event</th>
                                                        <th>Message Contents dispatched</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td><span class="badge badge-success" style="padding:4px 8px;border-radius:4px;">Order Confirmed</span></td>
                                                        <td>Invoice link, amount breakdown & payment type</td>
                                                    </tr>
                                                    <tr>
                                                        <td><span class="badge badge-info" style="padding:4px 8px;border-radius:4px;">Processing</span></td>
                                                        <td>Warehouse packaging details</td>
                                                    </tr>
                                                    <tr>
                                                        <td><span class="badge badge-primary" style="padding:4px 8px;border-radius:4px;">Shipped</span></td>
                                                        <td>Courier transit detail updates with tracking info</td>
                                                    </tr>
                                                    <tr>
                                                        <td><span class="badge badge-success" style="padding:4px 8px;border-radius:4px;">Delivered</span></td>
                                                        <td>Order cash-on-delivery settlement alerts</td>
                                                    </tr>
                                                    <tr>
                                                        <td><span class="badge badge-danger" style="padding:4px 8px;border-radius:4px;">Cancelled</span></td>
                                                        <td>System cancellation notices</td>
                                                    </tr>
                                                    <tr>
                                                        <td><span class="badge badge-secondary" style="padding:4px 8px;border-radius:4px;">Member Welcome</span></td>
                                                        <td>Account password setups & validation notifications</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Save Settings Card --}}
                        <div class="col-md-12">
                            <div class="card mb-4">
                                <div class="card-body d-flex align-items-center justify-content-between flex-wrap gap-3" style="padding:20px;">
                                    <div>
                                        <h6 class="font-weight-bold mb-1" style="color:#0f172a;"><i class="fas fa-save mr-1" style="color:#6366f1;"></i> Apply Notification Updates</h6>
                                        <p class="text-muted mb-0" style="font-size:12px;">Changes are propagated instantly across triggers upon saving.</p>
                                    </div>
                                    <button type="submit" class="btn btn-primary" style="background:#6366f1;border:none;padding:12px 35px;border-radius:8px;font-weight:600;box-shadow:0 4px 6px -1px rgba(99,102,241,0.2);">
                                        <i class="fas fa-save mr-2"></i> Save Notification Settings
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </section>
    </div>
@endsection

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
        document.getElementById('callmebot_key').type = 'text';
    </script>
@endpush
