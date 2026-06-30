@extends('backend.layouts.master')
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        {{-- Page Header --}}
        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:22px;flex-wrap:wrap;gap:12px;">
            <div>
                <h1 style="font-size:22px;font-weight:800;color:#0f172a;margin:0;">
                    <i class="fas fa-cube" style="color:#6366f1;margin-right:8px;"></i>
                    @if (isset($editData)) Edit Subscription Plan @else Add Subscription Plan @endif
                </h1>
                <p style="color:#64748b;font-size:13px;margin:2px 0 0;">
                    <a href="{{ route('home') }}" style="color:#6366f1;text-decoration:none;">Home</a>
                    <span style="margin:0 6px;color:#cbd5e1;">/</span>
                    <a href="{{ route('subscriptions.view') }}" style="color:#6366f1;text-decoration:none;">Subscriptions</a>
                    <span style="margin:0 6px;color:#cbd5e1;">/</span>
                    @if (isset($editData)) Edit @else Add @endif
                </p>
            </div>
            <a class="btn btn-sm btn-primary" href="{{ route('subscriptions.view') }}" style="display:inline-flex;align-items:center;gap:6px;padding:9px 18px;background:#6366f1;border:none;border-radius:8px;font-size:13px;font-weight:600;color:#fff;text-decoration:none;">
                <i class="fas fa-list"></i> Subscriptions List
            </a>
        </div>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <section class="col-md-12">
                        <form id="myForm" method="post" action="{{ @$editData ? route('subscriptions.update', $editData->id) : route('subscriptions.store') }}">
                            @csrf
                            <div class="row">
                                <!-- Column 1: Plan Details -->
                                <div class="col-lg-4 col-md-12">
                                    <div class="card mb-4" style="border: 1px solid #e2e8f0; border-radius: 12px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05); height: calc(100% - 24px);">
                                        <div class="card-header" style="background:#f8fafc; border-bottom: 1px solid #e2e8f0; border-radius: 12px 12px 0 0;">
                                            <h3 class="card-title" style="font-size:15px; font-weight:700; color:#0f172a; margin:0;">
                                                <i class="fas fa-cube" style="color:#6366f1; margin-right:6px;"></i> Plan Details
                                            </h3>
                                        </div>
                                        <div class="card-body" style="padding: 20px;">
                                            <div class="form-group">
                                                <label for="account_type_of_myshop" style="font-weight:600; color:#334155;">Account Type <span class="text-danger">*</span></label>
                                                <input type="text" name="account_type_of_myshop" value="{{ old('account_type_of_myshop', @$editData->account_type_of_myshop) }}" class="form-control" id="account_type_of_myshop" placeholder="e.g., Bronze, Silver, Premium" required>
                                                <span style="color: red;">{{ $errors->has('account_type_of_myshop') ? $errors->first('account_type_of_myshop') : '' }}</span>
                                            </div>
                                            <div class="form-group">
                                                <label for="duration" style="font-weight:600; color:#334155;">Billing Cycle <span class="text-danger">*</span></label>
                                                <select name="duration" id="duration" class="form-control select2" required style="width:100%;">
                                                    <option value="monthly" {{ old('duration', @$editData->duration) == 'monthly' ? 'selected' : '' }}>Monthly</option>
                                                    <option value="yearly" {{ old('duration', @$editData->duration) == 'yearly' ? 'selected' : '' }}>Yearly</option>
                                                </select>
                                                <span style="color: red;">{{ $errors->has('duration') ? $errors->first('duration') : '' }}</span>
                                            </div>
                                            <div class="form-group mb-0">
                                                <label for="subscription_fees" style="font-weight:600; color:#334155;">Subscription Fee (৳) <span class="text-danger">*</span></label>
                                                <input type="number" name="subscription_fees" id="subscription_fees" class="form-control" value="{{ old('subscription_fees', @$editData->subscription_fees) }}" placeholder="e.g., 500" min="0" required>
                                                <span style="color: red;">{{ $errors->has('subscription_fees') ? $errors->first('subscription_fees') : '' }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Column 2: Plan Features -->
                                <div class="col-lg-4 col-md-12">
                                    <div class="card mb-4" style="border: 1px solid #e2e8f0; border-radius: 12px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05); height: calc(100% - 24px);">
                                        <div class="card-header" style="background:#f8fafc; border-bottom: 1px solid #e2e8f0; border-radius: 12px 12px 0 0;">
                                            <h3 class="card-title" style="font-size:15px; font-weight:700; color:#0f172a; margin:0;">
                                                <i class="fas fa-list-ul" style="color:#6366f1; margin-right:6px;"></i> Features & Allowances
                                            </h3>
                                        </div>
                                        <div class="card-body" style="padding: 20px;">
                                            <div class="form-group mb-0">
                                                <label for="plan_features" style="font-weight:600; color:#334155;">Features (One item per line)</label>
                                                <textarea name="plan_features" id="plan_features" class="form-control" rows="6" placeholder="List allowances - one per line" style="resize:none;">{{ old('plan_features', isset($editData) ? implode(PHP_EOL, $editData->plan_features ?? []) : '') }}</textarea>
                                                <span style="color: red;">{{ $errors->has('plan_features') ? $errors->first('plan_features') : '' }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Column 3: Save Action -->
                                <div class="col-lg-4 col-md-12">
                                    <div class="card mb-4" style="border: 1px solid #e2e8f0; border-radius: 12px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05); background: #f8fafc;">
                                        <div class="card-body p-3">
                                            <button type="submit" class="btn btn-primary btn-block" style="background:#6366f1; border:none; padding:12px; border-radius:8px; font-weight:700; font-size:14px; display:flex; align-items:center; justify-content:center; gap:8px; width:100%;">
                                                <i class="fas fa-save"></i> {{ @$editData ? 'Update Plan' : 'Save Plan' }}
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </section>
                </div>
            </div>
        </section>
    </div>

    <script type="text/javascript">
        $(function() {
            $('.select2').select2({
                theme: 'bootstrap4'
            });

            $('#myForm').validate({
                rules: {
                    account_type_of_myshop: {
                        required: true
                    },
                    subscription_fees: {
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
@endsection
