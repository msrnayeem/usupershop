@extends('backend.layouts.master')
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6">
                        <h5 class="m-0"><i class='fas fa-hand-point-right'></i> Manage Customer</h5>
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li class="breadcrumb-item active">Customer</li>
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
                                        Edit Customer
                                   
                                    @endif

                                    <a class="btn btn-sm btn-primary float-right" href="{{ route('customers.view') }}"><i
                                            class="fas fa-list"></i> All Customer</a>
                                </h5>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <form method="post"
                                    action="{{route('customers.update', $editData->id)}}"
                                    id="myForm">
                                    @csrf
                                    <div class="form-row">
                                        <div class="form-group col-md-4">
                                            <label for="name">Customer Name</label>
                                            <input type="text" name="name" value="{{ @$editData->name }}"
                                                class="form-control" id="name" placeholder="Enter name">
                                            <span
                                                style="color: red;">{{ $errors->has('name') ? $errors->first('name') : '' }}</span>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="name">Customer Email</label>
                                            <input type="email" name="email" value="{{ @$editData->email }}"
                                                class="form-control" id="email" placeholder="Enter email">
                                            <span
                                                style="color: red;">{{ $errors->has('email') ? $errors->first('email') : '' }}</span>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="name">Customer Password</label>
                                            <input type="password" name="password" value="{{old('password')}}"
                                                class="form-control" id="password" placeholder="Enter password">
                                            <span
                                                style="color: red;">{{ $errors->has('password') ? $errors->first('password') : '' }}</span>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="name"> Mobile</label>
                                            <input type="text" name="mobile" value="{{ @$editData->mobile }}"
                                                class="form-control" id="mobile" placeholder="Enter mobile">
                                            <span
                                                style="color: red;">{{ $errors->has('mobile') ? $errors->first('mobile') : '' }}</span>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="name"> Address</label>
                                            <input type="text" name="address" value="{{ @$editData->address }}"
                                                class="form-control" id="address" placeholder="Enter address">
                                            <span
                                                style="color: red;">{{ $errors->has('address') ? $errors->first('address') : '' }}</span>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="gender">Gender :</label>
                                            <select name="gender" id="gender" class="form-control">
                                                <option value="">Select Gender</option>
                                                <option value="Male" {{ @$editData->gender == 'Male' ? 'selected' : '' }}>Male</option>
                                                <option value="Female" {{ @$editData->gender == 'Female' ? 'selected' : '' }}>Female</option>
                                            </select>
                                        </div>
                                        
                                      
                                        <div class="form-group col-md-4">
                                            <label for="name"> User Image</label>
                                            <input type="file" name="image" value="{{ @$editData->image }}"
                                                class="form-control" id="image" placeholder="Enter image">
                                            <span
                                                style="color: red;">{{ $errors->has('image') ? $errors->first('image') : '' }}</span>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <img id="showImage" style="width: 100px;height:105px; border:1px solid #000"
                                                src="{{ !empty($editData->image) ? url('public/upload/user_images/' . $editData->image) : url('public/upload/profile.jpg') }}">
                                        </div>
                                       
                                        <div class="form-group col-md-6 text-right">
                                            
                                            <button type="submit"
                                                class="btn btn-primary">Update</button>
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
