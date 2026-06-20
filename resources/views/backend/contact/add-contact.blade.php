@extends('backend.layouts.master')
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6">
                        <h5 class="m-0"><i class='fas fa-hand-point-right'></i> Manage Contacts</h5>
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li class="breadcrumb-item active">Contacts</li>
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
                                        Edit Contact
                                    @else
                                        Add Contact
                                    @endif
                                    <a class="btn btn-sm btn-primary float-right" href="{{ route('contacts.view') }}"><i
                                            class="fas fa-list"></i> Contacts List</a>
                                </h5>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <form method="post"
                                    action="{{ @$editData ? route('contacts.update', $editData->id) : route('contacts.store') }}"
                                    id="myForm" enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-row">
                                        <div class="form-group col-md-4">
                                            <label for="address">Address</label>
                                            <input type="text" name="address" value="{{ @$editData->address }}"
                                                class="form-control" id="address" placeholder="Enter contact address">
                                            <span
                                                style="color: red;">{{ $errors->has('address') ? $errors->first('address') : '' }}</span>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="mobile">Mobile No</label>
                                            <input type="text" name="mobile" value="{{ @$editData->mobile }}"
                                                class="form-control" id="mobile" placeholder="Enter contact mobile">
                                            <span
                                                style="color: red;">{{ $errors->has('mobile') ? $errors->first('mobile') : '' }}</span>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="email">Email</label>
                                            <input type="text" name="email" value="{{ @$editData->email }}"
                                                class="form-control" id="email" placeholder="Enter contact email">
                                            <span
                                                style="color: red;">{{ $errors->has('email') ? $errors->first('email') : '' }}</span>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="facebook">Facebook</label>
                                            <input type="text" name="facebook" value="{{ @$editData->facebook }}"
                                                class="form-control" id="facebook" placeholder="Enter facebook link">
                                            <span
                                                style="color: red;">{{ $errors->has('facebook') ? $errors->first('facebook') : '' }}</span>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="facebook_icon">Facebook icon</label>
                                            <input type="file" name="facebook_icon" value="{{ @$editData->facebook_icon }}"
                                                class="form-control" id="facebook_icon" placeholder="Enter facebook icon">
                                            <span
                                                style="color: red;">{{ $errors->has('facebook_icon') ? $errors->first('facebook_icon') : '' }}</span>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="youtube">Youtube</label>
                                            <input type="text" name="youtube" value="{{ @$editData->youtube }}"
                                                class="form-control" id="youtube" placeholder="Enter youtube link">
                                            <span
                                                style="color: red;">{{ $errors->has('youtube') ? $errors->first('youtube') : '' }}</span>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="youtube_icon">Youtube icon</label>
                                            <input type="file" name="youtube_icon" value="{{ @$editData->youtube_icon }}"
                                                class="form-control" id="youtube_icon" placeholder="Enter youtube icon">
                                            <span
                                                style="color: red;">{{ $errors->has('youtube_icon') ? $errors->first('youtube_icon') : '' }}</span>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="twitter">Twitter</label>
                                            <input type="text" name="twitter" value="{{ @$editData->twitter }}"
                                                class="form-control" id="twitter" placeholder="Enter twitter link">
                                            <span
                                                style="color: red;">{{ $errors->has('twitter') ? $errors->first('twitter') : '' }}</span>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="twitter_icon">Twitter icon</label>
                                            <input type="file" name="twitter_icon" value="{{ @$editData->twitter_icon }}"
                                                class="form-control" id="twitter_icon" placeholder="Enter twitter icon">
                                            <span
                                                style="color: red;">{{ $errors->has('twitter_icon') ? $errors->first('twitter_icon') : '' }}</span>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="instagram">Instragram </label>
                                            <input type="text" name="instagram" value="{{ @$editData->instagram }}"
                                                class="form-control" id="instagram" placeholder="Enter instagram link">
                                            <span
                                                style="color: red;">{{ $errors->has('instagram') ? $errors->first('instagram') : '' }}</span>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="instagram">Instragram icon</label>
                                            <input type="file" name="instagram_icon" value="{{ @$editData->instagram_icon }}"
                                                class="form-control" id="instagram_icon" placeholder="Enter instagram icon">
                                            <span
                                                style="color: red;">{{ $errors->has('instagram_icon') ? $errors->first('instagram_icon') : '' }}</span>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="telegram">Telegram </label>
                                            <input type="text" name="telegram" value="{{ @$editData->telegram }}"
                                                class="form-control" id="telegram" placeholder="Enter telegram link">
                                            <span
                                                style="color: red;">{{ $errors->has('telegram') ? $errors->first('telegram') : '' }}</span>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="telegram_icon">Telegram icon</label>
                                            <input type="file" name="telegram_icon" value="{{ @$editData->telegram_icon }}"
                                                class="form-control" id="telegram_icon" placeholder="Enter telegram icon">
                                            <span
                                                style="color: red;">{{ $errors->has('telegram_icon') ? $errors->first('telegram_icon') : '' }}</span>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="whatsapp">Whatsapp </label>
                                            <input type="text" name="whatsapp" value="{{ @$editData->whatsapp }}"
                                                class="form-control" id="whatsapp" placeholder="Enter whatsapp link">
                                            <span
                                                style="color: red;">{{ $errors->has('whatsapp') ? $errors->first('whatsapp') : '' }}</span>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="whatsapp_icon">Whatsapp icon</label>
                                            <input type="file" name="whatsapp_icon" value="{{ @$editData->whatsapp_icon }}"
                                                class="form-control" id="whatsapp_icon" placeholder="Enter whatsapp icon">
                                            <span
                                                style="color: red;">{{ $errors->has('whatsapp_icon') ? $errors->first('whatsapp_icon') : '' }}</span>
                                        </div>
                                        <div class="form-group col-md-6" style="padding-top: 30px; float:right;">
                                            <button type="submit"
                                                class="btn btn-primary float-right">{{ @$editData ? 'Update' : 'Submit' }}</button>
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
                    address: {
                        required: true
                    },
                    mobile: {
                        required: true
                    },
                    email: {
                        required: true
                    },
                    facebook: {
                        required: true
                    },
                    youtube: {
                        required: true
                    },
                    twitter: {
                        required: true
                    },
                    google_plus: {
                        required: true
                    }
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
