@extends('backend.layouts.master')
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        {{-- Page Header --}}
        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:22px;flex-wrap:wrap;gap:12px;">
            <div>
                <h1 style="font-size:22px;font-weight:800;color:#0f172a;margin:0;">
                    <i class="fas fa-user-clock" style="color:#eab308;margin-right:8px;"></i>
                    Draft Dropshippers List
                </h1>
                <p style="color:#64748b;font-size:13px;margin:2px 0 0;">
                    <a href="{{ route('home') }}" style="color:#6366f1;text-decoration:none;">Home</a>
                    <span style="margin:0 6px;color:#cbd5e1;">/</span>
                    Draft Dropshippers
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
                                    Manage Draft Dropshippers
                                </span>
                            </div>
                            <div class="card-body">
                                <div class="msg"></div>
                                <table id="vendorDraftTbl" class="table table-bordered table-striped nowrap dt-responsive" style="width: 100%">
                                    <thead>
                                        <tr>
                                            <th width="6%" class="text-center">SN</th>
                                            <th class="text-center">Name</th>
                                            <th class="text-center">Email</th>
                                            <th class="text-center">Phone No</th>
                                            <th class="text-center">Address</th>
                                            <th class="text-center">Acc. Type</th>
                                            <th class="text-center">Signup Status</th>
                                            <th class="text-center">Payment</th>
                                            <th class="text-center">Status</th>
                                            <th width="16%" class="text-center">Action</th>
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
                columns: [
                    {data: "sn", searchable: false, orderable: false, className: "text-center"},
                    {data: "name", name: "name", className: "text-center"},
                    {data: "email", name: "email", className: "text-center"},
                    {data: "mobile", name: "mobile", className: "text-center"},
                    {data: "address", name: "address", className: "text-center"},
                    {data: "account_type", name: "account_type", className: "text-center"},
                    {data: "difference", name: "difference", searchable: false, orderable: false, className: "text-center"},
                    {data: "payment_status", name: "payment_status", searchable: false, orderable: false, className: "text-center"},
                    {data: "status", name: "status", searchable: false, orderable: false, className: "text-center"},
                    {data: "action", name: "action", searchable: false, orderable: false, className: "text-center"}
                ],
                lengthMenu: [[15, 50, 100, -1], [15, 50, 100, "All"]],
            });
        });

        function statusChangedPayment(id){
            var commission = $("#commission_"+id).val();
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
                            $(".msg").html("<div class='alert alert-danger alert-dismissible' role='alert' style='border-radius:8px;background:#fef2f2;color:#b91c1c;border:none;'> <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>" + resData.message + "</div>");
                        } else {
                            $(".msg").html("<div class='alert alert-success alert-dismissible' role='alert' style='border-radius:8px;background:#f0fdf4;color:#15803d;border:none;'> <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>" + resData.message + "</div>");
                        }
                        var table = $('#vendorDraftTbl').DataTable();
                        table.ajax.reload();
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    $(".msg").html(
                        "<div class='alert alert-danger alert-dismissible' role='alert' style='border-radius:8px;background:#fef2f2;color:#b91c1c;border:none;'> <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>" + jqXHR.status + ":" + errorThrown + "</div>"
                    );
                }
            });
        }
    </script>
@endsection
