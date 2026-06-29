@extends('backend.layouts.master')
@section('content')
    <div class="content-wrapper">
        {{-- Page Header --}}
        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:22px;flex-wrap:wrap;gap:12px;">
            <div>
                <h1 style="font-size:22px;font-weight:800;color:#0f172a;margin:0;">
                    <i class="fas fa-store" style="color:#6366f1;margin-right:8px;"></i>
                    Seller Orders
                </h1>
                <p style="color:#64748b;font-size:13px;margin:2px 0 0;">
                    <a href="{{ route('home') }}" style="color:#6366f1;text-decoration:none;">Home</a>
                    <span style="margin:0 6px;color:#cbd5e1;">/</span>
                    Seller Orders
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
                                    <i class="fas fa-shopping-cart" style="color:#6366f1;margin-right:6px;"></i>
                                    Manage Seller Orders
                                </span>
                            </div>
                            <div class="card-body">
                                <div class="msg mb-3"></div>
                           
                                <table id="appOrderTbl" class="table table-bordered table-striped nowrap dt-responsive" style="width: 100%">
                                    <thead>
                                        <tr>
                                            <th class="text-center" width="4%">SN</th>
                                            <th class="text-center" width="4%">
                                                <input type="checkbox" id="oderID" style="width:16px;height:16px;">
                                            </th>
                                            <th class="text-center">Order No</th>
                                            <th class="text-center">Total Amt.</th>
                                            <th class="text-center">Payment Type</th>
                                            <th class="text-center">Order Date</th>
                                            <th class="text-center">Status</th>
                                            <th class="text-center">Shop Name</th>
                                            <th class="text-center">Commission</th>
                                            <th class="text-center" width="16%">Action</th>
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
                                            <option value="delivered">Delivered</option>
                                            <option value="canceled">Canceled</option>
                                            <option value="return">Return</option>
                                        </select>
                                        <button type="submit" id="bulkStatusBtn"
                                            style="height:34px;padding:0 14px;background:#6366f1;color:#fff;border:none;border-radius:8px;font-size:13px;font-weight:600;cursor:pointer;display:inline-flex;align-items:center;gap:6px;">
                                            <i class="fas fa-paper-plane"></i> Apply
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

    <script type="text/javascript">
        $(document).ready(function() {
            var src_from = null;
            var src_to = null;
            var status = null;

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
                columns: [
                    {data: "sn", searchable: false, className: "text-center", orderable: false},
                    {data: "check_box", searchable: false, className: "text-center", orderable: false},
                    {data: "order_no", className: "text-center", name: "order_no"},
                    {data: "order_total", className: "text-center", name: "order_total"},
                    {data: "payment_id", name: "payment_id", className: "text-center", searchable: false, orderable: false},
                    {data: "order_date", name: "order_date", className: "text-center", searchable: false, orderable: false},
                    {data: "status", name: "status", className: "text-center", searchable: false, orderable: false},
                    {data: "shop", name: "shop", className: "text-center", searchable: false, orderable: false},
                    {data: "commission", name: "commission", className: "text-center", searchable: false, orderable: false},
                    {data: "action", name: "action", className: "text-center", searchable: false, orderable: false},
                ],
                lengthMenu: [[15, 50, 100, -1], [15, 50, 100, "All"]],
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

            $("#bulkStatusBtn").click(function() {
                var status = $("select[name=status]").val();
                if (status == "" || selectedODRs.length < 1) {
                    alert("Select at least one order and status!");
                    return;
                }
                showLoading();
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
                        hideLoading();
                        if (textStatus == 'success') {
                            if (jqXHR.status >= 203) {
                                showAlert('info', resData.message);
                            } else {
                                showAlert('warning', resData.message);
                            }
                            appOrderTbl.ajax.reload();
                            resetSelections();
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        hideLoading();
                        showAlert('error', errorThrown);
                    }
                });
            });

            function resetSelections() {
                selectedODRs = [];
                $('#oderID').prop('checked', false);
                $('input[type=checkbox]').prop('checked', false);
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
                var alertClass = type === 'error' ? 'alert-danger' : (type === 'info' ? 'alert-info' : 'alert-success');
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
