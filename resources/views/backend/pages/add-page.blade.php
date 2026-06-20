@extends('backend.layouts.master')
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6">
                        <h5 class="m-0"><i class='fas fa-hand-point-right'></i> Manage Page</h5>
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li class="breadcrumb-item active">Page</li>
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
                                    @if (isset($page))
                                        Edit Page
                                    @else
                                        Add Page
                                    @endif
                                    <a class="btn btn-sm btn-primary float-right" href="{{ route('pages.index') }}"><i
                                            class="fas fa-list"></i> Page List</a>
                                </h5>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <form method="post"
                                action="{{ isset($page) ? route('pages.update', $page->id) : route('pages.store') }}"
                                id="myForm">
                                @csrf
                                @isset($page) 
                                    @method('PUT') 
                                @endisset
                            
                                <div class="form-row">
                                    {{-- Page Name --}}
                                    <div class="form-group col-md-12">
                                        <label for="name">Title</label>
                                        <input type="text" name="name" value="{{ old('name', $page->name ?? '') }}"
                                            class="form-control" id="name" placeholder="Enter name...">
                                        @error('name')
                                            <span style="color: red;">{{ $message }}</span>
                                        @enderror
                                    </div>
                            
                                    {{-- Page Description --}}
                                    <div class="form-group col-md-12">
                                        <label>Description</label>
                                        <textarea name="description" id="summernote" class="form-control" rows="4"
                                            placeholder="Enter description...">{{ old('description', $page->description ?? '') }}</textarea>
                                        @error('description')
                                            <span style="color: red;">{{ $message }}</span>
                                        @enderror
                                    </div>
                            
                                    {{-- Submit Button --}}
                                    <div class="form-group col-md-6" style="padding-top: 30px;">
                                        <button type="submit" class="btn btn-primary">
                                            {{ isset($page) ? 'Update' : 'Submit' }}
                                        </button>
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

                    description: {
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
