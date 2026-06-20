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
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h4 class="m-0">Manage Location</h4>
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li class="breadcrumb-item active">Location</li>
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
                                <h4>
                                    @if (isset($editData))
                                        Edit Location
                                    @else
                                        Add Location
                                    @endif

                                    <a class="btn btn-sm btn-primary float-right" href="{{ route('areas.location') }}"><i
                                            class="fas fa-list"></i> Location List</a>
                                </h4>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <form method="post"
                                    action="{{ @$editData ? route('areas.location.update', $editData->id) : route('areas.location.store') }}"
                                    id="myForm">
                                    @csrf
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label for="division_id">Division</label>
                                            <select name="division_id" id="division_id" class="form-control select2">
                                                <option value="">Select Division</option>
                                                @foreach ($divisions as $division)
                                                    <option value="{{ $division->id }}"
                                                        {{ @$editData->division_id == $division->id ? 'Selected' : '' }}>
                                                        {{ $division->division_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="location_name">Location Name</label>
                                            <input type="text" name="location_name"
                                                value="{{ @$editData->location_name }}" class="form-control"
                                                id="location_name" placeholder="Enter location name">
                                            <span
                                                style="color: red;">{{ $errors->has('location_name') ? $errors->first('location_name') : '' }}</span>
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
                    location_name: {
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
