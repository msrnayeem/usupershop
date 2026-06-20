@extends('backend.layouts.master')
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
                            <a class="btn btn-sm btn-primary float-right" href="{{ route('products.view') }}"><i
                                    class="fas fa-list"></i> Products List</a>
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

                            <div class="card-body">
                                <form method="post" action="{{ route('products.store') }}" id="myForm"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-row">

                                        <div class="form-group col-md-3">
                                            <label for="category_id">Category</label>
                                            <select name="category_id" id="category_id" class="form-control select2">
                                                <option value="">Select Category</option>
                                                @foreach ($categories as $category)
                                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                                @endforeach
                                            </select>
                                            <span style="color: red;">{{ $errors->first('category_id') }}</span>
                                        </div>

                                        <div class="form-group col-md-3">
                                            <label for="subcategory_id">Subcategory</label>
                                            <select name="subcategory_id" id="subcategory_id" class="form-control select2">
                                                <option value="">Select Subcategory</option>
                                                @foreach ($subcategories as $subcategory)
                                                    <option value="{{ $subcategory->id }}">{{ $subcategory->name }}</option>
                                                @endforeach
                                            </select>
                                            <span style="color: red;">{{ $errors->first('subcategory_id') }}</span>
                                        </div>

                                        <div class="form-group col-md-3">
                                            <label for="brand_id">Brand</label>
                                            <select name="brand_id" id="brand_id" class="form-control select2">
                                                <option value="">Select Brand</option>
                                                @foreach ($brands as $brand)
                                                    <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                                                @endforeach
                                            </select>
                                            <span style="color: red;">{{ $errors->first('brand_id') }}</span>
                                        </div>

                                        <div class="form-group col-md-3">
                                            <label for="sku">Product code</label>
                                            <input type="text" name="sku" class="form-control" id="sku"
                                                placeholder="Enter product sku">
                                            <span style="color: red;">{{ $errors->first('sku') }}</span>
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label for="name">Product Name</label>
                                            <input type="text" name="name" class="form-control" id="name"
                                                placeholder="Enter product name">
                                            <span style="color: red;">{{ $errors->first('name') }}</span>
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label for="name_bn">Product Name Bangla</label>
                                            <input type="text" name="name_bn" class="form-control" id="name_bn"
                                                placeholder="Enter product name bangla">
                                            <span style="color: red;">{{ $errors->first('name_bn') }}</span>
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label for="quantity">Stock Quantity</label>
                                            <input type="text" name="quantity" class="form-control" id="quantity"
                                                placeholder="Enter product quantity">
                                            <span style="color: red;">{{ $errors->first('quantity') }}</span>
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label>Available Colors <span class="text-danger">*</span></label>
                                            <select id="available_colors" name="color_id[]" class="form-control select2"
                                                multiple>
                                                @foreach ($colors as $color)
                                                    <option value="{{ $color->id }}" data-name="{{ $color->name }}">
                                                        {{ $color->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <small class="text-muted">Select multiple colors for this product</small>
                                            <span style="color: red;">{{ $errors->first('color_id') }}</span>
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label>Available Sizes <span class="text-danger">*</span></label>
                                            <select id="available_sizes" name="size_id[]" class="form-control select2"
                                                multiple>
                                                @foreach ($sizes as $size)
                                                    <option value="{{ $size->id }}" data-name="{{ $size->name }}">
                                                        {{ $size->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <small class="text-muted">Select multiple sizes for this product</small>
                                            <span style="color: red;">{{ $errors->first('size_id') }}</span>
                                        </div>

                                        <!-- Generate Combinations Button -->
                                        <div class="form-group col-md-12">
                                            <div class="card">
                                                <div class="card-header bg-info text-white">
                                                    <h5 class="mb-0">
                                                        <i class="fas fa-cogs"></i> Color & Size Combinations
                                                    </h5>
                                                </div>
                                                <div class="card-body">
                                                    <p class="text-muted mb-3">
                                                        Select colors and sizes above, then click the button below to
                                                        generate all possible combinations with individual pricing and stock
                                                        management.
                                                    </p>
                                                    <button type="button" class="btn btn-info btn-lg"
                                                        id="generateCombinations">
                                                        <i class="fas fa-magic"></i> Generate Color & Size Combinations
                                                    </button>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Color & Size Combinations with Pricing -->
                                        <div class="form-group col-md-12">
                                            <div class="card">
                                                <div class="card-header">
                                                    <h5 class="mb-0">
                                                        <i class="fas fa-list-alt"></i> Generated Combinations
                                                    </h5>
                                                </div>
                                                <div class="card-body">
                                                    <div id="color-size-combinations">
                                                        <div class="text-center text-muted py-4">
                                                            <i class="fas fa-info-circle fa-2x mb-2"></i>
                                                            <p>No combinations generated yet.</p>
                                                            <p>Select colors and sizes above, then click "Generate
                                                                Combinations".</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Add some helpful alerts -->
                                        <div class="form-group col-md-12">
                                            <div class="alert alert-info" role="alert">
                                                <h6><i class="fas fa-lightbulb"></i> Tips for Color & Size Combinations:
                                                </h6>
                                                <ul class="mb-0">
                                                    <li>Each color-size combination can have its own additional price</li>
                                                    <li>Set individual stock quantities for better inventory management</li>
                                                    <li>SKU is optional but recommended for inventory tracking</li>
                                                    <li>Additional price will be added to the base product price</li>
                                                </ul>
                                            </div>
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label>Short Description</label>
                                            <textarea name="short_desc" class="form-control summernote"></textarea>
                                            <span style="color: red;">{{ $errors->first('short_desc') }}</span>
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label>Short Description Bangla</label>
                                            <textarea name="short_desc_bn" class="form-control summernote"></textarea>
                                            <span style="color: red;">{{ $errors->first('short_desc_bn') }}</span>
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label>Origin</label>
                                            <select name="country_id" class="form-control select2">
                                                <option value="">Select Country</option>
                                                @foreach ($countries as $country)
                                                    <option value="{{ $country->id }}">{{ $country->country }}</option>
                                                @endforeach
                                            </select>
                                            <span style="color: red;">{{ $errors->first('country_id') }}</span>
                                        </div>

                                        <div class="form-group col-md-8">
                                            <label>Long Description</label>
                                            <textarea name="long_desc" class="form-control summernote" rows="3"></textarea>
                                            <span style="color: red;">{{ $errors->first('long_desc') }}</span>
                                        </div>

                                        <div class="form-group col-md-3">
                                            <label>Trade Price</label>
                                            <input type="number" name="trade_price" class="form-control">
                                            <span style="color: red;">{{ $errors->first('trade_price') }}</span>
                                        </div>

                                        <div class="form-group col-md-3">
                                            <label>Sales Price</label>
                                            <input type="number" name="price" class="form-control">
                                            <span style="color: red;">{{ $errors->first('price') }}</span>
                                        </div>

                                        <div class="form-group col-md-3">
                                            <label>Discount Type</label>
                                            <select name="discount_type" class="form-control select2">
                                                <option value="">Select Type</option>
                                                <option value="1">Percentage</option>
                                                <option value="2">Fixed Amount</option>
                                            </select>
                                            <span style="color: red;">{{ $errors->first('discount_type') }}</span>
                                        </div>

                                        <div class="form-group col-md-3">
                                            <label>Discount Value</label>
                                            <input type="number" name="discount" class="form-control">
                                            <span style="color: red;">{{ $errors->first('discount') }}</span>
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label>Hole Sale Price</label>
                                            <input type="number" name="sale_price" class="form-control" step="0.01"
                                                placeholder="Enter sale price">
                                            <span style="color: red;">{{ $errors->first('sale_price') }}</span>
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label>Min Price</label>
                                            <input type="number" name="min_price" class="form-control" step="0.01"
                                                placeholder="Enter minimum price">
                                            <span style="color: red;">{{ $errors->first('sale_price') }}</span>
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label>Max Price</label>
                                            <input type="number" name="max_price" class="form-control" step="0.01"
                                                placeholder="Enter max price">
                                            <span style="color: red;">{{ $errors->first('sale_price') }}</span>
                                        </div>

                                        <div class="form-group col-md-3">
                                            <label>Is Hot Deals</label><br>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="hot_deals"
                                                    id="hot_deals_yes" value="1">
                                                <label class="form-check-label" for="hot_deals_yes">Yes</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="hot_deals"
                                                    id="hot_deals_no" value="0">
                                                <label class="form-check-label" for="hot_deals_no">No</label>
                                            </div>
                                        </div>

                                        <div class="form-group col-md-3">
                                            <label>Is Featured</label><br>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="featured"
                                                    id="featured_yes" value="1">
                                                <label class="form-check-label" for="featured_yes">Yes</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="featured"
                                                    id="featured_no" value="0">
                                                <label class="form-check-label" for="featured_no">No</label>
                                            </div>
                                        </div>

                                        <div class="form-group col-md-3">
                                            <label>Is Special Offer</label><br>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="special_offer"
                                                    id="special_offer_yes" value="1">
                                                <label class="form-check-label" for="special_offer_yes">Yes</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="special_offer"
                                                    id="special_offer_no" value="0">
                                                <label class="form-check-label" for="special_offer_no">No</label>
                                            </div>
                                        </div>

                                        <div class="form-group col-md-3">
                                            <label>Is Special Deals</label><br>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="special_deals"
                                                    id="special_deals_yes" value="1">
                                                <label class="form-check-label" for="special_deals_yes">Yes</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="special_deals"
                                                    id="special_deals_no" value="0">
                                                <label class="form-check-label" for="special_deals_no">No</label>
                                            </div>
                                        </div>

                                        <div class="form-group col-md-3">
                                            <label>Image <span class="text-danger">(You must upload a 512px x 512px
                                                    image.)</span></label>
                                            <input type="file" name="image" id="image" class="form-control">
                                            <span style="color: red;">{{ $errors->first('image') }}</span>
                                        </div>

                                        <div class="form-group col-md-2">
                                            <img id="showImage" style="width: 100px;height:105px; border:1px solid #000"
                                                src="">
                                        </div>

                                        <div class="form-group col-md-3">
                                            <label>Sub Image <span class="text-danger">(You must upload a 512px x 512px
                                                    image.)</span></label>
                                            <input type="file" name="sub_image[]" class="form-control" multiple>
                                            <span style="color: red;">{{ $errors->first('sub_image') }}</span>
                                        </div>

                                        <!-- SEO Fields -->
                                       <div class="form-group col-md-4">
                                            <label for="meta_title">Meta Title</label>
                                            <input type="text" name="meta_title" value="{{ @$editData->meta_title }}"
                                                class="form-control" id="meta_title" placeholder="Enter meta title for SEO">
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label for="meta_description">Meta Description</label>
                                            <textarea name="meta_description" class="form-control" id="meta_description"
                                                placeholder="Enter meta description for SEO">{{ @$editData->meta_description }}</textarea>
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label for="meta_keywords">Meta Keywords</label>
                                             <textarea name="meta_keywords" class="form-control" id="meta_keywords"
                                                placeholder="Enter meta Keywords for SEO">{{ @$editData->meta_keywords }}</textarea>
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label>Publication Status</label>
                                            <select name="status" class="form-control select2">
                                                <option value="1">Active</option>
                                                <option value="2">Pending</option>
                                                <option value="0">Inactive</option>
                                            </select>
                                            <span style="color: red;">{{ $errors->first('status') }}</span>
                                        </div>

                                        <div class="form-group col-md-12 text-right">
                                            <button type="submit" class="btn btn-primary">
                                                <i class="fas fa-check-double"></i> Submit
                                            </button>
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
                    image: {
                        required: true
                    },
                    "sub_image[]": {
                        required: true
                    },
                    trade_price: {
                        required: true
                    },
                    price: {
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
    <script type="text/javascript">
        $(document).ready(function() {
            $('#image').change(function(e) {
                var reader = new FileReader();
                reader.onload = function(event) {
                    setTimeout(function() {
                        $('#showImage').attr('src', event.target.result);
                    }, 200); // Delays by 200ms to ensure fast display
                };
                reader.readAsDataURL(e.target.files[0]);
            });
        });
    </script>


    <script>
        $(document).ready(function() {
            $('.select2').select2();

            // Generate combinations when button is clicked
            $('#generateCombinations').click(function() {
                generateColorSizeCombinations();
            });

            // Image preview
            $('#image').change(function() {
                readURL(this);
            });

            function readURL(input) {
                if (input.files && input.files[0]) {
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        $('#showImage').attr('src', e.target.result);
                    }
                    reader.readAsDataURL(input.files[0]);
                }
            }

            function generateColorSizeCombinations() {
                // Correct way to get selected values and texts
                const selectedColorIds = $('#available_colors').val();
                const selectedSizeIds = $('#available_sizes').val();

                if (!selectedColorIds || !selectedSizeIds || selectedColorIds.length === 0 || selectedSizeIds
                    .length === 0) {
                    alert('Please select both colors and sizes first!');
                    return;
                }

                // Get color and size names from options
                const colorMap = {};
                const sizeMap = {};

                $('#available_colors option').each(function() {
                    colorMap[$(this).val()] = $(this).text();
                });

                $('#available_sizes option').each(function() {
                    sizeMap[$(this).val()] = $(this).text();
                });

                console.log('Selected Color IDs:', selectedColorIds);
                console.log('Selected Size IDs:', selectedSizeIds);
                console.log('Color Map:', colorMap);
                console.log('Size Map:', sizeMap);

                let combinationsHtml = '';
                let combinationIndex = 0;

                // Add bulk action buttons
                combinationsHtml += `
            <div class="bulk-actions mt-3 mb-3 text-center">
                <button type="button" class="btn btn-sm btn-outline-primary" onclick="setAllAdditionalPrices()">
                    <i class="fas fa-dollar-sign"></i> Set All Additional Prices
                </button>
                <button type="button" class="btn btn-sm btn-outline-success" onclick="setAllStockQuantities()">
                    <i class="fas fa-boxes"></i> Set All Stock Quantities
                </button>
                <button type="button" class="btn btn-sm btn-outline-danger" onclick="clearAllCombinations()">
                    <i class="fas fa-trash"></i> Clear All
                </button>
            </div>
            <hr>
        `;

                selectedColorIds.forEach(function(colorId) {
                    selectedSizeIds.forEach(function(sizeId) {
                        const colorName = colorMap[colorId] || 'Unknown Color';
                        const sizeName = sizeMap[sizeId] || 'Unknown Size';

                        combinationsHtml += `
                    <div class="color-size-pricing mb-3 p-3 border rounded" data-combination="${combinationIndex}">
                        <div class="row align-items-center">
                            <div class="col-md-2">
                                <label class="form-label"><strong>Color:</strong></label>
                                <div class="form-control bg-light">${colorName}</div>
                                <input type="hidden" name="combinations[${combinationIndex}][color_id]" value="${colorId}">
                                <input type="hidden" name="combinations[${combinationIndex}][color_name]" value="${colorName}">
                            </div>
                            <div class="col-md-2">
                                <label class="form-label"><strong>Size:</strong></label>
                                <div class="form-control bg-light">${sizeName}</div>
                                <input type="hidden" name="combinations[${combinationIndex}][size_id]" value="${sizeId}">
                                <input type="hidden" name="combinations[${combinationIndex}][size_name]" value="${sizeName}">
                            </div>
                            <div class="col-md-2">
                                <label class="form-label">Additional Price (৳)</label>
                                <input type="number" name="combinations[${combinationIndex}][additional_price]" 
                                       class="form-control" step="0.01" value="0" min="0"
                                       placeholder="Extra price">
                            </div>
                            <div class="col-md-2">
                                <label class="form-label">Stock Quantity *</label>
                                <input type="number" name="combinations[${combinationIndex}][stock_quantity]" 
                                       class="form-control" value="0" min="0" required
                                       placeholder="Stock quantity">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">SKU (Optional)</label>
                                <input type="text" name="combinations[${combinationIndex}][sku]" 
                                       class="form-control" 
                                       placeholder="Variant SKU">
                            </div>
                            <div class="col-md-1">
                                <button type="button" class="btn btn-danger btn-sm mt-4" onclick="removeCombination(${combinationIndex})">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                `;
                        combinationIndex++;
                    });
                });

                $('#color-size-combinations').html(combinationsHtml);

                // Show success message
                if (combinationIndex > 0) {
                    toastr.success(`Generated ${combinationIndex} color-size combinations successfully!`);
                }
            }

            // Form submission validation
            $('form').on('submit', function(e) {
                const combinations = $('[data-combination]');
                if (combinations.length === 0) {
                    if (!confirm(
                            'No color-size combinations generated. Do you want to submit without combinations?'
                            )) {
                        e.preventDefault();
                        return false;
                    }
                }

                // Validate all combinations have stock quantity
                let hasError = false;
                combinations.each(function() {
                    const stockInput = $(this).find('input[name*="stock_quantity"]');
                    if (!stockInput.val() || stockInput.val() < 0) {
                        stockInput.addClass('is-invalid');
                        hasError = true;
                    } else {
                        stockInput.removeClass('is-invalid');
                    }
                });

                if (hasError) {
                    e.preventDefault();
                    alert('Please enter valid stock quantity for all combinations!');
                    return false;
                }
            });
        });

        // Remove individual combination
        function removeCombination(index) {
            $(`[data-combination="${index}"]`).fadeOut(300, function() {
                $(this).remove();

                // Update remaining combinations indices
                updateCombinationIndices();

                // Check if no combinations left
                if ($('[data-combination]').length === 0) {
                    $('#color-size-combinations').html(`
                <div class="text-center text-muted py-4">
                    <i class="fas fa-info-circle fa-2x mb-2"></i>
                    <p>No combinations generated yet.</p>
                    <p>Select colors and sizes above, then click "Generate Combinations".</p>
                </div>
            `);
                }
            });
        }

        // Update combination indices after removal
        function updateCombinationIndices() {
            const combinations = $('[data-combination]');
            combinations.each(function(newIndex) {
                const oldIndex = $(this).data('combination');
                $(this).attr('data-combination', newIndex);

                // Update all input names
                $(this).find('input, select').each(function() {
                    const name = $(this).attr('name');
                    if (name) {
                        const newName = name.replace(/combinations\[\d+\]/, `combinations[${newIndex}]`);
                        $(this).attr('name', newName);
                    }
                });
            });
        }

        // Bulk operations
        function setAllAdditionalPrices() {
            const price = prompt('Enter additional price for all combinations:');
            if (price !== null && !isNaN(price) && price >= 0) {
                $('input[name*="additional_price"]').val(parseFloat(price).toFixed(2));
                toastr.success('Additional price set for all combinations!');
            }
        }

        function setAllStockQuantities() {
            const stock = prompt('Enter stock quantity for all combinations:');
            if (stock !== null && !isNaN(stock) && stock >= 0) {
                $('input[name*="stock_quantity"]').val(parseInt(stock));
                toastr.success('Stock quantity set for all combinations!');
            }
        }

        function clearAllCombinations() {
            if (confirm('Are you sure you want to clear all combinations?')) {
                $('#color-size-combinations').html(`
            <div class="text-center text-muted py-4">
                <i class="fas fa-info-circle fa-2x mb-2"></i>
                <p>No combinations generated yet.</p>
                <p>Select colors and sizes above, then click "Generate Combinations".</p>
            </div>
        `);
                toastr.info('All combinations cleared!');
            }
        }

        // Alternative method using select2 data (if needed)
        function getSelect2Data(selector) {
            const selectedData = [];
            const selectedValues = $(selector).val();

            if (selectedValues) {
                selectedValues.forEach(function(value) {
                    const option = $(selector).find('option[value="' + value + '"]');
                    if (option.length) {
                        selectedData.push({
                            id: value,
                            text: option.text()
                        });
                    }
                });
            }

            return selectedData;
        }
    </script>

    <!-- Updated CSS for better styling -->
    <style>
        .color-size-pricing {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            border: 1px solid #dee2e6;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 15px;
            transition: all 0.3s ease;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .color-size-pricing:hover {
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
            transform: translateY(-2px);
            border-color: #007bff;
        }

        .bulk-actions {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            border: 1px solid #dee2e6;
        }

        .bulk-actions button {
            margin: 0 5px 5px 0;
        }

        .remove-btn {
            transition: all 0.3s ease;
        }

        .remove-btn:hover {
            transform: scale(1.1);
        }

        .form-label {
            font-weight: 600;
            margin-bottom: 5px;
            color: #495057;
        }

        #color-size-combinations {
            max-height: 600px;
            overflow-y: auto;
            padding: 15px;
            background: white;
            border-radius: 8px;
            border: 1px solid #dee2e6;
        }

        /* Scrollbar styling */
        #color-size-combinations::-webkit-scrollbar {
            width: 8px;
        }

        #color-size-combinations::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 4px;
        }

        #color-size-combinations::-webkit-scrollbar-thumb {
            background: #c1c1c1;
            border-radius: 4px;
        }

        #color-size-combinations::-webkit-scrollbar-thumb:hover {
            background: #a8a8a8;
        }

        /* Responsive design */
        @media (max-width: 768px) {

            .color-size-pricing .col-md-2,
            .color-size-pricing .col-md-3 {
                margin-bottom: 10px;
            }

            .color-size-pricing .col-md-1 {
                text-align: center;
                margin-top: 10px;
            }

            .bulk-actions button {
                display: block;
                width: 100%;
                margin-bottom: 10px;
            }
        }
    </style>
    <script>
        $(document).ready(function() {
            $('.select2').select2();

            // Generate combinations when button is clicked
            $('#generateCombinations').click(function() {
                generateColorSizeCombinations();
            });

            // Image preview
            $('#image').change(function() {
                readURL(this);
            });

            function readURL(input) {
                if (input.files && input.files[0]) {
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        $('#showImage').attr('src', e.target.result);
                    }
                    reader.readAsDataURL(input.files[0]);
                }
            }

            function generateColorSizeCombinations() {
                const selectedColors = $('#available_colors').select2('data');
                const selectedSizes = $('#available_sizes').select2('data');

                console.log('Selected Colors:', selectedColors); // Debug line
                console.log('Selected Sizes:', selectedSizes); // Debug line

                if (selectedColors.length === 0 || selectedSizes.length === 0) {
                    alert('Please select both colors and sizes first!');
                    return;
                }

                let combinationsHtml = '';
                let combinationIndex = 0;

                selectedColors.forEach(function(color) {
                    selectedSizes.forEach(function(size) {
                        combinationsHtml += `
                    <div class="color-size-pricing" data-combination="${combinationIndex}">
                        <div class="row align-items-end">
                            <div class="col-md-2">
                                <label>Color</label>
                                <input type="text" value="${color.text}" readonly class="form-control form-control-sm">
                                <input type="hidden" name="combinations[${combinationIndex}][color_id]" value="${color.id}">
                                <input type="hidden" name="combinations[${combinationIndex}][color_name]" value="${color.text}">
                            </div>
                            <div class="col-md-2">
                                <label>Size</label>
                                <input type="text" value="${size.text}" readonly class="form-control form-control-sm">
                                <input type="hidden" name="combinations[${combinationIndex}][size_id]" value="${size.id}">
                                <input type="hidden" name="combinations[${combinationIndex}][size_name]" value="${size.text}">
                            </div>
                            <div class="col-md-2">
                                <label>Additional Price</label>
                                <input type="number" name="combinations[${combinationIndex}][additional_price]" 
                                       class="form-control form-control-sm" step="0.01" value="0" 
                                       placeholder="Extra price">
                            </div>
                            <div class="col-md-2">
                                <label>Stock Qty</label>
                                <input type="number" name="combinations[${combinationIndex}][stock_quantity]" 
                                       class="form-control form-control-sm" value="0" min="0"
                                       placeholder="Stock quantity" required>
                            </div>
                            <div class="col-md-3">
                                <label>SKU (Optional)</label>
                                <input type="text" name="combinations[${combinationIndex}][sku]" 
                                       class="form-control form-control-sm" 
                                       placeholder="Variant SKU">
                            </div>
                            <div class="col-md-1">
                                <button type="button" class="btn btn-sm btn-danger remove-btn" onclick="removeCombination(${combinationIndex})">
                                    <i class="fas fa-times"></i> Remove
                                </button>
                            </div>
                        </div>
                    </div>
                `;
                        combinationIndex++;
                    });
                });

                $('#color-size-combinations').html(combinationsHtml);

                // Show success message
                if (combinationIndex > 0) {
                    toastr.success(`Generated ${combinationIndex} combinations successfully!`);
                }
            }

            // Auto-generate combinations when selections change
            $('#available_colors, #available_sizes').on('change', function() {
                // Optional: Auto-generate when selections change
                // Uncomment the line below if you want auto-generation
                // generateColorSizeCombinations();
            });

            // Form submission validation
            $('form').on('submit', function(e) {
                const combinations = $('[data-combination]');
                if (combinations.length === 0) {
                    e.preventDefault();
                    alert('Please generate color-size combinations first!');
                    return false;
                }

                // Validate all combinations have stock quantity
                let hasError = false;
                combinations.each(function() {
                    const stockInput = $(this).find('input[name*="stock_quantity"]');
                    if (!stockInput.val() || stockInput.val() < 0) {
                        stockInput.addClass('is-invalid');
                        hasError = true;
                    } else {
                        stockInput.removeClass('is-invalid');
                    }
                });

                if (hasError) {
                    e.preventDefault();
                    alert('Please enter valid stock quantity for all combinations!');
                    return false;
                }
            });
        });

        function removeCombination(index) {
            $(`[data-combination="${index}"]`).fadeOut(300, function() {
                $(this).remove();

                // Check if no combinations left
                if ($('[data-combination]').length === 0) {
                    $('#color-size-combinations').html(
                        '<p class="text-muted">No combinations generated yet. Select colors and sizes, then click "Generate Combinations".</p>'
                        );
                }
            });
        }

        // Bulk operations for combinations
        function setAllAdditionalPrices() {
            const price = prompt('Enter additional price for all combinations:');
            if (price !== null && !isNaN(price)) {
                $('input[name*="additional_price"]').val(price);
                toastr.success('Additional price set for all combinations!');
            }
        }

        function setAllStockQuantities() {
            const stock = prompt('Enter stock quantity for all combinations:');
            if (stock !== null && !isNaN(stock) && stock >= 0) {
                $('input[name*="stock_quantity"]').val(stock);
                toastr.success('Stock quantity set for all combinations!');
            }
        }

        // Add bulk action buttons after combinations are generated
        function addBulkActionButtons() {
            const bulkActions = `
        <div class="bulk-actions mt-3 mb-3">
            <button type="button" class="btn btn-sm btn-outline-primary" onclick="setAllAdditionalPrices()">
                <i class="fas fa-dollar-sign"></i> Set All Additional Prices
            </button>
            <button type="button" class="btn btn-sm btn-outline-success" onclick="setAllStockQuantities()">
                <i class="fas fa-boxes"></i> Set All Stock Quantities
            </button>
            <button type="button" class="btn btn-sm btn-outline-danger" onclick="clearAllCombinations()">
                <i class="fas fa-trash"></i> Clear All
            </button>
        </div>
    `;

            if ($('.bulk-actions').length === 0) {
                $('#color-size-combinations').prepend(bulkActions);
            }
        }

        function clearAllCombinations() {
            if (confirm('Are you sure you want to clear all combinations?')) {
                $('#color-size-combinations').html(
                    '<p class="text-muted">No combinations generated yet. Select colors and sizes, then click "Generate Combinations".</p>'
                    );
                toastr.info('All combinations cleared!');
            }
        }
    </script>

    <!-- Add some additional CSS for better styling -->
    <style>
        .color-size-pricing {
            border: 1px solid #dee2e6;
            border-radius: 5px;
            padding: 15px;
            margin-bottom: 15px;
            background-color: #f8f9fa;
            transition: all 0.3s ease;
        }

        .color-size-pricing:hover {
            background-color: #e9ecef;
            border-color: #007bff;
        }

        .remove-btn {
            background: #dc3545;
            border: none;
            color: white;
            padding: 5px 10px;
            border-radius: 3px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .remove-btn:hover {
            background: #c82333;
            transform: scale(1.05);
        }

        #color-size-combinations {
            max-height: 500px;
            overflow-y: auto;
            border: 1px solid #dee2e6;
            border-radius: 5px;
            padding: 15px;
            background-color: #fff;
        }

        .bulk-actions {
            border-bottom: 1px solid #dee2e6;
            padding-bottom: 15px;
            margin-bottom: 15px;
        }

        .bulk-actions button {
            margin-right: 10px;
            margin-bottom: 5px;
        }

        .is-invalid {
            border-color: #dc3545 !important;
        }

        .combination-header {
            background-color: #007bff;
            color: white;
            padding: 8px 15px;
            border-radius: 5px 5px 0 0;
            margin-bottom: 15px;
            font-weight: bold;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {

            .color-size-pricing .col-md-1,
            .color-size-pricing .col-md-2,
            .color-size-pricing .col-md-3 {
                margin-bottom: 10px;
            }
        }
    </style>
@endsection
