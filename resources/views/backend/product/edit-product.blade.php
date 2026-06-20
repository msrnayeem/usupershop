@extends('backend.layouts.master')
@section('content')
    <style>
        /* Previous styles remain same */
        .container {
            display: block;
            position: relative;
            padding-left: 35px;
            margin-bottom: 12px;
            cursor: pointer;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
        }

        .container input {
            position: absolute;
            opacity: 0;
            cursor: pointer;
            height: 0;
            width: 0;
        }

        .checkmark {
            position: absolute;
            top: 0;
            left: 0;
            height: 25px;
            width: 25px;
            background-color: #eee;
        }

        .container:hover input~.checkmark {
            background-color: #ccc;
        }

        .container input:checked~.checkmark {
            background-color: #2196F3;
        }

        .checkmark:after {
            content: "";
            position: absolute;
            display: none;
        }

        .container input:checked~.checkmark:after {
            display: block;
        }

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

        .select2-container--default .select2-selection--single {
            height: 38px;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow b {
            margin-left: -5px;
            margin-top: 5px;
        }

        /* New styles for combinations */
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

    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6">
                        <h5 class="m-0"><i class='fas fa-hand-point-right'></i> Update Product</h5>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li class="breadcrumb-item active">Products</li>
                            &nbsp;&nbsp;&nbsp;
                            <a class="btn btn-sm btn-primary float-right" href="{{ route('products.view') }}"><i
                                    class="fas fa-list"></i> Products List</a>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <section class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <form method="post" action="{{ route('products.update', $editData->id) }}" id="myForm"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-row">
                                        <!-- Previous form fields remain same -->
                                        <div class="form-group col-md-3">
                                            <label for="category_id">Category</label>
                                            <select name="category_id" id="category_id" class="form-control select2">
                                                <option value="">Select Category</option>
                                                @foreach ($categories as $category)
                                                    <option value="{{ $category->id }}"
                                                        {{ $editData->category_id == $category->id ? 'Selected' : '' }}>
                                                        {{ $category->name }}</option>
                                                @endforeach
                                            </select>
                                            <span style="color: red;">{{ $errors->first('category_id') }}</span>
                                        </div>

                                        <div class="form-group col-md-3">
                                            <label for="subcategory_id">Subcategory</label>
                                            <select name="subcategory_id" id="subcategory_id" class="form-control select2">
                                                <option value="">Select Subcategory</option>
                                                @foreach ($subcategories as $subcategory)
                                                    <option value="{{ $subcategory->id }}"
                                                        {{ $editData->subcategory_id == $subcategory->id ? 'Selected' : '' }}>
                                                        {{ $subcategory->name }}</option>
                                                @endforeach
                                            </select>
                                            <span style="color: red;">{{ $errors->first('subcategory_id') }}</span>
                                        </div>

                                        <div class="form-group col-md-3">
                                            <label for="brand_id">Brand</label>
                                            <select name="brand_id" id="brand_id" class="form-control select2">
                                                <option value="">Select Brand</option>
                                                @foreach ($brands as $brand)
                                                    <option value="{{ $brand->id }}"
                                                        {{ $editData->brand_id == $brand->id ? 'Selected' : '' }}>
                                                        {{ $brand->name }}</option>
                                                @endforeach
                                            </select>
                                            <span style="color: red;">{{ $errors->first('brand_id') }}</span>
                                        </div>

                                        <div class="form-group col-md-3">
                                            <label for="sku">Product code</label>
                                            <input type="text" name="sku" value="{{ $editData->sku }}"
                                                class="form-control" id="sku" placeholder="Enter product sku">
                                            <span style="color: red;">{{ $errors->first('sku') }}</span>
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label for="name">Product Name</label>
                                            <input type="text" name="name" value="{{ $editData->name }}"
                                                class="form-control" id="name" placeholder="Enter product name">
                                            <span style="color: red;">{{ $errors->first('name') }}</span>
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label for="name_bn">Product Name Bangla</label>
                                            <input type="text" name="name_bn" value="{{ $editData->name_bn }}"
                                                class="form-control" id="name_bn" placeholder="Enter product name bangla">
                                            <span style="color: red;">{{ $errors->first('name_bn') }}</span>
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label for="quantity">Stock Quantity</label>
                                            <input type="text" name="quantity" class="form-control" id="quantity"
                                                placeholder="Enter product quantity" value="{{ $editData->quantity }}">
                                            <span style="color: red;">{{ $errors->first('quantity') }}</span>
                                        </div>

                                        <!-- NEW: Available Colors & Sizes with Combinations -->
                                        <div class="form-group col-md-6">
                                            <label>Available Colors <span class="text-danger">*</span></label>
                                            <select id="available_colors" name="color_id[]" class="form-control select2"
                                                multiple>
                                                @foreach ($colors as $color)
                                                    <option value="{{ $color->id }}" data-name="{{ $color->name }}"
                                                        {{ in_array(['color_id' => $color->id], $color_array) ? 'selected' : '' }}>
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
                                                    <option value="{{ $size->id }}" data-name="{{ $size->name }}"
                                                        {{ in_array(['size_id' => $size->id], $size_array) ? 'selected' : '' }}>
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
                                                        Update colors and sizes above, then click the button below to
                                                        regenerate combinations with individual pricing and stock
                                                        management.
                                                    </p>
                                                    <button type="button" class="btn btn-info btn-lg"
                                                        id="generateCombinations">
                                                        <i class="fas fa-magic"></i> Generate/Update Color & Size
                                                        Combinations
                                                    </button>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Color & Size Combinations Display -->
                                        <div class="form-group col-md-12">
                                            <div class="card">
                                                <div class="card-header">
                                                    <h5 class="mb-0">
                                                        <i class="fas fa-list-alt"></i> Product Combinations
                                                    </h5>
                                                </div>
                                                <div class="card-body">
                                                    <div id="color-size-combinations">
                                                        <!-- Existing combinations will be loaded here via JavaScript -->
                                                        <div class="text-center text-muted py-4">
                                                            <i class="fas fa-info-circle fa-2x mb-2"></i>
                                                            <p>Loading existing combinations...</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Rest of the form fields -->
                                        <div class="form-group col-md-6">
                                            <label>Short Description</label>
                                            <textarea name="short_desc" class="form-control summernote">{{ $editData->short_desc }}</textarea>
                                            <span style="color: red;">{{ $errors->first('short_desc') }}</span>
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label>Short Description Bangla</label>
                                            <textarea name="short_desc_bn" class="form-control summernote">{{ $editData->short_desc_bn }}</textarea>
                                            <span style="color: red;">{{ $errors->first('short_desc_bn') }}</span>
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label>Origin</label>
                                            <select name="country_id" class="form-control select2">
                                                <option value="">Select Country</option>
                                                @foreach ($countries as $country)
                                                    <option value="{{ $country->id }}"
                                                        {{ $editData->country_id == $country->id ? 'Selected' : '' }}>
                                                        {{ $country->country }}</option>
                                                @endforeach
                                            </select>
                                            <span style="color: red;">{{ $errors->first('country_id') }}</span>
                                        </div>

                                        <div class="form-group col-md-8">
                                            <label>Long Description</label>
                                            <textarea name="long_desc" class="form-control summernote" rows="3">{{ $editData->long_desc }}</textarea>
                                            <span style="color: red;">{{ $errors->first('long_desc') }}</span>
                                        </div>

                                        <div class="form-group col-md-3">
                                            <label>Trade Price</label>
                                            <input type="number" name="trade_price"
                                                value="{{ $editData->trade_price }}" class="form-control">
                                            <span style="color: red;">{{ $errors->first('trade_price') }}</span>
                                        </div>

                                        <div class="form-group col-md-3">
                                            <label>Sales Price</label>
                                            <input type="number" name="price" value="{{ $editData->price }}"
                                                class="form-control">
                                            <span style="color: red;">{{ $errors->first('price') }}</span>
                                        </div>

                                        <div class="form-group col-md-3">
                                            <label>Discount Type</label>
                                            <select name="discount_type" class="form-control select2">
                                                <option value="">Select Type</option>
                                                <option value="1"
                                                    {{ $editData->discount_type == 1 ? 'Selected' : '' }}>Percentage
                                                </option>
                                                <option value="2"
                                                    {{ $editData->discount_type == 2 ? 'Selected' : '' }}>Fixed Amount
                                                </option>
                                            </select>
                                            <span style="color: red;">{{ $errors->first('discount_type') }}</span>
                                        </div>

                                        <div class="form-group col-md-3">
                                            <label>Discount Value</label>
                                            <input type="number" name="discount" value="{{ $editData->discount }}"
                                                class="form-control">
                                            <span style="color: red;">{{ $errors->first('discount') }}</span>
                                        </div>

                                        <div class="form-group col-md-3">
                                            <label>Hole Sale Price</label>
                                            <input type="number" name="sale_price" value="{{ $editData->sale_price }}"
                                                class="form-control" step="0.01">
                                            <span style="color: red;">{{ $errors->first('sale_price') }}</span>
                                        </div>

                                        <div class="form-group col-md-3">
                                            <label>Min Price</label>
                                            <input type="number" name="min_price" value="{{ $editData->min_price }}"
                                                class="form-control" step="0.01">
                                            <span style="color: red;">{{ $errors->first('min_price') }}</span>
                                        </div>

                                        <div class="form-group col-md-3">
                                            <label>Max Price</label>
                                            <input type="number" name="max_price" value="{{ $editData->max_price }}"
                                                class="form-control" step="0.01">
                                            <span style="color: red;">{{ $errors->first('max_price') }}</span>
                                        </div>

                                        <div class="form-group col-md-3">
                                            <label>Is Hot Deals</label><br>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="hot_deals"
                                                    id="hot_deals_yes" value="1"
                                                    {{ $editData->hot_deals == 1 ? 'checked' : '' }}>
                                                <label class="form-check-label" for="hot_deals_yes">Yes</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="hot_deals"
                                                    id="hot_deals_no" value="0"
                                                    {{ $editData->hot_deals == 0 ? 'checked' : '' }}>
                                                <label class="form-check-label" for="hot_deals_no">No</label>
                                            </div>
                                        </div>

                                        <div class="form-group col-md-3">
                                            <label>Is Featured</label><br>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="featured"
                                                    id="featured_yes" value="1"
                                                    {{ $editData->featured == 1 ? 'checked' : '' }}>
                                                <label class="form-check-label" for="featured_yes">Yes</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="featured"
                                                    id="featured_no" value="0"
                                                    {{ $editData->featured == 0 ? 'checked' : '' }}>
                                                <label class="form-check-label" for="featured_no">No</label>
                                            </div>
                                        </div>

                                        <div class="form-group col-md-3">
                                            <label>Is Special Offer</label><br>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="special_offer"
                                                    id="special_offer_yes" value="1"
                                                    {{ $editData->special_offer == 1 ? 'checked' : '' }}>
                                                <label class="form-check-label" for="special_offer_yes">Yes</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="special_offer"
                                                    id="special_offer_no" value="0"
                                                    {{ $editData->special_offer == 0 ? 'checked' : '' }}>
                                                <label class="form-check-label" for="special_offer_no">No</label>
                                            </div>
                                        </div>

                                        <div class="form-group col-md-3">
                                            <label>Is Special Deals</label><br>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="special_deals"
                                                    id="special_deals_yes" value="1"
                                                    {{ $editData->special_deals == 1 ? 'checked' : '' }}>
                                                <label class="form-check-label" for="special_deals_yes">Yes</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="special_deals"
                                                    id="special_deals_no" value="0"
                                                    {{ $editData->special_deals == 0 ? 'checked' : '' }}>
                                                <label class="form-check-label" for="special_deals_no">No</label>
                                            </div>
                                        </div>

                                        <div class="form-group col-md-3">
                                            <label>Image <span class="text-danger">(512px x 512px)</span></label>
                                            <input type="file" name="image" id="image" class="form-control">
                                        </div>

                                        <div class="form-group col-md-2">
                                            <img id="showImage" style="width: 100px;height:105px; border:1px solid #000"
                                                src="{{ !empty($editData->image) ? url('upload/product_images/' . $editData->image) : url('frontend/no-image-icon.jpg') }}">
                                        </div>

                                        <div class="form-group col-md-3">
                                            <label>Sub Image <span class="text-danger">(512px x 512px)</span></label>
                                            <input type="file" name="sub_image[]" class="form-control" multiple>
                                        </div>

                                        <!-- SEO Fields -->
                                        <div class="form-group col-md-4">
                                            <label for="meta_title">Meta Title</label>
                                            <input type="text" name="meta_title" value="{{ @$editData->meta_title }}"
                                                class="form-control" id="meta_title"
                                                placeholder="Enter meta title for SEO">
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label for="meta_description">Meta Description</label>
                                            <textarea name="meta_description" class="form-control" id="meta_description"
                                                placeholder="Enter meta description for SEO">{{ @$editData->meta_description }}</textarea>
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label for="meta_keywords">Meta Keywords</label>
                                            <textarea name="meta_keywords" class="form-control" id="meta_keywords" placeholder="Enter meta Keywords for SEO">{{ @$editData->meta_keywords }}</textarea>
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label>Publication Status</label>
                                            <select name="status" class="form-control select2">
                                                <option value="1" {{ $editData->status == 1 ? 'Selected' : '' }}>
                                                    Active</option>
                                                <option value="2" {{ $editData->status == 2 ? 'Selected' : '' }}>
                                                    Pending</option>
                                                <option value="0" {{ $editData->status == 0 ? 'Selected' : '' }}>
                                                    Inactive</option>
                                            </select>
                                            <span style="color: red;">{{ $errors->first('status') }}</span>
                                        </div>

                                        <div class="form-group col-md-12 text-right">
                                            <button type="submit" class="btn btn-primary">
                                                <i class="fas fa-check-double"></i> Update Product
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </section>
    </div>

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
                    }
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
                    }, 200);
                };
                reader.readAsDataURL(e.target.files[0]);
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            $('.select2').select2();

            // Store existing combinations from database
            const existingVariants = @json($editData->variants ?? []);

            // Load existing combinations on page load
            loadExistingCombinations();

            // Generate new combinations when button is clicked
            $('#generateCombinations').click(function() {
                generateColorSizeCombinations();
            });

            function loadExistingCombinations() {
                if (existingVariants && existingVariants.length > 0) {
                    let combinationsHtml = generateBulkActionsHtml();

                    existingVariants.forEach(function(variant, index) {
                        combinationsHtml += generateCombinationHtml(
                            index,
                            variant.color_id,
                            variant.color ? variant.color.name : 'Unknown',
                            variant.size_id,
                            variant.size ? variant.size.name : 'Unknown',
                            variant.additional_price || 0,
                            variant.stock_quantity || 0,
                            variant.sku || '',
                            variant.id
                        );
                    });

                    $('#color-size-combinations').html(combinationsHtml);
                } else {
                    showEmptyMessage();
                }
            }

            function generateColorSizeCombinations() {
                const selectedColorIds = $('#available_colors').val();
                const selectedSizeIds = $('#available_sizes').val();

                if (!selectedColorIds || !selectedSizeIds || selectedColorIds.length === 0 || selectedSizeIds
                    .length === 0) {
                    alert('Please select both colors and sizes first!');
                    return;
                }

                const colorMap = {};
                const sizeMap = {};

                $('#available_colors option').each(function() {
                    colorMap[$(this).val()] = $(this).text();
                });

                $('#available_sizes option').each(function() {
                    sizeMap[$(this).val()] = $(this).text();
                });

                let combinationsHtml = generateBulkActionsHtml();
                let combinationIndex = 0;

                // Check existing variants to preserve data
                const existingVariantMap = {};
                existingVariants.forEach(v => {
                    const key = `${v.color_id}-${v.size_id}`;
                    existingVariantMap[key] = v;
                });

                selectedColorIds.forEach(function(colorId) {
                    selectedSizeIds.forEach(function(sizeId) {
                        const colorName = colorMap[colorId] || 'Unknown Color';
                        const sizeName = sizeMap[sizeId] || 'Unknown Size';
                        const key = `${colorId}-${sizeId}`;
                        const existing = existingVariantMap[key];

                        combinationsHtml += generateCombinationHtml(
                            combinationIndex,
                            colorId,
                            colorName,
                            sizeId,
                            sizeName,
                            existing ? existing.additional_price : 0,
                            existing ? existing.stock_quantity : 0,
                            existing ? existing.sku : '',
                            existing ? existing.id : null
                        );
                        combinationIndex++;
                    });
                });

                $('#color-size-combinations').html(combinationsHtml);

                if (combinationIndex > 0) {
                    toastr.success(`Generated ${combinationIndex} color-size combinations!`);
                }
            }

            function generateBulkActionsHtml() {
                return `
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
            }

            function generateCombinationHtml(index, colorId, colorName, sizeId, sizeName, additionalPrice, stockQty,
                sku, variantId) {
                return `
                <div class="color-size-pricing mb-3 p-3 border rounded" data-combination="${index}">
                    <div class="row align-items-center">
                        <div class="col-md-2">
                            <label class="form-label"><strong>Color:</strong></label>
                            <div class="form-control bg-light">${colorName}</div>
                            <input type="hidden" name="combinations[${index}][color_id]" value="${colorId}">
                            <input type="hidden" name="combinations[${index}][color_name]" value="${colorName}">
                            ${variantId ? `<input type="hidden" name="combinations[${index}][id]" value="${variantId}">` : ''}
                        </div>
                        <div class="col-md-2">
                            <label class="form-label"><strong>Size:</strong></label>
                            <div class="form-control bg-light">${sizeName}</div>
                            <input type="hidden" name="combinations[${index}][size_id]" value="${sizeId}">
                            <input type="hidden" name="combinations[${index}][size_name]" value="${sizeName}">
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">Additional Price (৳)</label>
                            <input type="number" name="combinations[${index}][additional_price]" 
                                   class="form-control" step="0.01" value="${additionalPrice}" min="0"
                                   placeholder="Extra price">
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">Stock Quantity *</label>
                            <input type="number" name="combinations[${index}][stock_quantity]" 
                                   class="form-control" value="${stockQty}" min="0" required
                                   placeholder="Stock quantity">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">SKU (Optional)</label>
                            <input type="text" name="combinations[${index}][sku]" 
                                   class="form-control" value="${sku}"
                                   placeholder="Variant SKU">
                        </div>
                        <div class="col-md-1">
                            <button type="button" class="btn btn-danger btn-sm mt-4" onclick="removeCombination(${index})">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                </div>
            `;
            }

            function showEmptyMessage() {
                $('#color-size-combinations').html(`
                <div class="text-center text-muted py-4">
                    <i class="fas fa-info-circle fa-2x mb-2"></i>
                    <p>No combinations found.</p>
                    <p>Select colors and sizes above, then click "Generate Combinations".</p>
                </div>
            `);
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
            if (confirm('Are you sure you want to remove this combination?')) {
                $(`[data-combination="${index}"]`).fadeOut(300, function() {
                    $(this).remove();
                    updateCombinationIndices();

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
        }

        // Update combination indices after removal
        function updateCombinationIndices() {
            const combinations = $('[data-combination]');
            combinations.each(function(newIndex) {
                $(this).attr('data-combination', newIndex);

                $(this).find('input, select').each(function() {
                    const name = $(this).attr('name');
                    if (name) {
                        const newName = name.replace(/combinations\[\d+\]/, `combinations[${newIndex}]`);
                        $(this).attr('name', newName);
                    }
                });

                $(this).find('button[onclick]').each(function() {
                    $(this).attr('onclick', `removeCombination(${newIndex})`);
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
    </script>
@endsection
