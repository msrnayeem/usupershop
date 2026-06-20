@extends('backend.seller.seller-master')
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6">
                        <h5 class="m-0"><i class='fas fa-hand-point-right'></i> Manage Seller Users</h5>
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('seller.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active">Users</li>
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
                                    Edit User
                                    <a class="btn btn-sm btn-primary float-right" href="{{ route('users.view') }}"><i
                                            class="fas fa-list"></i> User List</a>
                                </h5>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <form method="post" action="{{ route('users.update', $editData->id) }}" id="myForm">
                                    @csrf
                                    <div class="form-row">
                                        <div class="form-group col-md-4">
                                            <label for="role">User Role</label>
                                            <select name="role" id="role" class="form-control" id="role">
                                                <option value="">Select Role</option>
                                                <option value="admin" {{ $editData->role == 'admin' ? 'selected' : '' }}>
                                                    Admin</option>
                                                <option value="user" {{ $editData->role == 'user' ? 'selected' : '' }}>
                                                    User
                                                </option>
                                            </select>
                                        </div>

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

                                        <!-- <div class="form-group col-md-4">
                                            <label for="password">Password</label>
                                            <input type="password" name="password" class="form-control" id="password">
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label for="password">Confirm Password</label>
                                            <input type="password" name="password2" class="form-control" id="password2">
                                        </div> -->

                                        <div class="form-group col-md-6">
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
