@extends('backend.seller.seller-master')
@section('content')
    <style>
        .custom-switch-label {
            position: relative;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            cursor: pointer;
            user-select: none;
            font-size: 13.5px;
            font-weight: 600;
            color: #334155;
            background: #f8fafc;
            padding: 8px 16px;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            transition: all 0.2s ease;
            width: 100%;
        }
        .custom-switch-label:hover {
            border-color: #cbd5e1;
            background: #f1f5f9;
        }
        .custom-switch-input {
            position: absolute;
            opacity: 0;
            cursor: pointer;
            height: 0;
            width: 0;
        }
        .custom-switch-slider {
            width: 38px;
            height: 20px;
            background-color: #cbd5e1;
            border-radius: 20px;
            position: relative;
            transition: background-color 0.2s ease;
        }
        .custom-switch-slider::before {
            content: "";
            position: absolute;
            width: 14px;
            height: 14px;
            border-radius: 50%;
            background-color: white;
            left: 3px;
            top: 3px;
            transition: transform 0.2s ease;
        }
        .custom-switch-input:checked + .custom-switch-slider {
            background-color: #6366f1;
        }
        .custom-switch-input:checked + .custom-switch-slider::before {
            transform: translateX(18px);
        }
    </style>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        {{-- Page Header --}}
        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:22px;flex-wrap:wrap;gap:12px;">
            <div>
                <h1 style="font-size:22px;font-weight:800;color:#0f172a;margin:0;">
                    <i class="fas fa-box-open" style="color:#6366f1;margin-right:8px;"></i>
                    @if (isset($editData)) Edit Product @else Add Product @endif
                </h1>
                <p style="color:#64748b;font-size:13px;margin:2px 0 0;">
                    <a href="{{ route('seller.dashboard') }}" style="color:#6366f1;text-decoration:none;">Dashboard</a>
                    <span style="margin:0 6px;color:#cbd5e1;">/</span>
                    <a href="{{ route('vendor.productview') }}" style="color:#6366f1;text-decoration:none;">My Products</a>
                    <span style="margin:0 6px;color:#cbd5e1;">/</span>
                    @if (isset($editData)) Edit @else Add @endif
                </p>
            </div>
            <a class="btn btn-sm btn-primary" href="{{ route('vendor.productview') }}" style="display:inline-flex;align-items:center;gap:6px;padding:9px 18px;background:#6366f1;border:none;border-radius:8px;font-size:13px;font-weight:600;color:#fff;text-decoration:none;">
                <i class="fas fa-list"></i> Products List
            </a>
        </div>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="card">
                    <div class="card-header">
                        <span class="card-title">
                            <i class="fas fa-cog" style="color:#6366f1;margin-right:6px;"></i>
                            Product Parameters
                        </span>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <form method="post"
                            action="{{ @$editData ? route('vendor.updateproduct', $editData->id) : route('vendor.store.product') }}"
                            id="myForm" enctype="multipart/form-data">
                            @csrf
                            <div class="form-row">
                                <div class="form-group col-md-3">
                                    <label for="category_id">Category <span class="text-danger">*</span></label>
                                    <select name="category_id" id="category_id" class="form-control select2" required>
                                        <option value="">Select Category</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}"
                                                {{ @$editData->category_id == $category->id ? 'Selected' : '' }}>
                                                {{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group col-md-3">
                                    <label for="subcategory_id">Subcategory <span class="text-danger">*</span></label>
                                    <select name="subcategory_id" id="subcategory_id" class="form-control select2" required>
                                        <option value="">Select Subcategory</option>
                                        @foreach ($subcategories as $subcategory)
                                            <option value="{{ $subcategory->id }}"
                                                {{ @$editData->subcategory_id == $subcategory->id ? 'Selected' : '' }}>
                                                {{ $subcategory->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group col-md-3">
                                    <label for="brand_id">Brand <span class="text-danger">*</span></label>
                                    <select name="brand_id" id="brand_id" class="form-control select2" required>
                                        <option value="">Select Brand</option>
                                        @foreach ($brands as $brand)
                                            <option value="{{ $brand->id }}"
                                                {{ @$editData->brand_id == $brand->id ? 'Selected' : '' }}>
                                                {{ $brand->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group col-md-3">
                                    <label for="sku">SKU Code</label>
                                    <input type="text" name="sku" value="{{ @$editData->sku }}" class="form-control" id="sku" placeholder="Enter product SKU">
                                    <span style="color: red;">{{ $errors->has('sku') ? $errors->first('sku') : '' }}</span>
                                </div>

                                <div class="form-group col-md-4">
                                    <label for="name">Product Name (EN) <span class="text-danger">*</span></label>
                                    <input type="text" name="name" value="{{ @$editData->name }}" class="form-control" id="name" placeholder="Enter name in English" required>
                                    <span style="color: red;">{{ $errors->has('name') ? $errors->first('name') : '' }}</span>
                                </div>

                                <div class="form-group col-md-4">
                                    <label for="name_bn">Product Name (BN) <span class="text-danger">*</span></label>
                                    <input type="text" name="name_bn" value="{{ @$editData->name_bn }}" class="form-control" id="name_bn" placeholder="Enter name in Bangla" required>
                                    <span style="color: red;">{{ $errors->has('name_bn') ? $errors->first('name_bn') : '' }}</span>
                                </div>

                                <div class="form-group col-md-4">
                                    <label for="quantity">Stock Quantity <span class="text-danger">*</span></label>
                                    <input type="number" name="quantity" value="{{ @$editData->quantity }}" class="form-control" id="quantity" placeholder="Stock units" required>
                                    <span style="color: red;">{{ $errors->has('quantity') ? $errors->first('quantity') : '' }}</span>
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
                                    <span style="color: red;">{{ $errors->has('color_id') ? $errors->first('color_id') : '' }}</span>
                                </div>

                                <div class="form-group col-md-6">
                                    <label>Sizes</label>
                                    <select name="size_id[]" class="form-control select2" multiple>
                                        @foreach ($sizes as $size)
                                            <option value="{{ $size->id }}"
                                                {{ @in_array(['size_id' => $size->id], $size_array) ? 'selected' : '' }}>
                                                {{ $size->name }}</option>
                                        @endforeach
                                    </select>
                                    <span style="color: red;">{{ $errors->has('size_id') ? $errors->first('size_id') : '' }}</span>
                                </div>

                                <div class="form-group col-md-6">
                                    <label>Short Description (EN) <span class="text-danger">*</span></label>
                                    <textarea name="short_desc" class="form-control summernote">{{ @$editData->short_desc }}</textarea>
                                    <span style="color: red;">{{ $errors->has('short_desc') ? $errors->first('short_desc') : '' }}</span>
                                </div>

                                <div class="form-group col-md-6">
                                    <label>Short Description (BN) <span class="text-danger">*</span></label>
                                    <textarea name="short_desc_bn" class="form-control summernote">{{ @$editData->short_desc_bn }}</textarea>
                                    <span style="color: red;">{{ $errors->has('short_desc_bn') ? $errors->first('short_desc_bn') : '' }}</span>
                                </div>

                                <div class="form-group col-md-12">
                                    <label>Long Description <span class="text-danger">*</span></label>
                                    <textarea name="long_desc" class="form-control summernote" rows="4">{{ @$editData->long_desc }}</textarea>
                                    <span style="color: red;">{{ $errors->has('long_desc') ? $errors->first('long_desc') : '' }}</span>
                                </div>

                                <div class="form-group col-md-3">
                                    <label>Trade Price <span class="text-danger">*</span></label>
                                    <input type="number" name="trade_price" value="{{ @$editData->trade_price }}" class="form-control" required>
                                    <span style="color: red;">{{ $errors->has('trade_price') ? $errors->first('trade_price') : '' }}</span>
                                </div>

                                <div class="form-group col-md-3">
                                    <label>Retail Selling Price <span class="text-danger">*</span></label>
                                    <input type="number" name="price" value="{{ @$editData->price }}" class="form-control" required>
                                    <span style="color: red;">{{ $errors->has('price') ? $errors->first('price') : '' }}</span>
                                </div>

                                <div class="form-group col-md-3">
                                    <label>Discount Type</label>
                                    <select name="discount_type" class="form-control select2">
                                        <option value="">Select Type</option>
                                        <option value="1" {{ @$editData->discount_type == 1 ? 'Selected' : '' }}>Percentage (%)</option>
                                        <option value="2" {{ @$editData->discount_type == 2 ? 'Selected' : '' }}>Fixed Amount (৳)</option>
                                    </select>
                                    <span style="color: red;">{{ $errors->has('discount_type') ? $errors->first('discount_type') : '' }}</span>
                                </div>

                                <div class="form-group col-md-3">
                                    <label>Discount Value</label>
                                    <input type="number" name="discount" value="{{ @$editData->discount }}" class="form-control">
                                    <span style="color: red;">{{ $errors->has('discount') ? $errors->first('discount') : '' }}</span>
                                </div>

                                <div class="form-group col-md-4">
                                    <label>🏷️ Dropshipper Wholesale Cost</label>
                                    <input type="number" name="sale_price" value="{{ @$editData->sale_price }}" class="form-control" step="0.01" min="0">
                                    <span style="color: red;">{{ $errors->has('sale_price') ? $errors->first('sale_price') : '' }}</span>
                                </div>

                                <div class="form-group col-md-4">
                                    <label>📉 Min Dropshipper Reselling Limit</label>
                                    <input type="number" name="min_price" value="{{ @$editData->min_price }}" class="form-control" step="0.01" min="0">
                                    <span style="color: red;">{{ $errors->has('min_price') ? $errors->first('min_price') : '' }}</span>
                                </div>

                                <div class="form-group col-md-4">
                                    <label>📈 Max Dropshipper Reselling Limit</label>
                                    <input type="number" name="max_price" value="{{ @$editData->max_price }}" class="form-control" step="0.01" min="0">
                                    <span style="color: red;">{{ $errors->has('max_price') ? $errors->first('max_price') : '' }}</span>
                                </div>

                                {{-- Switches --}}
                                <div class="form-group col-md-3 mt-4">
                                    <label class="custom-switch-label">
                                        <input type="checkbox" name="hot_deals" value="1" class="custom-switch-input" {{ @$editData->hot_deals == 1 ? 'checked' : '' }}>
                                        <span class="custom-switch-slider"></span>
                                        <span>Hot Deals</span>
                                    </label>
                                </div>
                                <div class="form-group col-md-3 mt-4">
                                    <label class="custom-switch-label">
                                        <input type="checkbox" name="featured" value="1" class="custom-switch-input" {{ @$editData->featured == 1 ? 'checked' : '' }}>
                                        <span class="custom-switch-slider"></span>
                                        <span>Featured Item</span>
                                    </label>
                                </div>
                                <div class="form-group col-md-3 mt-4">
                                    <label class="custom-switch-label">
                                        <input type="checkbox" name="special_offer" value="1" class="custom-switch-input" {{ @$editData->special_offer == 1 ? 'checked' : '' }}>
                                        <span class="custom-switch-slider"></span>
                                        <span>Special Offer</span>
                                    </label>
                                </div>
                                <div class="form-group col-md-3 mt-4">
                                    <label class="custom-switch-label">
                                        <input type="checkbox" name="special_deals" value="1" class="custom-switch-input" {{ @$editData->special_deals == 1 ? 'checked' : '' }}>
                                        <span class="custom-switch-slider"></span>
                                        <span>Special Deals</span>
                                    </label>
                                </div>

                                <div class="form-group col-md-4 mt-3">
                                    <label>Primary Thumbnail</label>
                                    <input type="file" name="image" id="image" class="form-control">
                                    <div class="mt-3" style="background:#f8fafc;padding:6px;border:1px solid #cbd5e1;border-radius:8px;display:inline-block;">
                                        <img id="showImage" style="width: 100px;height:100px;object-fit:cover;display:block;"
                                            src="{{ !empty($editData->image) ? url('upload/product_images/' . $editData->image) : url('frontend/no-image-icon.jpg') }}">
                                    </div>
                                </div>

                                <div class="form-group col-md-4 mt-3">
                                    <label>Sub Gallery Images (Multiple)</label>
                                    <input type="file" name="sub_image[]" class="form-control" multiple>
                                </div>

                                <div class="form-group col-md-12 mt-4" style="border-top:1px solid #e2e8f0;padding-top:20px;">
                                    <h5 style="font-weight:800;color:#0f172a;font-size:16px;margin-bottom:15px;"><i class="fas fa-search-plus" style="color:#6366f1;margin-right:6px;"></i> SEO Meta Search Indexing</h5>
                                </div>

                                <div class="form-group col-md-4">
                                    <label for="meta_title">Meta SEO Title</label>
                                    <input type="text" name="meta_title" value="{{ @$editData->meta_title }}" class="form-control" id="meta_title" placeholder="Meta title">
                                </div>

                                <div class="form-group col-md-4">
                                    <label for="meta_description">Meta Description</label>
                                    <textarea name="meta_description" class="form-control" id="meta_description" rows="2" placeholder="Brief metadata description">{{ @$editData->meta_description }}</textarea>
                                </div>

                                <div class="form-group col-md-4">
                                    <label for="meta_keywords">Meta Keywords</label>
                                    <textarea name="meta_keywords" class="form-control" id="meta_keywords" rows="2" placeholder="Keywords, comma separated">{{ @$editData->meta_keywords }}</textarea>
                                </div>

                                <div class="form-group col-md-4">
                                    <label>Origin Country <span class="text-danger">*</span></label>
                                    <select name="country_id" class="form-control select2" required>
                                        <option value="">Select Country</option>
                                        @foreach ($countries as $country)
                                            <option value="{{ $country->id }}"
                                                {{ @$editData->country_id == $country->id ? 'Selected' : '' }}>
                                                {{ $country->country }}</option>
                                        @endforeach
                                    </select>
                                    <span style="color: red;">{{ $errors->has('country_id') ? $errors->first('country_id') : '' }}</span>
                                </div>

                                <div class="form-group col-md-4">
                                    <label>Visibility Status</label>
                                    <select name="status" class="form-control select2">
                                        <option value="1" {{ @$editData->status == 1 ? 'selected' : '' }}>Active</option>
                                        <option value="2" {{ @$editData->status == 2 ? 'selected' : '' }}>Pending Approval</option>
                                        <option value="0" {{ @$editData->status == 0 ? 'selected' : '' }}>Inactive / Hidden</option>
                                    </select>
                                    <span style="color: red;">{{ $errors->first('status') }}</span>
                                </div>

                                <div class="form-group col-md-12 text-right mt-4" style="border-top:1px solid #e2e8f0;padding-top:20px;margin-bottom:0;">
                                    <button type="submit" class="btn btn-primary px-4" style="background:#6366f1;border:none;font-weight:600;padding:10px 24px;border-radius:8px;">
                                        <i class="fas fa-save mr-1"></i> {{ @$editData ? 'Update Product' : 'Save Product' }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('scripts')
    <script type="text/javascript">
        $(function() {
            $('.select2').select2({
                theme: 'bootstrap4'
            });

            $('#image').change(function(e) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#showImage').attr('src', e.target.result);
                }
                reader.readAsDataURL(e.target.files['0']);
            });

            $('#myForm').validate({
                rules: {
                    name: { required: true },
                    name_bn: { required: true },
                    category_id: { required: true },
                    subcategory_id: { required: true },
                    brand_id: { required: true },
                    country_id: { required: true },
                    trade_price: { required: true },
                    price: { required: true }
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
@endpush
