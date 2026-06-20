@extends('backend.layouts.master')
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6">
                        <h5 class="m-0"><i class='fas fa-hand-point-right'></i> Manage Wallets</h5>
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li class="breadcrumb-item active">Wallets</li>
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
                           
                            <div class="card-header">
                                <div class="row w-100">
                                    <div class="col">
                                        <h5 class="mb-0">Wallet List</h5>
                                    </div>
                                    <div class="col text-right">
                                        <a href="{{ route('wallets.received') }}" class="btn btn-sm btn-primary">Wallet History</a>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- /.card-header -->
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="example1" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th width="6%">SN</th>
                                                <th>User Name</th>
                                                <th class="d-none">User id</th>
                                                <!--<th>Nid Number</th>-->
                                                <th>Bkash Phone No</th>
                                                <!--<th>Nid Front Image</th>-->
                                                <th>Payment Type</th>
                                                <th>Transaction Status</th>
                                                <th>Balance</th>
                                              
                                                <th width="12%">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if($wallets!=null)
                                            @forelse ($wallets as $key=>$wallet)
                                            <tr class="{{ $wallet->id }}">
                                                <td>{{ $key + 1 }}</td>
                                                <td>{{ $wallet->name ?? ''}}</td>
                                                <td class="d-none userID">{{ $wallet->user_id}}</td>
                                                <!--<td >{{ $wallet->nid_no ?? ''}}</td>-->
                                                <td class="wallet-mobile">{{ $wallet->mobile_no ?? ''}}</td>
                                                <!--<td>-->
                                                <!--    <img style="width: 60px;height:40px"-->
                                                <!--        src="{{ !empty($wallet->front_image) ? url('public/upload/profile_verify/' . $wallet->front_image) : url('frontend/no-image-icon.jpg') }}">-->
                                                <!--</td>-->
                                                <td  class="wallet-payment-type">{{ $wallet->payment_type ?? ''}}</td>
                                                <td class="wallet-transaction_status">{{ $wallet->transaction_status ?? ''}}</td>
                                                <td class="wallet-balance">{{ $wallet->balance ?? ''}}</td>
                                                <td>
                                                    <button type="button" class="btn btn-sm btn-info open-modal"  data-toggle="modal" data-target="#paymentModal">
                                                        <i
                                                        class="fas fa-money-check"></i> Pay Now
                                                      </button>
                                                </td>
                                            </tr>
                                            @empty
                                                <td colspan="9">
                                                    <p class="text-center">Wallets Not Found!!</p>
                                                </td>
                                            @endforelse
                                           
                                            @endif
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
                <div class="modal fade" id="paymentModal" tabindex="-1" role="dialog" aria-labelledby="paymentModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="paymentModalLabel">Payment Details</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form method="post" class="form" action="{{ route('wallets.money') }}">
                                    @csrf
                                    <input type="hidden" id="user_id" name="user_id" value=""/>
                                    <div class="form-group">
                                        <label for="mobile_no">Bkash Phone Number</label>
                                        <input type="text" class="form-control" id="mobile_no" name="mobile_no" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="payment_type">Payment Type</label>
                                        <select disabled class="custom-select" id="payment_type" name="payment_type">
                                            <option value="Bkash">Bkash</option>
                                            <option value="Nagad">Nagad</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="balance">Balance</label>
                                        <input type="number" class="form-control" id="balance" name="balance" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="balance">Transaction ID</label>
                                        <input type="text" class="form-control" id="transaction_id" name="transaction_id" >
                                    </div>
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@endsection
@section('custom_js')
<script>
document.addEventListener("DOMContentLoaded", function () {
    // Handle modal open button click
    document.querySelectorAll('.open-modal').forEach(button => {
        button.addEventListener('click', function (event) {
            const row = event.target.closest('tr'); // Get the row of the clicked button
            
            const mobileNo = row.querySelector('.wallet-mobile').textContent.trim();
            const userid = row.querySelector('.userID').textContent.trim();
            const paymentType = row.querySelector('.wallet-payment-type').textContent.trim();
            const balance = row.querySelector('.wallet-balance').textContent.trim();
            
            // Populate modal fields
            document.getElementById('mobile_no').value = mobileNo;
            document.getElementById('user_id').value = userid;
            document.getElementById('payment_type').value = paymentType;
            document.getElementById('balance').value = balance;
        });
    });
});
</script>


@endsection
