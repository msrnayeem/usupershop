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
                        <ol class="breadcrumb float-sm-left">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li class="breadcrumb-item active">Area</li>
                        </ol>
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <a class="btn btn-sm btn-primary float-right" href="{{ route('areas.area') }}"><i
                                    class="fas fa-list"></i> Area
                                List</a>
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
                                        Edit Area
                                    @else
                                        Add Area
                                    @endif
                                    {{--  <a class="btn btn-sm btn-primary float-right" href="{{ route('areas.area') }}"><i
                                            class="fas fa-list"></i> Area
                                        List</a> --}}
                                </h5>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <form method="post"
                                    action="{{ @$editData ? route('areas.area.update', $editData->id) : route('areas.area.store') }}"
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
                                            <label for="sub_location_id">Sub Location</label>
                                            <select name="sub_location_id" id="sub_location_id"
                                                class="form-control select2">
                                                <option value="">Select Sub Location</option>
                                                {{-- @foreach ($sub_locations as $sub_location)
                                                    <option value="{{ $sub_location->id }}"
                                                        {{ @$editData->sub_location_id == $sub_location->id ? 'Selected' : '' }}>
                                                        {{ $sub_location->sub_location_name }}</option>
                                                @endforeach --}}
                                            </select>
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label for="area_name">Area Name</label>
                                            <input type="text" name="area_name" value="{{ @$editData->area_name }}"
                                                class="form-control" id="area_name" placeholder="Enter area name">
                                            <span
                                                style="color: red;">{{ $errors->has('area_name') ? $errors->first('area_name') : '' }}</span>
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label for="deliveryCharge">Delivery Charge</label>
                                            <input type="text" name="deliveryCharge"
                                                value="{{ @$editData->deliveryCharge }}" class="form-control"
                                                id="deliveryCharge" placeholder="Enter delivery charge">
                                            <span
                                                style="color: red;">{{ $errors->has('deliveryCharge') ? $errors->first('deliveryCharge') : '' }}</span>
                                        </div>

                                        <div class="form-group offset-md-8 col-md-4 text-right">
                                            <button type="submit" class="btn btn-primary"><i
                                                    class="fas fa-check-double"></i>
                                                {{ @$editData ? 'Update' : 'Submit' }}</button>
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
                        url: "{{ url('/location/ajax') }}/" + division_id,
                        type: "GET",
                        dataType: "json",
                        success: function(data) {
                            var tag = $('select[name="location_id"]');
                            tag.empty();
                            tag.append('<option value="0">Select Location</option>');
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

            // Sub Location Ajax here...
            $('select[name="location_id"]').on('change', function() {
                var location_id = $(this).val();
                if (location_id) {
                    $.ajax({
                        url: "{{ url('/sublocation/ajax') }}/" + location_id,
                        type: "GET",
                        dataType: "json",
                        success: function(data) {
                            var tag = $('select[name="sub_location_id"]');
                            tag.empty();
                            tag.append('<option value="0">Select Sub Location</option>');
                            $.each(data, function(key, value) {
                                $('select[name="sub_location_id"]').append(
                                    '<option value="' + value.id + '">' + value
                                    .sub_location_name + '</option>');
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
                    area_name: {
                        required: true
                    },
                    deliveryCharge: {
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
