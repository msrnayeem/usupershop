@extends('backend.dropshipper.dropshipper-master')
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6">
                        <h5 class="m-0"><i class='fas fa-hand-point-right'></i> Manage Dropshipper Profile</h5>
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('dropshipper.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active">Dropshipper Profile</li>
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
                    <section class="col-md-4 offset-md-4">
                        <!-- Profile Image -->
                        <div class="card card-primary card-outline">
                            <div class="card-body box-profile">
                                <div class="text-center">
                                    <img class="profile-user-img img-fluid img-circle"
                                        src="{{ !empty($user->image) ? url('public/upload/user_images/' . $user->image) : url('public/upload/profile.jpg') }}"
                                        alt="User profile picture">
                                </div>
                                <h3 class="profile-username text-center">{{ $user->name }}</h3>
                                <p class="text-muted text-center">{{ $user->address }}
                                <p>
                                <table width="100%" class="table table-bordered">
                                    <tbody>
                                        <tr>
                                            <td>Mobile No</td>
                                            <td>{{ $user->mobile }}</td>
                                        </tr>
                                        <tr>
                                            <td>Shop Name</td>
                                            <td>{{ $user->shop_name }}</td>
                                        </tr>
                                        <tr>
                                            <td>Account Type</td>
                                            <td>{{ $user->account_type }}</td>
                                        </tr>
                                        <tr>
                                            <td>Comission(%)</td>
                                            <td>{{ $user->commission }}%</td>
                                        </tr>
                                        <tr>
                                            <td>Refer Code</td>
                                            <td>{{ $user->code }}</td>
                                        </tr>
                                        <tr>
                                            <td>Email</td>
                                            <td>{{ $user->email }}</td>
                                        </tr>
                                        <tr>
                                            <td>Gender</td>
                                            <td>{{ $user->gender }}</td>
                                        </tr>
                                        <tr>
                                            <td>Create Date</td>
                                            <td>{{ $user->created_at }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                                <a href="{{ route('dropshipper.edit.profile') }}" class="btn btn-primary btn-block mt-3"><b>Edit
                                        Profile</b></a>
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
@endsection
