@extends('backend.layouts.master')
@section('content')
    <style>
        .table-bordered td, .table-bordered th{
            text-align: center;
        }
    </style>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Main content -->
        <div class="content">
            <div class="container-fluid">
                <!-- Main row -->
                <div class="row">
                    <!-- Left col -->
                    <div class="col-md-12 mt-2">
                        <!-- Custom tabs (Charts with tabs)-->
                        <div class="card">
                            <div class="card-header">
                                <h5 class="my-0" style="font-weight: 600;">{{ $pageTitle }}</h5>
                            </div>

                            <div class="card-body">
                                <table id="dataTables" class="table table-bordered table-striped nowrap dt-responsive"
                                    style="width: 100%">
                                    <thead>
                                        <tr>
                                            <th width="50px" class="text-center">SL.</th>
                                            <th class="text-left">Dropshipper</th>
                                            <th class="text-left">From User</th>
                                            <th class="text-left" style="width: 250px;">Note</th>
                                            <th class="text-center">Type</th>
                                            <th class="text-right">Amount</th>
                                            <th class="text-center">Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($history as $i => $data)
                                            <tr>
                                                <td width="50px" class="text-center">{{ ++$i }}</td>
                                                <td class="text-left">
                                                    {{ $data->user->name ?? 'N/A' }}<br>
                                                    <small class="text-muted">{{ $data->user->mobile ?? '' }}</small>
                                                </td>
                                                <td class="text-left">{{ $data->from_user->name ?? 'N/A' }}</td>
                                                <td class="text-left" style="width: 250px;">{{ $data->note }}</td>
                                                <td class="text-center">
                                                    @php
                                                        $type = 'Unknown';
                                                        foreach(\App\utilities\Constant::TRANSACTION_TYPE as $key => $val){
                                                            if($val == $data->tnx_type){
                                                                $type = str_replace('_', ' ', ucwords($key, '_'));
                                                                break;
                                                            }
                                                        }
                                                    @endphp
                                                    <span class="badge badge-info">{{ $type }}</span>
                                                </td>
                                                <td class="text-right font-weight-bold">
                                                    {{ number_format($data->credit > 0 ? $data->credit : $data->debit, 2) }}
                                                </td>
                                                <td class="text-center">{{ $data->created_at->format('d M, Y') }}</td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="7" class="text-center">Data Not Found!</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                    <!-- /.Left col -->
                </div>
                <!-- /.row (main row) -->
            </div>
            <!-- /.container-fluid -->
        </div>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@endsection

@push('scripts')
    <script>
        $(document).ready(function(){
            $("#dataTables").DataTable();
        });
    </script>
@endpush
