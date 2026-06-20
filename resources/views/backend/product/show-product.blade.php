@extends('backend.layouts.master')
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Manage Products</h1>
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li class="breadcrumb-item active">Products</li>
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
                                <h3>
                                    Product Details Info
                                    <a class="btn btn-sm btn-primary float-right" href="{{ route('products.view') }}"><i
                                            class="fas fa-list"></i> Product List</a>
                                </h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table class="table table-bordered table-hover table-sm">
                                    <tr>
                                        <td width="40%">Category</td>
                                        <td width="60%">{{ $showData['category']['name'] }}</td>
                                    </tr>
                                    <tr>
                                        <td width="40%">Brand</td>
                                        <td width="60%">{{ $showData['brand']['name'] }}</td>
                                    </tr>
                                    <tr>
                                        <td width="40%">Product Name</td>
                                        <td width="60%">{{ $showData->name }}</td>
                                    </tr>
                                    <tr>
                                        <td width="40%">Origin</td>
                                        <td width="60%">{{ $showData['origin']['country'] }}</td>
                                    </tr>
                                    <tr>
                                        <td width="40%">Price</td>
                                        <td width="60%">{{ $showData->price }} Tk.</td>
                                    </tr>
                                    <tr>
                                        <td width="40%">Short Description</td>
                                        <td width="60%">{{ $showData->short_desc }}</td>
                                    </tr>
                                    <tr>
                                        <td width="40%">Long Description</td>
                                        <td width="60%">{{ $showData->long_desc }}</td>
                                    </tr>
                                    <tr>
                                        <td width="40%">Image</td>
                                        <td width="60%">
                                            <img style="width: 60px;height:70px"
                                                src="{{ !empty($showData->image) ? url('upload/product_images/' . $showData->image) : url('frontend/no-image-icon.jpg') }}">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td width="40%">Colors</td>
                                        <td width="60%">
                                            @php
                                                $colorss = App\Models\ProductColor::where('product_id', $showData->id)->get();
                                            @endphp
                                            @foreach ($colorss as $cls)
                                                {{ $cls['color']['name'] }},
                                            @endforeach
                                        </td>
                                    </tr>
                                    <tr>
                                        <td width="40%">Sizes</td>
                                        <td width="60%">
                                            @php
                                                $sizes = App\Models\ProductSize::where('product_id', $showData->id)->get();
                                            @endphp
                                            @foreach ($sizes as $s)
                                                {{ $s['size']['name'] }},
                                            @endforeach
                                        </td>
                                    </tr>

                                    <tr>
                                        <td width="40%">Product Sub Images</td>
                                        <td width="60%">
                                            @php
                                                $sub_images = App\Models\ProductSubImage::where('product_id', $showData->id)->get();
                                            @endphp
                                            @foreach ($sub_images as $img)
                                                <img style="width: 50px;height:55px"
                                                    src="{{ url('upload/product_images/product_sub_images/' . $img->sub_image) }}">
                                            @endforeach
                                        </td>
                                    </tr>

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
