@extends('backend.layouts.master')
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        {{-- Page Header --}}
        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:22px;flex-wrap:wrap;gap:12px;">
            <div>
                <h1 style="font-size:22px;font-weight:800;color:#0f172a;margin:0;">
                    <i class="fas fa-user-edit" style="color:#6366f1;margin-right:8px;"></i>
                    @if (isset($editData)) Edit Seller @else Add Seller @endif
                </h1>
                <p style="color:#64748b;font-size:13px;margin:2px 0 0;">
                    <a href="{{ route('home') }}" style="color:#6366f1;text-decoration:none;">Home</a>
                    <span style="margin:0 6px;color:#cbd5e1;">/</span>
                    <a href="{{ route('sellers.view') }}" style="color:#6366f1;text-decoration:none;">Sellers</a>
                    <span style="margin:0 6px;color:#cbd5e1;">/</span>
                    @if (isset($editData)) Edit @else Add @endif
                </p>
            </div>
            <a class="btn btn-sm btn-primary" href="{{ route('sellers.view') }}" style="display:inline-flex;align-items:center;gap:6px;padding:9px 18px;background:#6366f1;border:none;border-radius:8px;font-size:13px;font-weight:600;color:#fff;text-decoration:none;">
                <i class="fas fa-list"></i> Sellers List
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
                                    Seller Profile & Settings
                                </span>
                            </div>
                            <div class="card-body">
                                <form method="post" action="{{ route('sellers.update', $editData->id) }}" id="myForm" enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-row">
                                        <div class="form-group col-md-4">
                                            <label for="name">Seller Name</label>
                                            <input type="text" name="name" value="{{ @$editData->name }}" class="form-control" id="name" placeholder="Enter full name" required>
                                            <span style="color: red;">{{ $errors->has('name') ? $errors->first('name') : '' }}</span>
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label for="email">Seller Email</label>
                                            <input type="email" name="email" value="{{ @$editData->email }}" class="form-control" id="email" placeholder="Enter email" required>
                                            <span style="color: red;">{{ $errors->has('email') ? $errors->first('email') : '' }}</span>
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label for="password">Seller Password (Optional)</label>
                                            <input type="password" name="password" class="form-control" id="password" placeholder="Enter password to change">
                                            <span style="color: red;">{{ $errors->has('password') ? $errors->first('password') : '' }}</span>
                                        </div>

                                        <div class="form-group col-md-3">
                                            <label for="mobile">Seller Mobile</label>
                                            <input type="text" name="mobile" value="{{ @$editData->mobile }}" class="form-control" id="mobile" placeholder="Enter mobile no" required>
                                            <span style="color: red;">{{ $errors->has('mobile') ? $errors->first('mobile') : '' }}</span>
                                        </div>

                                        <div class="form-group col-md-3">
                                            <label for="address">Seller Address</label>
                                            <input type="text" name="address" value="{{ @$editData->address }}" class="form-control" id="address" placeholder="Enter address">
                                            <span style="color: red;">{{ $errors->has('address') ? $errors->first('address') : '' }}</span>
                                        </div>

                                        <div class="form-group col-md-3">
                                            <label for="gender">Gender</label>
                                            <select name="gender" id="gender" class="form-control select2">
                                                <option value="">Select Gender</option>
                                                <option value="Male" {{ @$editData->gender == 'Male' ? 'selected' : '' }}>Male</option>
                                                <option value="Female" {{ @$editData->gender == 'Female' ? 'selected' : '' }}>Female</option>
                                            </select>
                                        </div>

                                        <div class="form-group col-md-3">
                                            <label for="usertype">User Type</label>
                                            <select name="usertype" id="usertype" class="form-control select2" required>
                                                <option value="">Select Usertype</option>
                                                <option value="seller" {{ @$editData->usertype == 'seller' ? 'selected' : '' }}>Seller</option>
                                                <option value="vendor" {{ @$editData->usertype == 'vendor' ? 'selected' : '' }}>Vendor</option>
                                                <option value="dropshipper" {{ @$editData->usertype == 'dropshipper' ? 'selected' : '' }}>Dropshipper</option>
                                            </select>
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label for="status">User Status</label>
                                            <select name="status" id="status" class="form-control select2" required>
                                                <option value="2" {{ @$editData->status == 2 ? 'selected' : '' }}>Active</option>
                                                <option value="1" {{ @$editData->status == 1 ? 'selected' : '' }}>Inactive</option>
                                            </select>
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label for="shop_name">Seller Shop Name</label>
                                            <input type="text" name="shop_name" value="{{ @$editData->shop_name }}" class="form-control" id="shop_name" placeholder="Enter shop name">
                                            <span style="color: red;">{{ $errors->has('shop_name') ? $errors->first('shop_name') : '' }}</span>
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label for="subscription_plan">Seller Subscription Plan (Y-M-D)</label>
                                            <input type="date" name="subscription_plan" value="{{ isset($createDate) ? date('Y-m-d', strtotime($createDate)) : date('Y-m-d') }}" class="form-control" id="subscription_plan">
                                            <span style="color: red;">{{ $errors->has('subscription_plan') ? $errors->first('subscription_plan') : '' }}</span>
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label for="image">Seller Image</label>
                                            <input type="file" name="image" id="image" class="form-control">
                                        </div>

                                        <div class="form-group col-md-2" style="display:flex;align-items:flex-end;">
                                            <img id="showImage" style="width: 80px;height:80px;border-radius:8px;border:1px solid #e2e8f0;object-fit:cover;"
                                                src="{{ !empty($editData->image) ? url('public/upload/user_images/' . $editData->image) : url('public/upload/profile.jpg') }}">
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label for="logo">Seller Shop Logo</label>
                                            <input type="file" name="logo" id="logo" class="form-control">
                                        </div>

                                        <div class="form-group col-md-2" style="display:flex;align-items:flex-end;">
                                            <img id="showLogo" style="width: 80px;height:80px;border-radius:8px;border:1px solid #e2e8f0;object-fit:cover;"
                                                src="{{ !empty($editData->logo) ? url('public/upload/user_images/' . $editData->logo) : url('public/upload/profile.jpg') }}">
                                        </div>

                                        <div class="form-group col-md-12 text-right" style="margin-top:20px;border-top:1px solid #e2e8f0;padding-top:20px;">
                                            <button type="submit" class="btn btn-primary" style="background:#6366f1;border:none;padding:9px 24px;border-radius:8px;font-weight:600;">
                                                <i class="fas fa-save mr-1"></i> Update Details
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

            // Live preview image
            $('#image').change(function(e) {
                var reader = new FileReader();
                reader.onload = function(event) {
                    $('#showImage').attr('src', event.target.result);
                };
                reader.readAsDataURL(e.target.files[0]);
            });

            // Live preview logo
            $('#logo').change(function(e) {
                var reader = new FileReader();
                reader.onload = function(event) {
                    $('#showLogo').attr('src', event.target.result);
                };
                reader.readAsDataURL(e.target.files[0]);
            });

            $('#myForm').validate({
                rules: {
                    name: {
                        required: true
                    },
                    email: {
                        required: true,
                        email: true
                    },
                    mobile: {
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
