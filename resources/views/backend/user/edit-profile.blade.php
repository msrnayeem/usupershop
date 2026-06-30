@extends('backend.layouts.master')
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        {{-- Page Header --}}
        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:22px;flex-wrap:wrap;gap:12px;">
            <div>
                <h1 style="font-size:22px;font-weight:800;color:#0f172a;margin:0;">
                    <i class="fas fa-user-edit" style="color:#6366f1;margin-right:8px;"></i>
                    Edit Profile
                </h1>
                <p style="color:#64748b;font-size:13px;margin:2px 0 0;">
                    <a href="{{ route('home') }}" style="color:#6366f1;text-decoration:none;">Home</a>
                    <span style="margin:0 6px;color:#cbd5e1;">/</span>
                    <a href="{{ route('profiles.view') }}" style="color:#6366f1;text-decoration:none;">Profile</a>
                    <span style="margin:0 6px;color:#cbd5e1;">/</span>
                    Edit
                </p>
            </div>
            <a class="btn btn-sm btn-primary" href="{{ route('profiles.view') }}" style="display:inline-flex;align-items:center;gap:6px;padding:9px 18px;background:#6366f1;border:none;border-radius:8px;font-size:13px;font-weight:600;color:#fff;text-decoration:none;">
                <i class="fas fa-user"></i> My Profile
            </a>
        </div>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <section class="col-md-12">
                        <form method="post" action="{{ route('profiles.update') }}" id="myForm" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <!-- Column 1: Personal Details -->
                                <div class="col-lg-4 col-md-12">
                                    <div class="card mb-4" style="border: 1px solid #e2e8f0; border-radius: 12px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05); height: calc(100% - 24px);">
                                        <div class="card-header" style="background:#f8fafc; border-bottom: 1px solid #e2e8f0; border-radius: 12px 12px 0 0;">
                                            <h3 class="card-title" style="font-size:15px; font-weight:700; color:#0f172a; margin:0;">
                                                <i class="fas fa-user-tie" style="color:#6366f1; margin-right:6px;"></i> Personal Details
                                            </h3>
                                        </div>
                                        <div class="card-body" style="padding: 20px;">
                                            <div class="form-group">
                                                <label for="name" style="font-weight:600; color:#334155;">Name <span class="text-danger">*</span></label>
                                                <input type="text" name="name" value="{{ $editData->name }}" class="form-control" id="name" required>
                                                <span style="color: red;">{{ $errors->has('name') ? $errors->first('name') : '' }}</span>
                                            </div>
                                            <div class="form-group">
                                                <label for="email" style="font-weight:600; color:#334155;">Email <span class="text-danger">*</span></label>
                                                <input type="email" name="email" value="{{ $editData->email }}" class="form-control" id="email" required>
                                                <span style="color: red;">{{ $errors->has('email') ? $errors->first('email') : '' }}</span>
                                            </div>
                                            <div class="form-group mb-0">
                                                <label for="mobile" style="font-weight:600; color:#334155;">Phone No <span class="text-danger">*</span></label>
                                                <input type="text" name="mobile" value="{{ $editData->mobile }}" class="form-control" id="mobile" required>
                                                <span style="color: red;">{{ $errors->has('mobile') ? $errors->first('mobile') : '' }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Column 2: Bio & Location -->
                                <div class="col-lg-4 col-md-12">
                                    <div class="card mb-4" style="border: 1px solid #e2e8f0; border-radius: 12px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05); height: calc(100% - 24px);">
                                        <div class="card-header" style="background:#f8fafc; border-bottom: 1px solid #e2e8f0; border-radius: 12px 12px 0 0;">
                                            <h3 class="card-title" style="font-size:15px; font-weight:700; color:#0f172a; margin:0;">
                                                <i class="fas fa-map-marker-alt" style="color:#6366f1; margin-right:6px;"></i> Bio & Location
                                            </h3>
                                        </div>
                                        <div class="card-body" style="padding: 20px;">
                                            <div class="form-group">
                                                <label for="address" style="font-weight:600; color:#334155;">Address</label>
                                                <input type="text" name="address" value="{{ $editData->address }}" class="form-control" id="address">
                                                <span style="color: red;">{{ $errors->has('address') ? $errors->first('address') : '' }}</span>
                                            </div>
                                            <div class="form-group mb-0">
                                                <label for="gender" style="font-weight:600; color:#334155;">Gender</label>
                                                <select name="gender" class="form-control select2" id="gender" style="width:100%;">
                                                    <option value="">Select Gender</option>
                                                    <option value="Male" {{ $editData->gender == 'Male' ? 'selected' : '' }}>Male</option>
                                                    <option value="Female" {{ $editData->gender == 'Female' ? 'selected' : '' }}>Female</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Column 3: Profile Photo & Action -->
                                <div class="col-lg-4 col-md-12">
                                    <div class="card mb-4" style="border: 1px solid #e2e8f0; border-radius: 12px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05); height: calc(100% - 24px); display:flex; flex-direction:column; justify-content:space-between;">
                                        <div>
                                            <div class="card-header" style="background:#f8fafc; border-bottom: 1px solid #e2e8f0; border-radius: 12px 12px 0 0;">
                                                <h3 class="card-title" style="font-size:15px; font-weight:700; color:#0f172a; margin:0;">
                                                    <i class="fas fa-image" style="color:#6366f1; margin-right:6px;"></i> Profile Photo
                                                </h3>
                                            </div>
                                            <div class="card-body" style="padding: 20px;">
                                                <div style="display:flex; align-items:center; gap:16px; margin-bottom:12px;">
                                                    <div style="position:relative;">
                                                        <img id="showImage" style="width: 80px; height:80px; border-radius:12px; border:2px solid #e2e8f0; object-fit:cover;"
                                                            src="{{ !empty($editData->image) ? url('public/upload/user_images/' . $editData->image) : url('upload/profile.jpg') }}">
                                                    </div>
                                                    <div style="flex:1;">
                                                        <label for="image" style="font-weight:600; color:#334155; margin-bottom:4px;">Upload Photo</label>
                                                        <input type="file" name="image" id="image" class="form-control" style="font-size: 13px; padding: 4px 10px; height: auto;">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div style="padding: 20px; border-top: 1px solid #e2e8f0; background: #f8fafc; border-radius: 0 0 12px 12px;">
                                            <button type="submit" class="btn btn-primary btn-block" style="background:#6366f1; border:none; padding:12px; border-radius:8px; font-weight:700; font-size:14px; display:flex; align-items:center; justify-content:center; gap:8px; width:100%;">
                                                <i class="fas fa-save"></i> Update Profile
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

            // Live preview
            $('#image').change(function(e) {
                var reader = new FileReader();
                reader.onload = function(event) {
                    $('#showImage').attr('src', event.target.result);
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
