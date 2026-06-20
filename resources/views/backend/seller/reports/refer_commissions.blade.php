@extends('backend.seller.seller-master')
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">

        <!-- Main content -->
        <section class="content pt-3">
            <div class="container-fluid">
                <!-- Small boxes (Stat box) -->
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <!-- Custom tabs (Charts with tabs)-->
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">
                                    <i class="fas fa-chart-pie mr-1"></i>
                                    {{ $pageTitle }}
                                </h3>
                                <div class="card-tools">
                                    <div class="btn-group">
                                        <a href="{{ route('seller.reports.refer.pdf') }}" class="btn btn-sm btn-danger">
                                            <i class="fas fa-file-pdf"></i> PDF
                                        </a>
                                        <a href="{{ route('seller.reports.refer.excel') }}" class="btn btn-sm btn-success">
                                            <i class="fas fa-file-excel"></i> Excel
                                        </a>
                                    </div>
                                </div>

                            </div>
                            
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th class="text-center" style="width: 50px;">SL</th>
                                                <th class="text-left">From User</th>
                                                <th class="text-left">Description</th>
                                                <th class="text-right" style="width: 200px;">Amount</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($data as $i => $value)
                                                <tr>
                                                    <td class="text-center" style="width: 50px;">{{ ++$i }}</td>
                                                    <td class="text-left">{{ $value->from_user->name }}</td>
                                                    <td class="text-left">{{ $value->note }}</td>
                                                    <td class="text-right" style="width: 200px;">{{ number_format($value->credit, 2) }}</td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="4" class="text-center">No Data..</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                        <!-- /.card -->
                    </div>
                </div>
                <!-- /.row (main row) -->
            </div>
            <!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@endsection
