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
                                    @if (isset($editData))
                                        Edit Banner
                                    @else
                                        Add Banner
                                    @endif
                                    <a class="btn btn-sm btn-primary float-right" href="{{ route('banners.view') }}"><i
                                            class="fas fa-list"></i> Banner List</a>
                                </h5>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <form method="post"
                                    action="{{ @$editData ? route('banners.update', $editData->id) : route('banners.store') }}"
                                    id="myForm" enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-row">
                                        <div class="form-group col-md-4">
                                            <label>Home Page Banner Small Image One <span class="text-danger">(Must upload 475px x 375px image)</span></label>
                                            <input type="file" name="banner_small_image_one" id="banner_small_image_one" class="form-control">
                                        </div>
                                        <div class="form-group col-md-2">
                                            <img id="showImage_banner_small_image_one" style="width: 100px;height:105px; border:1px solid #000"
                                                src="{{ !empty($editData->banner_small_image_one) ? url('upload/banner/' . $editData->banner_small_image_one) : url('frontend/no-image-icon.jpg') }}">
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label>Home Page Banner Small Image Two <span class="text-danger">(Must upload 475px x 375px image)</span></label>
                                            <input type="file" name="banner_small_image_two" id="banner_small_image_two" class="form-control">
                                        </div>
                                        <div class="form-group col-md-2">
                                            <img id="showImage_banner_small_image_two" style="width: 100px;height:105px; border:1px solid #000"
                                                src="{{ !empty($editData->banner_small_image_two) ? url('upload/banner/' . $editData->banner_small_image_two) : url('frontend/no-image-icon.jpg') }}">
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label>Category Banner Image <span class="text-danger">(Must upload 1500px x 130px image)</span></label>
                                            <input type="file" name="category_banner_image" id="category_banner_image" class="form-control">
                                        </div>
                                        <div class="form-group col-md-2">
                                            <img id="showImage_category_banner_image" style="width: 100px;height:105px; border:1px solid #000"
                                                src="{{ !empty($editData->category_banner_image) ? url('upload/banner/' . $editData->category_banner_image) : url('frontend/no-image-icon.jpg') }}">
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label>Shop Page Banner Image Two <span class="text-danger">(Must upload 1115px x 130px image)</span></label>
                                            <input type="file" name="shop_page_banner" id="shop_page_banner" class="form-control">
                                        </div>
                                        <div class="form-group col-md-2">
                                            <img id="showImage_shop_page_banner" style="width: 100px;height:105px; border:1px solid #000"
                                                src="{{ !empty($editData->shop_page_banner) ? url('upload/banner/' . $editData->shop_page_banner) : url('frontend/no-image-icon.jpg') }}">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <button type="submit"
                                                class="btn btn-primary">{{ @$editData ? 'Update' : 'Submit' }}</button>
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

    <script>
        $(function () {
            $('#myForm').validate({
                rules: {
                    banner_small_image_one: {
                        accept: "image/*"
                    },
                    banner_small_image_two: {
                        accept: "image/*"
                    },
                    category_banner_image: {
                        accept: "image/*"
                    },
                    shop_page_banner: {
                        accept: "image/*"
                    }
                },
                messages: {
                    banner_small_image_one: {
                        accept: "Please upload a valid image file (jpg, jpeg, png, etc.)"
                    },
                    banner_small_image_two: {
                        accept: "Please upload a valid image file (jpg, jpeg, png, etc.)"
                    },
                    category_banner_image: {
                        accept: "Please upload a valid image file (jpg, jpeg, png, etc.)"
                    },
                    shop_page_banner: {
                        accept: "Please upload a valid image file (jpg, jpeg, png, etc.)"
                    }
                },
                errorElement: 'span',
                errorPlacement: function (error, element) {
                    error.addClass('invalid-feedback');
                    element.closest('.form-group').append(error);
                },
                highlight: function (element, errorClass, validClass) {
                    $(element).addClass('is-invalid');
                },
                unhighlight: function (element, errorClass, validClass) {
                    $(element).removeClass('is-invalid');
                }
            });
        });
    </script>
    
@endsection
