@extends('backend.layouts.master')
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6">
                        <h5 class="m-0"><i class='fas fa-hand-point-right'></i> Manage Categories</h5>
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li class="breadcrumb-item active">Categories</li>
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
                                        Edit Category
                                    @else
                                        Add Category
                                    @endif

                                    <a class="btn btn-sm btn-primary float-right" href="{{ route('categories.view') }}"><i
                                            class="fas fa-list"></i> Categories List</a>
                                </h5>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <form method="post"
                                    action="{{ @$editData ? route('categories.update', $editData->id) : route('categories.store') }}"
                                    id="myForm" enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-row">
                                        <div class="form-group col-md-4">
                                            <label for="name">Category Name</label>
                                            <input type="text" name="name" value="{{ @$editData->name }}"
                                                class="form-control" id="name" placeholder="Enter category name">
                                            <span
                                                style="color: red;">{{ $errors->has('name') ? $errors->first('name') : '' }}</span>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="name">Category Name Bangla</label>
                                            <input type="text" name="name_bn" value="{{ @$editData->name_bn }}"
                                                class="form-control" id="name_bn" placeholder="Enter category name">
                                            <span
                                                style="color: red;">{{ $errors->has('name_bn') ? $errors->first('name_bn') : '' }}</span>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label>Image <span class="text-danger">(Must upload 120px x 120px
                                                    image)</span></label>
                                            <input type="file" name="image" id="image" class="form-control">
                                        </div>

                                        <div class="form-group col-md-2">
                                            <img id="showImage" style="width: 100px;height:105px; border:1px solid #000"
                                                src="{{ !empty($editData->image) ? url('upload/category_images/' . $editData->image) : url('frontend/no-image-icon.jpg') }}">
                                        </div>
                                        <div class="form-group col-md-2"></div>

                                        <div class="form-group col-md-3">
                                            <label class="container">Is Show Top Menu
                                                <input type="checkbox" name="is_show" value="1"
                                                    style="height:15px;width:15px;">
                                                <span class="checkmark"></span>
                                            </label>
                                        </div>

                                        <!-- SEO Fields -->
                                        <div class="form-group col-md-4">
                                            <label for="meta_title">Meta Title</label>
                                            <input type="text" name="meta_title" value="{{ @$editData->meta_title }}"
                                                class="form-control" id="meta_title" placeholder="Enter meta title for SEO">
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label for="meta_description">Meta Description</label>
                                            <textarea name="meta_description" class="form-control" id="meta_description"
                                                placeholder="Enter meta description for SEO">{{ @$editData->meta_description }}</textarea>
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label for="meta_keywords">Meta Keywords</label>
                                           <textarea name="meta_keywords" class="form-control" id="meta_keywords"
                                                placeholder="Enter meta Keywords for SEO">{{ @$editData->meta_keywords }}</textarea>
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

    <script type="text/javascript">
        $(function() {
            $('#myForm').validate({
                rules: {
                    name: {
                        required: true
                    },
                },
                messages: {

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
