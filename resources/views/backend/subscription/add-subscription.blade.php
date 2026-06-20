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
                                    @if (isset($editData))
                                        Edit Subscription
                                    @else
                                        Add Subscription
                                    @endif
                                    <a class="btn btn-sm btn-primary float-right" href="{{ route('subscriptions.view') }}"><i
                                            class="fas fa-list"></i> Subscription List</a>
                                </h5>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <form id="myForm" method="post"
                                    action="{{ @$editData ? route('subscriptions.update', $editData->id) : route('subscriptions.store') }}">
                                    @csrf
                                    <div class="form-row">
                                        <div class="form-group col-md-4">
                                            <label for="name">Account Type</label>
                                            <input type="text" name="account_type_of_myshop" value="{{ old('account_type_of_myshop', @$editData->account_type_of_myshop) }}"
                                                class="form-control" id="account_type_of_myshop" placeholder="Enter account name">
                                            <span
                                                style="color: red;">{{ $errors->has('account_type_of_myshop') ? $errors->first('account_type_of_myshop') : '' }}</span>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="duration">Duration</label>
                                            <select name="duration" id="duration" class="form-control">
                                                <option value="monthly" {{ old('duration', @$editData->duration) == 'monthly' ? 'selected' : '' }}>Monthly</option>
                                                <option value="yearly" {{ old('duration', @$editData->duration) == 'yearly' ? 'selected' : '' }}>Yearly</option>
                                            </select>
                                            <span style="color: red;">{{ $errors->has('duration') ? $errors->first('duration') : '' }}</span>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label>Seller Fee</label>
                                            <input type="number" name="subscription_fees" id="subscription_fees" class="form-control" value="{{ old('subscription_fees', @$editData->subscription_fees) }}">
                                            <span style="color: red;">{{ $errors->has('subscription_fees') ? $errors->first('subscription_fees') : '' }}</span>
                                        </div>

                                        <div class="form-group col-md-8">
                                            <label for="plan_features">Listed Things (One per line)</label>
                                            <textarea name="plan_features" id="plan_features" class="form-control" rows="6"
                                                placeholder="Add one listed thing per line">{{ old('plan_features', isset($editData) ? implode(PHP_EOL, $editData->plan_features ?? []) : '') }}</textarea>
                                            <span style="color: red;">{{ $errors->has('plan_features') ? $errors->first('plan_features') : '' }}</span>
                                        </div>

                                        <div class="form-group col-md-12">
                                            <button type="submit"
                                                class="btn btn-primary">{{ @$editData ? 'Update' : 'Submit' }}</button>
                                        </div>
                                    </div>
                                </form>
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

    <script type="text/javascript">
        $(function() {
            $('#myForm').validate({
                rules: {
                    name: {
                        required: true
                    },
                },
                messages: {

                },
                errorElement: 'span',
                errorPlacement: function(error, element) {
                    error.addClass('invalid-feedback');
                    element.closest('.form-group').append(error);
                },
                highlight: function(element, errorClass, validClass) {
                    $(element).addClass('is-invalid');
                },
                unhighlight: function(element, errorClass, validClass) {
                    $(element).removeClass('is-invalid');
                }
            });
        });
    </script>
@endsection
