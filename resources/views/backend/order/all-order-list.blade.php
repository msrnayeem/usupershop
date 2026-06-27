@extends('backend.layouts.master')
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6">
                        <h5 class="m-0"><i class='fas fa-hand-point-right'></i> Manage All Orders</h5>
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li class="breadcrumb-item active">All Orders</li>
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
                                
                                <!-- Search Form -->
                                <form name="searchOrderForm" id="searchOrderForm" class="form-inline" method="GET"
                                    action="#" autocomplete="off" onsubmit="return false">
                                    <label class="mx-sm-3 mb-2"
                                        style="margin-left:0px !important; font-weight: normal !important;">From :</label>
                                    <div class="form-group mx-sm-3 mb-2" style="margin-left:0px !important;">
                                        <input type="text" name="src_from" readonly="readonly" size="9"
                                            class="form-control form-control-sm" id="src_from" value=""
                                            style="height: 25px;">
                                        <script type="text/javascript">
                                            Calendar.setup({
                                                inputField: "src_from",
                                                ifFormat: "%Y-%m-%d",
                                                showsTime: false,
                                                button: "src_from",
                                                singleClick: true,
                                                step: 1
                                            });
                                        </script>
                                    </div>
                                    <label class="mx-sm-3 mb-2"
                                        style="margin-left:0px !important; font-weight: normal !important;">To :</label>
                                    <div class="form-group mx-sm-3 mb-2" style="margin-left:0px !important;">
                                        <input type="text" name="src_to" readonly="readonly" size="9"
                                            class="form-control form-control-sm" id="src_to" value=""
                                            style="height: 25px;">
                                        <script type="text/javascript">
                                            Calendar.setup({
                                                inputField: "src_to",
                                                ifFormat: "%Y-%m-%d",
                                                showsTime: false,
                                                button: "src_to",
                                                singleClick: true,
                                                step: 1
                                            });
                                        </script>
                                    </div>

                                    <div class="form-group mx-sm-3 mb-2" style="margin-left:0px !important;">
                                        <select name="orderstatus" id="orderstatus" class="form-control form-control-sm"
                                            style="height:26px;">
                                            <option value="">Select Order Status</option>
                                            <option value="pending">Pending</option>
                                            <option value="confirmed">Confirmed</option>
                                            <option value="canceled">Canceled</option>
                                            <option value="packaging">Packaging</option>
                                            <option value="shipment">Shipment</option>
                                            <option value="delivered">Delivered</option>
                                            <option value="return">Return</option>
                                        </select>
                                    </div>
                                    <button type="submit" id="searchData" class="btn btn-info btn-sm mb-2"><i
                                            class='fas fa-search'></i> Search</button>
                                </form>

                                <!-- Orders Table -->
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
                                            <th width="12%" class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
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
                            <!-- /.card-body -->
                        </div>
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

    <!-- Courier Assignment Modal -->
    <div class="modal fade" id="courierModal" tabindex="-1" role="dialog" aria-labelledby="courierModalLabel">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title" id="courierModalLabel">
                        <i class="fas fa-shipping-fast"></i> Assign to Courier
                    </h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="courier-assignment-form">
                        <input type="hidden" id="order-id" name="order_id">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="order-info-card">
                                    <h6 class="text-success"><i class="fas fa-info-circle"></i> Order Information</h6>
                                    <table class="table table-sm table-borderless">
                                        <tr>
                                            <td><strong>Order No:</strong></td>
                                            <td id="modal-order-no">-</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Amount:</strong></td>
                                            <td id="modal-order-amount">-</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Payment:</strong></td>
                                            <td id="modal-payment-type">-</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Date:</strong></td>
                                            <td id="modal-order-date">-</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="courier-select" class="required">Select Courier</label>
                                    <select class="form-control" id="courier-select" name="courier_id" required>
                                        <option value="">Choose Courier...</option>
                                        <option value="steadfast">Steadfast</option>
                                        <option value="pathao">Pathao</option>
                                        <option value="redx">RedX</option>
                                    
                                    </select>
                                </div>
                                
                                <div class="form-group">
                                    <label for="priority-select">Priority</label>
                                    <select class="form-control" id="priority-select" name="priority">
                                        <option value="normal">Normal</option>
                                        <option value="urgent">Urgent</option>
                                        <option value="express">Express</option>
                                    </select>
                                </div>
                                
                                <div class="form-group">
                                    <label for="courier-notes">Special Notes</label>
                                    <textarea class="form-control" id="courier-notes" name="notes" rows="3" 
                                              placeholder="Any special delivery instructions..."></textarea>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        <i class="fas fa-times"></i> Cancel
                    </button>
                    <button type="button" class="btn btn-success" id="confirm-courier-assignment">
                        <i class="fas fa-paper-plane"></i> Send to Courier
                    </button>
                </div>
            </div>
        </div>
    </div>

    <style>
        .order-info-card {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
            border-left: 4px solid #28a745;
        }
        
        .required:after {
            content: "*";
            color: red;
        }
        
        .courier-btn {
            background: linear-gradient(45deg, #28a745, #20c997);
            border: none;
            color: white;
            padding: 2px 8px;
            border-radius: 3px;
            font-size:13px;
        }
        
        .courier-btn:hover {
            background: linear-gradient(45deg, #218838, #1ea99e);
            color: white;
            text-decoration: none;
        }

        .courier-info {
            background: #d4edda;
            color: #155724;
            padding: 2px 6px;
            border-radius: 3px;
            font-size:12px;
            font-weight: bold;
        }
    </style>

    <script type="text/javascript">
      // Updated JavaScript for the view file

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
            url: "{{ route('orders.list') }}",
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
                orderable: false,
                className: "text-center",
            },
            {
                data: "check_box",
                searchable: false,
                orderable: false,
                className: "text-center",
            },
            {
                data: "order_no",
                name: "order_no",
                className: "text-center",
            },
            {
                data: "order_total",
                name: "order_total",
                className: "text-center",
                render: function(data, type, row) {
                    return '৳' + parseFloat(data).toLocaleString();
                }
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
                data: "action",
                name: "action",
                className: "text-center",
                searchable: false,
                orderable: false
            },
        ],
        lengthMenu: [
            [15, 50, 100, -1],
            [15, 50, 100, "All"]
        ],
    });

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

    // Status update functionality
    $("form[name=addDeliveryStatusForm]").submit(function() {
        var status = $("select[name=status]").val();
        if (status == "" || selectedODRs.length < 1) {
            alert("select at least one order ID and Order Status !");
            return;
        }
        
        // Show loading
        showLoading();
        
        $.ajax({
            cache: false,
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
                    if (jqXHR.status >= 203) {
                        showAlert('info', resData.message);
                    } else {
                        showAlert('success', resData.message);
                    }
                    appOrderTbl.ajax.reload();
                    resetSelections();
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                hideLoading();
                showAlert('error', jqXHR.responseJSON?.message || errorThrown);
            }
        });
    });

    // Enhanced bulk courier assignment functionality
    $("form[name=bulkCourierForm]").submit(function() {
        var courier = $("select[name=courier]").val();
        if (courier == "" || selectedODRs.length < 1) {
            alert("Please select at least one order and a courier!");
            return;
        }
        
        var courierName = $("select[name=courier] option:selected").text();
        
        if (confirm(`Are you sure you want to assign ${selectedODRs.length} orders to ${courierName} courier?\n\nThis will send the orders to the courier API.`)) {
            // Show loading with progress
            showLoadingWithProgress(`Sending ${selectedODRs.length} orders to ${courierName}...`);
            
            $.ajax({
                cache: false,
                type: 'POST',
                url: "{{ route('courier.bulk.assign') }}",
                data: {
                    _token: "{{ csrf_token() }}",
                    courier_id: courier,
                    orders: selectedODRs,
                    priority: 'normal'
                },
                success: function(resData, textStatus, jqXHR) {
                    hideLoading();
                    
                    if (textStatus == 'success') {
                        showDetailedResult(resData);
                        appOrderTbl.ajax.reload();
                        resetSelections();
                        $("select[name=courier]").val('');
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    hideLoading();
                    var errorMessage = jqXHR.responseJSON?.message || errorThrown;
                    showAlert('error', 'Failed to assign orders to courier: ' + errorMessage);
                }
            });
        }
    });

    // Enhanced individual courier assignment
    $('#confirm-courier-assignment').on('click', function() {
        const courierData = {
            _token: "{{ csrf_token() }}",
            order_id: $('#order-id').val(),
            courier_id: $('#courier-select').val(),
            priority: $('#priority-select').val(),
            notes: $('#courier-notes').val()
        };
        
        if (!courierData.courier_id) {
            alert('Please select a courier');
            return;
        }
        
        // Disable button and show loading
        $(this).prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Sending...');
        
        $.ajax({
            url: "{{ route('courier.assign') }}",
            method: 'POST',
            data: courierData,
            success: function(response) {
                $('#confirm-courier-assignment')
                    .prop('disabled', false)
                    .html('<i class="fas fa-paper-plane"></i> Send to Courier');
                
                showAlert('success', response.message + 
                    (response.tracking_id ? '<br><strong>Tracking ID:</strong> ' + response.tracking_id : ''));
                
                $('#courierModal').modal('hide');
                appOrderTbl.ajax.reload();
            },
            error: function(xhr) {
                $('#confirm-courier-assignment')
                    .prop('disabled', false)
                    .html('<i class="fas fa-paper-plane"></i> Send to Courier');
                
                var errorMessage = xhr.responseJSON?.message || 'Something went wrong';
                showAlert('error', errorMessage);
            }
        });
    });

    // Track order functionality
    function trackOrder(orderNo) {
        showLoading();
        
        $.ajax({
            url: "{{ route('courier.track') }}",
            method: 'POST',
            data: {
                _token: "{{ csrf_token() }}",
                order_id: orderNo
            },
            success: function(response) {
                hideLoading();
                showTrackingInfo(response);
            },
            error: function(xhr) {
                hideLoading();
                showAlert('error', xhr.responseJSON?.message || 'Failed to track order');
            }
        });
    }

    // Helper functions
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

    function showLoadingWithProgress(message) {
        if (!$('#loadingModal').length) {
            $('body').append(`
                <div class="modal fade" id="loadingModal" tabindex="-1" data-backdrop="static" data-keyboard="false">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-body text-center">
                                <div class="spinner-border text-primary mb-3" role="status">
                                    <span class="sr-only">Loading...</span>
                                </div>
                                <h5 id="loading-message">Processing...</h5>
                                <div class="progress mt-3">
                                    <div class="progress-bar progress-bar-striped progress-bar-animated" 
                                         role="progressbar" style="width: 100%"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            `);
        }
        $('#loading-message').text(message);
        $('#loadingModal').modal('show');
    }

    function hideLoading() {
        setTimeout(function() {
            $('#loadingModal').modal('hide');
            setTimeout(function() {
                $('.modal-backdrop').remove();
                $('body').removeClass('modal-open');
            }, 300);
        }, 500);
    }

    function showAlert(type, message) {
        var alertClass = type === 'error' ? 'alert-danger' : 
                        type === 'success' ? 'alert-success' : 
                        type === 'info' ? 'alert-info' : 'alert-warning';
        
        $(".msg").html(`
            <div class='alert ${alertClass} alert-dismissible' role='alert'>
                <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                    <span aria-hidden='true'>&times;</span>
                </button>
                ${message}
            </div>
        `);

        // Auto hide after 5 seconds for success messages
        if (type === 'success') {
            setTimeout(function() {
                $('.alert').fadeOut();
            }, 5000);
        }
    }

    function showDetailedResult(response) {
        var successCount = 0;
        var failCount = 0;
        var details = '';

        if (response.details) {
            response.details.forEach(function(detail) {
                if (detail.result.success) {
                    successCount++;
                    details += `<div class="text-success">✓ ${detail.order_no}: ${detail.result.message}`;
                    if (detail.result.tracking_id) {
                        details += ` (ID: ${detail.result.tracking_id})`;
                    }
                    details += `</div>`;
                } else {
                    failCount++;
                    details += `<div class="text-danger">✗ ${detail.order_no}: ${detail.result.message}</div>`;
                }
            });
        }

        var modalHtml = `
            <div class="modal fade" id="resultModal" tabindex="-1">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header bg-info text-white">
                            <h5 class="modal-title">Courier Assignment Results</h5>
                            <button type="button" class="close text-white" data-dismiss="modal">
                                <span>&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <div class="card bg-success text-white">
                                        <div class="card-body text-center">
                                            <h3>${successCount}</h3>
                                            <p>Successfully Sent</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="card bg-danger text-white">
                                        <div class="card-body text-center">
                                            <h3>${failCount}</h3>
                                            <p>Failed</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="details-section">
                                <h6>Details:</h6>
                                <div style="max-height: 300px; overflow-y: auto;">
                                    ${details}
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
        `;

        // Remove existing modal
        $('#resultModal').remove();
        $('body').append(modalHtml);
        $('#resultModal').modal('show');
    }

    function showTrackingInfo(response) {
        var trackingHtml = `
            <div class="modal fade" id="trackingModal" tabindex="-1">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header bg-primary text-white">
                            <h5 class="modal-title">
                                <i class="fas fa-map-marker-alt"></i> Order Tracking Information
                            </h5>
                            <button type="button" class="close text-white" data-dismiss="modal">
                                <span>&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <h6>Order Details:</h6>
                                    <table class="table table-sm">
                                        <tr><td><strong>Order No:</strong></td><td>${response.order.order_no}</td></tr>
                                        <tr><td><strong>Courier:</strong></td><td>${response.order.courier_name || 'N/A'}</td></tr>
                                        <tr><td><strong>Tracking ID:</strong></td><td>${response.order.courier_tracking_id || 'N/A'}</td></tr>
                                        <tr><td><strong>Status:</strong></td><td>${response.order.status}</td></tr>
                                    </table>
                                </div>
                                <div class="col-md-6">
                                    <h6>Courier Tracking:</h6>
                                    <div id="tracking-data">
                                        <pre>${JSON.stringify(response.tracking_data, null, 2)}</pre>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
        `;

        $('#trackingModal').remove();
        $('body').append(trackingHtml);
        $('#trackingModal').modal('show');
    }

    function resetSelections() {
        selectedODRs = [];
        $('#oderID').prop('checked', false);
        $('input[type=checkbox]').prop('checked', false);
    }

    // Global function to open courier modal (enhanced)
    window.openCourierModal = function(orderData) {
        $('#order-id').val(orderData.order_no || orderData.id);
        $('#modal-order-no').text(orderData.order_no);
        $('#modal-order-amount').text('৳' + parseFloat(orderData.order_total).toLocaleString());
        $('#modal-payment-type').text(orderData.payment_id);
        $('#modal-order-date').text(orderData.order_date);
        
        // Reset form
        $('#courier-assignment-form')[0].reset();
        $('#courier-select').val('');
        $('#priority-select').val('normal');
        
        $('#courierModal').modal('show');
    };

    // Global function to track order
    window.trackOrder = trackOrder;

    jQuery(function($) {
        $('.chosen-select').chosen({
            allow_single_deselect: true
        });
    });
});
    </script>
@endsection