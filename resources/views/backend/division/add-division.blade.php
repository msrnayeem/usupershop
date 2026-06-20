@extends('backend.layouts.master')
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h4 class="m-0">Manage Delivery Charge</h4>
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li class="breadcrumb-item active">Delivery Charge</li>
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
                                        Edit Delivery Charge
                                    @else
                                        Add Delivery Charge
                                    @endif

                                    <a class="btn btn-sm btn-primary float-right" href="{{ route('areas.division') }}"><i
                                            class="fas fa-list"></i> Delivery Charge
                                        List</a>
                                </h4>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <form method="post"
                                    action="{{ @$editData ? route('areas.division.update', $editData->id) : route('areas.division.store') }}"
                                    id="myForm">
                                    @csrf
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label for="zone_area">Delivery Area Name</label>
                                            <input type="text" name="zone_area"
                                                value="{{ @$editData->zone_area }}" class="form-control"
                                                id="zone_area" placeholder="Enter area name">
                                            <span
                                                style="color: red;">{{ $errors->has('zone_area') ? $errors->first('zone_area') : '' }}</span>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="zone_charge">Delivery Charge</label>
                                            <input type="text" name="zone_charge"
                                                value="{{ @$editData->zone_charge }}" class="form-control"
                                                id="zone_charge" placeholder="Enter charge name">
                                            <span
                                                style="color: red;">{{ $errors->has('zone_charge') ? $errors->first('zone_charge') : '' }}</span>
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
                    division_name: {
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
