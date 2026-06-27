@extends('backend.layouts.master')
@section('admin_css')
<style>
    @media screen and (max-width: 368px) and (max-width: 568px) and (max-width: 668px){
        .table-responsive {
    overflow-x: auto;
    max-width: 100%;
    border-radius: 8px;
    box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
}
#example1 thead: {
    overflow: hidden;
    display: block;
    width:100%;
}
}
.debug-card {
    border-left: 4px solid #17a2b8;
    margin-bottom: 20px;
}
.debug-card.error {
    border-left-color: #dc3545;
}
.debug-card.success {
    border-left-color: #28a745;
}
.validation-badge {
    font-size: 0.75rem;
    padding: 3px 8px;
    border-radius: 3px;
}
.validation-badge.valid {
    background-color: #d4edda;
    color: #155724;
}
.validation-badge.invalid {
    background-color: #f8d7da;
    color: #721c24;
}
.diagnosis-item {
    padding: 8px 12px;
    margin-bottom: 8px;
    border-radius: 4px;
    background-color: #f8f9fa;
    border-left: 3px solid #6c757d;
}
.diagnosis-item.warning {
    background-color: #fff3cd;
    border-left-color: #ffc107;
}
.diagnosis-item.danger {
    background-color: #f8d7da;
    border-left-color: #dc3545;
}
.diagnosis-item.success {
    background-color: #d4edda;
    border-left-color: #28a745;
}
.step-indicator {
    display: flex;
    align-items: center;
    margin-bottom: 8px;
}
.step-number {
    width: 24px;
    height: 24px;
    border-radius: 50%;
    background-color: #17a2b8;
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size:13px;
    font-weight: bold;
    margin-right: 10px;
}
.step-arrow {
    margin-left: 34px;
    color: #6c757d;
    font-size:13px;
}
</style>
@endsection
@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6">
                        <h5 class="m-0"><i class='fas fa-hand-point-right'></i> Manage SMS Gatway</h5>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li class="breadcrumb-item active">SMS Gatway</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <section class="col-md-12">
                        @if (Session::get('success'))
                            <div class="alert alert-success alert-dismissible" role="alert">
                                <button type="button" class="close" data-dismiss="alert">&times;</button>
                                <strong>{{ Session::get('success') }}</strong>
                            </div>
                        @endif
                        @if (Session::get('error'))
                            <div class="alert alert-danger alert-dismissible" role="alert">
                                <button type="button" class="close" data-dismiss="alert">&times;</button>
                                <strong>{{ Session::get('error') }}</strong>
                            </div>
                        @endif

                        <div class="card mb-3">
                            <div class="card-header">
                                <h5 class="mb-0">Test SMS Gateway</h5>
                            </div>
                            <div class="card-body">
                                <form method="post" action="{{ route('smsgateways.test') }}">
                                    @csrf
                                    <div class="form-row">
                                        <div class="form-group col-md-4">
                                            <label for="mobile">Recipient Mobile <span class="text-danger">*</span></label>
                                            <input type="text" name="mobile" id="mobile" class="form-control" placeholder="e.g., 01712345678 or +8801712345678" value="{{ old('mobile') }}">
                                            @error('mobile')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                            <small class="text-muted">Valid: 11 digits (01XXXXXXXXX)</small>
                                            <div id="mobile-preview" class="mt-2 p-2 bg-light rounded" style="font-size: 0.8rem; display: none;">
                                                <strong>Preview:</strong> <span id="preview-normalized"></span>
                                            </div>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="message">Test Message</label>
                                            <input type="text" name="message" id="message" class="form-control" value="{{ old('message', 'U SuperShop SMS test message') }}">
                                            @error('message')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-2 d-flex align-items-end">
                                            <button type="submit" class="btn btn-primary btn-block">Send Test</button>
                                        </div>
                                    </div>
                                    <div class="row mt-2">
                                        <div class="col-md-12">
                                            <div class="alert alert-info py-2" style="font-size: 0.85rem; margin-bottom: 0;">
                                                <i class="fas fa-info-circle"></i> <strong>Accepted Formats:</strong> 
                                                <code>01712345678</code> or 
                                                <code>+8801712345678</code> or 
                                                <code>8801712345678</code> or 
                                                <code>008801712345678</code>
                                                <span class="float-right text-muted">The system will normalize to 88 + 11 digits (13 total: 8801XXXXXXXXX)</span>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>

                        @if (Session::get('sms_test_response'))
                        @php
                            $smsTestResponse = Session::get('sms_test_response');
                            $smsTestIsSuccess = isset($smsTestResponse['status']) && strtolower((string) $smsTestResponse['status']) === 'success';
                            $debugData = Session::get('sms_test_debug') ?? [];
                            $inputMobile = Session::get('sms_test_input_mobile') ?? '';
                            $lengthCheck = $debugData['mobile_length_check'] ?? [];
                            $prefixCheck = $debugData['mobile_prefix_check'] ?? [];
                        @endphp

                        <div class="card debug-card {{ $smsTestIsSuccess ? 'success' : 'error' }}">
                            <div class="card-header bg-info text-white">
                                <h6 class="mb-0"><i class="fas fa-bug"></i> Debug Information</h6>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <h6 class="text-uppercase text-muted mb-3" style="font-size: 0.85rem;">
                                            <i class="fas fa-mobile-alt"></i> Mobile Number Transformation
                                        </h6>
                                        <div class="step-indicator">
                                            <span class="step-number">1</span>
                                            <span><strong>Input:</strong> {{ $inputMobile }}</span>
                                            <span class="ml-2 text-muted">({{ strlen($inputMobile) }} chars)</span>
                                        </div>
                                        <div class="step-arrow">↓</div>
                                        <div class="step-indicator">
                                            <span class="step-number">2</span>
                                            <span><strong>Normalized:</strong> {{ $debugData['mobile_after_normalization'] ?? 'N/A' }}</span>
                                            <span class="ml-2 text-muted">({{ strlen($debugData['mobile_after_normalization'] ?? '') }} chars)</span>
                                        </div>
                                        <div class="step-arrow">↓</div>
                                        <div class="step-indicator">
                                            <span class="step-number">3</span>
                                            <span><strong>Sent to API:</strong> {{ Session::get('sms_test_mobile') }}</span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <h6 class="text-uppercase text-muted mb-3" style="font-size: 0.85rem;">
                                            <i class="fas fa-check-circle"></i> Validation Status
                                        </h6>
                                        <div class="mb-2">
                                            <span class="validation-badge {{ ($lengthCheck['is_valid'] ?? false) ? 'valid' : 'invalid' }}">
                                                {{ ($lengthCheck['is_valid'] ?? false) ? '✓' : '✗' }}
                                            </span>
                                            <span class="ml-2">Digits after 88: {{ $lengthCheck['digit_count_after_country_code'] ?? 0 }} (expected {{ $lengthCheck['expected_digits_after_88'] ?? 11 }})</span>
                                        </div>
                                        <div class="mb-2">
                                            <span class="validation-badge {{ ($prefixCheck['is_valid_operator_code'] ?? false) ? 'valid' : 'invalid' }}">
                                                {{ ($prefixCheck['is_valid_operator_code'] ?? false) ? '✓' : '✗' }}
                                            </span>
                                            <span class="ml-2">Operator: {{ $prefixCheck['operator_prefix'] ?? 'N/A' }} ({{ $prefixCheck['operator_name'] ?? 'Invalid' }})</span>
                                        </div>
                                    </div>
                                </div>

                                @if(!$smsTestIsSuccess)
                                <hr>
                                <div class="row">
                                    <div class="col-md-12">
                                        <h6 class="text-uppercase text-muted mb-3" style="font-size: 0.85rem;">
                                            <i class="fas fa-stethoscope"></i> Diagnosis
                                        </h6>
                                        @php
                                            $responseResult = $smsTestResponse['responseResult'] ?? '';
                                        @endphp
                                        @if(\Illuminate\Support\Str::contains($responseResult, 'Invalid Mobile Number') || \Illuminate\Support\Str::contains($responseResult, 'Invalid Number'))
                                            @if(($lengthCheck['is_valid'] ?? false) && ($prefixCheck['is_valid_operator_code'] ?? false))
                                            <div class="diagnosis-item warning">
                                                <strong><i class="fas fa-exclamation-triangle"></i> Note:</strong> Format appears VALID but MimSMS rejected it.<br>
                                                Possible causes: API restrictions, blocked IP, or number not active.
                                            </div>
                                            @else
                                            <div class="diagnosis-item danger">
                                                <strong><i class="fas fa-times-circle"></i> Issue:</strong> Invalid mobile number format.<br>
                                                Input: <code>{{ $inputMobile }}</code> → Normalized: <code>{{ $debugData['mobile_after_normalization'] ?? '' }}</code><br>
                                                Digits after 88: {{ $lengthCheck['digit_count_after_country_code'] ?? 0 }} (expected 11)
                                            </div>
                                            @endif
                                        @endif

                                        @if(isset($debugData['credentials_status']))
                                        <div class="diagnosis-item {{ ($debugData['credentials_status']['apiKey_configured'] ?? false) ? 'success' : 'danger' }}">
                                            <strong><i class="fas fa-key"></i> Credentials:</strong>
                                            API Key: {{ ($debugData['credentials_status']['apiKey_configured'] ?? false) ? 'Configured' : 'NOT SET' }},
                                            Username: {{ $debugData['credentials_status']['userName_value'] ?? 'N/A' }},
                                            Sender: {{ $debugData['credentials_status']['sender_name'] ?? 'N/A' }}
                                        </div>
                                        @endif
                                    </div>
                                </div>
                                @endif

                                <hr>
                                <div class="row">
                                    <div class="col-md-6">
                                        <h6 class="text-uppercase text-muted mb-2" style="font-size: 0.85rem;">
                                            <i class="fas fa-paper-plane"></i> API Request
                                        </h6>
                                        <pre class="bg-light p-2 rounded" style="font-size: 0.75rem;">{{ json_encode($debugData['api_request'] ?? [], JSON_PRETTY_PRINT) }}</pre>
                                    </div>
                                    <div class="col-md-6">
                                        <h6 class="text-uppercase text-muted mb-2" style="font-size: 0.85rem;">
                                            <i class="fas fa-reply-all"></i> API Response
                                        </h6>
                                        <pre class="bg-light p-2 rounded" style="font-size: 0.75rem;">{{ json_encode($smsTestResponse, JSON_PRETTY_PRINT) }}</pre>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif

                        <div class="card">
                            <div class="card-header">
                                <h5>
                                    SMS Gatway List
                                    @if ($countsms < 1)
                                        <a class="btn btn-sm btn-primary float-right" href="{{ route('smsgateways.add') }}"><i class="fas fa-plus-circle"></i> Add SMS Gatway</a>
                                    @endif
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="example1" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th width="6%">SN</th>
                                                <th>SMS Username</th>
                                                <th>SMS Api Key</th>
                                                <th>SMS Gatway Sender Name</th>
                                                <th width="12%">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($allData as $key => $sms)
                                                <tr class="{{ $sms->id }}">
                                                    <td>{{ $key + 1 }}</td>
                                                    <td>{{ $sms->userName ?? ''}}</td>
                                                    <td>
                                                        {{ $sms->apiKey ?? ''}}
                                                    </td>
                                                    <td>
                                                        {{ $sms->SenderName ?? ''}}
                                                    </td>
                                                    <td>
                                                        <a title="Edit" class="btn btn-sm btn-info" href="{{ route('smsgateways.edit', $sms->id) }}"><i class="fas fa-edit"></i> Edit</a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </section>
    </div>
@endsection

@section('admin_js')
<script>
$(document).ready(function() {
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
            
            var statusText = isValid ? ' (Valid: 8801XXXXXXXXX)' : ' (' + digitsAfter88 + ' digits after 88 - need 11)';
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
@endsection