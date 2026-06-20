@extends('backend.layouts.master')
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6">
                        <h5 class="m-0"><i class='fas fa-hand-point-right'></i> Manage Profile</h5>
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li class="breadcrumb-item active">Profiles</li>
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
                            <div class="card-header">
                                <h5>
                                    Edit Profile
                                    <a class="btn btn-sm btn-primary float-right" href="{{ route('profiles.view') }}"><i
                                            class="fas fa-list"></i> Your Profile</a>
                                </h5>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <form method="post" action="{{ route('profiles.update') }}" id="myForm"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-row">
                                        <div class="form-group col-md-4">
                                            <label for="name">Name</label>
                                            <input type="text" name="name" value="{{ $editData->name }}"
                                                class="form-control" id="name">
                                            <span
                                                style="color: red;">{{ $errors->has('name') ? $errors->first('name') : '' }}</span>
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label for="email">Email</label>
                                            <input type="email" name="email" value="{{ $editData->email }}"
                                                class="form-control" id="email">
                                            <span
                                                style="color: red;">{{ $errors->has('email') ? $errors->first('email') : '' }}</span>
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label for="mobile">Phone No</label>
                                            <input type="text" name="mobile" value="{{ $editData->mobile }}"
                                                class="form-control" id="mobile">
                                            <span
                                                style="color: red;">{{ $errors->has('mobile') ? $errors->first('mobile') : '' }}</span>
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label for="address">Address</label>
                                            <input type="text" name="address" value="{{ $editData->address }}"
                                                class="form-control" id="address">
                                            <span
                                                style="color: red;">{{ $errors->has('address') ? $errors->first('address') : '' }}</span>
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label for="gender">Gender</label>
                                            <select name="gender" class="form-control" id="gender">
                                                <option value="">Select Gender</option>
                                                <option value="Male" {{ $editData->gender == 'Male' ? 'selected' : '' }}>
                                                    Male</option>
                                                <option value="Female"
                                                    {{ $editData->gender == 'Female' ? 'selected' : '' }}>
                                                    Female
                                                </option>
                                            </select>
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label for="image">Image</label>
                                            <input type="file" name="image" id="image" class="form-control">
                                        </div>

                                        <div class="form-group col-md-2">
                                            <img id="showImage" style="width: 150px;height:160px; border:1px solid #000"
                                                src="{{ !empty($editData->image) ? url('public/upload/user_images/' . $editData->image) : url('upload/profile.jpg') }}">
                                        </div>

                                        <div class="form-group col-md-6" style="padding-top: 30px;">
                                            <input type="submit" value="update" class="btn btn-primary">
                                        </div>
                                    </div>
                                </form>
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

    <script type="text/javascript">
        $(function() {
            $('#myForm').validate({
                rules: {
                    usertype: {
                        required: true
                    },
                    name: {
                        required: true
                    },
                    email: {
                        required: true,
                        email: true,
                    },
                },
                messages: {
                    usertype: {
                        required: "Please select user role"
                    },
                    name: {
                        required: "Please enter username"
                    },
                    email: {
                        required: "Please enter a email address",
                        email: "Please enter a vaild email address"
                    },
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
