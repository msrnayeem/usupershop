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
                                            <th class="text-left">User</th>
                                            <th class="text-left">From User</th>
                                            <th class="text-left">Note</th>
                                            <th class="text-right" style="width: 150px;">Amount</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($sales as $i => $data)
                                            <tr>
                                                <td width="50px" class="text-center">{{ ++$i }}</td>
                                                <td class="text-left">{{ $data->user->name }}</td>
                                                <td class="text-left">{{ $data->from_user->name }}</td>
                                                <td class="text-left">{{ $data->note }}</td>
                                                <td class="text-right" style="width: 150px;">{{ $data->credit }}</td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="5" class="text-center">Data Not Found!</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
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


