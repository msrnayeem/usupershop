@extends('backend.layouts.master')
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6">
                        <h5 class="m-0"><i class='fas fa-hand-point-right'></i> Profile Vendors</h5>
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li class="breadcrumb-item active">Vendors</li>
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
                                <div class="msg"></div>
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped nowrap dt-responsive"
                                        style="width: 100%">
                                        <thead>
                                            <tr>
                                               
                                                <th>NID Number</th>
                                                <th>Birth Date</th>
                                                <th>Front Image</th>
                                                <th>Back Image</th>
                                                <th width="12%">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if ($profiles!=null)
                                                <tr>
                                                    <td>{{ $profiles->nid_no ?? '' }}</td>
                                                    <td>{{ $profiles->birthdate ?? '' }}</td>
                                                    <td>
                                                        <img src="{{ asset('public/upload/profile_verify/' . ($profiles->front_image ?? 'default.jpg')) }}" 
                                                             class="img-responsive"
                                                             alt="NID Front" style="width:60px;"
                                                             onerror="this.onerror=null;this.src='{{ asset('frontend/assets/images/no-image.png') }}'">
                                                    </td>
                                                    <td>
                                                        <img src="{{ asset('public/upload/profile_verify/' . ($profiles->back_image ?? 'default.jpg')) }}" 
                                                             class="img-responsive"
                                                             alt="NID Back" style="width:60px;"
                                                             onerror="this.onerror=null;this.src='{{ asset('frontend/assets/images/no-image.png') }}'">
                                                    </td>
                                                    <td>
                                                        <a href="{{ route('vendors_profile.delete',$profiles->user_id) }}" class="btn btn-sm btn-danger">Delete</a>
                                                    </td>
                                                </tr>
                                            @endif
                                        </tbody>
                                    </table>
                                </div>

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

    <script></script>
@endsection
