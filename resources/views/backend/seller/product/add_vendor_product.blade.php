@extends('backend.seller.seller-master')
@section('content')
    <style>
        /* The container */
        .container {
            display: block;
            position: relative;
            padding-left: 35px;
            margin-bottom: 12px;
            cursor: pointer;
            /* font-size: 22px; */
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
        }

        /* Hide the browser's default checkbox */
        .container input {
            position: absolute;
            opacity: 0;
            cursor: pointer;
            height: 0;
            width: 0;
        }

        /* Create a custom checkbox */
        .checkmark {
            position: absolute;
            top: 0;
            left: 0;
            height: 25px;
            width: 25px;
            background-color: #eee;
        }

        /* On mouse-over, add a grey background color */
        .container:hover input~.checkmark {
            background-color: #ccc;
        }

        /* When the checkbox is checked, add a blue background */
        .container input:checked~.checkmark {
            background-color: #2196F3;
        }

        /* Create the checkmark/indicator (hidden when not checked) */
        .checkmark:after {
            content: "";
            position: absolute;
            display: none;
        }

        /* Show the checkmark when checked */
        .container input:checked~.checkmark:after {
            display: block;
        }

        /* Style the checkmark/indicator */
        .container .checkmark:after {
            left: 9px;
            top: 5px;
            width: 5px;
            height: 10px;
            border: solid white;
            border-width: 0 3px 3px 0;
            -webkit-transform: rotate(45deg);
            -ms-transform: rotate(45deg);
            transform: rotate(45deg);
        }
    </style>
    <style>
        .select2-container--default .select2-selection--single {
            height: 38px;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow b {
            margin-left: -5px;
            margin-top: 5px;
        }
    </style>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6">
                        <h5 class="m-0"><i class='fas fa-hand-point-right'></i> Add Product</h5>
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li class="breadcrumb-item active">Products</li>
                            &nbsp;&nbsp;&nbsp;
                            <a class="btn btn-sm btn-primary float-right" href="{{ route('vendor.productview') }}"><i class="fas fa-list"></i> Products List</a>
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
                            <!-- <div class="card-header">
                                <h3>
                                    @if (isset($editData))
                                        Edit Product
                                    @else
                                        Add Product
                                    @endif

                                  
                                </h3>
                            </div> -->
                            <!-- /.card-header -->
                            <div class="card-body">
                                <form method="post"
                                    action="{{ @$editData ? route('vendor.updateproduct', $editData->id) : route('vendor.store.product') }}"
                                    id="myForm" enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-row">
                                        <div class="form-group col-md-3">
                                            <label for="category_id">Category</label>
                                            <select name="category_id" id="category_id" class="form-control select2">
                                                <option value="">Select Category</option>
                                                @foreach ($categories as $category)
                                                    <option value="{{ $category->id }}"
                                                        {{ @$editData->category_id == $category->id ? 'Selected' : '' }}>
                                                        {{ $category->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="form-group col-md-3">
                                            <label for="subcategory_id">subcategory</label>
                                            <select name="subcategory_id" id="subcategory_id" class="form-control select2">
                                                <option value="">Select Subcategory</option>
                                                @foreach ($subcategories as $subcategory)
                                                    <option value="{{ $subcategory->id }}"
                                                        {{ @$editData->subcategory_id == $subcategory->id ? 'Selected' : '' }}>
                                                        {{ $subcategory->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="form-group col-md-3">
                                            <label for="brand_id">Brand</label>
                                            <select name="brand_id" id="brand_id" class="form-control select2">
                                                <option value="">Select Brand</option>
                                                @foreach ($brands as $brand)
                                                    <option value="{{ $brand->id }}"
                                                        {{ @$editData->brand_id == $brand->id ? 'Selected' : '' }}>
                                                        {{ $brand->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label for="sku">Product code </label>
                                            <input type="text" name="sku" value="{{ @$editData->sku }}"
                                            class="form-control" id="sku" placeholder="Enter product sku">
                                        <span
                                            style="color: red;">{{ $errors->has('sku') ? $errors->first('sku') : '' }}</span>
                                 
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="name">Product Name</label>
                                            <input type="text" name="name" value="{{ @$editData->name }}"
                                                class="form-control" id="name" placeholder="Enter product name">
                                            <span
                                                style="color: red;">{{ $errors->has('name') ? $errors->first('name') : '' }}</span>
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label for="name_bn">Product Name Bangla</label>
                                            <input type="text" name="name_bn" value="{{ @$editData->name_bn }}"
                                                class="form-control" id="name_bn" placeholder="Enter product name bangla">
                                            <span
                                                style="color: red;">{{ $errors->has('name_bn') ? $errors->first('name_bn') : '' }}</span>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="quantity">Stock Quantity</label>
                                            <input type="text" name="quantity" class="form-control" id="quantity"
                                                placeholder="Enter product quantity">
                                            <span
                                                style="color: red;">{{ $errors->has('quantity') ? $errors->first('quantity') : '' }}</span>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label>Colors</label>
                                            <select name="color_id[]" class="form-control select2" multiple>
                                                @foreach ($colors as $color)
                                                    <option value="{{ $color->id }}"
                                                        {{ @in_array(['color_id' => $color->id], $color_array) ? 'selected' : '' }}>
                                                        {{ $color->name }}</option>
                                                @endforeach
                                            </select>
                                            <span
                                                style="color: red;">{{ $errors->has('color_id') ? $errors->first('color_id') : '' }}</span>
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label>Size</label>
                                            <select name="size_id[]" class="form-control select2" multiple>
                                                @foreach ($sizes as $size)
                                                    <option value="{{ $size->id }}"
                                                        {{ @in_array(['size_id' => $size->id], $size_array) ? 'selected' : '' }}>
                                                        {{ $size->name }}</option>
                                                @endforeach
                                            </select>
                                            <span
                                                style="color: red;">{{ $errors->has('size_id') ? $errors->first('size_id') : '' }}</span>
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label>Short Description</label>
                                            <textarea name="short_desc" class="form-control summernote">{{ @$editData->short_desc }}</textarea>
                                            <span
                                                style="color: red;">{{ $errors->has('short_desc') ? $errors->first('short_desc') : '' }}</span>
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label>Short Description Bangla</label>
                                            <textarea name="short_desc_bn" class="form-control summernote">{{ @$editData->short_desc_bn }}</textarea>
                                            <span
                                                style="color: red;">{{ $errors->has('short_desc_bn') ? $errors->first('short_desc_bn') : '' }}</span>
                                        </div>

                                        <div class="form-group col-md-12">
                                            <label>Long Description</label>
                                            <textarea name="long_desc" class="form-control summernote"  rows="3">{{ @$editData->long_desc }}</textarea>
                                            <span
                                                style="color: red;">{{ $errors->has('long_desc') ? $errors->first('short_desc') : '' }}</span>
                                        </div>

                                        <div class="form-group col-md-3">
                                            <label>Trade Price</label>
                                            <input type="number" name="trade_price" value="{{ @$editData->trade_price }}"
                                                class="form-control">
                                            <span
                                                style="color: red;">{{ $errors->has('trade_price') ? $errors->first('trade_price') : '' }}</span>
                                        </div>

                                        <div class="form-group col-md-3">
                                            <label>Sales Price</label>
                                            <input type="number" name="price" value="{{ @$editData->price }}"
                                                class="form-control">
                                            <span style="color: red;">{{ $errors->has('price') ? $errors->first('price') : '' }}</span>
                                        </div>

                                        <div class="form-group col-md-3">
                                            <label>Discount Type</label>
                                            <select name="discount_type" class="form-control select2">
                                                <option value="">Select Type</option>
                                                <option value="1"
                                                    {{ @$editData->discount_type == 1 ? 'Selected' : '' }}> Percentage
                                                </option>
                                                <option value="2"
                                                    {{ @$editData->discount_type == 2 ? 'Selected' : '' }}>Fixed Amount
                                                </option>
                                            </select>
                                            <span
                                                style="color: red;">{{ $errors->has('discount_type') ? $errors->first('discount_type') : '' }}</span>
                                        </div>

                                        <div class="form-group col-md-3">
                                            <label>Discount Value</label>
                                            <input type="number" name="discount" value="{{ @$editData->discount }}"
                                                class="form-control">
                                            <span
                                                style="color: red;">{{ $errors->has('discount') ? $errors->first('discount') : '' }}</span>
                                        </div>

                                        <div class="form-group col-md-3">
                                            <label class="font-weight-bold">🏷️ Wholesale Price (Dropshipper Cost)</label>
                                            <input type="number" name="sale_price" value="{{ @$editData->sale_price }}"
                                                class="form-control" step="0.01" min="0">
                                            <span
                                                style="color: red;">{{ $errors->has('sale_price') ? $errors->first('sale_price') : '' }}</span>
                                        </div>

                                        <div class="form-group col-md-3">
                                            <label class="font-weight-bold">📉 Min Selling Price (Dropshipper)</label>
                                            <input type="number" name="min_price" value="{{ @$editData->min_price }}"
                                                class="form-control" step="0.01" min="0">
                                            <span
                                                style="color: red;">{{ $errors->has('min_price') ? $errors->first('min_price') : '' }}</span>
                                        </div>

                                        <div class="form-group col-md-3">
                                            <label class="font-weight-bold">📈 Max Selling Price (Dropshipper)</label>
                                            <input type="number" name="max_price" value="{{ @$editData->max_price }}"
                                                class="form-control" step="0.01" min="0">
                                            <span
                                                style="color: red;">{{ $errors->has('max_price') ? $errors->first('max_price') : '' }}</span>
                                        </div>

                                        <div class="form-group col-md-3">
                                            <!--<label class="container">is Hot Deals
                                                <input type="radio" name="radio1">
                                                <span class="checkmark"></span>
                                            </label> -->
                                            <label class="container">is Hot Deals
                                                <input type="checkbox" name="hot_deals" value="1">
                                                <span class="checkmark"></span>
                                            </label>
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label class="container">is Featured
                                                <input type="checkbox" name="featured" value="1">
                                                <span class="checkmark"></span>
                                            </label>
                                        </div>
                                        <div class="form-group col-md-3">
                                            <!-- <label class="container">is Special Offer
                                                <input type="radio" name="radio2">
                                                <span class="checkmark"></span>
                                            </label> -->
                                            <label class="container">is Special Offer
                                                <input type="checkbox" name="special_offer" value="1">
                                                <span class="checkmark"></span>
                                            </label>
                                        </div>
                                        <div class="form-group col-md-3">
                                            <!-- <label class="container">is Special deals
                                                <input type="radio" name="radio3">
                                                <span class="checkmark"></span>
                                            </label> -->
                                            <label class="container">is Special deals
                                                <input type="checkbox" name="special_deals" value="1">
                                                <span class="checkmark"></span>
                                            </label>
                                        </div>

                                        <div class="form-group col-md-3">
                                            <label>Image</label>
                                            <input type="file" name="image" id="image" class="form-control">
                                        </div>

                                        <div class="form-group col-md-2">
                                            <img id="showImage" style="width: 100px;height:105px; border:1px solid #000"
                                                src="{{ !empty($editData->image) ? url('upload/product_images/' . $editData->image) : url('frontend/no-image-icon.jpg') }}">
                                        </div>

                                        <div class="form-group col-md-3">
                                            <label>Sub Image</label>
                                            <input type="file" name="sub_image[]" class="form-control" multiple>
                                        </div>
                                        <div class="form-group col-md-12">
                                            <hr>
                                            <h5>SEO Meta Information</h5>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="meta_title">Meta Title</label>
                                            <input type="text" name="meta_title" value="{{ @$editData->meta_title }}"
                                                class="form-control" id="meta_title" placeholder="Enter meta title for SEO">
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="meta_description">Meta Description</label>
                                            <textarea name="meta_description" class="form-control" id="meta_description" rows="2"
                                                placeholder="Enter meta description for SEO">{{ @$editData->meta_description }}</textarea>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="meta_keywords">Meta Keywords</label>
                                             <textarea name="meta_keywords" class="form-control" id="meta_keywords" rows="2"
                                                placeholder="Enter meta Keywords for SEO">{{ @$editData->meta_keywords }}</textarea>
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label>Origin</label>
                                            <select name="country_id" class="form-control select2">
                                                <option value="">Select Country</option>
                                                @foreach ($countries as $country)
                                                    <option value="{{ $country->id }}"
                                                        {{ @$editData->country_id == $country->id ? 'Selected' : '' }}>
                                                        {{ $country->country }}</option>
                                                @endforeach
                                            </select>
                                            <span
                                                style="color: red;">{{ $errors->has('country_id') ? $errors->first('country_id') : '' }}</span>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label>Publication Status</label>
                                            <select name="status" class="form-control select2">
                                                <option value="1" {{ @$editData->status == 1 ? 'selected' : '' }}>Active</option>
                                                <option value="2" {{ @$editData->status == 2 ? 'selected' : '' }}>Pending</option>
                                                <option value="0" {{ @$editData->status == 0 ? 'selected' : '' }}>Inactive</option>
                                            </select>
                                            <span style="color: red;">{{ $errors->first('status') }}</span>
                                        </div>

                                        <div class="form-group col-md-12 text-right">
                                            <!--<input type="submit" value="submit" class="btn btn-primary"> -->
                                            <button type="submit" class="btn btn-primary"><i
                                                    class="fas fa-check-double"></i>
                                                {{ @$editData ? 'Update' : 'Submit' }}</button>
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
                    name_bn: {
                        required: true
                    },
                    category_id: {
                        required: true
                    },
                    subcategory_id: {
                        required: true
                    },
                    brand_id: {
                        required: true
                    },
                    country_id: {
                        required: true
                    },
                    short_desc: {
                        required: true
                    },
                    short_desc_bn: {
                        required: true
                    },
                    long_desc: {
                        required: true
                    },
                    trade_price: {
                        required: true
                    },
                    price: {
                        required: true
                    },
                    sale_price: {
                        number: true,
                        min: 0
                    },
                    min_price: {
                        number: true,
                        min: 0
                    },
                    max_price: {
                        number: true,
                        min: 0
                    },
                    meta_keywords: {
                        required: true
                    },
                    meta_description: {
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
