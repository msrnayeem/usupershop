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
                            <div class="card-header">
                                <h5 class="mb-0 fw-bold">
                                    {{ $pageTitle }}
                                </h5>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-3">
                                        @php
                                            $siteSetting = Helper::get_setting_data();
                                        @endphp
                                        
                                        <form action="{{ route('settings.commission.update') }}" method="POST">
                                            @csrf
                                            <div class="form-group">
                                                <label for="refer_commission_type">Refer Commssion Type <span class="text-danger">*</span></label>
                                                <select name="refer_commission_type" id="refer_commission_type" class="form-control @error('refer_commission_type') is_invalid @enderror">
                                                    <option value="0" @if($siteSetting->refer_commission_type == '0') selected @endif>Flat</option>
                                                    <option value="1" @if($siteSetting->refer_commission_type == '1') selected @endif>Percentage</option>
                                                </select>
                                                @error('refer_commission_type')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="form-group mt-3">
                                                <label for="refer_commission">Refer Commission <span class="text-danger">*</span></label>
                                                <input type="number" class="form-control @error('refer_commission') is_invalid @enderror" id="refer_commission" name="refer_commission" placeholder="Enter Refer Commission" value="{{ $siteSetting->refer_commission }}">
                                                @error('refer_commission')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>

                                            <div class="form-group mt-3">
                                                <button type="submit" class="form-control btn btn-success">Save</button>
                                            </div>

                                        </form>
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
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@endsection
