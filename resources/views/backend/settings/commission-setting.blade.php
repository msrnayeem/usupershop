@extends('backend.layouts.master')
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        {{-- Page Header --}}
        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:22px;flex-wrap:wrap;gap:12px;">
            <div>
                <h1 style="font-size:22px;font-weight:800;color:#0f172a;margin:0;">
                    <i class="fas fa-percentage" style="color:#6366f1;margin-right:8px;"></i>
                    {{ $pageTitle }}
                </h1>
                <p style="color:#64748b;font-size:13px;margin:2px 0 0;">
                    <a href="{{ route('home') }}" style="color:#6366f1;text-decoration:none;">Home</a>
                    <span style="margin:0 6px;color:#cbd5e1;">/</span>
                    {{ $pageTitle }}
                </p>
            </div>
        </div>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" style="border:none;border-radius:8px;background:#f0fdf4;color:#15803d;margin-bottom:20px;">
                        <i class="fas fa-check-circle mr-1"></i> {{ session('success') }}
                        <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
                    </div>
                @endif

                <div class="card">
                    <div class="card-header">
                        <span class="card-title">
                            <i class="fas fa-sliders-h" style="color:#6366f1;margin-right:6px;"></i>
                            Referral System Rates
                        </span>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-5">
                                @php
                                    $siteSetting = Helper::get_setting_data();
                                @endphp
                                
                                <form action="{{ route('settings.commission.update') }}" method="POST" id="myForm">
                                    @csrf
                                    <div class="form-group">
                                        <label for="refer_commission_type" style="font-weight:600;color:#334155;font-size:13px;">Refer Commission Type <span class="text-danger">*</span></label>
                                        <select name="refer_commission_type" id="refer_commission_type" class="form-control select2 @error('refer_commission_type') is-invalid @enderror" required>
                                            <option value="0" @if($siteSetting->refer_commission_type == '0') selected @endif>Flat Rate (৳)</option>
                                            <option value="1" @if($siteSetting->refer_commission_type == '1') selected @endif>Percentage (%)</option>
                                        </select>
                                        @error('refer_commission_type')
                                            <span class="text-danger" style="font-size:12px;">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="form-group mt-3">
                                        <label for="refer_commission" style="font-weight:600;color:#334155;font-size:13px;">Refer Commission Value <span class="text-danger">*</span></label>
                                        <input type="number" class="form-control @error('refer_commission') is-invalid @enderror" id="refer_commission" name="refer_commission" placeholder="Enter Commission Value" value="{{ $siteSetting->refer_commission }}" min="0" required>
                                        @error('refer_commission')
                                            <span class="text-danger" style="font-size:12px;">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="form-group mt-4 pt-3" style="border-top:1px solid #e2e8f0;">
                                        <button type="submit" class="btn btn-primary btn-block" style="background:#6366f1;border:none;padding:10px 0;border-radius:8px;font-weight:600;display:inline-flex;align-items:center;justify-content:center;gap:6px;">
                                            <i class="fas fa-save"></i> Save Commission Config
                                        </button>
                                    </div>
                                </form>
                            </div>
                            <div class="col-md-7">
                                <div style="background:#f8fafc;border-radius:12px;padding:24px;border:1px solid #e2e8f0;height:100%;">
                                    <h6 class="font-weight-bold mb-3" style="color:#0f172a;"><i class="fas fa-info-circle mr-2" style="color:#6366f1;"></i>Referral Commission Details</h6>
                                    <p style="font-size:13px;color:#475569;line-height:1.7;">
                                        Setting up a referral commission allows dropshippers, vendors, or resellers to earn a reward when user referrals complete their registrations or purchase operations on the platform.
                                    </p>
                                    <ul style="font-size:13px;color:#475569;line-height:1.8;padding-left:18px;margin-bottom:0;">
                                        <li><strong>Flat Rate:</strong> A static currency amount credited to the referrer balance (e.g., ৳100 per successful user activation).</li>
                                        <li><strong>Percentage Rate:</strong> A dynamic commission percentage calculated based on subscription plan signups or sale values.</li>
                                    </ul>
                                </div>
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

            $('#myForm').validate({
                rules: {
                    refer_commission: {
                        required: true,
                        min: 0
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
