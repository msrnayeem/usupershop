@extends('backend.layouts.master')
@section('content')
    <div class="content-wrapper">
        {{-- Page Header --}}
        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:22px;flex-wrap:wrap;gap:12px;">
            <div>
                <h1 style="font-size:22px;font-weight:800;color:#0f172a;margin:0;">
                    <i class="fas fa-sms" style="color:#6366f1;margin-right:8px;"></i>
                    Manage SMS Gateway
                </h1>
                <p style="color:#64748b;font-size:13px;margin:2px 0 0;">
                    <a href="{{ route('home') }}" style="color:#6366f1;text-decoration:none;">Home</a>
                    <span style="margin:0 6px;color:#cbd5e1;">/</span>
                    SMS Gateways
                </p>
            </div>
            @if ($countsms < 1)
                <a class="btn btn-sm btn-primary" href="{{ route('smsgateways.add') }}" style="display:inline-flex;align-items:center;gap:6px;padding:9px 18px;background:#6366f1;border:none;border-radius:8px;font-size:13px;font-weight:600;color:#fff;text-decoration:none;">
                    <i class="fas fa-plus-circle"></i> Add SMS Gateway
                </a>
            @endif
        </div>

        <section class="content">
            <div class="container-fluid">
                @if (Session::get('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert" style="border:none;border-radius:8px;background:#f0fdf4;color:#15803d;margin-bottom:20px;">
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                        <strong>{{ Session::get('success') }}</strong>
                    </div>
                @endif
                @if (Session::get('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert" style="border:none;border-radius:8px;background:#fef2f2;color:#b91c1c;margin-bottom:20px;">
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                        <strong>{{ Session::get('error') }}</strong>
                    </div>
                @endif

                {{-- Test Gateway Form --}}
                <div class="card mb-4">
                    <div class="card-header">
                        <span class="card-title">
                            <i class="fas fa-paper-plane" style="color:#6366f1;margin-right:6px;"></i>
                            Test Active SMS Gateway
                        </span>
                    </div>
                    <div class="card-body">
                        <form method="post" action="{{ route('smsgateways.test') }}">
                            @csrf
                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label for="mobile" style="font-weight:600;color:#334155;font-size:13px;">Recipient Mobile <span class="text-danger">*</span></label>
                                    <input type="text" name="mobile" id="mobile" class="form-control" placeholder="e.g. 01712345678" value="{{ old('mobile') }}" required>
                                    @error('mobile')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                    <small class="text-muted mt-1 d-block">Expected: 11 digit mobile number</small>
                                    <div id="mobile-preview" class="mt-2 p-2 rounded" style="font-size:0.8rem;display:none;background:#f8fafc;border:1px solid #e2e8f0;">
                                        <strong>Transformed Preview:</strong> <span id="preview-normalized"></span>
                                    </div>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="message" style="font-weight:600;color:#334155;font-size:13px;">Test Message Body</label>
                                    <input type="text" name="message" id="message" class="form-control" value="{{ old('message', 'U SuperShop SMS testing channel response') }}" required>
                                    @error('message')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="form-group col-md-2 d-flex align-items-end">
                                    <button type="submit" class="btn btn-primary btn-block" style="background:#6366f1;border:none;height:calc(1.5em + .75rem + 2px);font-weight:600;border-radius:6px;display:flex;align-items:center;justify-content:center;gap:6px;">
                                        <i class="fas fa-paper-plane"></i> Send Test
                                    </button>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-md-12">
                                    <div class="alert alert-info py-2" style="font-size: 0.85rem; margin-bottom: 0; background:#f0f9ff; color:#0369a1; border:none; border-radius:8px; line-height:1.6;">
                                        <i class="fas fa-info-circle"></i> <strong>Accepted formats:</strong> <code>017XXXXXXXX</code>, <code>8801XXXXXXXX</code>, <code>+8801XXXXXXXX</code>. The gateway will normalize numbers to country code 88 prefix automatically.
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                {{-- SMS Test Debug Box --}}
                @if (Session::get('sms_test_response'))
                    @php
                        $smsTestResponse = Session::get('sms_test_response');
                        $smsTestIsSuccess = isset($smsTestResponse['status']) && strtolower((string) $smsTestResponse['status']) === 'success';
                        $debugData = Session::get('sms_test_debug') ?? [];
                        $inputMobile = Session::get('sms_test_input_mobile') ?? '';
                        $lengthCheck = $debugData['mobile_length_check'] ?? [];
                        $prefixCheck = $debugData['mobile_prefix_check'] ?? [];
                    @endphp

                    <div class="card mb-4" style="border-left: 4px solid {{ $smsTestIsSuccess ? '#22c55e' : '#ef4444' }};">
                        <div class="card-header bg-dark text-white d-flex align-items-center justify-content-between">
                            <span class="font-weight-bold"><i class="fas fa-bug mr-2"></i>Gateway Debugger logs</span>
                            <span class="badge {{ $smsTestIsSuccess ? 'badge-success' : 'badge-danger' }}" style="padding:5px 10px;border-radius:6px;">
                                Status: {{ $smsTestIsSuccess ? 'SUCCESS' : 'FAILED' }}
                            </span>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <h6 class="text-uppercase font-weight-bold text-muted mb-3" style="font-size: 0.75rem; letter-spacing:0.5px;">Number Transformations</h6>
                                    <div class="d-flex align-items-center mb-2">
                                        <span style="width:20px;height:20px;border-radius:50%;background:#475569;color:#fff;display:inline-flex;align-items:center;justify-content:center;font-size:11px;font-weight:700;margin-right:8px;">1</span>
                                        <span style="font-size:13px;color:#0f172a;"><strong>Input:</strong> {{ $inputMobile }} <span class="text-muted">({{ strlen($inputMobile) }} chars)</span></span>
                                    </div>
                                    <div class="d-flex align-items-center mb-2" style="margin-left:3px;font-size:10px;color:#94a3b8;"><i class="fas fa-arrow-down"></i></div>
                                    <div class="d-flex align-items-center mb-2">
                                        <span style="width:20px;height:20px;border-radius:50%;background:#475569;color:#fff;display:inline-flex;align-items:center;justify-content:center;font-size:11px;font-weight:700;margin-right:8px;">2</span>
                                        <span style="font-size:13px;color:#0f172a;"><strong>Normalized:</strong> {{ $debugData['mobile_after_normalization'] ?? 'N/A' }} <span class="text-muted">({{ strlen($debugData['mobile_after_normalization'] ?? '') }} chars)</span></span>
                                    </div>
                                    <div class="d-flex align-items-center mb-2" style="margin-left:3px;font-size:10px;color:#94a3b8;"><i class="fas fa-arrow-down"></i></div>
                                    <div class="d-flex align-items-center">
                                        <span style="width:20px;height:20px;border-radius:50%;background:#6366f1;color:#fff;display:inline-flex;align-items:center;justify-content:center;font-size:11px;font-weight:700;margin-right:8px;">3</span>
                                        <span style="font-size:13px;color:#0f172a;"><strong>Sent to API:</strong> {{ Session::get('sms_test_mobile') }}</span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <h6 class="text-uppercase font-weight-bold text-muted mb-3" style="font-size: 0.75rem; letter-spacing:0.5px;">API Data Validation</h6>
                                    <div class="mb-2 d-flex align-items-center">
                                        <span class="badge {{ ($lengthCheck['is_valid'] ?? false) ? 'badge-success' : 'badge-danger' }}" style="padding:4px 8px;border-radius:4px;margin-right:10px;">
                                            {{ ($lengthCheck['is_valid'] ?? false) ? 'VALID' : 'INVALID' }}
                                        </span>
                                        <span style="font-size:13px;color:#334155;">Digits (excluding 88): {{ $lengthCheck['digit_count_after_country_code'] ?? 0 }} (expected {{ $lengthCheck['expected_digits_after_88'] ?? 11 }})</span>
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <span class="badge {{ ($prefixCheck['is_valid_operator_code'] ?? false) ? 'badge-success' : 'badge-danger' }}" style="padding:4px 8px;border-radius:4px;margin-right:10px;">
                                            {{ ($prefixCheck['is_valid_operator_code'] ?? false) ? 'VALID' : 'INVALID' }}
                                        </span>
                                        <span style="font-size:13px;color:#334155;">Operator Prefix: {{ $prefixCheck['operator_prefix'] ?? 'N/A' }} ({{ $prefixCheck['operator_name'] ?? 'Invalid' }})</span>
                                    </div>
                                </div>
                            </div>

                            @if(!$smsTestIsSuccess)
                                <hr style="border-top:1px dashed #cbd5e1;margin:15px 0;">
                                <div class="row">
                                    <div class="col-md-12">
                                        <h6 class="text-uppercase font-weight-bold text-muted mb-3" style="font-size: 0.75rem; letter-spacing:0.5px;">Diagnosis Report</h6>
                                        @php
                                            $responseResult = $smsTestResponse['responseResult'] ?? '';
                                        @endphp
                                        @if(\Illuminate\Support\Str::contains($responseResult, 'Invalid Mobile Number') || \Illuminate\Support\Str::contains($responseResult, 'Invalid Number'))
                                            @if(($lengthCheck['is_valid'] ?? false) && ($prefixCheck['is_valid_operator_code'] ?? false))
                                                <div style="background:#fffbeb;border-left:4px solid #d97706;padding:12px;border-radius:6px;font-size:13px;color:#78350f;">
                                                    <strong>Format Valid:</strong> The number formatting appears valid but was rejected by MimSMS. Verify your API credentials and sender key balance.
                                                </div>
                                            @else
                                                <div style="background:#fef2f2;border-left:4px solid #dc2626;padding:12px;border-radius:6px;font-size:13px;color:#991b1b;">
                                                    <strong>Format Error:</strong> Invalid digit counts or operator codes detected. Check input.
                                                </div>
                                            @endif
                                        @endif

                                        @if(isset($debugData['credentials_status']))
                                            <div class="mt-2" style="font-size:13px;color:#475569;background:#f8fafc;padding:10px;border-radius:6px;border:1px solid #e2e8f0;">
                                                <strong>Credential Status Check:</strong>
                                                API Key: {{ ($debugData['credentials_status']['apiKey_configured'] ?? false) ? 'Configured' : 'Missing' }} |
                                                Username: {{ $debugData['credentials_status']['userName_value'] ?? 'N/A' }} |
                                                Sender ID: {{ $debugData['credentials_status']['sender_name'] ?? 'N/A' }}
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @endif

                            <hr style="border-top:1px dashed #cbd5e1;margin:15px 0;">
                            <div class="row">
                                <div class="col-md-6">
                                    <h6 class="text-uppercase font-weight-bold text-muted mb-2" style="font-size: 0.75rem; letter-spacing:0.5px;">API Outgoing JSON Request</h6>
                                    <pre style="background:#0f172a;color:#cbd5e1;padding:15px;border-radius:8px;font-size:11px;overflow-x:auto;">{{ json_encode($debugData['api_request'] ?? [], JSON_PRETTY_PRINT) }}</pre>
                                </div>
                                <div class="col-md-6">
                                    <h6 class="text-uppercase font-weight-bold text-muted mb-2" style="font-size: 0.75rem; letter-spacing:0.5px;">API Response Log</h6>
                                    <pre style="background:#0f172a;color:#cbd5e1;padding:15px;border-radius:8px;font-size:11px;overflow-x:auto;">{{ json_encode($smsTestResponse, JSON_PRETTY_PRINT) }}</pre>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                {{-- SMS Gateways Config List --}}
                <div class="card mb-4">
                    <div class="card-header">
                        <span class="card-title">
                            <i class="fas fa-list-ul" style="color:#6366f1;margin-right:6px;"></i>
                            Active SMS Gateways List
                        </span>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="example1" class="dataTables table table-bordered table-striped nowrap dt-responsive" style="width: 100%">
                                <thead>
                                    <tr>
                                        <th width="6%" class="text-center">SN</th>
                                        <th>SMS Username</th>
                                        <th>SMS Api Key</th>
                                        <th>SMS Gateway Sender Name</th>
                                        <th width="12%" class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($allData as $key => $sms)
                                        <tr class="{{ $sms->id }}">
                                            <td class="text-center">{{ $key + 1 }}</td>
                                            <td style="font-weight:700;color:#0f172a;">{{ $sms->userName ?? ''}}</td>
                                            <td style="font-family:monospace;font-size:12px;">{{ Str::limit($sms->apiKey ?? '', 25) }}</td>
                                            <td style="font-weight:600;color:#475569;">{{ $sms->SenderName ?? ''}}</td>
                                            <td class="text-center">
                                                <a title="Edit" class="btn btn-sm btn-info" href="{{ route('smsgateways.edit', $sms->id) }}" style="border-radius:6px;padding:5px 12px;font-weight:600;">
                                                    <i class="fas fa-edit mr-1"></i> Edit API
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
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
            $('.dataTables').DataTable({
                responsive: true
            });

            function normalizeMobile(input) {
                var mobile = input.replace(/\D/g, '');
                
                if (mobile.startsWith('008801')) {
                    mobile = mobile.substring(4);
                } else if (mobile.startsWith('00881')) {
                    mobile = '0' + mobile.substring(4);
                } else if (mobile.startsWith('8801')) {
                    mobile = mobile.substring(2);
                } else if (mobile.startsWith('881')) {
                    mobile = '0' + mobile.substring(2);
                } else if (mobile.startsWith('01')) {
                    // Keep it
                } else if (mobile.startsWith('1')) {
                    mobile = '0' + mobile;
                }
                
                return '88' + mobile;
            }

            $('#mobile').on('input', function() {
                var input = $(this).val();
                var preview = $('#mobile-preview');
                
                if (input.length > 0) {
                    var normalized = normalizeMobile(input);
                    var after88 = normalized.substring(2);
                    var digitsAfter88 = after88.length;
                    var prefixTwo = after88.substring(0, 2);
                    var operatorDigit = after88.substring(2, 3);
                    
                    var validDigits = (digitsAfter88 === 11);
                    var validPrefix = (prefixTwo === '01' && /^[3-9]$/.test(operatorDigit));
                    var isValid = validDigits && validPrefix;
                    
                    var statusText = isValid ? ' (Valid operator format)' : ' (Needs 11 digits after 88)';
                    $('#preview-normalized').text(normalized + statusText);
                    if (isValid) {
                        $('#preview-normalized').addClass('text-success').removeClass('text-danger');
                    } else {
                        $('#preview-normalized').addClass('text-danger').removeClass('text-success');
                    }
                    preview.show();
                } else {
                    preview.hide();
                }
            });
        });
    </script>
@endpush