@extends('backend.layouts.master')
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        {{-- Page Header --}}
        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:22px;flex-wrap:wrap;gap:12px;">
            <div>
                <h1 style="font-size:22px;font-weight:800;color:#0f172a;margin:0;">
                    <i class="fas fa-ticket-alt" style="color:#6366f1;margin-right:8px;"></i>
                    @if (isset($editData)) Edit Coupon @else Add Coupon @endif
                </h1>
                <p style="color:#64748b;font-size:13px;margin:2px 0 0;">
                    <a href="{{ route('home') }}" style="color:#6366f1;text-decoration:none;">Home</a>
                    <span style="margin:0 6px;color:#cbd5e1;">/</span>
                    <a href="{{ route('coupons.view') }}" style="color:#6366f1;text-decoration:none;">Coupons</a>
                    <span style="margin:0 6px;color:#cbd5e1;">/</span>
                    @if (isset($editData)) Edit @else Add @endif
                </p>
            </div>
            <a class="btn btn-sm btn-primary" href="{{ route('coupons.view') }}" style="display:inline-flex;align-items:center;gap:6px;padding:9px 18px;background:#6366f1;border:none;border-radius:8px;font-size:13px;font-weight:600;color:#fff;text-decoration:none;">
                <i class="fas fa-list"></i> All Coupons
            </a>
        </div>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <section class="col-md-12">
                        <form method="post" action="{{ @$editData ? route('coupons.update', $editData->id) : route('coupons.store') }}" id="myForm">
                            @csrf
                            <div class="row">
                                <!-- Column 1: Details & Scope -->
                                <div class="col-lg-4 col-md-12">
                                    <div class="card mb-4" style="border: 1px solid #e2e8f0; border-radius: 12px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05); height: calc(100% - 24px);">
                                        <div class="card-header" style="background:#f8fafc; border-bottom: 1px solid #e2e8f0; border-radius: 12px 12px 0 0;">
                                            <h3 class="card-title" style="font-size:15px; font-weight:700; color:#0f172a; margin:0;">
                                                <i class="fas fa-ticket-alt" style="color:#6366f1; margin-right:6px;"></i> Details & Scope
                                            </h3>
                                        </div>
                                        <div class="card-body" style="padding: 20px;">
                                            <div class="form-group">
                                                <label for="name" style="font-weight:600; color:#334155;">Coupon Title <span class="text-danger">*</span></label>
                                                <input type="text" name="name" value="{{ @$editData->name }}" class="form-control" id="name" placeholder="Enter coupon title" required>
                                                <span style="color: red;">{{ $errors->has('name') ? $errors->first('name') : '' }}</span>
                                            </div>
                                            <div class="form-group">
                                                <label for="promoCode" style="font-weight:600; color:#334155;">Promo Code <span class="text-danger">*</span></label>
                                                <input type="text" name="promoCode" value="{{ @$editData->promoCode }}" class="form-control" id="promoCode" placeholder="Enter promo code" required>
                                                <span style="color: red;">{{ $errors->has('promoCode') ? $errors->first('promoCode') : '' }}</span>
                                            </div>
                                            <div class="form-group">
                                                <label for="status" style="font-weight:600; color:#334155;">Publication Status <span class="text-danger">*</span></label>
                                                <select name="status" id="status" class="form-control select2" required style="width:100%;">
                                                    <option value="1" {{ @$editData->status == 1 ? 'selected' : '' }}>Active</option>
                                                    <option value="0" {{ @$editData->status == 0 ? 'selected' : '' }}>Inactive</option>
                                                </select>
                                            </div>
                                            <div class="form-group mb-0">
                                                <label for="availableFor" style="font-weight:600; color:#334155;">User Group Availability <span class="text-danger">*</span></label>
                                                <select name="availableFor" id="availableFor" class="form-control select2" required style="width:100%;">
                                                    <option value="0" {{ @$editData->availableFor == 0 ? 'selected' : '' }}>Customer</option>
                                                    <option value="1" {{ @$editData->availableFor == 1 ? 'selected' : '' }}>Staff</option>
                                                    <option value="3" {{ @$editData->availableFor == 3 ? 'selected' : '' }}>Vendor</option>
                                                    <option value="4" {{ @$editData->availableFor == 4 ? 'selected' : '' }}>Seller</option>
                                                    <option value="2" {{ @$editData->availableFor == 2 ? 'selected' : '' }}>Both</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Column 2: Discount & Scheduling -->
                                <div class="col-lg-4 col-md-12">
                                    <div class="card mb-4" style="border: 1px solid #e2e8f0; border-radius: 12px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05); height: calc(100% - 24px);">
                                        <div class="card-header" style="background:#f8fafc; border-bottom: 1px solid #e2e8f0; border-radius: 12px 12px 0 0;">
                                            <h3 class="card-title" style="font-size:15px; font-weight:700; color:#0f172a; margin:0;">
                                                <i class="fas fa-calendar-alt" style="color:#6366f1; margin-right:6px;"></i> Discount & Schedule
                                            </h3>
                                        </div>
                                        <div class="card-body" style="padding: 20px;">
                                            <div class="form-group">
                                                <label for="discount_type" style="font-weight:600; color:#334155;">Discount Type <span class="text-danger">*</span></label>
                                                <select name="discount_type" id="discount_type" class="form-control select2" required style="width:100%;">
                                                    <option value="">Select Type</option>
                                                    <option value="1" {{ @$editData->discount_type == 1 ? 'selected' : '' }}>Percentage</option>
                                                    <option value="2" {{ @$editData->discount_type == 2 ? 'selected' : '' }}>Fixed Amount</option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="discount_amount" style="font-weight:600; color:#334155;">Discount Value <span class="text-danger">*</span></label>
                                                <input type="number" name="discount_amount" value="{{ @$editData->discount_amount }}" class="form-control" id="discount_amount" placeholder="Discount value" required min="0" step="0.01">
                                                <span style="color: red;">{{ $errors->has('discount_amount') ? $errors->first('discount_amount') : '' }}</span>
                                            </div>
                                            <div class="form-group">
                                                <label for="start_date" style="font-weight:600; color:#334155;">Start Date <span class="text-danger">*</span></label>
                                                <input type="date" name="start_date" value="{{ @$editData->start_date }}" class="form-control" id="start_date" required>
                                                <span style="color: red;">{{ $errors->has('start_date') ? $errors->first('start_date') : '' }}</span>
                                            </div>
                                            <div class="form-group mb-0">
                                                <label for="end_date" style="font-weight:600; color:#334155;">End Date <span class="text-danger">*</span></label>
                                                <input type="date" name="end_date" value="{{ @$editData->end_date }}" class="form-control" id="end_date" required>
                                                <span style="color: red;">{{ $errors->has('end_date') ? $errors->first('end_date') : '' }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Column 3: Requirements, Products & Save Action -->
                                <div class="col-lg-4 col-md-12">
                                    <div class="card mb-4" style="border: 1px solid #e2e8f0; border-radius: 12px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05);">
                                        <div class="card-header" style="background:#f8fafc; border-bottom: 1px solid #e2e8f0; border-radius: 12px 12px 0 0;">
                                            <h3 class="card-title" style="font-size:15px; font-weight:700; color:#0f172a; margin:0;">
                                                <i class="fas fa-cog" style="color:#6366f1; margin-right:6px;"></i> Requirements & Save
                                            </h3>
                                        </div>
                                        <div class="card-body" style="padding: 20px;">
                                            <div class="form-row">
                                                <div class="form-group col-md-12">
                                                    <label for="min_amount" style="font-weight:600; color:#334155;">Min Purchase Amount <span class="text-danger">*</span></label>
                                                    <input type="number" name="min_amount" value="{{ @$editData->min_amount }}" class="form-control" id="min_amount" placeholder="Min requirements" required min="0" step="0.01">
                                                    <span style="color: red;">{{ $errors->has('min_amount') ? $errors->first('min_amount') : '' }}</span>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label for="available" style="font-weight:600; color:#334155;">Total Available <span class="text-danger">*</span></label>
                                                    <input type="number" name="available" value="{{ @$editData->available }}" class="form-control" id="available" placeholder="Total available" required min="1">
                                                    <span style="color: red;">{{ $errors->has('available') ? $errors->first('available') : '' }}</span>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label for="canBeUsed" style="font-weight:600; color:#334155;">Limit Per User <span class="text-danger">*</span></label>
                                                    <input type="number" name="canBeUsed" value="{{ @$editData->canBeUsed }}" class="form-control" id="canBeUsed" placeholder="Limit per user" required min="1">
                                                    <span style="color: red;">{{ $errors->has('canBeUsed') ? $errors->first('canBeUsed') : '' }}</span>
                                                </div>
                                                <div class="form-group col-md-12">
                                                    <label for="products" style="font-weight:600; color:#334155;">Select Products (Optional)</label>
                                                    <select name="products[]" id="products" class="form-control select2" multiple="multiple" data-placeholder="Select products" style="width:100%;">
                                                        @foreach($products as $product)
                                                            <option value="{{ $product->id }}" 
                                                                {{ @$editData && in_array($product->id, $selectedProducts) ? 'selected' : '' }}>
                                                                {{ $product->name }} (SKU: {{ $product->sku }})
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div style="margin-top: 15px; padding-top: 15px; border-top: 1px solid #e2e8f0;">
                                                <button type="submit" class="btn btn-primary btn-block" style="background:#6366f1; border:none; padding:10px; border-radius:8px; font-weight:700; font-size:14px; display:flex; align-items:center; justify-content:center; gap:8px; width:100%;">
                                                    <i class="fas fa-save"></i> {{ @$editData ? 'Update' : 'Save' }} Coupon
                                                </button>
                                            </div>
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
                theme: 'bootstrap4',
                placeholder: "Select option"
            });

            $('#products').select2({
                theme: 'bootstrap4',
                placeholder: "Select products",
                allowClear: true
            });
            
            $('#myForm').validate({
                rules: {
                    name: {
                        required: true
                    },
                    promoCode: {
                        required: true
                    },
                    canBeUsed: {
                        required: true
                    },
                    available: {
                        required: true
                    },
                    availableFor: {
                        required: true
                    },
                    start_date: {
                        required: true
                    },
                    end_date: {
                        required: true
                    },
                    discount_type: {
                        required: true
                    },
                    discount_amount: {
                        required: true
                    },
                    min_amount: {
                        required: true
                    },
                    status: {
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