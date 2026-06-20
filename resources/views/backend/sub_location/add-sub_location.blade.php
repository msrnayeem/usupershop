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
                        <h4 class="m-0">Manage Sub Location</h4>
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li class="breadcrumb-item active">Sub Location</li>
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
                                        Edit Sub Location
                                    @else
                                        Add Sub Location
                                    @endif

                                    <a class="btn btn-sm btn-primary float-right"
                                        href="{{ route('areas.sub_location') }}"><i class="fas fa-list"></i> Sub Location
                                        List</a>
                                </h4>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <form method="post"
                                    action="{{ @$editData ? route('areas.sub_location.update', $editData->id) : route('areas.sub_location.store') }}"
                                    id="myForm">
                                    @csrf
                                    <div class="form-row">
                                        <div class="form-group col-md-4">
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

                                        <div class="form-group col-md-4">
                                            <label for="location_id">Location</label>
                                            <select name="location_id" id="location_id" class="form-control select2">
                                                <option value="">Select Location</option>
                                                {{-- @foreach ($locations as $location)
                                                    <option value="{{ $location->id }}"
                                                        {{ @$editData->location_id == $location->id ? 'Selected' : '' }}>
                                                        {{ $location->location_name }}</option>
                                                @endforeach --}}
                                            </select>
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label for="sub_location_name">Sub Location Name</label>
                                            <input type="text" name="sub_location_name"
                                                value="{{ @$editData->sub_location_name }}" class="form-control"
                                                id="sub_location_name" placeholder="Enter sub location name">
                                            <span
                                                style="color: red;">{{ $errors->has('sub_location_name') ? $errors->first('sub_location_name') : '' }}</span>
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
        $(document).ready(function() {
            $('select[name="division_id"]').on('change', function() {
                var division_id = $(this).val();
                if (division_id) {
                    $.ajax({
                        url: "{{ url('location/ajax') }}/" + division_id,
                        type: "GET",
                        dataType: "json",
                        success: function(data) {
                            var d = $('select[name="location_id"]').empty();
                            $.each(data, function(key, value) {
                                $('select[name="location_id"]').append(
                                    '<option value="' + value.id + '">' + value
                                    .location_name + '</option>');
                            });
                        },
                    });
                } else {
                    alert('Danger');
                }
            });
        });
    </script>

    <script type="text/javascript">
        $(function() {
            $('#myForm').validate({
                rules: {
                    sub_location_name: {
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
