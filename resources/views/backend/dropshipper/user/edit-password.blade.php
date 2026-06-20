@extends('backend.dropshipper.dropshipper-master')
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6">
                        <h5 class="m-0"><i class='fas fa-hand-point-right'></i> Manage Password</h5>
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li class="breadcrumb-item active">Password</li>
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
                                <h5>Change Password</h5>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <form method="post" action="{{ route('dropshipper.password.update') }}" id="myForm">
                                    @csrf
                                    <div class="form-row">
                                        <div class="form-group col-md-4">
                                            <label for="current_password">Current Password</label>
                                            <input type="password" name="current_password" class="form-control"
                                                id="current_password">
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label for="new_password">New Password</label>
                                            <input type="password" name="new_password" class="form-control"
                                                id="new_password">
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label for="again_new_password">Again New Password</label>
                                            <input type="password" name="again_new_password" class="form-control">
                                        </div>

                                        <div class="form-group col-md-6">
                                            <input type="submit" value="Update" class="btn btn-primary">
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

                    current_password: {
                        required: true,
                    },
                    new_password: {
                        required: true,
                        minlength: 6
                    },
                    again_new_password: {
                        required: true,
                        equalTo: '#new_password'
                    },
                },
                messages: {
                    current_password: {
                        required: "Please provide current password",
                    },
                    new_password: {
                        required: "Please provide new password",
                        minlength: "Your password must be at least 6 characters long"
                    },
                    again_new_password: {
                        required: "Please enter new confirm password",
                        equalTo: "Confirm new password does not match"
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
