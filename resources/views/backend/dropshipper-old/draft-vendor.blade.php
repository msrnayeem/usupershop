@extends('backend.layouts.master')
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6">
                        <h5 class="m-0"><i class='fas fa-hand-point-right'></i> Manage Draft Vendors</h5>
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li class="breadcrumb-item active">Draft Vendors</li>
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
                                    Draft Vendors List
                                    <a class="btn btn-sm btn-primary float-right" href="{{ route('users.add') }}"><i
                                            class="fas fa-plus-circle"></i> Add Customer</a>
                                </h3>
                            </div>-->
                            <!-- /.card-header -->
                            <div class="card-body">
                                <div class="msg"></div>
                                <table id="vendorDraftTbl" class="table table-bordered table-striped nowrap dt-responsive"
                                    style="width: 100%">
                                    <thead>
                                        <tr>
                                            <th width="6%">SN</th>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Phone No</th>
                                            <th>Address</th>
                                            <th>Acc. Type</th>
                                            <th>Signup Status</th>
                                            <th>Payment</th>
                                            <th>Status</th>
                                            <th width="16%">Action</th>
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
            $("#vendorDraftTbl").DataTable({
                processing: true,
                serverSide: true,
                searchable: true,
                ajax: {
                    url: "{{ route('vendors.draft.list') }}",
                    data: function(data) {
                        let customFilter = {};

                        customFilter.usertype = null;
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
                        data: "address",
                        name: "address"
                    },
                    {
                        data: "account_type",
                        name: "account_type"
                    },
                    {
                        data: "difference",
                        name: "difference",
                        searchable: false,
                        orderable: false
                    },
                    {
                        data: "payment_status",
                        name: "payment_status",
                        searchable: false,
                        orderable: false
                    },
                    {
                        data: "status",
                        name: "status",
                        searchable: false,
                        orderable: false
                    },
                    {
                        data: "action",
                        name: "action",
                        searchable: false,
                        orderable: false
                    }
                ],
                lengthMenu: [
                    [15, 50, 100, -1],
                    [15, 50, 100, "All"]
                ],
            });
        });

        function statusChangedPayment(id){
            //alert(id);
            var commission = $("#commission_"+id).val();
            //console.log(comission);
            $.ajax({
                type: 'GET',
                data: ({
                    id: id,
                    commission:commission
                }),
                url: '{{ route("vendors.approved") }}',

                success: function(resData, textStatus, jqXHR) {
                    if (textStatus == 'success') {
                        if (jqXHR.status >= 203) {
                            $(".msg").html("<div class='alert alert-danger alert-dismissible' role='alert'> <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>" + resData.message + "</div>");
                        } else {
                            $(".msg").html("<div class='alert alert-success alert-dismissible' role='alert'> <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>" + resData.message + "</div>");
                        }
                        //window.location.reload();
                        var table = $('#vendorDraftTbl').DataTable();
                            table.ajax.reload();
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    $(".msg").html(
                        "<div class='alert alert-danger alert-dismissible' role='alert'> <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>" + jqXHR.status + ":" + errorThrown + "</div>"
                    );
                }
            });
        }
    </script>
@endsection
