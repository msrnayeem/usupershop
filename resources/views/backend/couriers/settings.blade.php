@extends('backend.layouts.master')
@section('content')
<div class="content-wrapper">
    {{-- Page Header --}}
    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:22px;flex-wrap:wrap;gap:12px;">
        <div>
            <h1 style="font-size:22px;font-weight:800;color:#0f172a;margin:0;">
                <i class="fas fa-truck" style="color:#6366f1;margin-right:8px;"></i>
                Courier API Settings
            </h1>
            <p style="color:#64748b;font-size:13px;margin:2px 0 0;">
                <a href="{{ route('home') }}" style="color:#6366f1;text-decoration:none;">Home</a>
                <span style="margin:0 6px;color:#cbd5e1;">/</span>
                Couriers Config
            </p>
        </div>
        <a class="btn btn-sm btn-primary" href="{{ route('couriers.index') }}" style="display:inline-flex;align-items:center;gap:6px;padding:9px 18px;background:#6366f1;border:none;border-radius:8px;font-size:13px;font-weight:600;color:#fff;text-decoration:none;">
            <i class="fas fa-list"></i> Courier Services List
        </a>
    </div>

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
                    <i class="fas fa-times-circle"></i> {{ session('error') }}
                    <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
                </div>
            @endif

            @php
                $steadfast = $couriers->where('name', 'Steadfast')->first();
                $pathao    = $couriers->where('name', 'Pathao')->first();
            @endphp

            <div class="row">
                {{-- Steadfast --}}
                <div class="col-md-6 mb-4">
                    <div class="card h-100">
                        <div class="card-header d-flex align-items-center justify-content-between" style="background:#fff1f2;border-bottom:1px solid #ffe4e6;">
                            <span class="card-title font-weight-bold text-danger mb-0" style="font-size:16px;">
                                🚚 Steadfast Courier API
                            </span>
                            <span class="badge {{ $steadfast?->is_active ? 'badge-success' : 'badge-secondary' }}" style="padding:6px 12px;border-radius:6px;font-weight:700;">
                                {{ $steadfast?->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </div>
                        <form action="{{ route('couriers.update', $steadfast?->id ?? 0) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="card-body">
                                <div class="alert alert-light border-0 mb-4" style="font-size:12px;background:#f8fafc;color:#475569;border-radius:8px;line-height:1.6;padding:12px;">
                                    <strong>📋 API Portal Configuration:</strong> Log in to <a href="https://portal.packzy.com" target="_blank" style="color:#6366f1;font-weight:700;">portal.packzy.com</a> → Settings → API Integration. Copy keys below.
                                </div>

                                <div class="form-group">
                                    <label class="font-weight-bold" style="font-size:13px;color:#334155;">API Key <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <input type="text" name="api_key" class="form-control" id="sfApiKey" value="{{ old('api_key', $steadfast?->api_key) }}" placeholder="Steadfast API Key" style="font-family:monospace;font-size:13px;" required>
                                        <div class="input-group-append">
                                            <button type="button" class="btn btn-outline-secondary" onclick="toggleVisible('sfApiKey')" style="border-top-right-radius:6px;border-bottom-right-radius:6px;"><i class="fas fa-eye"></i></button>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="font-weight-bold" style="font-size:13px;color:#334155;">Secret Key <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <input type="password" name="secret_key" class="form-control" id="sfSecretKey" value="{{ old('secret_key', $steadfast?->secret_key) }}" placeholder="Steadfast Secret Key" style="font-family:monospace;font-size:13px;" required>
                                        <div class="input-group-append">
                                            <button type="button" class="btn btn-outline-secondary" onclick="toggleVisible('sfSecretKey')" style="border-top-right-radius:6px;border-bottom-right-radius:6px;"><i class="fas fa-eye"></i></button>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="font-weight-bold" style="font-size:13px;color:#334155;">API Base URL</label>
                                    <input type="text" name="base_url" class="form-control" value="{{ old('base_url', $steadfast?->base_url ?? 'https://portal.packzy.com/api/v1') }}" style="font-family:monospace;font-size:13px;" required>
                                    <small class="text-muted mt-1 d-block">Default production API URL</small>
                                </div>

                                <div class="custom-control custom-switch mt-4 mb-2">
                                    <input type="checkbox" class="custom-control-input" name="is_active" id="sfActive" value="1" {{ $steadfast?->is_active ? 'checked' : '' }} style="cursor:pointer;">
                                    <label class="custom-control-label font-weight-bold" for="sfActive" style="cursor:pointer;color:#334155;font-size:13px;">Enable Steadfast Courier Integration</label>
                                </div>
                            </div>
                            <div class="card-footer d-flex align-items-center justify-content-between" style="background:#f8fafc;border-top:1px solid #e2e8f0;padding:15px 20px;">
                                <button type="submit" class="btn btn-primary" style="background:#e11d48;border:none;font-weight:600;padding:8px 20px;border-radius:6px;"><i class="fas fa-save mr-2"></i>Save Config</button>
                                <button type="button" class="btn btn-outline-secondary" style="border-radius:6px;font-weight:600;padding:7px 15px;" onclick="testCourier('steadfast')">
                                    <i class="fas fa-plug mr-1"></i>Test Integration
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                {{-- Pathao --}}
                <div class="col-md-6 mb-4">
                    <div class="card h-100">
                        <div class="card-header d-flex align-items-center justify-content-between" style="background:#fef2f2;border-bottom:1px solid #fee2e2;">
                            <span class="card-title font-weight-bold text-danger mb-0" style="font-size:16px;color:#b91c1c;">
                                🔴 Pathao Courier API
                            </span>
                            <span class="badge {{ $pathao?->is_active ? 'badge-success' : 'badge-secondary' }}" style="padding:6px 12px;border-radius:6px;font-weight:700;">
                                {{ $pathao?->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </div>
                        <form action="{{ route('couriers.update', $pathao?->id ?? 0) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="card-body">
                                <div class="alert alert-light border-0 mb-4" style="font-size:12px;background:#f8fafc;color:#475569;border-radius:8px;line-height:1.6;padding:12px;">
                                    <strong>📋 API Portal Configuration:</strong> Log in to <a href="https://courier.pathao.com" target="_blank" style="color:#6366f1;font-weight:700;">courier.pathao.com</a> → Developer API settings. Generate Client keys.
                                </div>

                                <div class="form-row">
                                    <div class="col-md-6 form-group">
                                        <label class="font-weight-bold" style="font-size:13px;color:#334155;">Client ID <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <input type="text" name="client_id" class="form-control" id="ptClientId" value="{{ old('client_id', $pathao?->client_id) }}" placeholder="Client ID" style="font-family:monospace;font-size:13px;" required>
                                            <div class="input-group-append">
                                                <button type="button" class="btn btn-outline-secondary" onclick="toggleVisible('ptClientId')" style="border-top-right-radius:6px;border-bottom-right-radius:6px;"><i class="fas fa-eye"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label class="font-weight-bold" style="font-size:13px;color:#334155;">Client Secret <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <input type="password" name="client_secret" class="form-control" id="ptSecret" value="{{ old('client_secret', $pathao?->client_secret) }}" placeholder="Client Secret" style="font-family:monospace;font-size:13px;" required>
                                            <div class="input-group-append">
                                                <button type="button" class="btn btn-outline-secondary" onclick="toggleVisible('ptSecret')" style="border-top-right-radius:6px;border-bottom-right-radius:6px;"><i class="fas fa-eye"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="col-md-6 form-group">
                                        <label class="font-weight-bold" style="font-size:13px;color:#334155;">Portal Account Email <span class="text-danger">*</span></label>
                                        <input type="email" name="username" class="form-control" value="{{ old('username', $pathao?->username) }}" placeholder="login@email.com" required>
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label class="font-weight-bold" style="font-size:13px;color:#334155;">Portal Password <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <input type="password" name="password" class="form-control" id="ptPw" value="{{ old('password', $pathao?->password) }}" placeholder="Password" required>
                                            <div class="input-group-append">
                                                <button type="button" class="btn btn-outline-secondary" onclick="toggleVisible('ptPw')" style="border-top-right-radius:6px;border-bottom-right-radius:6px;"><i class="fas fa-eye"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="font-weight-bold" style="font-size:13px;color:#334155;">Store ID <span class="badge badge-light ml-1" style="font-weight:600;border:1px solid #cbd5e1;">Optional</span></label>
                                    <input type="text" name="store_id" class="form-control" value="{{ old('store_id', $pathao?->store_id) }}" placeholder="Leave blank to auto fetch" style="font-family:monospace;font-size:13px;">
                                </div>

                                <div class="form-row">
                                    <div class="col-md-8 form-group">
                                        <label class="font-weight-bold" style="font-size:13px;color:#334155;">API Base URL</label>
                                        <input type="text" name="base_url" class="form-control" value="{{ old('base_url', $pathao?->base_url ?? 'https://courier-api.pathao.com') }}" style="font-family:monospace;font-size:13px;" required>
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label class="font-weight-bold" style="font-size:13px;color:#334155;">API Server Mode</label>
                                        <select name="is_sandbox" class="form-control select2" onchange="updatePathaoUrl(this.value)">
                                            <option value="0" {{ ($pathao?->is_sandbox ?? 0) == 0 ? 'selected' : '' }}>Production</option>
                                            <option value="1" {{ ($pathao?->is_sandbox ?? 0) == 1 ? 'selected' : '' }}>Sandbox</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="custom-control custom-switch mt-3 mb-2">
                                    <input type="checkbox" class="custom-control-input" name="is_active" id="ptActive" value="1" {{ $pathao?->is_active ? 'checked' : '' }} style="cursor:pointer;">
                                    <label class="custom-control-label font-weight-bold" for="ptActive" style="cursor:pointer;color:#334155;font-size:13px;">Enable Pathao Courier Integration</label>
                                </div>
                            </div>
                            <div class="card-footer d-flex align-items-center justify-content-between" style="background:#f8fafc;border-top:1px solid #e2e8f0;padding:15px 20px;">
                                <button type="submit" class="btn btn-primary" style="background:#dc2626;border:none;font-weight:600;padding:8px 20px;border-radius:6px;"><i class="fas fa-save mr-2"></i>Save Config</button>
                                <button type="button" class="btn btn-outline-secondary" style="border-radius:6px;font-weight:600;padding:7px 15px;" onclick="testCourier('pathao')">
                                    <i class="fas fa-plug mr-1"></i>Test Integration
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            {{-- Connection Test Modal/Alert container --}}
            <div id="testResult" style="display:none;margin-top:10px;margin-bottom:20px;border:none;border-radius:8px;" class="alert alert-info alert-dismissible fade show">
                <button type="button" class="close" onclick="document.getElementById('testResult').style.display='none'"><span>&times;</span></button>
                <span id="testMsg" style="font-weight:600;"></span>
            </div>

            {{-- Workflow Information --}}
            <div class="card mb-4">
                <div class="card-header bg-dark">
                    <span class="card-title font-weight-bold text-white"><i class="fas fa-info-circle mr-2"></i>Order Fulfilment Integration Guide</span>
                </div>
                <div class="card-body" style="font-size:13px;line-height:1.7;color:#475569;">
                    <div class="row">
                        <div class="col-md-6 mb-3 mb-md-0">
                            <h6 class="font-weight-bold text-dark mb-2">🚚 Automated Consignment Booking:</h6>
                            <ol style="padding-left:18px;margin-bottom:0;">
                                <li>Navigate to Orders section and open a pending invoice.</li>
                                <li>Click on the <strong>Send to Courier</strong> options.</li>
                                <li>Select the active carrier (Steadfast/Pathao) and input packaging dimensions.</li>
                                <li>The API will return a tracking consignment ID instantly and sync status.</li>
                            </ol>
                        </div>
                        <div class="col-md-6">
                            <h6 class="font-weight-bold text-dark mb-2">🔑 Key Settings:</h6>
                            <p class="mb-2"><strong>Steadfast API:</strong> Key and Secrets are generated on API Integration tab inside Packzy Portal.</p>
                            <p class="mb-0"><strong>Pathao API:</strong> Generate Client ID and Client Secret keys on Pathao developer API panel dashboard.</p>
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
    $(document).ready(function() {
        $('.select2').select2({
            theme: 'bootstrap4'
        });
    });

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
            el.className = 'alert alert-dismissible fade show ' + (data.success ? 'alert-success' : 'alert-danger');
            el.style.borderRadius = '8px';
            el.style.border = 'none';
            msg.innerHTML = (data.success ? '<i class="fas fa-check-circle mr-1"></i>' : '<i class="fas fa-exclamation-circle mr-1"></i>') + data.message;
            btn.disabled = false;
            btn.innerHTML = '<i class="fas fa-plug mr-1"></i>Test Integration';
        })
        .catch(() => {
            var el = document.getElementById('testResult');
            var msg = document.getElementById('testMsg');
            el.style.display = 'block';
            el.className = 'alert alert-danger alert-dismissible fade show';
            el.style.borderRadius = '8px';
            el.style.border = 'none';
            msg.innerHTML = '<i class="fas fa-exclamation-circle mr-1"></i> Connection error. Try again.';
            btn.disabled = false;
            btn.innerHTML = '<i class="fas fa-plug mr-1"></i>Test Integration';
        });
    }
</script>
@endpush
