@extends('backend.layouts.master')
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6">
                        <h5 class="m-0"><i class='fas fa-hand-point-right'></i> Manage SMS Gatway</h5>
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li class="breadcrumb-item active">SMS Gatway</li>
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
                                        Edit SMS Gatway
                                    @else
                                        Add SMS Gatway
                                    @endif
                                    <a class="btn btn-sm btn-primary float-right" href="{{ route('smsgateways.view') }}"><i
                                            class="fas fa-list"></i> SMS Gatway List</a>
                                </h5>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <form method="post"
                                    action="{{ @$editData ? route('smsgateways.update', $editData->id) : route('smsgateways.store') }}"
                                    id="myForm" >
                                    @csrf
                                    <div class="form-row">
                                        <div class="form-group col-md-4">
                                            <label for="userName">SMS Gatway UserName</label>
                                            <input type="text" name="userName" value="{{ @$editData->userName }}"
                                                class="form-control" id="userName" placeholder="Enter  Username">
                                            <span
                                                style="color: red;">{{ $errors->has('userName') ? $errors->first('userName') : '' }}</span>
                                        </div>
                                       
                                        <div class="form-group col-md-4">
                                            <label for="apiKey">SMS Gatway Api Key</label>
                                            <input type="text" name="apiKey" value="{{ @$editData->apiKey }}"
                                                class="form-control" id="apiKey" placeholder="Enter Api Key">
                                            <span
                                                style="color: red;">{{ $errors->has('apiKey') ? $errors->first('apiKey') : '' }}</span>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="SenderName">SMS Gatway Sender Name</label>
                                            <input type="text" name="SenderName" value="{{ @$editData->SenderName }}"
                                                class="form-control" id="SenderName" placeholder="Enter Sender Name">
                                            <span
                                                style="color: red;">{{ $errors->has('SenderName') ? $errors->first('SenderName') : '' }}</span>
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
       
    </script>
@endsection
