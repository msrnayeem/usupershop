@extends('backend.layouts.master')
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6">
                        <h5 class="m-0"><i class='fas fa-hand-point-right'></i> Manage Logo</h5>
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li class="breadcrumb-item active">Logo</li>
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
                                    logo List
                                    @if ($countLogo < 1)
                                        <a class="btn btn-sm btn-primary float-right" href="{{ route('logos.add') }}"><i
                                                class="fas fa-plus-circle"></i> Add Logo</a>
                                    @endif
                                </h5>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th width="6%">SN</th>
                                            <th>Logo Name</th>
                                            <th>Logo Image</th>
                                            <th width="12%">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($allData as $key => $logo)
                                            <tr class="{{ $logo->id }}">
                                                <td>{{ $key + 1 }}</td>
                                                <td>{{ $logo->name }}</td>
                                                <td>
                                                    <img style="width: 60px;height:40px"
                                                        src="{{ !empty($logo->image) ? url('upload/logo_image/' . $logo->image) : url('frontend/no-image-icon.jpg') }}">
                                                </td>
                                                <td>
                                                    <a title="Edit" class="btn btn-sm btn-info"
                                                        href="{{ route('logos.edit', $logo->id) }}"><i
                                                            class="fas fa-edit"></i> Edit</a>
                                                    <a title="Delete" id="delete" class="btn btn-sm btn-danger"
                                                        href="{{ route('logos.delete') }}" data-token="{{ csrf_token() }}"
                                                        data-id="{{ $logo->id }}"><i class="fas fa-trash"></i> Delete</a>
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
