@extends('backend.seller.seller-master')
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header" style="padding-bottom:0px;">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Shopkeeper Product</h1>
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li class="breadcrumb-item active">Shopkeeper Product</li>
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
                           
                            <nav class="navbar justify-content-end">
                                <form class="form-inline" action="{{ route('sellers.product_search') }}">
                                    <input class="form-control mr-sm-2" type="search"
                                     placeholder="Search" aria-label="Search" name="product_search">
                                     <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
                                </form>
                            </nav>
                            <div class="card-body">
                                <div class="row row-cols-1 row-cols-md-4">
                                    @forelse ($products as $items)
                                   
                                        <div class="col mb-4">
                                            <div class="card" style="height:380px;">
                                                <img class="card-img-top"
                                                    src="{{ url('upload/product_images/' . $items->image) }}"
                                                    alt="{{ $items->slug }}" style="height:260px;">
                                                <div class="card-body">
                                                    <h5 title="{{ $items->name }}">
                                                        <?php
                                                        $string = $items->name;
                                                        echo $result = substr($string, 0, 25);
                                                        ?>
                                                    </h5>
                                                      <div class="product-price">
                                        @if (!empty($items->discount))
                                            <span class="price text-danger">
                                                @if ($items->discount_type == 1)
                                                    &#2547;
                                                    {{ $items->price - ($items->price * $items->discount) / 100 }}
                                                @else
                                                    &#2547; {{ $items->price - $items->discount }}
                                                @endif
                                            </span>
                                        @else
                                            <span class="price text-danger">&#2547;
                                                {{ $items->price }}</span>
                                        @endif
                                      
                                    </div>
                                                    <div class="d-flex justify-content-center">
                                                        <button type="button" onclick="addToMyShop(this.id)"
                                                            id="{{ $items->id }}" class="btn btn-info btn-sm">Add to
                                                            shop</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach

                                </div>
                            </div>
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
