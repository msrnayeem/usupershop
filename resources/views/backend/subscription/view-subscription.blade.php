@extends('backend.layouts.master')
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6">
                        <h5 class="m-0"><i class='fas fa-hand-point-right'></i> Manage Subscription</h5>
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li class="breadcrumb-item active">Subscription</li>
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
                                    Subscription List
                                    @if ($countSellerFee > 1)
                                        <a class="btn btn-sm btn-primary float-right"
                                            href="{{ route('subscriptions.add') }}"><i class="fas fa-plus-circle"></i> Add
                                            Subscription</a>
                                    @endif
                                </h5>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th width="6%">SN</th>
                                            <th>Account Type</th>
                                            <th>Fee</th>
                                            <th>Duration</th>
                                            <th>Listed Things</th>
                                            <th width="12%">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($allData as $key => $logo)
                                            <tr class="{{ $logo->id }}">
                                                <td>{{ $key + 1 }}</td>
                                                <td>{{ $logo->account_type_of_myshop ?? ''}}</td>
                                                <td>
                                                    {{ $logo->subscription_fees ?? ''}}
                                                </td>
                                                <td>
                                                    {{ ucfirst($logo->duration ?? 'Monthly') }}
                                                </td>
                                                <td>
                                                    @if (!empty($logo->plan_features) && is_array($logo->plan_features))
                                                        <ul class="mb-0 pl-3">
                                                            @foreach ($logo->plan_features as $feature)
                                                                <li>{{ $feature }}</li>
                                                            @endforeach
                                                        </ul>
                                                    @else
                                                        <span class="text-muted">No listed things</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <a title="Edit" class="btn btn-sm btn-info"
                                                        href="{{ route('subscriptions.edit', $logo->id) }}"><i
                                                            class="fas fa-edit"></i> Edit</a>
                                                    <a title="Delete" class="btn btn-sm btn-danger"
                                                        href="{{ route('subscriptions.delete', $logo->id) }}"><i
                                                            class="fas fa-trash"></i> Delete </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
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
