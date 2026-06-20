@extends('backend.layouts.master')

@section('content')
    <div class="content-wrapper">
        <!-- Content Header -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6">
                        <h5 class="m-0">
                            <i class='fas fa-truck'></i>
                            Courier Assigned Orders
                        </h5>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li class="breadcrumb-item active">Courier Orders</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <section class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="msg"></div>
                                <table id="CourierOrderTbl" class="table table-bordered table-striped nowrap dt-responsive" style="width: 100%">
                                    <thead>
                                        <tr style="background:#b6f7f4">
                                            <th width="4%">SN</th>
                                            <th class="text-center" width="4%">
                                                <input type="checkbox" id="selectAllOrders" style="width:17px;height:17px;">
                                            </th>
                                            <th>Order No</th>
                                            <th>Total Amount</th>
                                            <th>Payment Type</th>
                                            <th>Courier</th>
                                            <th>Order Date</th>
                                            <th>Status</th>
                                            <th width="12%">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>

                                <!-- Bulk Actions Row -->
                                <div class="row mt-3">
                                    <div class="col-md-6">
                                        <!-- Status Update Form -->
                                        <form name="addDeliveryStatusForm" class="form-inline" method="post" action="#"
                                            autocomplete="off" onsubmit="return false">
                                            <div class="form-group mx-sm-3 mb-2" style="margin-left:0px !important;">
                                                <select name="status" class="form-control form-control-sm" style="height:25px;">
                                                    <option value="">Select Order Status</option>
                                                    <option value="pending">Pending</option>
                                                    <option value="confirmed">Confirmed</option>
                                                    <option value="packaging">Packaging</option>
                                                    <option value="shipment">Shipment</option>
                                                    <option value="delivered">Delivered</option>
                                                    <option value="canceled">Canceled</option>
                                                    <option value="return">Return</option>
                                                </select>
                                            </div>
                                            <button type="submit" class="btn btn-danger btn-sm mb-2"><i
                                                    class='fas fa-paper-plane'></i> Change Order Status</button>
                                        </form>
                                    </div>
                                    <div class="col-md-6">
                                        <!-- Courier Assignment Form -->
                                        <form name="bulkCourierForm" class="form-inline" method="post" action="#"
                                            autocomplete="off" onsubmit="return false">
                                            <div class="form-group mx-sm-3 mb-2" style="margin-left:0px !important;">
                                                <select name="courier" class="form-control form-control-sm" style="height:25px;">
                                                    <option value="">Select Courier</option>
                                                    <option value="steadfast">Steadfast</option>
                                                    <option value="pathao">Pathao</option>
                                                    <option value="redx">RedX</option>
                                                </select>
                                            </div>
                                            <button type="submit" class="btn btn-success btn-sm mb-2"><i
                                                    class='fas fa-shipping-fast'></i> Send to Courier</button>
                                        </form>
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
                    {data: "DT_RowIndex", searchable: false, orderable: false},
                    {data: "checkbox", searchable: false, orderable: false, className: "text-center"},
                    {data: "order_no", name: "order_no"},
                    {data: "order_total", name: "order_total"},
                    {data: "payment_id", name: "payment_id", searchable: false, orderable: false},
                    {data: "courier_id", name: "courier_id"},
                    {data: "order_date", name: "order_date"},
                    {data: "status", name: "status", searchable: false, orderable: false},
                    {data: "action", name: "action", searchable: false, orderable: false},
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
            $("form[name=addDeliveryStatusForm]").submit(function() {
                var status = $("select[name=status]").val();
                if (status == "" || selectedODRs.length < 1) {
                    alert("Select at least one order ID and Order Status !");
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
            $("form[name=bulkCourierForm]").submit(function() {
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
