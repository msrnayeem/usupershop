@extends('backend.layouts.master')
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6">
                        <h5 class="m-0"><i class='fas fa-hand-point-right'></i> Manage Seller Orders</h5>
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li class="breadcrumb-item active">Seller Orders</li>
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
                            <!-- /.card-header -->
                            <div class="card-body">
                                <div class="msg"></div>
                           
                                <table id="appOrderTbl" class="table table-bordered table-striped nowrap dt-responsive"
                                    style="width: 100%">
                                    <thead>
                                        <tr style="background:#b6f7f4">
                                            <th class="text-center" width="4%">SN</th>
                                            <th class="text-center"><input type="checkbox" name="oder_id" id="oderID" value=""
                                                    style="width:17px;height:17px;"></th>
                                            <th class="text-center">Order No</th>
                                            <th class="text-center">Total Amm.</th>
                                            <th class="text-center">Payment Type</th>
                                            <th class="text-center">Order Date</th>
                                             <th class="text-center">Status</th>
                                            <th class="text-center">Shop Name</th>
                                            <th class="text-center">Commission </th>
                                            <th class="text-center" width="16%">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>

                                <!-- Add Delivery Status -->
                                <form name="addDeliveryStatusForm" class="form-inline" method="post"
                                       
                                    autocomplete="off" onsubmit="return false">
                                    
                                    <div class="form-group mx-sm-3 mb-2" style="margin-left:0px !important;">
                                        <select name="status" class="form-control form-control-sm" style="height:25px;">
                                            <option value="">Select Order Status</option>
                                            <option value="pending">Pending</option>
                                            <option value="confirmed">Confirmed</option>
                                            <option value="packaging">Packaging</option>
                                            <option value="delivered">Delivered</option>
                                            <option value="canceled">Canceled</option>
                                            <option value="return">Return</option>
                                        </select>
                                    </div>
                                    <button type="submit" class="btn btn-danger btn-sm mb-2"><i
                                            class='fas fa-paper-plane'></i> Change Order Status</button>
                                </form>
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
            var searchOrderForm = {};
            var src_from = null;
            var src_to = null;
            var status = null;
            $('#searchData').click(function(e) {
                src_from = $('#src_from').val();
                src_to = $('#src_to').val();
                status = $('#orderstatus').find(":selected").val();
                appOrderTbl.draw();
            });

            let appOrderTbl = $("#appOrderTbl").DataTable({
                processing: true,
                serverSide: true,
                searchable: true,
                ajax: {
                    url: "{{ route('seller.orders.list') }}",
                    data: function(data) {
                        let customFilter = {};
                        customFilter.src_from = src_from;
                        customFilter.src_to = src_to;
                        customFilter.status = status;
                        data.customFilter = customFilter;
                    },
                    type: "GET",
                },
                columns: [{
                        data: "sn",
                        searchable: false,
                        className: "text-center",
                        orderable: false
                    },
                    {
                        data: "check_box",
                        searchable: false,
                        className: "text-center",
                        orderable: false
                    },
                    {
                        data: "order_no",
                        className: "text-center",
                        name: "order_no"
                    },
                    {
                        data: "order_total",
                        className: "text-center",
                        name: "order_total"
                    },
                    {
                        data: "payment_id",
                        name: "payment_id",
                        className: "text-center",
                        searchable: false,
                        orderable: false
                    },

                    {
                        data: "order_date",
                        name: "order_date",
                        className: "text-center",
                        searchable: false,
                        orderable: false
                    },
                    {
                        data: "status",
                        name: "status",
                        className: "text-center",
                        searchable: false,
                        orderable: false
                    },
                    {
                        data: "shop",
                        name: "shop",
                        className: "text-center",
                        searchable: false,
                        orderable: false
                    },
                    {
                        data: "commission",
                        name: "commission",
                        className: "text-center",
                        searchable: false,
                        orderable: false
                    },
                    {
                        data: "action",
                        name: "action",
                        className: "text-center",
                        searchable: false,
                        orderable: false
                    },
                ],
                /* dom: 'lBfrtip', */
                lengthMenu: [
                    [15, 50, 100, -1],
                    [15, 50, 100, "All"]
                ],
            });
            //setInterval($(""),1000);

            let selectedODRs = [];
            $('#oderID').click(function() {
                if ($(this).is(':checked')) {
                    $('input[type = checkbox]').prop('checked', true);

                    $('.checkedOrds:checked').each(function() {
                        selectedODRs.push($(this).val());
                    });
                } else {
                    $('input[type = checkbox]').prop('checked', false);
                    selectedODRs = [];
                }
            });

            appOrderTbl.on('click', 'tr td > .checkedOrds', function() {
                var item = $(this).val();
                let index = selectedODRs.indexOf(item);
                if (index === -1) {
                    selectedODRs.push(item);
                } else {
                    selectedODRs.splice(index, 1);
                }
            });

            $("form[name=addDeliveryStatusForm]").submit(function() {
                console.log(selectedODRs);
                var status = $("select[name=status]").val();
                alert(status)
                if (status == "" || selectedODRs.length < 1) {
                    alert("select at least one order ID and Order Status !");
                    return;
                }
                $.ajax({
                    cache: false,
                    type: 'POST',
                    url: "{{ route('vendor.status.update') }}",
                    data: {
                        _token: "{{ csrf_token() }}",
                        status: status,
                        selectedODRs: selectedODRs
                    },
                    success: function(resData, textStatus, jqXHR) {
                        if (textStatus == 'success') {
                            if (jqXHR.status >= 203) {
                                $(".msg").html(
                                    "<div class='alert alert-info alert-dismissible' role='alert'> <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>" +
                                    resData.message + "</div>");
                            } else {
                                $(".msg").html(
                                    "<div class='alert alert-warning alert-dismissible' role='alert'> <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>" +
                                    resData.message + "</div>");
                            }
                            appOrderTbl.ajax.reload();
                            // location.reload();
                            $('#oderID').prop('checked', false);
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        $(".msg").html(
                            "<div class='alert alert-danger alert-dismissible' role='alert'> <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>" +
                            jqXHR.status + ":" + errorThrown + "</div>"
                        );
                    }
                });

            });
            jQuery(function($) {
                $('.chosen-select').chosen({
                    allow_single_deselect: true
                });
            });

        });
    </script>
@endsection
