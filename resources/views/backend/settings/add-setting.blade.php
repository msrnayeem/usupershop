@extends('backend.layouts.master')
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6">
                        <h5 class="m-0"><i class='fas fa-hand-point-right'></i> Meta Setting</h5>
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li class="breadcrumb-item active"></li>
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
                                        Edit Setting
                                    @else
                                        Add Setting
                                    @endif
                                    <a class="btn btn-sm btn-primary float-right" href="{{ route('settings.view') }}"><i
                                            class="fas fa-list"></i>  Setting List</a>
                                </h5>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <form method="post"
                                    action="{{ @$editData ? route('settings.update', $editData->id) : route('settings.store') }}"
                                    id="myForm">
                                    @csrf
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label for="app_name">App Name</label>
                                            <input type="text" name="app_name" value="{{ @$editData->app_name }}"
                                                class="form-control" id="app_name" placeholder="Enter app name...">
                                            <span
                                                style="color: red;">{{ $errors->has('app_name') ? $errors->first('app_name') : '' }}</span>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="keywords">Meta Keywords</label>
                                            <input type="text" name="keywords" value="{{ @$editData->keywords }}"
                                                class="form-control" id="keywords" placeholder="Enter keywords...">
                                            <span
                                                style="color: red;">{{ $errors->has('keywords') ? $errors->first('keywords') : '' }}</span>
                                        </div>

                                        <div class="form-group col-md-12">
                                            <label>Description</label>
                                            <textarea name="description" id="summernote" class="form-control" rows="4" placeholder="Enter description...">{{ @$editData->description }}</textarea>
                                            <span
                                                style="color: red;">{{ $errors->has('description') ? $errors->first('description') : '' }}</span>
                                        </div>


                                        {{-- ── WhatsApp Notify Number (Admin only) ──────── --}}
                                        <div class="form-group col-md-12" style="border:2px solid #25D366; border-radius:10px; padding:18px 20px; margin-top:10px; background:#f0fff4;">
                                            <label for="whatsapp_notify_number" style="color:#128C7E; font-weight:700; font-size:15px;">
                                                <i class="fab fa-whatsapp" style="font-size:18px; margin-right:6px;"></i>
                                                WhatsApp Notification Number
                                                <span style="background:#128C7E; color:#fff; font-size:12px; padding:2px 8px; border-radius:10px; margin-left:8px;">ADMIN ONLY</span>
                                            </label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" style="background:#25D366; color:#fff; border:none; font-weight:700;">+880</span>
                                                </div>
                                                <input type="text"
                                                    name="whatsapp_notify_number"
                                                    value="{{ @$editData->whatsapp_notify_number }}"
                                                    class="form-control"
                                                    id="whatsapp_notify_number"
                                                    placeholder="01816622128"
                                                    maxlength="15">
                                            </div>
                                            <small style="color:#555; margin-top:8px; display:block; line-height:1.8;">
                                                ℹ️ <strong>.env ফাইলে নিচের তিনটি value সেট করুন:</strong><br>
                                                <code style="background:#e8f5e9; padding:2px 6px; border-radius:4px;">WHATSAPP_TOKEN</code> — Meta Developer থেকে Access Token<br>
                                                <code style="background:#e8f5e9; padding:2px 6px; border-radius:4px;">WHATSAPP_PHONE_NUMBER_ID</code> — Meta WhatsApp Phone Number ID<br>
                                                <code style="background:#e8f5e9; padding:2px 6px; border-radius:4px;">ADMIN_WHATSAPP_NUMBER=8801816622128</code> — আপনার নম্বর (ইতিমধ্যে সেট আছে)<br>
                                                🔗 <a href="https://developers.facebook.com" target="_blank" style="color:#128C7E;">developers.facebook.com</a> → Apps → WhatsApp → API Setup
                                            </small>
                                        </div>

                                        <div class="form-group col-md-6" style="padding-top: 30px;">
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
                    title: {
                        required: true
                    },

                    description: {
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
