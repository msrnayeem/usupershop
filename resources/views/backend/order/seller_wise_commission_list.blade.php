@extends('backend.layouts.master')
@section('content')
    <style type="text/css">
        .modal-header {
            padding: .5rem .75rem;
        }
        .modal-body {
            padding: .25rem 1rem 1rem 1rem;
        }
        .modal-footer {
            padding: .25rem .75rem;
        }
        .mb-3, .my-3 {
            margin-bottom: 0rem !important;
        }
    </style>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6">
                        <h5 class="m-0"><i class='fas fa-hand-point-right'></i> Order Commission</h5>
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li class="breadcrumb-item active">Order Commission</li>
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
                                <table id="sellerWiseCommissionTbl" class="table table-bordered table-striped nowrap dt-responsive"
                                    style="width: 100%">
                                    <thead>
                                        <tr style="background:#b6f7f4">  
                                            <th width="4%">SN</th>
                                            <th>Reseller</th>
                                            <th>Debit</th>
                                            <th>Credit</th>
                                            <th width="12%">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>
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

    <!--Show parts item Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form name="sellerPaymentForm" method="post" action="#" autocomplete="off" onsubmit="return false">
                    @csrf
                    <input type="hidden" name="seller_id" class="form-control" id="seller_id">
                    <div class="modal-header">
                        <h5 class="modal-title fs-5" id="exampleModalLabel"><i class="fas fa-hand-point-right"></i> Seller Payment</h5>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div class="msg"></div>
                        <div class="mb-3">
                            <label for="amount" class="col-form-label">Amount :</label>
                            <input type="text" name="amount" class="form-control" id="amount">
                        </div>
                        <div class="mb-3">
                            <label for="payment_mood" class="col-form-label">Payment Mood :</label>
                            <select name="payment_mood" class="form-control" id="payment_mood">
                                <option value="">Select Mood</option>
                                <option value="Bkash">Bkash</option>
                                <option value="Nagad">Nagad</option>
                                <option value="Bank">Bank</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="reference_no" class="col-form-label">Reference No :</label>
                            <input type="text" name="reference_no" class="form-control" id="reference_no">
                        </div>
                        <div class="mb-3">
                            <label for="account_no" class="col-form-label">Account/Mobile No :</label>
                            <input type="text" name="account_no" class="form-control" id="account_no">
                        </div>
                        <div class="mb-3">
                            <label for="message-text" class="col-form-label">Comments :</label>
                            <textarea class="form-control" name="comments" id="comments"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                       <!--  <button type="button" class="btn btn-secondary btn-md" data-dismiss="modal">Close</button> -->
                        <button type="submit" class="btn btn-primary btn-sm">Save Payment</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Modal -->

    <!-- /.content-wrapper -->
    <script type="text/javascript">

        function openCommissionModal(resellerID){
            $("#seller_id").val(parseInt(resellerID));
            $('#exampleModal').modal({
                keyboard: true,
                backdrop: "static"
            });
        }

        $(document).ready(function(){
            
            let sellerWiseCommissionTbl = $("#sellerWiseCommissionTbl").DataTable({
                processing: true,
                serverSide: true,
                searchable: true,
                ajax: {
                    url: "{{ route('seller.wise.commission.list') }}",
                    data: function(data) {
                        let customFilter = {};
                    },
                    type: "GET",
                },
                columns: [
                    {
                        data: "sn",
                        searchable: false,
                        orderable: false
                    },
                    {
                        data: "reseller_id",
                        name: "reseller_id"
                    },
                    {
                        data: "debit_balance",
                        name: "debit_balance",
                        searchable: false,
                        orderable: false
                    },
                    {
                        data: "credit_balance",
                        name: "credit_balance",
                        searchable: false,
                        orderable: false
                    },
                    {
                        data: "action",
                        name: "action",
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
            
            

            $("form[name=sellerPaymentForm]").submit(function(){
                var data = $(this).serialize()
                $.ajax({
                    cache: false,
                    type: "post",
                    url: "{{ route('add.seller.payment') }}",
                    data: data,
                    success: function(resData, textStatus, jqXHR) {
                        if (textStatus == 'success'){
                            if (jqXHR.status >= 203) {
                                $(".msg").html("<div class='alert alert-danger alert-dismissible' role='alert'> <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>" + resData.message + "</div>");
                            } else {
                                $(".msg").html("<div class='alert alert-info alert-dismissible' role='alert'> <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>" + resData.message + "</div>");
                                sellerWiseCommissionTbl.ajax.reload();
                                $('#exampleModal').modal('hide');
                            }
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown){
                        $(".msg").html(
                            "<div class='alert alert-danger alert-dismissible' role='alert'> <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>" + jqXHR.status + ":" + errorThrown + "</div>"
                        );
                    }
                });
            });
            
            // Choosen code here....
            jQuery(function($) {
                $('.chosen-select').chosen({allow_single_deselect: true});
            });

        });
    </script>
@endsection
