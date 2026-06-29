@extends('backend.layouts.master')
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        {{-- Page Header --}}
        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:22px;flex-wrap:wrap;gap:12px;">
            <div>
                <h1 style="font-size:22px;font-weight:800;color:#0f172a;margin:0;">
                    <i class="fas fa-sms" style="color:#6366f1;margin-right:8px;"></i>
                    @if (isset($editData)) Edit SMS Gateway @else Add SMS Gateway @endif
                </h1>
                <p style="color:#64748b;font-size:13px;margin:2px 0 0;">
                    <a href="{{ route('home') }}" style="color:#6366f1;text-decoration:none;">Home</a>
                    <span style="margin:0 6px;color:#cbd5e1;">/</span>
                    <a href="{{ route('smsgateways.view') }}" style="color:#6366f1;text-decoration:none;">SMS Gateways</a>
                    <span style="margin:0 6px;color:#cbd5e1;">/</span>
                    @if (isset($editData)) Edit @else Add @endif
                </p>
            </div>
            <a class="btn btn-sm btn-primary" href="{{ route('smsgateways.view') }}" style="display:inline-flex;align-items:center;gap:6px;padding:9px 18px;background:#6366f1;border:none;border-radius:8px;font-size:13px;font-weight:600;color:#fff;text-decoration:none;">
                <i class="fas fa-list"></i> SMS Gateways List
            </a>
        </div>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="card">
                    <div class="card-header">
                        <span class="card-title">
                            <i class="fas fa-cog" style="color:#6366f1;margin-right:6px;"></i>
                            API Connection settings
                        </span>
                    </div>
                    <div class="card-body">
                        <form method="post" action="{{ @$editData ? route('smsgateways.update', $editData->id) : route('smsgateways.store') }}" id="myForm">
                            @csrf
                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label for="userName" style="font-weight:600;color:#334155;font-size:13px;">SMS Gateway API Username <span class="text-danger">*</span></label>
                                    <input type="text" name="userName" value="{{ @$editData->userName }}" class="form-control" id="userName" placeholder="Enter API Username" required>
                                    <span style="color: red;">{{ $errors->has('userName') ? $errors->first('userName') : '' }}</span>
                                </div>
                               
                                <div class="form-group col-md-4">
                                    <label for="apiKey" style="font-weight:600;color:#334155;font-size:13px;">SMS Gateway API Key <span class="text-danger">*</span></label>
                                    <input type="text" name="apiKey" value="{{ @$editData->apiKey }}" class="form-control" id="apiKey" placeholder="Enter API Key" required>
                                    <span style="color: red;">{{ $errors->has('apiKey') ? $errors->first('apiKey') : '' }}</span>
                                </div>

                                <div class="form-group col-md-4">
                                    <label for="SenderName" style="font-weight:600;color:#334155;font-size:13px;">Registered Sender ID (SenderName) <span class="text-danger">*</span></label>
                                    <input type="text" name="SenderName" value="{{ @$editData->SenderName }}" class="form-control" id="SenderName" placeholder="Enter Registered Sender ID" required>
                                    <span style="color: red;">{{ $errors->has('SenderName') ? $errors->first('SenderName') : '' }}</span>
                                </div>

                                <div class="form-group col-md-12 text-right" style="margin-top:20px;border-top:1px solid #e2e8f0;padding-top:20px;margin-bottom:0;">
                                    <button type="submit" class="btn btn-primary" style="background:#6366f1;border:none;padding:10px 30px;border-radius:8px;font-weight:600;box-shadow: 0 4px 6px -1px rgba(99,102,241,0.2);">
                                        <i class="fas fa-save mr-1"></i> {{ @$editData ? 'Update Gateway' : 'Save Gateway' }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $('#myForm').validate({
                rules: {
                    userName: {
                        required: true
                    },
                    apiKey: {
                        required: true
                    },
                    SenderName: {
                        required: true
                    }
                },
                errorElement: 'span',
                errorPlacement: function(error, element) {
                    error.addClass('invalid-feedback');
                    element.closest('.form-group').append(error);
                },
                highlight: function(element, errorClass, validClass) {
                    $(element).addClass('is-invalid');
                },
                unhighlight: function(element, errorClass, validClass) {
                    $(element).removeClass('is-invalid');
                }
            });
        });
    </script>
@endpush
