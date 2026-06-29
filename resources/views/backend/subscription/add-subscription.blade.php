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
                        <div class="card">
                            <div class="card-header">
                                <span class="card-title">
                                    <i class="fas fa-edit" style="color:#6366f1;margin-right:6px;"></i>
                                    Plan Parameters Form
                                </span>
                            </div>
                            <div class="card-body">
                                <form id="myForm" method="post" action="{{ @$editData ? route('subscriptions.update', $editData->id) : route('subscriptions.store') }}">
                                    @csrf
                                    <div class="form-row">
                                        <div class="form-group col-md-4">
                                            <label for="account_type_of_myshop">Account Type <span class="text-danger">*</span></label>
                                            <input type="text" name="account_type_of_myshop" value="{{ old('account_type_of_myshop', @$editData->account_type_of_myshop) }}" class="form-control" id="account_type_of_myshop" placeholder="e.g., Bronze, Silver, Premium" required>
                                            <span style="color: red;">{{ $errors->has('account_type_of_myshop') ? $errors->first('account_type_of_myshop') : '' }}</span>
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label for="duration">Billing Cycle / Duration <span class="text-danger">*</span></label>
                                            <select name="duration" id="duration" class="form-control select2" required>
                                                <option value="monthly" {{ old('duration', @$editData->duration) == 'monthly' ? 'selected' : '' }}>Monthly</option>
                                                <option value="yearly" {{ old('duration', @$editData->duration) == 'yearly' ? 'selected' : '' }}>Yearly</option>
                                            </select>
                                            <span style="color: red;">{{ $errors->has('duration') ? $errors->first('duration') : '' }}</span>
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label for="subscription_fees">Seller Subscription Fee (৳) <span class="text-danger">*</span></label>
                                            <input type="number" name="subscription_fees" id="subscription_fees" class="form-control" value="{{ old('subscription_fees', @$editData->subscription_fees) }}" placeholder="e.g., 500" min="0" required>
                                            <span style="color: red;">{{ $errors->has('subscription_fees') ? $errors->first('subscription_fees') : '' }}</span>
                                        </div>

                                        <div class="form-group col-md-12" style="margin-top:10px;">
                                            <label for="plan_features">Plan Features / Allowances (One item per line)</label>
                                            <textarea name="plan_features" id="plan_features" class="form-control" rows="6" placeholder="List products, storage, support options - one per line">{{ old('plan_features', isset($editData) ? implode(PHP_EOL, $editData->plan_features ?? []) : '') }}</textarea>
                                            <span style="color: red;">{{ $errors->has('plan_features') ? $errors->first('plan_features') : '' }}</span>
                                        </div>

                                        <div class="form-group col-md-12 text-right" style="margin-top:20px;border-top:1px solid #e2e8f0;padding-top:20px;">
                                            <button type="submit" class="btn btn-primary" style="background:#6366f1;border:none;padding:9px 24px;border-radius:8px;font-weight:600;">
                                                <i class="fas fa-save mr-1"></i> {{ @$editData ? 'Update Plan' : 'Save Plan' }}
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
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
