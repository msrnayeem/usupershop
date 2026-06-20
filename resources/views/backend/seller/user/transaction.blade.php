@extends('backend.seller.seller-master')
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header" style="padding-bottom:0px;">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0"><span style="text-transform: capitalize;">{{ Auth::user()->usertype ?? '' }} </span> Dashboard</h1>
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li class="breadcrumb-item active"><span style="text-transform: capitalize;">{{ Auth::user()->usertype ?? '' }} </span> Dashboard</li>
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
                    <section class="col-lg-12 connectedSortable">
                        <!-- Custom tabs (Charts with tabs)-->
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">
                                    Transaction History
                                </h3>
                               
                            </div>
                            <!-- /.card-header -->

                            <div class="card-body">
                                <div class="tab-content p-0">
                                    @if ($errors->any())
                                        <div class="alert alert-danger">
                                            <ul>
                                                @foreach ($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif

                                    @if (session()->has('message'))
                                        <div class="alert alert-{{ session('type') }}">
                                            {{ session('message') }}
                                        </div>
                                    @endif
                                    <!-- Morris chart - Sales -->

                                  
                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <table id="Tbl" class="table table-bordered table-striped dt-responsive"
                                                style="width: 100%;text-align:center;">
                                                <thead style="width: 100%;">
                                                    <tr>
                                                        <th style="width:10%;">User Name</th>
                                                        <th style="width:10%;">Phone Number.</th>
                                                        <th style="width:15%;"> Payment Type </th>
                                                        <th style="width:20%">Transaction Status</th>
                                                        <th style="width:10%;">Transaction Date</th>
                                                        <th style="width:20%">Transaction Balance</th>
                                                    </tr>
                                                </thead>
                                                <tbody>

                                                    @if ($transaction != null)
                                                    @foreach ($transaction as $transaction)
                                                    <tr>

                                                        <td>{{ $transaction->name ?? '' }}</td>
                                                        <td>{{ $transaction->mobile_no ?? '' }}</td>
                                                        <td>{{ $transaction->payment_type ?? '' }}</td>
                                                       
                                                        <td>
                                                            {{ $transaction->transaction_status ?? '' }}
                                                        </td>
                                                        <td>
                                                            {{ $transaction->transaction_date ?? '' }}

                                                        </td>
                                                        <td>

                                                            {{ $transaction->transaction_balance ?? '' }}

                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                       
                                                    @endif
                                                </tbody>
                                            </table>
                                            </div>
                                           
                                        </div>
                                  


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
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Withdraw</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form method="post" class="form" action="{{ route('wallet.save') }}">
                            @csrf
                            <div class="form-group">
                                <label for="mobile_no">Bkash Mobile Number</label>
                                <input type="text" class="form-control" id="mobile_no" name="mobile_no" placeholder="Mobile Number">
                                @error('mobile_no')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="payment_type">Payment Type</label>
                                <select class="custom-select" name="payment_type">
                                    <option selected>Select Payment Type</option>
                                    <option value="Bkash">Bkash</option>
                                   
                                </select>
                                @error('payment_type')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-primary">Submit</button>
                        </form>
                    </div>

                </div>
            </div>
        </div>

    </div>
    <!-- /.content-wrapper -->
@endsection
@section('custom_js')
    <script></script>
@endsection
