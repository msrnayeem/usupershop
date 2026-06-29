@extends('backend.layouts.master')
@section('content')
<div class="content-wrapper">

    {{-- Page Header --}}
    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:22px;flex-wrap:wrap;gap:12px;">
        <div>
            <h1 style="font-size:22px;font-weight:800;color:#0f172a;margin:0;">
                <i class="fas fa-list-alt" style="color:#6366f1;margin-right:8px;"></i>All Orders
            </h1>
            <p style="color:#64748b;font-size:13px;margin:2px 0 0;">
                <a href="{{ route('home') }}" style="color:#6366f1;text-decoration:none;">Home</a>
                <span style="margin:0 6px;color:#cbd5e1;">/</span>All Orders
            </p>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header" style="display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:12px;">
                    <span class="card-title"><i class="fas fa-shopping-cart" style="color:#6366f1;margin-right:6px;"></i>Manage All Orders</span>
                </div>
                <div class="card-body">
                    <div class="msg mb-3"></div>

                    {{-- Filter Bar --}}
                    <div style="display:flex;align-items:center;flex-wrap:wrap;gap:10px;margin-bottom:18px;padding:14px 16px;background:#f8fafc;border:1px solid #e2e8f0;border-radius:10px;">
                        <label style="font-size:12px;font-weight:600;color:#64748b;margin:0;">From</label>
                        <input type="text" name="src_from" readonly id="src_from" value=""
                            style="height:34px;width:110px;padding:0 10px;border:1px solid #d1d5db;border-radius:8px;font-size:13px;color:#0f172a;background:#fff;">
                        <script>Calendar.setup({inputField:"src_from",ifFormat:"%Y-%m-%d",showsTime:false,button:"src_from",singleClick:true,step:1});</script>

                        <label style="font-size:12px;font-weight:600;color:#64748b;margin:0;">To</label>
                        <input type="text" name="src_to" readonly id="src_to" value=""
                            style="height:34px;width:110px;padding:0 10px;border:1px solid #d1d5db;border-radius:8px;font-size:13px;color:#0f172a;background:#fff;">
                        <script>Calendar.setup({inputField:"src_to",ifFormat:"%Y-%m-%d",showsTime:false,button:"src_to",singleClick:true,step:1});</script>

                        <select id="orderstatus" name="orderstatus"
                            style="height:34px;padding:0 10px;border:1px solid #d1d5db;border-radius:8px;font-size:13px;color:#0f172a;background:#fff;min-width:160px;">
                            <option value="">All Statuses</option>
                            <option value="pending">Pending</option>
                            <option value="confirmed">Confirmed</option>
                            <option value="canceled">Canceled</option>
                            <option value="packaging">Packaging</option>
                            <option value="shipment">Shipment</option>
                            <option value="delivered">Delivered</option>
                            <option value="return">Return</option>
                        </select>

                        <button id="searchData" type="button"
                            style="height:34px;padding:0 16px;background:#6366f1;color:#fff;border:none;border-radius:8px;font-size:13px;font-weight:600;cursor:pointer;display:inline-flex;align-items:center;gap:6px;">
                            <i class="fas fa-search"></i> Search
                        </button>
                    </div>

                    {{-- DataTable --}}
                    <table id="appOrderTbl" class="table table-bordered table-striped nowrap dt-responsive" style="width:100%">
                        <thead>
                            <tr>
                                <th class="text-center" width="4%">SN</th>
                                <th class="text-center"><input type="checkbox" id="oderID" style="width:16px;height:16px;"></th>
                                <th class="text-center">Order No</th>
                                <th class="text-center">Total Amt.</th>
                                <th class="text-center">Payment Type</th>
                                <th class="text-center">Order Date</th>
                                <th class="text-center">Status</th>
                                <th class="text-center" width="12%">Action</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>

                    {{-- Bulk Action Bar --}}
                    <div style="display:flex;flex-wrap:wrap;gap:12px;margin-top:18px;padding:14px 16px;background:#f8fafc;border:1px solid #e2e8f0;border-radius:10px;align-items:center;">
                        <div style="display:flex;align-items:center;gap:8px;">
                            <span style="font-size:12px;font-weight:600;color:#64748b;">Bulk Status:</span>
                            <select name="status" style="height:34px;padding:0 10px;border:1px solid #d1d5db;border-radius:8px;font-size:13px;background:#fff;color:#0f172a;min-width:160px;">
                                <option value="">Select Status</option>
                                <option value="pending">Pending</option>
                                <option value="confirmed">Confirmed</option>
                                <option value="packaging">Packaging</option>
                                <option value="shipment">Shipment</option>
                                <option value="delivered">Delivered</option>
                                <option value="canceled">Canceled</option>
                                <option value="return">Return</option>
                            </select>
                            <button type="button" id="bulkStatusBtn"
                                style="height:34px;padding:0 14px;background:#6366f1;color:#fff;border:none;border-radius:8px;font-size:13px;font-weight:600;cursor:pointer;display:inline-flex;align-items:center;gap:6px;">
                                <i class="fas fa-paper-plane"></i> Apply
                            </button>
                        </div>
                        <div style="display:flex;align-items:center;gap:8px;">
                            <span style="font-size:12px;font-weight:600;color:#64748b;">Courier:</span>
                            <select name="courier" style="height:34px;padding:0 10px;border:1px solid #d1d5db;border-radius:8px;font-size:13px;background:#fff;color:#0f172a;min-width:140px;">
                                <option value="">Select Courier</option>
                                <option value="steadfast">Steadfast</option>
                                <option value="pathao">Pathao</option>
                                <option value="redx">RedX</option>
                            </select>
                            <button type="button" id="bulkCourierBtn"
                                style="height:34px;padding:0 14px;background:#10b981;color:#fff;border:none;border-radius:8px;font-size:13px;font-weight:600;cursor:pointer;display:inline-flex;align-items:center;gap:6px;">
                                <i class="fas fa-shipping-fast"></i> Send
                            </button>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>
</div>

{{-- Courier Assignment Modal --}}
<div class="modal fade" id="courierModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content" style="border-radius:12px;border:none;box-shadow:0 20px 60px rgba(0,0,0,0.15);">
            <div class="modal-header" style="background:linear-gradient(135deg,#10b981,#059669);border-radius:12px 12px 0 0;">
                <h5 class="modal-title" style="color:#fff;font-weight:700;">
                    <i class="fas fa-shipping-fast"></i> Assign to Courier
                </h5>
                <button type="button" class="close" data-dismiss="modal" style="color:#fff;opacity:1;">&times;</button>
            </div>
            <div class="modal-body" style="padding:24px;">
                <form id="courier-assignment-form">
                    <input type="hidden" id="order-id" name="order_id">
                    <div class="row">
                        <div class="col-md-6">
                            <div style="background:#f0fdf4;border-left:4px solid #10b981;border-radius:8px;padding:14px 16px;margin-bottom:16px;">
                                <h6 style="font-size:13px;font-weight:700;color:#059669;margin-bottom:10px;"><i class="fas fa-info-circle"></i> Order Info</h6>
                                <table style="width:100%;font-size:13px;">
                                    <tr><td style="color:#64748b;padding:3px 0;">Order No:</td><td id="modal-order-no" style="font-weight:600;color:#0f172a;">-</td></tr>
                                    <tr><td style="color:#64748b;padding:3px 0;">Amount:</td><td id="modal-order-amount" style="font-weight:600;color:#0f172a;">-</td></tr>
                                    <tr><td style="color:#64748b;padding:3px 0;">Payment:</td><td id="modal-payment-type" style="color:#0f172a;">-</td></tr>
                                    <tr><td style="color:#64748b;padding:3px 0;">Date:</td><td id="modal-order-date" style="color:#0f172a;">-</td></tr>
                                </table>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Select Courier <span style="color:#ef4444;">*</span></label>
                                <select class="form-control" id="courier-select" name="courier_id" required>
                                    <option value="">Choose Courier...</option>
                                    <option value="steadfast">Steadfast</option>
                                    <option value="pathao">Pathao</option>
                                    <option value="redx">RedX</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Priority</label>
                                <select class="form-control" id="priority-select" name="priority">
                                    <option value="normal">Normal</option>
                                    <option value="urgent">Urgent</option>
                                    <option value="express">Express</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Special Notes</label>
                                <textarea class="form-control" id="courier-notes" name="notes" rows="3" placeholder="Any special instructions..."></textarea>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer" style="border-top:1px solid #e2e8f0;padding:16px 24px;">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                    <i class="fas fa-times"></i> Cancel
                </button>
                <button type="button" id="confirm-courier-assignment"
                    style="padding:8px 20px;background:#10b981;color:#fff;border:none;border-radius:8px;font-weight:600;cursor:pointer;">
                    <i class="fas fa-paper-plane"></i> Send to Courier
                </button>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    var src_from = null, src_to = null, status = null;

    $('#searchData').click(function() {
        src_from = $('#src_from').val();
        src_to   = $('#src_to').val();
        status   = $('#orderstatus').val();
        appOrderTbl.draw();
    });

    let appOrderTbl = $("#appOrderTbl").DataTable({
        processing: true, serverSide: true,
        ajax: {
            url: "{{ route('orders.list') }}",
            data: function(d) { d.customFilter = {src_from, src_to, status}; },
            type: "GET"
        },
        columns: [
            {data:"sn",searchable:false,orderable:false,className:"text-center"},
            {data:"check_box",searchable:false,orderable:false,className:"text-center"},
            {data:"order_no",name:"order_no",className:"text-center"},
            {data:"order_total",name:"order_total",className:"text-center",render:d=>'৳'+parseFloat(d).toLocaleString()},
            {data:"payment_id",name:"payment_id",className:"text-center",searchable:false,orderable:false},
            {data:"order_date",name:"order_date",className:"text-center",searchable:false,orderable:false},
            {data:"status",name:"status",className:"text-center",searchable:false,orderable:false},
            {data:"action",name:"action",className:"text-center",searchable:false,orderable:false},
        ],
        lengthMenu:[[15,50,100,-1],[15,50,100,"All"]]
    });

    let selectedODRs = [];
    $('#oderID').click(function() {
        if ($(this).is(':checked')) {
            $('input[type=checkbox]').prop('checked',true);
            $('.checkedOrds:checked').each(function(){ selectedODRs.push($(this).val()); });
        } else { $('input[type=checkbox]').prop('checked',false); selectedODRs = []; }
    });
    appOrderTbl.on('click','tr td > .checkedOrds',function(){
        var v=$(this).val(), i=selectedODRs.indexOf(v);
        i===-1 ? selectedODRs.push(v) : selectedODRs.splice(i,1);
    });

    $('#bulkStatusBtn').click(function(){
        var st=$('select[name=status]').val();
        if(!st||selectedODRs.length<1){alert('Select at least one order and a status!');return;}
        $.post("{{ route('status.update') }}",{_token:"{{ csrf_token() }}",status:st,selectedODRs},function(r){
            showAlert('success',r.message); appOrderTbl.ajax.reload(); selectedODRs=[];
        }).fail(function(x){showAlert('error',x.responseJSON?.message||'Error');});
    });

    $('#bulkCourierBtn').click(function(){
        var c=$('select[name=courier]').val();
        if(!c||selectedODRs.length<1){alert('Select at least one order and a courier!');return;}
        if(confirm(`Send ${selectedODRs.length} orders to ${$('select[name=courier] option:selected').text()}?`)){
            $.post("{{ route('courier.bulk.assign') }}",{_token:"{{ csrf_token() }}",courier_id:c,orders:selectedODRs,priority:'normal'},function(r){
                showAlert('success',r.message||'Done!'); appOrderTbl.ajax.reload(); selectedODRs=[]; $('select[name=courier]').val('');
            }).fail(function(x){showAlert('error',x.responseJSON?.message||'Error');});
        }
    });

    $('#confirm-courier-assignment').click(function(){
        var d={_token:"{{ csrf_token() }}",order_id:$('#order-id').val(),courier_id:$('#courier-select').val(),priority:$('#priority-select').val(),notes:$('#courier-notes').val()};
        if(!d.courier_id){alert('Please select a courier');return;}
        $(this).prop('disabled',true).html('<i class="fas fa-spinner fa-spin"></i> Sending...');
        $.post("{{ route('courier.assign') }}",d,function(r){
            $('#confirm-courier-assignment').prop('disabled',false).html('<i class="fas fa-paper-plane"></i> Send to Courier');
            showAlert('success',r.message+(r.tracking_id?'<br><strong>Tracking ID:</strong> '+r.tracking_id:''));
            $('#courierModal').modal('hide'); appOrderTbl.ajax.reload();
        }).fail(function(x){
            $('#confirm-courier-assignment').prop('disabled',false).html('<i class="fas fa-paper-plane"></i> Send to Courier');
            showAlert('error',x.responseJSON?.message||'Error');
        });
    });

    window.openCourierModal = function(o){
        $('#order-id').val(o.order_no||o.id);
        $('#modal-order-no').text(o.order_no);
        $('#modal-order-amount').text('৳'+parseFloat(o.order_total).toLocaleString());
        $('#modal-payment-type').text(o.payment_id);
        $('#modal-order-date').text(o.order_date);
        $('#courier-assignment-form')[0].reset();
        $('#courierModal').modal('show');
    };

    function showAlert(type,msg){
        var cls=type==='error'?'alert-danger':type==='success'?'alert-success':'alert-info';
        $('.msg').html(`<div class='alert ${cls} alert-dismissible'><button type='button' class='close' data-dismiss='alert'>&times;</button>${msg}</div>`);
        if(type==='success') setTimeout(()=>$('.alert').fadeOut(),5000);
    }
});
</script>
@endsection