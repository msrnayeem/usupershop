@extends('backend.layouts.master')
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6">
                        <h5 class="m-0"><i class='fas fa-hand-point-right'></i> {{ $pageTitle }}</h5>
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li class="breadcrumb-item active">{{ $pageTitle }}</li>
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
<div class='row p-2 my-3 mx-4'>
                                <div class='col-4'>
                                    
                             <button type="button" class="btn btn-success btn-sm edit-commission"
                                                            data-toggle="modal" data-target="#vendorCommissionModal"
                                                            data-user-id=""
                                                            data-commission="">
                                                            Add Seller Commission
                                                        </button>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="msg"></div>
                                <div class="table-responsive">
                                    <table id="shopTblseller"
                                        class="dataTables table table-bordered table-striped nowrap dt-responsive" style="width: 100%">
                                        <thead>
                                            <tr>

                                                <th class="text-center" style="width: 40px;">SN</th>
                                                <th class="text-left">Name</th>
                                                <th class="text-left">Email</th>
                                                <th class="text-left">Phone No</th>
                                                <th class="text-left">Shop Name</th>
                                                <th class="text-left">Address</th>
                                                <th class="text-center">Commission</th>
                                                <th class="text-left">Registered / Active On</th>
                                                <th class="text-center">Payment</th>
                                                <th class="text-center">Status</th>
                                                <th class="text-center">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($sellers as $i => $seller)
                                                <tr>
                                                    <td class="text-center" style="width: 40px;">{{ ++$i }}</td>
                                                    <td class="text-left">{{ $seller->name }}</td>
                                                    <td class="text-left">{{ $seller->email }}</td>
                                                    <td class="text-left">{{ $seller->mobile }}</td>
                                                    <td class="text-left">{{ $seller->shop_name }}</td>
                                                    <td class="text-left">{{ $seller->address }}</td>
                                                    <td class="text-center">{{ $seller->commission . '%' }}</td>
                                                    <td class="text-left">
                                                        <div>
                                                            <small class="d-block text-muted">Registered</small>
                                                            {{ optional($seller->created_at)->format('d M Y, h:i A') ?? '--' }}
                                                        </div>
                                                        <div class="mt-1">
                                                            <small class="d-block text-muted">Active</small>
                                                            {{ optional($seller->activated_at ?: $seller->created_at)->format('d M Y, h:i A') ?? '--' }}
                                                        </div>
                                                    </td>
                                                     
                                                    <td class="text-center">
                                                        @if ($seller->payment_status == 1)
                                                            <span class="badge badge-success">Paid</span>
                                                        @else
                                                            <span class="badge badge-danger">UnPaid</span>
                                                        @endif
                                                    </td>
                                                    <td class="text-center">
                                                        @if ($seller->status == 0)
                                                            <span class="badge badge-info">Inactive</span>
                                                        @elseif ($seller->status == 1)
                                                            <span class="badge badge-success">Active</span>
                                                        @else
                                                            <span class="badge badge-danger">Suspended</span>
                                                        @endif
                                                    </td>
                                                    <td class="text-center">

                                                        @php
                                                            $reseller = App\Models\User::find($seller->reseller_id);
                                                        @endphp

                                                        @if ($reseller)
                                                            <button type="button" class="btn btn-success btn-sm edit-refer"
                                                                data-toggle="modal" data-target="#sellerReferModal"
                                                                data-reseller-id="{{ $reseller->id }}"
                                                                data-reseller-name="{{ $reseller->mobile }}"
                                                                data-reseller-balance="{{ $reseller->balance }}">
                                                                <i class="fas fa-money-bill"></i> Add Refer Balance
                                                            </button>
                                                        @endif


                                                        <button type="button" class="btn btn-success btn-sm edit-commission"
                                                            data-toggle="modal" data-target="#sellerCommissionModal"
                                                            data-user-id="{{ $seller->id }}"
                                                            data-commission="{{ str_replace('%', '', $seller->commission) }}">
                                                            Edit Seller Commission
                                                        </button>


                                                        @if ($seller->status == 0)
                                                            <a title="Active" class="btn btn-sm btn-success" href="{{ route('vendors.status', ['id' => $seller->id, 'status' => '1']) }}">Active</a>
                                                        @elseif ($seller->status == 1)
                                                            <a title="Inactive" class="btn btn-sm btn-warning" href="{{ route('vendors.status', ['id' => $seller->id, 'status' => '0']) }}">Inactive</a>
                                                        @else
                                                            <a title="Inactive" class="btn btn-sm btn-warning" href="{{ route('vendors.status', ['id' => $seller->id, 'status' => '0']) }}">Inactive</a>
                                                        @endif
                                                        

                                                        <a title="Suspend" class="btn btn-sm btn-secondary" href="{{ route('vendors.status', ['id' => $seller->id, 'status' => '2']) }}">Suspend</a>

                                                        @if ($seller->payment_status == 0)
                                                            <a title="Paid" class="btn btn-sm btn-success" href="{{ route('vendors.payment_status', ['id' => $seller->id, 'payment_status' => '1']) }}">Paid</a>
                                                        @endif
                                                        @if ($seller->payment_status == 1)
                                                            <a title="Unpaid" class="btn btn-sm btn-warning" href="{{ route('vendors.payment_status', ['id' => $seller->id, 'payment_status' => '0']) }}">Unpaid</a>
                                                        @endif



                                                        <a title="Edit" class="btn btn-sm btn-primary" href="{{ route('sellers.edit', $seller->id) }}">
                                                            <i class="fas fa-edit"></i> Edit
                                                        </a>
                                                        
                                                        {{-- <a title="Delete" class="btn btn-sm btn-danger" href="{{ route('vendors.delete', $vendor->id) }}">
                                                            <i class="fas fa-trash"></i> Delete
                                                        </a> --}}
                                                        
                                                        <a title="Vendor Profile" class="btn btn-sm btn-success" href="{{ route('sellers.profile', $seller->id) }}">
                                                            <i class="fas fa-users"></i> Seller Profile
                                                        </a>
                                                    </td>

                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>

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


    <!-- Seller Commission Modal -->
    <!-- Seller Commission Modal (Bootstrap 3) -->
    <div class="modal fade" id="sellerCommissionModal" tabindex="-1" role="dialog"
        aria-labelledby="sellerCommissionModalLabel">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <form id="commissionForm" method="POST" action="{{ route('sellers.commission') }}">
                    @csrf
                    <input type="hidden" name="user_id" id="modalUserId">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="sellerCommissionInput">Seller Commission (%)</label>
                            <input type="number" class="form-control" id="sellerCommissionInput" name="commission"
                                placeholder="e.g., 10">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="sellerReferModal" tabindex="-1" role="dialog" aria-labelledby="sellerReferModalLabel">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <form id="ReferForm" method="POST" action="{{ route('sellers.add.balance') }}">
                    @csrf
                    <input type="hidden" name="reseller_id" id="resellerIdInput">
                    <div class="modal-body">

                        <div class="form-group">
                            <label for="resellerNameField" id="resellerNameField"></label><br>
                            <label for="resellerBalanceField">Reseller Balance</label>

                            <input type="number" class="form-control" id="resellerBalanceField" name="balance"
                                placeholder="">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
      <!-- vendor  Commission Modal (Bootstrap 3) -->
    <div class="modal fade" id="vendorCommissionModal" tabindex="-1" role="dialog"
        aria-labelledby="vendorCommissionModalLabel">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <form id="commissionForm" method="POST" action="{{ route('sellers.commission') }}">
                    @csrf
                    <input type="hidden" name="user_id" id="modalUserId">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="sellerCommissionInput">Seller Commission (%)</label>
                            <input type="number" class="form-control" id="sellerCommissionInput" name="commission"
                                placeholder="e.g., 10">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <script>
        $(document).ready(function () {
            $('.dataTables').DataTable();
        });
        // When commission edit button is clicked
        $(document).on('click', '.edit-commission', function() {
            var userId = $(this).data('user-id');
            var commission = $(this).data('commission');
            // Set values in modal
            $('#modalUserId').val(userId);
            $('#sellerCommissionInput').val(commission);
        });
        $(document).on('click', '.edit-refer', function() {
            const resellerId = $(this).data('reseller-id');
            const resellerName = $(this).data('reseller-name');
            const resellerBalance = $(this).data('reseller-balance');
            // Populate modal fields
            $('#resellerIdInput').val(resellerId);
            $('#resellerNameField').text('Reseler Mobile Number '+resellerName); // For label
            $('#resellerBalanceField').val(resellerBalance??0); // For input field
        });

        // Handle form submission
        $('#commissionForm').on('submit', function(e) {
            e.preventDefault();

            $.ajax({
                url: $(this).attr('action'),
                method: 'POST',
                data: $(this).serialize(),
                success: function(response) {
                    $('#sellerCommissionModal').modal('hide');
                    // Refresh DataTable or show success message
                    // $('#shopTblseller').DataTable().ajax.reload();
                    alert('Commission updated successfully');
                    
                    window.location.reload();
                },
                error: function(xhr) {
                    alert('Error updating commission');
                }
            });
        });
    </script>
@endpush
