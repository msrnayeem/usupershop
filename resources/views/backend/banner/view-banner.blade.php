@extends('backend.layouts.master')
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6">
                        <h5 class="m-0"><i class='fas fa-hand-point-right'></i> Manage Banner</h5>
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li class="breadcrumb-item active">Banner</li>
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
                                    Banner List
                                    @if ($countBanner < 1)
                                        <a class="btn btn-sm btn-primary float-right" href="{{ route('banners.add') }}"><i
                                                class="fas fa-plus-circle"></i> Add Banner</a>
                                    @endif
                                </h5>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th width="6%">SN</th>
                                            <th>Home Page Small Banner Image One</th>
                                            <th>Home Page Small Banner Image Two</th>
                                            <th>Home Page Category Banner Image</th>
                                            <th>Shop Page Banner Image</th>
                                            <th width="12%">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if($allData!=null)
                                            @foreach ($allData as $key => $logo)
                                            <tr class="{{ $logo->id }}">
                                                <td>{{ $key + 1 }}</td>
                                                <td>
                                                    <img style="width: 60px;height:40px"
                                                        src="{{ !empty($logo->banner_small_image_one) ? url('upload/banner/' . $logo->banner_small_image_one) : url('frontend/no-image-icon.jpg') }}">
                                                </td>
                                                <td>
                                                    <img style="width: 60px;height:40px"
                                                        src="{{ !empty($logo->banner_small_image_two) ? url('upload/banner/' . $logo->banner_small_image_two) : url('frontend/no-image-icon.jpg') }}">
                                                </td>
                                               
                                                <td>
                                                    <img style="width: 60px;height:40px"
                                                        src="{{ !empty($logo->category_banner_image) ? url('upload/banner/' . $logo->category_banner_image) : url('frontend/no-image-icon.jpg') }}">
                                                </td>
                                              
                                                <td>
                                                    <img style="width: 60px;height:40px"
                                                        src="{{ !empty($logo->shop_page_banner) ? url('upload/banner/' . $logo->shop_page_banner) : url('frontend/no-image-icon.jpg') }}">
                                                </td>
                                                <td>
                                                    <a title="Edit" class="btn btn-sm btn-info"
                                                        href="{{ route('banners.edit', $logo->id) }}"><i
                                                            class="fas fa-edit"></i> Edit</a>
                                                   
                                                </td>
                                            </tr>
                                        @endforeach
                                        @endif
                                      
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
