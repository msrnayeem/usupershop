@extends('backend.seller.seller-master')
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header" style="padding-bottom:0px;">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0"><span style="text-transform: capitalize;">{{ Auth::user()->usertype ?? '' }}
                            </span> Dashboard</h1>
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li class="breadcrumb-item active"><span
                                    style="text-transform: capitalize;">{{ Auth::user()->usertype ?? '' }} </span> Dashboard
                            </li>
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
                                    Wallet Info
                                </h3>
                                @if (auth()->check() && auth()->user()->balance >= 200)
                                    <button type="button" class="btn btn-info btn-sm text-right" data-toggle="modal"
                                        data-target="#exampleModal" style="float:right;">
                                        Withdraw request
                                    </button>
                                @endif
                                <a href="{{ route('transaction.history') }}" style="display: flex;float:right;"
                                    class="btn btn-sm btn-primary">Transaction Status</a>
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
                                            <table id="Tbl"
                                                class="table table-bordered table-striped dt-responsive"
                                                style="width: 100%;text-align:center;">
                                                <thead style="width: 100%;">
                                                    <tr>
                                                        <th style="width:10%;">User Name</th>
                                                        <!--<th style="width:10%;">Nid Number.</th>-->
                                                        <th style="width:15%;"> Phone No </th>
                                                        <!--<th style="width:20%">Nid Front Image</th>-->
                                                        <th style="width:10%;">Payment Type</th>
                                                        <th style="width:10%;">Transaction Status</th>
                                                        <th style="width:20%">Total Balance</th>
                                                    </tr>
                                                </thead>
                                                <tbody>

                                                    @if ($profile != null)
                                                        <tr>

                                                            <td>{{ $profile->name ?? '' }}</td>
                                                            <!--<td>{{ $profile->nid_no ?? '' }}</td>-->
                                                            <td>{{ $profile->mobile_no ?? '' }}</td>
                                                            <!--<td>-->
                                                            <!--    <img src="{{ asset('public/upload/profile_verify/' . $profile->front_image) }}"-->
                                                            <!--        width="60" />-->
                                                            <!--</td>-->
                                                            <td>
                                                                {{ $profile->payment_type ?? '' }}
                                                            </td>
                                                            <td>
                                                                {{ $profile->transaction_status ?? '' }}

                                                            </td>
                                                            <td>

                                                                {{ number_format($profile->balance ?? 0, 2) }}

                                                            </td>
                                                        </tr>
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
        @php
            // Fetch all payment methods for logged in user
            $paymentSetting = \App\Models\PaymentSetting::where('user_id', auth()->id())->get();
        @endphp

        <main class="content-wrapper">
            <div class="container-fluid">

                <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">

                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Withdraw</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>

                            <div class="modal-body">

                                <form method="POST" class="form" action="{{ route('wallet.save') }}">
                                    @csrf

                                    <div class="form-group">
                                        <label for="payment_type">Payment Method</label>

                                        <select class="custom-select" name="payment_type" id="payment_type">
                                            <option value="">Select Payment Type</option>

                                            @foreach ($paymentSetting as $ps)
                                                <option value="{{ $ps->method }}"
                                                    {{ old('payment_type') == $ps->method ? 'selected' : '' }}>
                                                    {{ $ps->method }}
                                                </option>
                                            @endforeach

                                        </select>

                                        @error('payment_type')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="mobile_no">Phone Number</label>
                                        <input type="text" class="form-control" id="mobile_no" name="mobile_no"
                                            placeholder="Phone Number" readonly>

                                        @error('mobile_no')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>


                                    <div class="form-group">
                                        <label for="amount">Amount</label>

                                        <input type="number" class="form-control" id="amount" name="amount"
                                            step="0.01" placeholder="Enter Request Amount" min="200"
                                            max="{{ $profile->balance ?? 0 }}" value="{{ $profile->balance ?? 0 }}">

                                        @error('amount')
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
        </main>

    @endsection


    @section('custom_js')
        <script>
            $('#payment_type').on('change', function() {

                let method = $(this).val();

                if (method === "") {
                    $('#mobile_no').val("");
                    return;
                }

                $.ajax({
                    url: "{{ route('manage.wallets.payment') }}",
                    type: "GET",
                    data: {
                        method_type: method
                    },
                    success: function(res) {
                        if (res.data) {
                            $('#mobile_no').val(res.data.number);
                        } else {
                            $('#mobile_no').val("");
                        }
                    }
                });

            });
        </script>
    @endsection
