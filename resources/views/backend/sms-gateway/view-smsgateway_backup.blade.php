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
    font-size: 12px;
    font-weight: bold;
    margin-right: 10px;
}
.step-arrow {
    margin-left: 34px;
    color: #6c757d;
    font-size: 12px;
}
</style>
@endsection
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6">
                        <h5 class="m-0"><i class='fas fa-hand-point-right'></i> Manage SMS Gatway</h5>
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li class="breadcrumb-item active">SMS Gatway</li>
                        </ol>
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <!-- Main row -->
                <div class="row">
                    <!-- Left col -->
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
                        @if (Session::get('sms_test_response'))
                            @php
                                $smsTestResponse = Session::get('sms_test_response');
                                $smsTestIsSuccess = isset($smsTestResponse['status']) && strtolower((string) $smsTestResponse['status']) === 'success';
                                $debugData = Session::get('sms_test_debug') ?? [];
                                $inputMobile = Session::get('sms_test_input_mobile') ?? '';
                            @endphp
                            <div class="alert {{ $smsTestIsSuccess ? 'alert-success' : 'alert-danger' }} alert-dismissible" role="alert">
                                <button type="button" class="close" data-dismiss="alert">&times;</button>
                                <strong>
                                    {{ $smsTestIsSuccess ? 'SMS test sent successfully to' : 'SMS test failed for' }}
                                    {{ Session::get('sms_test_mobile') }}
                                </strong>
                            </div>

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
                                                <span><strong>After Normalization:</strong> {{ $debugData['mobile_after_normalization'] ?? 'N/A' }}</span>
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
                                            @php
                                                $lengthCheck = $debugData['mobile_length_check'] ?? [];
                                                $prefixCheck = $debugData['mobile_prefix_check'] ?? [];
                                            @endphp
                                            <div class="mb-2">
                                                <span class="validation-badge {{ ($lengthCheck['is_valid'] ?? false) ? 'valid' : 'invalid' }}">
                                                    {{ ($lengthCheck['is_valid'] ?? false) ? '✓' : '✗' }}
                                                </span>
                                                <span class="ml-2">Digits after 88: {{ $lengthCheck['digit_count_after_country_code'] ?? 0 }} ({{ $lengthCheck['expected_digits_after_88'] ?? '10 or 11' }} expected)
                                                @if(($lengthCheck['is_valid'] ?? false))
                                                    <span class="text-success">(Valid)</span>
                                                @else
                                                    <span class="text-danger">(Invalid)</span>
                                                @endif
                                                </span>
                                            </div>
                                            <div class="mb-2">
                                                <span class="validation-badge {{ ($prefixCheck['is_valid_operator_code'] ?? false) ? 'valid' : 'invalid' }}">
                                                    {{ ($prefixCheck['is_valid_operator_code'] ?? false) ? '✓' : '✗' }}
                                                </span>
                                                <span class="ml-2">Operator: {{ $prefixCheck['operator_prefix'] ?? 'N/A' }} ({{ $prefixCheck['operator_name'] ?? ($prefixCheck['is_valid_operator_code'] ? 'Valid' : 'Invalid') }})
                                                @if($prefixCheck['digit_count_issue'] ?? false)
                                                    <span class="text-danger">(But digit count wrong!)</span>
                                                @endif
                                                </span>
                                            </div>
                                            @if(!empty($debugData['validation_errors']))
                                                <div class="mt-2">
                                                    @foreach($debugData['validation_errors'] as $error)
                                                        <div class="diagnosis-item danger">
                                                            <i class="fas fa-exclamation-triangle"></i> {{ $error }}
                                                        </div>
                                                    @endforeach
                                                </div>
                                            @endif
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
                                                    $httpCode = $debugData['curl_http_code'] ?? '';
                                                    $curlError = $debugData['curl_error'] ?? '';
                                                @endphp
                                                
@if(strpos($responseResult, 'Invalid Mobile Number') !== false)
                                                    @if(($lengthCheck['is_valid'] ?? false) && ($prefixCheck['is_valid_operator_code'] ?? false))
                                                        <div class="diagnosis-item warning">
                                                            <strong><i class="fas fa-exclamation-triangle"></i> Note:</strong> The mobile number format appears VALID based on our validation checks.<br>
                                                            <strong>But MimSMS API rejected it anyway.</strong><br>
                                                            <strong>Possible Causes:</strong><br>
                                                            <ul class="mb-0 mt-1">
                                                                <li>MimSMS may not accept the {{ $prefixCheck['operator_prefix'] ?? '' }} ({{ $prefixCheck['operator_name'] ?? 'unknown' }}) prefix</li>
                                                                <li>MimSMS server IP might be blocked or rate-limited</li>
                                                                <li>The number might be deactivated/port-out</li>
                                                                <li>MimSMS API specific restrictions</li>
                                                            </ul>
                                                        </div>
                                                    @else
                                                        <div class="diagnosis-item danger">
                                                            <strong><i class="fas fa-times-circle"></i> Issue:</strong> The mobile number format is not accepted by MimSMS API.<br>
                                                            <strong>Possible Causes:</strong><br>
                                                            <ul class="mb-0 mt-1">
                                                                <li>Mobile number has wrong digit count after country code: {{ $lengthCheck['digit_count_after_country_code'] ?? 'N/A' }} digits (expected 10 or 11)</li>
                                                                <li>Number doesn't start with valid operator prefix (13, 14, 15, 16, 17, 18, 19)</li>
                                                                <li>Input was: <code>{{ $inputMobile }}</code></li>
                                                            </ul>
                                                        </div>
                                                    @endif
                                                @endif
                                                        </ul>
                                                    </div>
                                                @endif
                                                
                                                @if($curlError)
                                                    <div class="diagnosis-item warning">
                                                        <strong><i class="fas fa-plug"></i> Network Issue:</strong> {{ $curlError }}
                                                    </div>
                                                @endif

                                                @if($httpCode && $httpCode != 200)
                                                    <div class="diagnosis-item warning">
                                                        <strong><i class="fas fa-code"></i> HTTP Code:</strong> {{ $httpCode }} (expected 200)
                                                    </div>
                                                @endif
                                                
                                                @if(isset($debugData['credentials_status']))
                                                    <div class="diagnosis-item {{ ($debugData['credentials_status']['apiKey_configured'] ?? false) ? 'success' : 'danger' }}">
                                                        <strong><i class="fas fa-key"></i> Credentials:</strong>
                                                        API Key: {{ ($debugData['credentials_status']['apiKey_configured'] ?? false) ? 'Configured (' . ($debugData['credentials_status']['apiKey_length'] ?? 0) . ' chars)' : 'NOT CONFIGURED' }},
                                                        Username: {{ $debugData['credentials_status']['userName_value'] ?? 'N/A' }},
                                                        Sender: {{ $debugData['credentials_status']['sender_name'] ?? 'N/A' }}
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    @endif

                                    @if($smsTestIsSuccess)
                                        <hr>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="diagnosis-item success">
                                                    <strong><i class="fas fa-check-circle"></i> SMS sent successfully!</strong> The mobile number format is valid and MimSMS API accepted it.
                                                </div>
                                            </div>
                                        </div>
                                    @endif

                                    <hr>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <h6 class="text-uppercase text-muted mb-2" style="font-size: 0.85rem;">
                                                <i class="fas fa-paper-plane"></i> API Request Sent
                                            </h6>
                                            <pre class="bg-light p-2 rounded" style="font-size: 0.75rem;">{{ json_encode($debugData['api_request'] ?? [], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) }}</pre>
                                        </div>
                                        <div class="col-md-6">
                                            <h6 class="text-uppercase text-muted mb-2" style="font-size: 0.85rem;">
                                                <i class="fas fa-reply-all"></i> API Response
                                            </h6>
                                            <pre class="bg-light p-2 rounded" style="font-size: 0.75rem;">{{ json_encode($smsTestResponse, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) }}</pre>
                                        </div>
                                    </div>
                                </div>
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
                                                <code>00881712345678</code>
                                                <span class="float-right text-muted">The system will normalize to 88 + 10 digits (12 total)</span>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <!-- Custom tabs (Charts with tabs)-->
                        <div class="card">
                            <div class="card-header">
                                <h5>
                                    SMS Gatway List
                                    @if ($countsms < 1)
                                        <a class="btn btn-sm btn-primary float-right" href="{{ route('smsgateways.add') }}"><i
                                                class="fas fa-plus-circle"></i> Add SMS Gatway</a>
                                    @endif
                                </h5>
                            </div>
                            <!-- /.card-header -->
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
                                                        <a title="Edit" class="btn btn-sm btn-info"
                                                            href="{{ route('smsgateways.edit', $sms->id) }}"><i
                                                                class="fas fa-edit"></i> Edit</a>
                                                       
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                               
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                        <!-- /.card -->
                    </section>
                    <!-- /.Left col -->
                </div>
                <!-- /.row (main row) -->
            </div>
            <!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@endsection

@section('admin_js')
<script>
$(document).ready(function() {
    function normalizeMobile(input) {
        var mobile = input.replace(/\D/g, '');
        
        if (mobile.startsWith('0088')) {
            mobile = mobile.substring(4);
        } else if (mobile.startsWith('88')) {
            mobile = mobile.substring(2);
        }
        
        if (mobile.startsWith('0')) {
            mobile = mobile.substring(1);
        }
        
        return '88' + mobile;
    }

    $('#mobile').on('input', function() {
        var input = $(this).val();
        var preview = $('#mobile-preview');
        
        if (input.length > 0) {
            var normalized = normalizeMobile(input);
            var digitsAfter88 = normalized.substring(2).length;
            var firstDigit = normalized.substring(2, 3);
            var validDigits = (digitsAfter88 === 10 || digitsAfter88 === 11);
            var validPrefix = /^[3-9]$/.test(firstDigit);
            var isValid = validDigits && validPrefix;
            
            var statusText = isValid ? ' (Valid format)' : ' (' + digitsAfter88 + ' digits after 88 - need 10 or 11)';
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
