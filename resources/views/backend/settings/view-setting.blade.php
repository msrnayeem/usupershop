@extends('backend.layouts.master')
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6">
                        <h5 class="m-0"><i class='fas fa-hand-point-right'></i> Manage About</h5>
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li class="breadcrumb-item active">About</li>
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
                                    Settings List
                                    @if ($countSettings < 1)
                                        <a class="btn btn-sm btn-primary float-right" href="{{ route('settings.add') }}"><i
                                                class="fas fa-plus-circle"></i> Add Settings</a>
                                    @endif
                                </h5>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th width="6%">SN</th>
                                            <th>App Name</th>
                                            <th>Meta Title</th>
                                            <th>Meta Description</th>
                                            <th width="12%">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($settings as $key => $setting)
                                            <tr class="{{ $setting->id }}">
                                                <td>{{ $key + 1 }}</td>
                                                <td>{{ $setting->app_name }}</td>
                                                <td>{{ $setting->keywords }}</td>
                                                <td style="text-align: justify">{!! $setting->description !!}</td>
                                                <td>
                                                    <a title="Edit" class="btn btn-sm btn-info"
                                                        href="{{ route('settings.edit', $setting->id) }}"><i
                                                            class="fas fa-edit"></i> Edit</a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
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
@endsection
