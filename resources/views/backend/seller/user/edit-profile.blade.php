@extends('backend.seller.seller-master')
@section('content')
    <div class="content-wrapper">
        {{-- Page Header --}}
        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:22px;flex-wrap:wrap;gap:12px;">
            <div>
                <h1 style="font-size:22px;font-weight:800;color:#0f172a;margin:0;">
                    <i class="fas fa-user-edit" style="color:#6366f1;margin-right:8px;"></i>
                    Edit Profile
                </h1>
                <p style="color:#64748b;font-size:13px;margin:2px 0 0;">
                    <a href="{{ route('seller.dashboard') }}" style="color:#6366f1;text-decoration:none;">Dashboard</a>
                    <span style="margin:0 6px;color:#cbd5e1;">/</span>
                    Edit Profile
                </p>
            </div>
            <a href="{{ route('sellers.view.profile') }}" class="btn btn-sm btn-secondary" style="display:inline-flex;align-items:center;gap:6px;padding:9px 18px;border-radius:8px;font-size:13px;font-weight:600;text-decoration:none;">
                <i class="fas fa-user"></i> View Profile
            </a>
        </div>

        <section class="content">
            <div class="container-fluid">
                <div class="card">
                    <div class="card-header">
                        <span class="card-title font-weight-bold text-dark"><i class="fas fa-edit mr-1 text-primary"></i> Update Your Information</span>
                    </div>
                    <div class="card-body">
                        <form method="post" action="{{ route('sellers.update.profile') }}" id="myForm" enctype="multipart/form-data">
                            @csrf
                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label for="name">Full Name</label>
                                    <input type="text" name="name" value="{{ $editData->name }}" class="form-control" id="name" placeholder="Your full name">
                                    <span style="color:red;">{{ $errors->has('name') ? $errors->first('name') : '' }}</span>
                                </div>

                                <div class="form-group col-md-4">
                                    <label for="email">Email <span style="background:#f0f0f0;color:#888;font-size:11px;padding:1px 6px;border-radius:6px;font-weight:700;">🔒 Fixed</span></label>
                                    <input type="email" name="email" value="{{ $editData->email }}" class="form-control" id="email" readonly>
                                </div>

                                <div class="form-group col-md-4">
                                    <label for="mobile">Phone No <span style="background:#f0f0f0;color:#888;font-size:11px;padding:1px 6px;border-radius:6px;font-weight:700;">🔒 Fixed</span></label>
                                    <input type="text" name="mobile" value="{{ $editData->mobile }}" class="form-control" id="mobile" readonly>
                                </div>

                                <div class="form-group col-md-4">
                                    <label for="shop_name">Shop Name</label>
                                    <input type="text" name="shop_name" value="{{ $editData->shop_name ?? '' }}" class="form-control" id="shop_name" placeholder="Your shop name">
                                    <span style="color:red;">{{ $errors->has('shop_name') ? $errors->first('shop_name') : '' }}</span>
                                </div>

                                <div class="form-group col-md-4">
                                    <label for="address">Address</label>
                                    <input type="text" name="address" value="{{ $editData->address }}" class="form-control" id="address" placeholder="Your address">
                                    <span style="color:red;">{{ $errors->has('address') ? $errors->first('address') : '' }}</span>
                                </div>

                                <div class="form-group col-md-4">
                                    <label for="gender">Gender</label>
                                    <select name="gender" class="form-control" id="gender">
                                        <option value="">Select Gender</option>
                                        <option value="Male" {{ $editData->gender == 'Male' ? 'selected' : '' }}>Male</option>
                                        <option value="Female" {{ $editData->gender == 'Female' ? 'selected' : '' }}>Female</option>
                                    </select>
                                </div>

                                <div class="form-group col-md-4">
                                    <label for="image">Profile Photo</label>
                                    <input type="file" name="image" id="image" class="form-control">
                                </div>

                                <div class="form-group col-md-2 d-flex align-items-end">
                                    <img id="showImage" style="width:80px;height:80px;border-radius:8px;object-fit:cover;border:2px solid #e2e8f0;"
                                        src="{{ !empty($editData->image) ? url('public/upload/user_images/' . $editData->image) : url('upload/profile.jpg') }}">
                                </div>

                                <div class="form-group col-md-4">
                                    <label for="logo">Shop Logo</label>
                                    <input type="file" name="logo" id="logo" class="form-control">
                                </div>

                                <div class="form-group col-md-2 d-flex align-items-end">
                                    <img id="showLogo" style="width:80px;height:80px;border-radius:8px;object-fit:contain;border:2px solid #e2e8f0;background:#f8fafc;padding:6px;"
                                        src="{{ !empty($editData->logo) ? url('public/upload/user_images/' . $editData->logo) : url('upload/profile.jpg') }}">
                                </div>

                                <div class="form-group col-12 mt-2">
                                    <button type="submit" class="btn btn-primary px-5" style="background:#6366f1;border:none;border-radius:8px;font-weight:700;padding:10px 28px;">
                                        <i class="fas fa-save mr-1"></i> Update Profile
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <script type="text/javascript">
        $(function() {
            $('#myForm').validate({
                rules: {
                    name: { required: true },
                    email: { required: true, email: true },
                },
                messages: {
                    name: { required: "Please enter username" },
                    email: { required: "Please enter an email address", email: "Please enter a valid email address" },
                },
                errorElement: 'span',
                errorPlacement: function(error, element) {
                    error.addClass('invalid-feedback');
                    element.closest('.form-group').append(error);
                },
                highlight: function(element) { $(element).addClass('is-invalid'); },
                unhighlight: function(element) { $(element).removeClass('is-invalid'); }
            });

            $('#image').on('change', function() {
                let reader = new FileReader();
                reader.onload = function(e) { $('#showImage').attr('src', e.target.result); };
                reader.readAsDataURL(this.files[0]);
            });

            $('#logo').on('change', function() {
                let reader = new FileReader();
                reader.onload = function(e) { $('#showLogo').attr('src', e.target.result); };
                reader.readAsDataURL(this.files[0]);
            });
        });
    </script>
@endsection
