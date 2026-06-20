@extends('backend.layouts.master')
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6">
                        <h5 class="m-0"><i class='fas fa-hand-point-right'></i> Manage Payment Gatway</h5>
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li class="breadcrumb-item active">Payment Gatway</li>
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
                                        Edit Payment Gatway
                                    @else
                                        Add Payment Gatway
                                    @endif
                                    <a class="btn btn-sm btn-primary float-right" href="{{ route('paymentgatways.view') }}"><i
                                            class="fas fa-list"></i> Payment Gatway List</a>
                                </h5>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <form method="post"
                                    action="{{ @$editData ? route('paymentgatways.update', $editData->id) : route('paymentgatways.store') }}"
                                    id="myForm" enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-row">
                                        <div class="form-group col-md-4">
                                            <label for="BKASH_USERNAME">Payment Gatway Bkash UserName</label>
                                            <input type="text" name="BKASH_USERNAME" value="{{ @$editData->BKASH_USERNAME }}"
                                                class="form-control" id="BKASH_USERNAME" placeholder="Enter Bkash Username">
                                            <span
                                                style="color: red;">{{ $errors->has('BKASH_USERNAME') ? $errors->first('BKASH_USERNAME') : '' }}</span>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <div class="mt-4">
                                                <div class="custom-control custom-switch mt-1">
                                                    <input type="checkbox" class="custom-control-input" name="active_status" id="customSwitch1" value="1" {{ @$editData->active_status == 1 ? 'checked' : '' }}
                                                    >
                                                    <label class="custom-control-label" for="customSwitch1">Status Active </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="BKASH_PASSWORD">Payment Gatway Bkash Password</label>
                                            <input type="text" name="BKASH_PASSWORD" value="{{ @$editData->BKASH_PASSWORD }}"
                                                class="form-control" id="BKASH_PASSWORD" placeholder="Enter Bkash Password">
                                            <span
                                                style="color: red;">{{ $errors->has('BKASH_PASSWORD') ? $errors->first('BKASH_PASSWORD') : '' }}</span>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="BKASH_API_KEY">Payment Gatway Bkash Api Key</label>
                                            <input type="text" name="BKASH_API_KEY" value="{{ @$editData->BKASH_API_KEY }}"
                                                class="form-control" id="BKASH_API_KEY" placeholder="Enter Bkash Username">
                                            <span
                                                style="color: red;">{{ $errors->has('BKASH_API_KEY') ? $errors->first('BKASH_API_KEY') : '' }}</span>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="BKASH_SECRET_KEY">Payment Gatway Bkash Secrate Key</label>
                                            <input type="text" name="BKASH_SECRET_KEY" value="{{ @$editData->BKASH_SECRET_KEY }}"
                                                class="form-control" id="BKASH_SECRET_KEY" placeholder="Enter Bkash Username">
                                            <span
                                                style="color: red;">{{ $errors->has('BKASH_SECRET_KEY') ? $errors->first('BKASH_SECRET_KEY') : '' }}</span>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="NAGAD_USERNAME">Payment Gatway Nagad UserName</label>
                                            <input type="text" name="NAGAD_USERNAME" value="{{ @$editData->NAGAD_USERNAME }}"
                                                class="form-control" id="NAGAD_USERNAME" placeholder="Enter Nagad Username">
                                            <span
                                                style="color: red;">{{ $errors->has('NAGAD_USERNAME') ? $errors->first('NAGAD_USERNAME') : '' }}</span>
                                        </div>
                                       
                                        <div class="form-group col-md-4">
                                            <label for="NAGAD_PASSWORD">Payment Gatway Nagad Password</label>
                                            <input type="text" name="NAGAD_PASSWORD" value="{{ @$editData->NAGAD_PASSWORD }}"
                                                class="form-control" id="NAGAD_PASSWORD" placeholder="Enter Nagad Password">
                                            <span
                                                style="color: red;">{{ $errors->has('NAGAD_PASSWORD') ? $errors->first('NAGAD_PASSWORD') : '' }}</span>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="NAGAD_API_KEY">Payment Gatway Nagad Api Key</label>
                                            <input type="text" name="NAGAD_API_KEY" value="{{ @$editData->NAGAD_API_KEY }}"
                                                class="form-control" id="NAGAD_API_KEY" placeholder="Enter Nagad Api Key">
                                            <span
                                                style="color: red;">{{ $errors->has('NAGAD_API_KEY') ? $errors->first('NAGAD_API_KEY') : '' }}</span>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="NAGAD_SECRET_KEY">Payment Gatway Nagad Secrate Key</label>
                                            <input type="text" name="NAGAD_SECRET_KEY" value="{{ @$editData->NAGAD_SECRET_KEY }}"
                                                class="form-control" id="NAGAD_SECRET_KEY" placeholder="Enter Nagad Secret Key">
                                            <span
                                                style="color: red;">{{ $errors->has('NAGAD_SECRET_KEY') ? $errors->first('NAGAD_SECRET_KEY') : '' }}</span>
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
