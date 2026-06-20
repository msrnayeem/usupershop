@extends('backend.layouts.master')
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6">
                        <h5 class="m-0"><i class='fas fa-hand-point-right'></i> Manage Sub Location</h5>
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li class="breadcrumb-item active">Sub Location</li>
                            &nbsp;&nbsp;&nbsp;
                            <a class="btn btn-sm btn-primary float-right" href="{{ route('areas.sub_location.add') }}"><i
                                    class="fas fa-plus-circle"></i> Add Sub Location</a>
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
                            <!-- <div class="card-header">
                                <h3>
                                    Category List
                                    <a class="btn btn-sm btn-primary float-right" href="{{ route('categories.add') }}"><i
                                            class="fas fa-plus-circle"></i> Add Category</a>
                                </h3>
                            </div> -->
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="subLocationTbl" class="table table-bordered table-striped nowrap dt-responsive"
                                    style="width: 100%">
                                    <thead>
                                        <tr>
                                            <th width="6%">SL.</th>
                                            <th>Division</th>
                                            <th>Location</th>
                                            <th>Sub Location</th>
                                            <th width="12%">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>
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
        $(function() {
            $("#subLocationTbl").DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('areas.sub_location.list') }}",
                    data: function(data) {
                        let customFilter = {};

                        customFilter.division_id = null;
                        data.customFilter = customFilter;
                    },
                    type: "GET",
                },
                columns: [{
                        data: "sn",
                        searchable: false,
                        orderable: false
                    },
                    {
                        data: "division_id",
                        name: "division_id"
                    },
                    {
                        data: "location_id",
                        name: "location_id"
                    },
                    {
                        data: "sub_location_name",
                        name: "sub_location_name"
                    },
                    {
                        data: "action",
                        name: "action",
                        searchable: false,
                        orderable: false
                    },
                ]
            });
        });
    </script>
@endsection
