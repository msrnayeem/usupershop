@extends('backend.layouts.master')
@section('admin_css')
<style>
    @media screen and (max-width: 368px) and (max-width: 568px) and (max-width: 668px){
        .table-responsive {
    overflow-x: auto;
    max-width: 100%;
    border-radius: 8px;
    box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
}
#example1 thead: {
    overflow: hidden;
    display: block;
    width:100%;
}
}
</style>
@endsection
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6">
                        <h5 class="m-0"><i class='fas fa-hand-point-right'></i> Manage Payment Gatway</h5>
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li class="breadcrumb-item active">Payment Gatway</li>
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
                                    Payment Gatway List
                                    @if ($countpay < 1)
                                        <a class="btn btn-sm btn-primary float-right" href="{{ route('paymentgatways.add') }}"><i
                                                class="fas fa-plus-circle"></i> Add Payment Gatway</a>
                                    @endif
                                </h5>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="example1" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th width="6%">SN</th>
                                                <th>Payment Gatway Bkash Username</th>
                                                <th>Payment Gatway Bkash Api Key</th>
                                                <th>Payment Gatway Bkash Bkash Secret Key</th>
                                                <th>Payment Gatway Nagad Username</th>
                                                <th width="12%">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($allData as $key => $payment)
                                                <tr class="{{ $payment->id }}">
                                                    <td>{{ $key + 1 }}</td>
                                                    <td>{{ $payment->BKASH_USERNAME ?? ''}}</td>
                                                    <td>
                                                        {{ $payment->BKASH_API_KEY ?? ''}}
                                                    </td>
                                                    <td>
                                                        {{ $payment->BKASH_SECRET_KEY ?? ''}}
                                                    </td>
                                                    <td>
                                                        {{ $payment->NAGAD_USERNAME ?? ''}}
                                                    </td>
                                                    <td>
                                                        <a title="Edit" class="btn btn-sm btn-info"
                                                            href="{{ route('paymentgatways.edit', $payment->id) }}"><i
                                                                class="fas fa-edit"></i> Edit</a>
                                                       
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
@endsection
