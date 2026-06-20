@extends('backend.layouts.master')
@section('admin_css')
<style>
.table-responsive {
    overflow-x: auto;
    max-width: 100%;
    border-radius: 8px;
    box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
}

/* Table styling */
#sliderTbl {
    width: 100%;
    border-collapse: collapse;
}

/* Table header */
#sliderTbl thead {
    color: #000;
    font-weight: bold;
}

#sliderTbl thead th {
    padding: 12px;
    text-align: center;
    font-size: 14px;
    border-right: 1px solid rgba(255, 255, 255, 0.5);
}

/* Table body */
#sliderTbl tbody tr {
    border-bottom: 1px solid #ddd;
    transition: background 0.3s ease-in-out;
}

#sliderTbl tbody tr:hover {
    background: #f5f5f5;
}

/* Table cells */
#sliderTbl tbody td {
    padding: 10px;
    text-align: center;
    font-size: 14px;
    vertical-align: middle;
}

/* Responsive Image */
#sliderTbl tbody td img {
    max-width: 100%;
    height: auto;
    border-radius: 5px;
}

/* Action Buttons */
#sliderTbl tbody td .btn {
    padding: 6px 12px;
    font-size: 13px;
    border-radius: 4px;
}

/* Responsive Design */
@media screen and (max-width: 768px) {
    #sliderTbl thead {
        display: none; /* Hide header for mobile */
    }

    #sliderTbl tbody tr {
        display: block;
        margin-bottom: 10px;
        border: 1px solid #ddd;
        padding: 10px;
        border-radius: 8px;
    }

    #sliderTbl tbody td {
        display: block;
        text-align: right;
        padding: 8px 10px;
        font-size: 14px;
        position: relative;
    }

    #sliderTbl tbody td::before {
        content: attr(data-label);
        position: absolute;
        left: 10px;
        font-weight: bold;
        text-transform: capitalize;
        color: #333;
    }
}

</style>
@endsection
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6">
                        <h5 class="m-0"><i class='fas fa-hand-point-right'></i> All Slider</h5>
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li class="breadcrumb-item active">Sliders</li>
                            &nbsp;&nbsp;&nbsp;
                            <a class="btn btn-sm btn-primary float-right" href="{{ route('sliders.add') }}"><i
                                    class="fas fa-plus-circle"></i> Add Slider</a>
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
                            <!--<div class="card-header">
                                <h3>
                                    Slider List
                                    <a class="btn btn-sm btn-primary float-right" href="{{ route('sliders.add') }}"><i
                                            class="fas fa-plus-circle"></i> Add Slider</a>
                                </h3>
                            </div>-->
                            <!-- /.card-header -->
                            <div class="card-body">
                                <div class="table-responsive" >
                                    <table id="sliderTbl" class="table table-bordered table-striped nowrap dt-responsive"
                                    style="width: 100%;">
                                    <thead>
                                        <tr>
                                            <th width="5%">SN</th>
                                            <th  width="20%">Slider Name</th>
                                            <th  width="40%">Slider Image</th>
                                            <th width="30%">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>
                                </div>
                              
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
            $("#sliderTbl").DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('sliders.list') }}",
                    data: function(data) {
                        let customFilter = {};

                        customFilter.created_by = null;
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
                        data: "image",
                        name: "image",
                        searchable: false,
                        orderable: false
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
