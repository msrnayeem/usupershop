@extends('backend.layouts.master')
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6">
                        <h5 class="m-0"><i class='fas fa-hand-point-right'></i> Manage Communicate</h5>
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li class="breadcrumb-item active">Contacts</li>
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
                                    Communicate List
                                </h3>
                            </div> -->
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="communicationTbl" class="table table-bordered table-striped nowrap dt-responsive"
                                    style="width: 100%">
                                    <thead>
                                        <tr>
                                            <th width="6%">SN</th>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Mobile No</th>
                                            <th>Message</th>
                                            <th>Status</th>
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
            $("#communicationTbl").DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('contacts.communicate.list') }}",
                    data: function(data) {
                        let customFilter = {};

                        customFilter.mobile = null;
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
                        data: "name",
                        name: "name"
                    },
                    {
                        data: "email",
                        name: "email"
                    },
                    {
                        data: "mobile",
                        name: "mobile"
                    },
                    {
                        data: "message",
                        name: "message"
                    },
                    {
                        data: "difference",
                        name: "difference",
                        searchable: false,
                        orderable: false
                    },
                    {
                        data: "action",
                        name: "action",
                        searchable: false,
                        orderable: false
                    }
                ]
            });
        });
    </script>
@endsection
