@extends('backend.layouts.master')
@section('content')
    <style>
        .select2-container--default .select2-selection--single {
            height: 38px;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow b {
            margin-left: -5px;
            margin-top: 5px;
        }
    </style>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6">
                        <h5 class="m-0"><i class='fas fa-hand-point-right'></i> Manage Sub Categories</h5>
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li class="breadcrumb-item active">Subcategories</li>
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
                                        Edit Subcategory
                                    @else
                                        Add Subcategory
                                    @endif

                                    <a class="btn btn-sm btn-primary float-right"
                                        href="{{ route('subcategories.view') }}"><i class="fas fa-list"></i> Subcategories
                                        List</a>
                                </h5>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <form method="post"
                                    action="{{ @$editData ? route('subcategories.update', $editData->id) : route('subcategories.store') }}"
                                    id="myForm">
                                    @csrf
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label for="category_id">Category</label>
                                            <select name="category_id" id="category_id" class="form-control select2">
                                                <option value="">Select Category</option>
                                                @foreach ($categories as $category)
                                                    <option value="{{ $category->id }}"
                                                        {{ @$editData->category_id == $category->id ? 'Selected' : '' }}>
                                                        {{ $category->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="name">Subcategory Name</label>
                                            <input type="text" name="name" value="{{ @$editData->name }}"
                                                class="form-control" id="name" placeholder="Enter subcategory...">
                                            <span
                                                style="color: red;">{{ $errors->has('name') ? $errors->first('name') : '' }}</span>
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
                                            <textarea name="meta_keywords" class="form-control" id="meta_keywords" placeholder="Enter meta Keywords for SEO">{{ @$editData->meta_keywords }}</textarea>
                                        </div>

                                        <div class="form-group col-md-6">
                                            {{-- <input type="submit" value="submit" class="btn btn-primary"> --}}
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
