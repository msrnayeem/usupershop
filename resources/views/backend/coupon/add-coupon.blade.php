@extends('backend.layouts.master')
@section('content')
    <style>
        .select2-container--default .select2-selection--single,
        .select2-container--default .select2-selection--multiple {
            height: 38px;
        }

        .select2-container--default .select2-selection--multiple .select2-selection__choice {
            background-color: #007bff;
            border-color: #006fe6;
            color: #fff;
            padding: 0 10px;
            margin-top: 6px;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow b {
            margin-left: -5px;
            margin-top: 5px;
        }
        
        .select2-container--default .select2-selection--multiple .select2-selection__choice__remove {
            color: #fff;
            margin-right: 5px;
        }
    </style>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6">
                        <h5 class="m-0"><i class='fas fa-hand-point-right'></i> Add Coupon</h5>
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li class="breadcrumb-item active">Coupons</li>
                            &nbsp;&nbsp;&nbsp;
                            <a class="btn btn-sm btn-primary float-right" href="{{ route('coupons.view') }}"><i
                                    class="fas fa-list"></i> All Coupon</a>
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
                        <!-- Custom tabs (Charts with tabs)-->
                        <div class="card">
                            <div class="card-body">
                                <form method="post"
                                    action="{{ @$editData ? route('coupons.update', $editData->id) : route('coupons.store') }}"
                                    id="myForm">
                                    @csrf
                                    <div class="form-row">
                                        <div class="form-group col-md-4">
                                            <label for="name">Coupon Name</label>
                                            <input type="text" name="name" value="{{ @$editData->name }}"
                                                class="form-control" id="name" placeholder="Enter title">
                                            <span
                                                style="color: red;">{{ $errors->has('name') ? $errors->first('name') : '' }}</span>
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label for="promoCode">Promo Code</label>
                                            <input type="text" name="promoCode" value="{{ @$editData->promoCode }}"
                                                class="form-control" id="promoCode" placeholder="Enter code">
                                            <span
                                                style="color: red;">{{ $errors->has('promoCode') ? $errors->first('promoCode') : '' }}</span>
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label for="canBeUsed">Can be Used</label>
                                            <input type="number" name="canBeUsed" value="{{ @$editData->canBeUsed }}"
                                                class="form-control" id="canBeUsed" placeholder="Enter use time">
                                            <span
                                                style="color: red;">{{ $errors->has('canBeUsed') ? $errors->first('canBeUsed') : '' }}</span>
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label for="available">Availability</label>
                                            <input type="number" name="available" value="{{ @$editData->available }}"
                                                class="form-control" id="available" placeholder="Enter title">
                                            <span
                                                style="color: red;">{{ $errors->has('available') ? $errors->first('available') : '' }}</span>
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label for="availableFor">Available For</label>
                                            <select name="availableFor" id="availableFor" class="form-control select2">
                                                @if (!empty($editData))
                                                    <option value="0"
                                                        {{ @$editData->availableFor == 0 ? 'Selected' : '' }}>Customer
                                                    </option>
                                                    <option value="1"
                                                        {{ @$editData->availableFor == 1 ? 'Selected' : '' }}>Staff
                                                    </option>
                                                    <option value="3"
                                                        {{ @$editData->availableFor == 3 ? 'Selected' : '' }}>Vendor
                                                    </option>
                                                    <option value="4"
                                                        {{ @$editData->availableFor == 4 ? 'Selected' : '' }}>Seller
                                                    </option>
                                                    <option value="2"
                                                        {{ @$editData->availableFor == 2 ? 'Selected' : '' }}>Both</option>
                                                @else
                                                    <option value="0">Customer</option>
                                                    <option value="1">Staff</option>
                                                    <option value="3">Vendor</option>
                                                    <option value="4">Seller</option>
                                                    <option value="2">Both</option>
                                                @endif
                                            </select>
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label for="start_date">Start Date</label>
                                            <input type="date" name="start_date" value="{{ @$editData->start_date }}"
                                                class="form-control" id="start_date">
                                            <span
                                                style="color: red;">{{ $errors->has('start_date') ? $errors->first('start_date') : '' }}</span>
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label for="end_date">End Date</label>
                                            <input type="date" name="end_date" value="{{ @$editData->end_date }}"
                                                class="form-control" id="end_date">
                                            <span
                                                style="color: red;">{{ $errors->has('end_date') ? $errors->first('end_date') : '' }}</span>
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label for="discount_type">Discount Type</label>
                                            <select name="discount_type" id="discount_type" class="form-control select2">
                                                @if (!empty($editData))
                                                    <option value="">Select Type</option>
                                                    <option value="1"
                                                        {{ @$editData->discount_type == 1 ? 'Selected' : '' }}>Percentage
                                                    </option>
                                                    <option value="2"
                                                        {{ @$editData->discount_type == 2 ? 'Selected' : '' }}>Fixed Amount
                                                    </option>
                                                @else
                                                    <option value="">Select Type</option>
                                                    <option value="1">Percentage</option>
                                                    <option value="2">Fixed Amount</option>
                                                @endif

                                                <span
                                                    style="color: red;">{{ $errors->has('discount_type') ? $errors->first('discount_type') : '' }}</span>

                                            </select>
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label for="discount_amount">Discount Amount</label>
                                            <input type="text" name="discount_amount"
                                                value="{{ @$editData->discount_amount }}" class="form-control"
                                                id="discount_amount" placeholder="Enter discount">
                                            <span
                                                style="color: red;">{{ $errors->has('discount_amount') ? $errors->first('discount_amount') : '' }}</span>
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label for="min_amount">Min Amount</label>
                                            <input type="text" name="min_amount" value="{{ @$editData->min_amount }}"
                                                class="form-control" id="min_amount" placeholder="Enter min amount">
                                            <span
                                                style="color: red;">{{ $errors->has('min_amount') ? $errors->first('min_amount') : '' }}</span>
                                        </div>

                                        <!-- New Product Selection Field -->
                                        <div class="form-group col-md-4">
                                            <label for="products">Select Products (Optional)</label>
                                            <select name="products[]" id="products" class="form-control select2" multiple="multiple" data-placeholder="Select products">
                                                @foreach($products as $product)
                                                    <option value="{{ $product->id }}" 
                                                        {{ @$editData && in_array($product->id, $selectedProducts) ? 'selected' : '' }}>
                                                        {{ $product->name }} (SKU: {{ $product->sku }})
                                                    </option>
                                                @endforeach
                                            </select>
                                            <small class="form-text text-muted">Leave empty to apply coupon to all products</small>
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label for="status">Publication Status</label>
                                            <select name="status" id="status" class="form-control select2">
                                                @if (!empty($editData))
                                                    <option value="1"
                                                        {{ @$editData->status == 1 ? 'Selected' : '' }}>
                                                        Active</option>
                                                    <option value="0"
                                                        {{ @$editData->status == 0 ? 'Selected' : '' }}>
                                                        Inactive</option>
                                                @else
                                                    <option value="1">Active</option>
                                                    <option value="0">Inactive</option>
                                                @endif

                                                <span
                                                    style="color: red;">{{ $errors->has('status') ? $errors->first('status') : '' }}</span>

                                            </select>
                                        </div>

                                        <div class="form-group offset-md-8 col-md-4 text-right">
                                            <button type="submit" class="btn btn-primary"><i
                                                    class="fas fa-check-double"></i>
                                                {{ @$editData ? 'Update' : 'Submit' }}</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <!-- /.card-body -->
                        </div>
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

    <script type="text/javascript">
        $(function() {
            // Initialize Select2 for products
            $('#products').select2({
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
                    },
                },
                messages: {
                    // Add custom messages if needed
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