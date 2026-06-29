@extends('backend.layouts.master')
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        {{-- Page Header --}}
        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:22px;flex-wrap:wrap;gap:12px;">
            <div>
                <h1 style="font-size:22px;font-weight:800;color:#0f172a;margin:0;">
                    <i class="fas fa-wallet" style="color:#6366f1;margin-right:8px;"></i>
                    Seller Commission List
                </h1>
                <p style="color:#64748b;font-size:13px;margin:2px 0 0;">
                    <a href="{{ route('home') }}" style="color:#6366f1;text-decoration:none;">Home</a>
                    <span style="margin:0 6px;color:#cbd5e1;">/</span>
                    Seller Commission
                </p>
            </div>
        </div>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <section class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <span class="card-title">
                                    <i class="fas fa-list" style="color:#6366f1;margin-right:6px;"></i>
                                    Manage Seller Commission
                                </span>
                            </div>
                            <div class="card-body">
                                <table id="sellerWiseCommissionTbl" class="table table-bordered table-striped nowrap dt-responsive" style="width: 100%">
                                    <thead>
                                        <tr>  
                                            <th class="text-center" width="4%">SN</th>
                                            <th class="text-center">Reseller</th>
                                            <th class="text-center">Debit</th>
                                            <th class="text-center">Credit</th>
                                            <th class="text-center" width="12%">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </section>
    </div>

    <!--Show parts item Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content" style="border-radius:12px;border:none;box-shadow:0 20px 60px rgba(0,0,0,0.15);">
                <form name="sellerPaymentForm" method="post" action="#" autocomplete="off" onsubmit="return false">
                    @csrf
                    <input type="hidden" name="seller_id" class="form-control" id="seller_id">
                    <div class="modal-header" style="background:linear-gradient(135deg,#6366f1,#4f46e5);border-radius:12px 12px 0 0;padding:16px 20px;">
                        <h5 class="modal-title" id="exampleModalLabel" style="color:#fff;font-weight:700;"><i class="fas fa-money-bill-wave"></i> Seller Payment</h5>
                        <button type="button" class="close" data-dismiss="modal" style="color:#fff;opacity:1;">&times;</button>
                    </div>
                    <div class="modal-body" style="padding:20px;">
                        <div class="msg mb-3"></div>
                        <div class="form-group">
                            <label for="amount">Amount :</label>
                            <input type="text" name="amount" class="form-control" id="amount" required>
                        </div>
                        <div class="form-group">
                            <label for="payment_mood">Payment Mode :</label>
                            <select name="payment_mood" class="form-control" id="payment_mood" required>
                                <option value="">Select Mode</option>
                                <option value="Bkash">Bkash</option>
                                <option value="Nagad">Nagad</option>
                                <option value="Bank">Bank</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="reference_no">Reference No :</label>
                            <input type="text" name="reference_no" class="form-control" id="reference_no">
                        </div>
                        <div class="form-group">
                            <label for="account_no">Account/Mobile No :</label>
                            <input type="text" name="account_no" class="form-control" id="account_no" required>
                        </div>
                        <div class="form-group">
                            <label for="comments">Comments :</label>
                            <textarea class="form-control" name="comments" id="comments" rows="3"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer" style="border-top:1px solid #e2e8f0;padding:16px 20px;">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary" style="background:#6366f1;border:none;">Save Payment</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

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
                    {data: "sn", searchable: false, orderable: false, className: "text-center"},
                    {data: "reseller_id", name: "reseller_id", className: "text-center"},
                    {data: "debit_balance", name: "debit_balance", searchable: false, orderable: false, className: "text-center"},
                    {data: "credit_balance", name: "credit_balance", searchable: false, orderable: false, className: "text-center"},
                    {data: "action", name: "action", searchable: false, orderable: false, className: "text-center"},
                ],
                lengthMenu: [[15, 50, 100, -1], [15, 50, 100, "All"]],
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
                                $(".msg").html("<div class='alert alert-success alert-dismissible' role='alert'> <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>" + resData.message + "</div>");
                                sellerWiseCommissionTbl.ajax.reload();
                                setTimeout(function(){
                                    $('#exampleModal').modal('hide');
                                    // Reset form and message
                                    $("form[name=sellerPaymentForm]")[0].reset();
                                    $(".msg").html("");
                                }, 1500);
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
            
            jQuery(function($) {
                $('.chosen-select').chosen({allow_single_deselect: true});
            });
        });
    </script>
@endsection
