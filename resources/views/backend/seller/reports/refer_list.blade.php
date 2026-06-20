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

                            </div>
                            
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th class="text-center" style="width: 50px;">SL</th>
                                                <th class="text-left">Name</th>
                                                <th class="text-left">Phone</th>
                                                <th class="text-center">User Type</th>
                                                <th class="text-center">Paid/Unpaid</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($data as $i => $value)
                                                <tr>
                                                    <td class="text-center" style="width: 50px;">{{ ++$i }}</td>
                                                    <td class="text-left">{{ $value->name }} (Refer ID : {{ $value->refer_code }})</td>
                                                    <td class="text-left">{{ $value->mobile }}</td>
                                                    <td class="text-center">{{ $value->usertype }}</td>
                                                    <td class="text-center">
                                                        @if ($value->payment_status == 1)
                                                            <span class="badge badge-success">Paid</span>
                                                        @else
                                                            <span class="badge badge-danger">Unpaid</span>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="6" class="text-center">No Data..</td>
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
