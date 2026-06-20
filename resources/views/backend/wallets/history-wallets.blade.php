@extends('backend.layouts.master')
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6">
                        <h5 class="m-0"><i class='fas fa-hand-point-right'></i>  Wallets History</h5>
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
                                <h5>
                                    Wallet List
                                  
                                </h5>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="example1" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th width="6%">SN</th>
                                                <th>User Name</th>
                                                <th>Nid Number</th>
                                                <th> Phone No</th>
                                                <th>Payment Type</th>
                                                <th>Transaction Status</th>
                                                <th>Transaction Date</th>
                                                <th>Transaction Balance</th>
                                              
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if($wallets!=null)
                                            @forelse ($wallets as $key=>$wallet)
                                            <tr class="{{ $wallet->id }}">
                                                <td>{{ $key + 1 }}</td>
                                                <td>{{ $wallet->name ?? ''}}</td>
                                            
                                                <td >{{ $wallet->nid_no ?? ''}}</td>
                                                <td class="wallet-mobile">{{ $wallet->mobile_no ?? ''}}</td>
                        
                                                <td  class="wallet-payment-type">{{ $wallet->payment_type ?? ''}}</td>
                                                <td class="wallet-transaction_status">{{ $wallet->transaction_status ?? ''}}</td>
                                                <td class="wallet-date">{{ $wallet->transaction_date ?? ''}}</td>
                                                <td class="wallet-balance">{{ $wallet->transaction_balance ?? ''}}</td>
                                                
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
