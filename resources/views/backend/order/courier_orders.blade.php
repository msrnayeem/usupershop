@extends('backend.layouts.master')

@section('content')
    <div class="content-wrapper">
        {{-- Page Header --}}
        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:22px;flex-wrap:wrap;gap:12px;">
            <div>
                <h1 style="font-size:22px;font-weight:800;color:#0f172a;margin:0;">
                    <i class="fas fa-truck-moving" style="color:#6366f1;margin-right:8px;"></i>
                    Courier Assigned Orders
                </h1>
                <p style="color:#64748b;font-size:13px;margin:2px 0 0;">
                    <a href="{{ route('home') }}" style="color:#6366f1;text-decoration:none;">Home</a>
                    <span style="margin:0 6px;color:#cbd5e1;">/</span>
                    Courier Orders
                </p>
            </div>
        </div>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <section class="col-md-12">
                        <div class="card">
                            <div class="card-header" style="display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:12px;">
                                <span class="card-title">
                                    <i class="fas fa-truck" style="color:#6366f1;margin-right:6px;"></i>
                                    Manage Courier Assigned Orders
                                </span>
                            </div>
                            <div class="card-body">
                                <div class="msg mb-3"></div>
                                <table id="CourierOrderTbl" class="table table-bordered table-striped nowrap dt-responsive" style="width: 100%">
                                    <thead>
                                        <tr>
                                            <th width="4%" class="text-center">SN</th>
                                            <th class="text-center" width="4%">
                                                <input type="checkbox" id="selectAllOrders" style="width:16px;height:16px;">
                                            </th>
                                            <th class="text-center">Order No</th>
                                            <th class="text-center">Total Amount</th>
                                            <th class="text-center">Payment Type</th>
                                            <th class="text-center">Courier</th>
                                            <th class="text-center">Order Date</th>
                                            <th class="text-center">Status</th>
                                            <th width="12%" class="text-center">Action</th>
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
                                        <button type="submit" id="bulkStatusBtn"
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
                                        <button type="submit" id="bulkCourierBtn"
                                            style="height:34px;padding:0 14px;background:#10b981;color:#fff;border:none;border-radius:8px;font-size:13px;font-weight:600;cursor:pointer;display:inline-flex;align-items:center;gap:6px;">
                                            <i class="fas fa-shipping-fast"></i> Send
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </section>
    </div>

    <script>
        $(function () {
            let selectedODRs = [];

            let courierOrderTbl = $("#CourierOrderTbl").DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('orders.courier.data') }}",
                columns: [
                    {data: "DT_RowIndex", searchable: false, orderable: false, className: "text-center"},
                    {data: "checkbox", searchable: false, orderable: false, className: "text-center"},
                    {data: "order_no", name: "order_no", className: "text-center"},
                    {data: "order_total", name: "order_total", className: "text-center"},
                    {data: "payment_id", name: "payment_id", searchable: false, orderable: false, className: "text-center"},
                    {data: "courier_id", name: "courier_id", className: "text-center"},
                    {data: "order_date", name: "order_date", className: "text-center"},
                    {data: "status", name: "status", searchable: false, orderable: false, className: "text-center"},
                    {data: "action", name: "action", searchable: false, orderable: false, className: "text-center"},
                ],
                lengthMenu: [[15, 50, 100, -1], [15, 50, 100, "All"]],
                pageLength: 15
            });

            // Select All logic
            $('#selectAllOrders').click(function() {
                if ($(this).is(':checked')) {
                    $('.checkedOrds').prop('checked', true);
                    updateSelectedOrders();
                } else {
                    $('.checkedOrds').prop('checked', false);
                    selectedODRs = [];
                }
            });

            // Individual checkbox logic
            $('#CourierOrderTbl').on('click', '.checkedOrds', function() {
                updateSelectedOrders();
            });

            function updateSelectedOrders() {
                selectedODRs = [];
                $('.checkedOrds:checked').each(function() {
                    selectedODRs.push($(this).val());
                });
            }

            // Status update logic
            $("#bulkStatusBtn").click(function() {
                var status = $("select[name=status]").val();
                if (status == "" || selectedODRs.length < 1) {
                    alert("Select at least one order and status!");
                    return;
                }

                showLoading();

                $.ajax({
                    type: 'POST',
                    url: "{{ route('status.update') }}",
                    data: {
                        _token: "{{ csrf_token() }}",
                        status: status,
                        selectedODRs: selectedODRs
                    },
                    success: function(resData, textStatus, jqXHR) {
                        hideLoading();
                        if (textStatus == 'success') {
                            showAlert('success', resData.message);
                            courierOrderTbl.ajax.reload();
                            resetSelections();
                        }
                    },
                    error: function(xhr) {
                        hideLoading();
                        showAlert('error', xhr.responseJSON?.message || "Failed to update status");
                    }
                });
            });

            // Bulk courier assignment logic
            $("#bulkCourierBtn").click(function() {
                var courier = $("select[name=courier]").val();
                if (courier == "" || selectedODRs.length < 1) {
                    alert("Please select at least one order and a courier!");
                    return;
                }
                
                var courierName = $("select[name=courier] option:selected").text();
                
                if (confirm(`Are you sure you want to assign ${selectedODRs.length} orders to ${courierName}?`)) {
                    showLoading();
                    
                    $.ajax({
                        type: 'POST',
                        url: "{{ route('courier.bulk.assign') }}",
                        data: {
                            _token: "{{ csrf_token() }}",
                            courier_id: courier,
                            orders: selectedODRs,
                            priority: 'normal'
                        },
                        success: function(resData) {
                            hideLoading();
                            showAlert('success', resData.message);
                            courierOrderTbl.ajax.reload();
                            resetSelections();
                        },
                        error: function(xhr) {
                            hideLoading();
                            showAlert('error', xhr.responseJSON?.message || "Failed to assign orders");
                        }
                    });
                }
            });

            function resetSelections() {
                selectedODRs = [];
                $('#selectAllOrders').prop('checked', false);
                $('.checkedOrds').prop('checked', false);
            }

            function showLoading() {
                if (!$('#loadingModal').length) {
                    $('body').append(`
                        <div class="modal fade" id="loadingModal" tabindex="-1" data-backdrop="static" data-keyboard="false">
                            <div class="modal-dialog modal-sm modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-body text-center">
                                        <div class="spinner-border text-primary" role="status">
                                            <span class="sr-only">Loading...</span>
                                        </div>
                                        <div class="mt-2">Processing...</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    `);
                }
                $('#loadingModal').modal('show');
            }

            function hideLoading() {
                $('#loadingModal').modal('hide');
            }

            function showAlert(type, message) {
                var alertClass = type === 'error' ? 'alert-danger' : 'alert-success';
                $(".msg").html(`
                    <div class='alert ${alertClass} alert-dismissible' role='alert'>
                        <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                            <span aria-hidden='true'>&times;</span>
                        </button>
                        ${message}
                    </div>
                `);
                if (type === 'success') {
                    setTimeout(function() { $('.alert').fadeOut(); }, 5000);
                }
            }
        });
    </script>
@endsection
