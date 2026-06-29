@extends('backend.layouts.master')
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        {{-- Page Header --}}
        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:22px;flex-wrap:wrap;gap:12px;">
            <div>
                <h1 style="font-size:22px;font-weight:800;color:#0f172a;margin:0;">
                    <i class="fas fa-edit" style="color:#6366f1;margin-right:8px;"></i>
                    Update Product
                </h1>
                <p style="color:#64748b;font-size:13px;margin:2px 0 0;">
                    <a href="{{ route('home') }}" style="color:#6366f1;text-decoration:none;">Home</a>
                    <span style="margin:0 6px;color:#cbd5e1;">/</span>
                    <a href="{{ route('products.view') }}" style="color:#6366f1;text-decoration:none;">Products</a>
                    <span style="margin:0 6px;color:#cbd5e1;">/</span>
                    Update Product
                </p>
            </div>
            <a class="btn btn-sm btn-primary" href="{{ route('products.view') }}" style="display:inline-flex;align-items:center;gap:6px;padding:9px 18px;background:#6366f1;border:none;border-radius:8px;font-size:13px;font-weight:600;color:#fff;text-decoration:none;">
                <i class="fas fa-list"></i> Products List
            </a>
        </div>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <section class="col-md-12">
                        <div style="background:transparent;border:none;">
                            <div style="padding:0;">
                                <form method="post" action="{{ route('products.update', $editData->id) }}" id="myForm" enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">
                                        <!-- Main Column (Left) -->
                                        <div class="col-lg-8 col-md-12">
                                            <div class="row">
                                                <!-- Left Sub-column (PC View) -->
                                                <div class="col-lg-6 col-md-12">
                                                    <!-- Card 1: Product Details -->
                                                    <div class="card mb-4" style="border: 1px solid #e2e8f0; border-radius: 12px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05);">
                                                        <div class="card-header" style="background:#f8fafc; border-bottom: 1px solid #e2e8f0; border-radius: 12px 12px 0 0;">
                                                            <h3 class="card-title" style="font-size:15px; font-weight:700; color:#0f172a; margin:0;">
                                                                <i class="fas fa-info-circle" style="color:#6366f1; margin-right:6px;"></i> Product Details
                                                            </h3>
                                                        </div>
                                                        <div class="card-body" style="padding: 20px;">
                                                            <div class="form-group">
                                                                <label for="name" style="font-weight:600; color:#334155; font-size:13px;">Product Name (English) <span class="text-danger">*</span></label>
                                                                <input type="text" name="name" value="{{ $editData->name }}" class="form-control" id="name" placeholder="Enter product name" required>
                                                                <span style="color: red;">{{ $errors->first('name') }}</span>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="name_bn" style="font-weight:600; color:#334155; font-size:13px;">Product Name (Bangla) <span class="text-danger">*</span></label>
                                                                <input type="text" name="name_bn" value="{{ $editData->name_bn }}" class="form-control" id="name_bn" placeholder="Enter product name in Bangla" required>
                                                                <span style="color: red;">{{ $errors->first('name_bn') }}</span>
                                                            </div>
                                                            <div class="form-row">
                                                                <div class="form-group col-6">
                                                                    <label for="sku" style="font-weight:600; color:#334155; font-size:13px;">Code (SKU)</label>
                                                                    <input type="text" name="sku" value="{{ $editData->sku }}" class="form-control" id="sku" placeholder="SKU">
                                                                    <span style="color: red;">{{ $errors->first('sku') }}</span>
                                                                </div>
                                                                <div class="form-group col-6">
                                                                    <label for="quantity" style="font-weight:600; color:#334155; font-size:13px;">Stock Quantity <span class="text-danger">*</span></label>
                                                                    <input type="number" name="quantity" class="form-control" id="quantity" placeholder="Qty" value="{{ $editData->quantity }}" required min="0">
                                                                    <span style="color: red;">{{ $errors->first('quantity') }}</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Card 2: Media & SEO -->
                                                    <div class="card mb-4" style="border: 1px solid #e2e8f0; border-radius: 12px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05);">
                                                        <div class="card-header" style="background:#f8fafc; border-bottom: 1px solid #e2e8f0; border-radius: 12px 12px 0 0;">
                                                            <h3 class="card-title" style="font-size:15px; font-weight:700; color:#0f172a; margin:0;">
                                                                <i class="fas fa-images" style="color:#6366f1; margin-right:6px;"></i> Media & SEO
                                                            </h3>
                                                        </div>
                                                        <div class="card-body" style="padding: 20px;">
                                                            <div class="form-group">
                                                                <label style="font-weight:600; color:#334155; font-size:13px;">Primary Image</label>
                                                                <input type="file" name="image" id="image" class="form-control">
                                                                <span style="color: red;">{{ $errors->first('image') }}</span>
                                                            </div>
                                                            <div class="form-row">
                                                                <div class="form-group col-3 d-flex align-items-center justify-content-center">
                                                                    <img id="showImage" style="width:50px; height:50px; border-radius:8px; border:1px solid #e2e8f0; object-fit:cover;" src="{{ !empty($editData->image) ? url('upload/product_images/' . $editData->image) : url('frontend/no-image-icon.jpg') }}">
                                                                </div>
                                                                <div class="form-group col-9">
                                                                    <label style="font-weight:600; color:#334155; font-size:13px;">Sub Images (Multiple)</label>
                                                                    <input type="file" name="sub_image[]" class="form-control" multiple>
                                                                    <span style="color: red;">{{ $errors->first('sub_image') }}</span>
                                                                </div>
                                                            </div>
                                                            <hr style="border-top: 1px solid #e2e8f0; margin: 15px 0;">
                                                            <div class="form-group">
                                                                <label for="meta_title" style="font-weight:600; color:#334155; font-size:13px;">Meta Title</label>
                                                                <input type="text" name="meta_title" value="{{ @$editData->meta_title }}" class="form-control" id="meta_title" placeholder="SEO Title">
                                                            </div>
                                                            <div class="form-row">
                                                                <div class="form-group col-6">
                                                                    <label for="meta_description" style="font-weight:600; color:#334155; font-size:13px;">Meta Description</label>
                                                                    <textarea name="meta_description" class="form-control" id="meta_description" placeholder="SEO Description" rows="2">{{ @$editData->meta_description }}</textarea>
                                                                </div>
                                                                <div class="form-group col-6">
                                                                    <label for="meta_keywords" style="font-weight:600; color:#334155; font-size:13px;">Meta Keywords</label>
                                                                    <textarea name="meta_keywords" class="form-control" id="meta_keywords" placeholder="Keywords" rows="2">{{ @$editData->meta_keywords }}</textarea>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Right Sub-column (PC View) -->
                                                <div class="col-lg-6 col-md-12">
                                                    <!-- Card 3: Color & Size Combinations -->
                                                    <div class="card mb-4" style="border: 1px solid #e2e8f0; border-radius: 12px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05); height: calc(100% - 24px);">
                                                        <div class="card-header" style="background:#f8fafc; border-bottom: 1px solid #e2e8f0; border-radius: 12px 12px 0 0;">
                                                            <h3 class="card-title" style="font-size:15px; font-weight:700; color:#0f172a; margin:0;">
                                                                <i class="fas fa-th" style="color:#6366f1; margin-right:6px;"></i> Attributes & Combinations
                                                            </h3>
                                                        </div>
                                                        <div class="card-body" style="padding: 20px;">
                                                            <div class="form-group">
                                                                <label for="available_colors" style="font-weight:600; color:#334155; font-size:13px;">Available Colors <span class="text-danger">*</span></label>
                                                                <select id="available_colors" name="color_id[]" class="form-control select2" multiple required style="width:100%;">
                                                                    @foreach ($colors as $color)
                                                                        <option value="{{ $color->id }}" data-name="{{ $color->name }}" {{ in_array(['color_id' => $color->id], $color_array) ? 'selected' : '' }}>{{ $color->name }}</option>
                                                                    @endforeach
                                                                </select>
                                                                <span style="color: red;">{{ $errors->first('color_id') }}</span>
                                                            </div>

                                                            <div class="form-group">
                                                                <label for="available_sizes" style="font-weight:600; color:#334155; font-size:13px;">Available Sizes <span class="text-danger">*</span></label>
                                                                <select id="available_sizes" name="size_id[]" class="form-control select2" multiple required style="width:100%;">
                                                                    @foreach ($sizes as $size)
                                                                        <option value="{{ $size->id }}" data-name="{{ $size->name }}" {{ in_array(['size_id' => $size->id], $size_array) ? 'selected' : '' }}>{{ $size->name }}</option>
                                                                    @endforeach
                                                                </select>
                                                                <span style="color: red;">{{ $errors->first('size_id') }}</span>
                                                            </div>

                                                            <!-- Generate Combinations Button -->
                                                            <div class="card shadow-sm border-0 mb-3" style="background:#f8fafc;border:1px solid #e2e8f0 !important;border-radius:10px;">
                                                                <div class="card-body p-3">
                                                                    <h6 style="font-weight:700;color:#0f172a;margin-bottom:4px;font-size:12px;"><i class="fas fa-cogs mr-1" style="color:#6366f1;"></i> Combinations Generator</h6>
                                                                    <p class="text-muted" style="font-size:11px;margin-bottom:10px;">Update colors & sizes and click generate below.</p>
                                                                    <button type="button" class="btn btn-info btn-sm" id="generateCombinations" style="background:#6366f1;border:none;font-size:11px;">
                                                                        <i class="fas fa-magic"></i> Generate/Update Combinations
                                                                    </button>
                                                                </div>
                                                            </div>

                                                            <!-- Generated Combinations -->
                                                            <div class="card border-0" style="border:1px solid #e2e8f0 !important;border-radius:10px;">
                                                                <div class="card-header" style="background:#f8fafc;border-bottom:1px solid #e2e8f0;padding:10px 15px;">
                                                                    <span class="card-title" style="font-size:12px;font-weight:700;"><i class="fas fa-list-alt mr-1" style="color:#6366f1;"></i> Product Combinations</span>
                                                                </div>
                                                                <div class="card-body" style="padding:5px;">
                                                                    <div id="color-size-combinations" style="max-height:280px;overflow-y:auto;background:#fff;border-radius:8px;padding:5px;">
                                                                        <div class="text-center text-muted py-3">
                                                                            <i class="fas fa-info-circle fa-2x mb-2" style="color:#94a3b8;"></i>
                                                                            <p style="margin-bottom:4px;font-weight:600;font-size:12px;">Loading existing combinations...</p>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-12">
                                                    <!-- Card 4: Descriptions -->
                                                    <div class="card mb-4" style="border: 1px solid #e2e8f0; border-radius: 12px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05);">
                                                        <div class="card-header" style="background:#f8fafc; border-bottom: 1px solid #e2e8f0; border-radius: 12px 12px 0 0;">
                                                            <h3 class="card-title" style="font-size:15px; font-weight:700; color:#0f172a; margin:0;">
                                                                <i class="fas fa-align-left" style="color:#6366f1; margin-right:6px;"></i> Descriptions
                                                            </h3>
                                                        </div>
                                                        <div class="card-body" style="padding: 20px;">
                                                            <div class="form-group">
                                                                <label style="font-weight:600; color:#334155; font-size:13px;">Short Description (English) <span class="text-danger">*</span></label>
                                                                <textarea name="short_desc" class="form-control summernote" required>{{ $editData->short_desc }}</textarea>
                                                                <span style="color: red;">{{ $errors->first('short_desc') }}</span>
                                                            </div>
                                                            <div class="form-group">
                                                                <label style="font-weight:600; color:#334155; font-size:13px;">Short Description (Bangla) <span class="text-danger">*</span></label>
                                                                <textarea name="short_desc_bn" class="form-control summernote" required>{{ $editData->short_desc_bn }}</textarea>
                                                                <span style="color: red;">{{ $errors->first('short_desc_bn') }}</span>
                                                            </div>
                                                            <div class="form-group">
                                                                <label style="font-weight:600; color:#334155; font-size:13px;">Long Description <span class="text-danger">*</span></label>
                                                                <textarea name="long_desc" class="form-control summernote" rows="3" required>{{ $editData->long_desc }}</textarea>
                                                                <span style="color: red;">{{ $errors->first('long_desc') }}</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Sidebar Column (Right) -->
                                        <div class="col-lg-4 col-md-12">
                                            <!-- Card 1: Action -->
                                            <div class="card mb-4" style="border: 1px solid #e2e8f0; border-radius: 12px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05); background: #f8fafc;">
                                                <div class="card-body p-3">
                                                    <button type="submit" class="btn btn-primary btn-block" style="background:#6366f1; border:none; padding:10px; border-radius:8px; font-weight:700; font-size:15px; display:flex; align-items:center; justify-content:center; gap:8px;">
                                                        <i class="fas fa-save"></i> Update Product
                                                    </button>
                                                </div>
                                            </div>

                                            <!-- Card 2: Classification -->
                                            <div class="card mb-4" style="border: 1px solid #e2e8f0; border-radius: 12px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05);">
                                                <div class="card-header" style="background:#f8fafc; border-bottom: 1px solid #e2e8f0; border-radius: 12px 12px 0 0;">
                                                    <h3 class="card-title" style="font-size:15px; font-weight:700; color:#0f172a; margin:0;">
                                                        <i class="fas fa-folder" style="color:#6366f1; margin-right:6px;"></i> Classification
                                                    </h3>
                                                </div>
                                                <div class="card-body" style="padding: 15px 20px;">
                                                    <div class="form-group">
                                                        <label for="category_id" style="font-weight:600; color:#334155;">Category <span class="text-danger">*</span></label>
                                                        <select name="category_id" id="category_id" class="form-control select2" required>
                                                            <option value="">Select Category</option>
                                                            @foreach ($categories as $category)
                                                                <option value="{{ $category->id }}" {{ $editData->category_id == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                                            @endforeach
                                                        </select>
                                                        <span style="color: red;">{{ $errors->first('category_id') }}</span>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="subcategory_id" style="font-weight:600; color:#334155;">Subcategory <span class="text-danger">*</span></label>
                                                        <select name="subcategory_id" id="subcategory_id" class="form-control select2" required>
                                                            <option value="">Select Subcategory</option>
                                                            @foreach ($subcategories as $subcategory)
                                                                <option value="{{ $subcategory->id }}" {{ $editData->subcategory_id == $subcategory->id ? 'selected' : '' }}>{{ $subcategory->name }}</option>
                                                            @endforeach
                                                        </select>
                                                        <span style="color: red;">{{ $errors->first('subcategory_id') }}</span>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="brand_id" style="font-weight:600; color:#334155;">Brand <span class="text-danger">*</span></label>
                                                        <select name="brand_id" id="brand_id" class="form-control select2" required>
                                                            <option value="">Select Brand</option>
                                                            @foreach ($brands as $brand)
                                                                <option value="{{ $brand->id }}" {{ $editData->brand_id == $brand->id ? 'selected' : '' }}>{{ $brand->name }}</option>
                                                            @endforeach
                                                        </select>
                                                        <span style="color: red;">{{ $errors->first('brand_id') }}</span>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="country_id" style="font-weight:600; color:#334155;">Origin <span class="text-danger">*</span></label>
                                                        <select name="country_id" id="country_id" class="form-control select2" required>
                                                            <option value="">Select Country</option>
                                                            @foreach ($countries as $country)
                                                                <option value="{{ $country->id }}" {{ $editData->country_id == $country->id ? 'selected' : '' }}>{{ $country->country }}</option>
                                                            @endforeach
                                                        </select>
                                                        <span style="color: red;">{{ $errors->first('country_id') }}</span>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="status" style="font-weight:600; color:#334155;">Publication Status <span class="text-danger">*</span></label>
                                                        <select name="status" id="status" class="form-control select2">
                                                            <option value="1" {{ $editData->status == 1 ? 'selected' : '' }}>Active</option>
                                                            <option value="2" {{ $editData->status == 2 ? 'selected' : '' }}>Pending</option>
                                                            <option value="0" {{ $editData->status == 0 ? 'selected' : '' }}>Inactive</option>
                                                        </select>
                                                        <span style="color: red;">{{ $errors->first('status') }}</span>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Card 3: Pricing -->
                                            <div class="card mb-4" style="border: 1px solid #e2e8f0; border-radius: 12px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05);">
                                                <div class="card-header" style="background:#f8fafc; border-bottom: 1px solid #e2e8f0; border-radius: 12px 12px 0 0;">
                                                    <h3 class="card-title" style="font-size:15px; font-weight:700; color:#0f172a; margin:0;">
                                                        <i class="fas fa-money-bill-wave" style="color:#6366f1; margin-right:6px;"></i> Pricing
                                                    </h3>
                                                </div>
                                                <div class="card-body" style="padding: 15px 20px;">
                                                    <div class="form-row">
                                                        <div class="form-group col-6">
                                                            <label style="font-weight:600; color:#334155; font-size:12px;">Trade Price <span class="text-danger">*</span></label>
                                                            <input type="number" name="trade_price" value="{{ $editData->trade_price }}" class="form-control" step="0.01" min="0" required>
                                                            <span style="color: red;">{{ $errors->first('trade_price') }}</span>
                                                        </div>
                                                        <div class="form-group col-6">
                                                            <label style="font-weight:600; color:#334155; font-size:12px;">Sales Price (MRP) <span class="text-danger">*</span></label>
                                                            <input type="number" name="price" value="{{ $editData->price }}" class="form-control" step="0.01" min="0" required>
                                                            <span style="color: red;">{{ $errors->first('price') }}</span>
                                                        </div>
                                                    </div>
                                                    <div class="form-row">
                                                        <div class="form-group col-6">
                                                            <label style="font-weight:600; color:#334155; font-size:12px;">Discount Type</label>
                                                            <select name="discount_type" class="form-control select2">
                                                                <option value="">Select Type</option>
                                                                <option value="1" {{ $editData->discount_type == 1 ? 'selected' : '' }}>Percentage</option>
                                                                <option value="2" {{ $editData->discount_type == 2 ? 'selected' : '' }}>Fixed Amount</option>
                                                            </select>
                                                            <span style="color: red;">{{ $errors->first('discount_type') }}</span>
                                                        </div>
                                                        <div class="form-group col-6">
                                                            <label style="font-weight:600; color:#334155; font-size:12px;">Discount Value</label>
                                                            <input type="number" name="discount" value="{{ $editData->discount }}" class="form-control" step="0.01" min="0">
                                                            <span style="color: red;">{{ $errors->first('discount') }}</span>
                                                        </div>
                                                    </div>
                                                    <hr style="margin: 10px 0; border-top: 1px solid #e2e8f0;">
                                                    <div class="form-group">
                                                        <label style="font-weight:700; color:#0f172a; font-size:13px; margin-bottom:4px;">Wholesale Price (Dropshipper's Cost) <span class="text-danger">*</span></label>
                                                        <div class="input-group input-group-sm">
                                                            <div class="input-group-prepend"><span class="input-group-text" style="background:#f8fafc; border-color:#cbd5e1;">৳</span></div>
                                                            <input type="number" name="sale_price" value="{{ $editData->sale_price }}" class="form-control" step="0.01" min="0" placeholder="e.g. 1000" id="wholesalePrice" onchange="updatePriceHints()" required>
                                                        </div>
                                                        <small class="text-muted" style="font-size:11px;">Dropshipper will buy at this price</small>
                                                        <span style="color: red;">{{ $errors->first('sale_price') }}</span>
                                                    </div>
                                                    <div class="form-group">
                                                        <label style="font-weight:700; color:#0f172a; font-size:13px; margin-bottom:4px;">Min Selling Price <span class="text-danger">*</span></label>
                                                        <div class="input-group input-group-sm">
                                                            <div class="input-group-prepend"><span class="input-group-text" style="background:#f8fafc; border-color:#cbd5e1;">৳</span></div>
                                                            <input type="number" name="min_price" value="{{ $editData->min_price }}" class="form-control" step="0.01" min="0" placeholder="e.g. 1100" id="minPrice" onchange="updatePriceHints()" required>
                                                        </div>
                                                        <small class="text-muted" style="font-size:11px;">Dropshipper minimum resale price</small>
                                                        <span style="color: red;">{{ $errors->first('min_price') }}</span>
                                                    </div>
                                                    <div class="form-group">
                                                        <label style="font-weight:700; color:#0f172a; font-size:13px; margin-bottom:4px;">Max Selling Price</label>
                                                        <div class="input-group input-group-sm">
                                                            <div class="input-group-prepend"><span class="input-group-text" style="background:#f8fafc; border-color:#cbd5e1;">৳</span></div>
                                                            <input type="number" name="max_price" value="{{ $editData->max_price }}" class="form-control" step="0.01" min="0" placeholder="e.g. 1500" id="maxPrice" onchange="updatePriceHints()">
                                                        </div>
                                                        <small class="text-muted" style="font-size:11px;">Dropshipper maximum resale price</small>
                                                        <div id="priceHintBox" style="display:none;background:#f0fdf4;border:1px solid #bbf7d0;border-radius:8px;padding:8px;margin-top:8px;font-size:11px;color:#166534;">
                                                            <strong>Profit Preview:</strong> Min Profit: <span id="minProfit" style="font-weight:700;">-</span> | Max Profit: <span id="maxProfit" style="font-weight:700;">-</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Card 4: Promotion Badges -->
                                            <div class="card mb-4" style="border: 1px solid #e2e8f0; border-radius: 12px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05);">
                                                <div class="card-header" style="background:#f8fafc; border-bottom: 1px solid #e2e8f0; border-radius: 12px 12px 0 0;">
                                                    <h3 class="card-title" style="font-size:15px; font-weight:700; color:#0f172a; margin:0;">
                                                        <i class="fas fa-tags" style="color:#6366f1; margin-right:6px;"></i> Promotion Badges
                                                    </h3>
                                                </div>
                                                <div class="card-body" style="padding: 15px 20px;">
                                                    <div class="form-row">
                                                        <div class="form-group col-6">
                                                            <label style="display:block;margin-bottom:6px;font-size:12px;font-weight:600;color:#334155;">Is Hot Deals</label>
                                                            <div class="custom-control custom-radio custom-control-inline">
                                                                <input class="custom-control-input" type="radio" name="hot_deals" id="hot_deals_yes" value="1" {{ $editData->hot_deals == 1 ? 'checked' : '' }}>
                                                                <label class="custom-control-label" for="hot_deals_yes">Yes</label>
                                                            </div>
                                                            <div class="custom-control custom-radio custom-control-inline">
                                                                <input class="custom-control-input" type="radio" name="hot_deals" id="hot_deals_no" value="0" {{ $editData->hot_deals == 0 ? 'checked' : '' }}>
                                                                <label class="custom-control-label" for="hot_deals_no">No</label>
                                                            </div>
                                                        </div>
                                                        <div class="form-group col-6">
                                                            <label style="display:block;margin-bottom:6px;font-size:12px;font-weight:600;color:#334155;">Is Featured</label>
                                                            <div class="custom-control custom-radio custom-control-inline">
                                                                <input class="custom-control-input" type="radio" name="featured" id="featured_yes" value="1" {{ $editData->featured == 1 ? 'checked' : '' }}>
                                                                <label class="custom-control-label" for="featured_yes">Yes</label>
                                                            </div>
                                                            <div class="custom-control custom-radio custom-control-inline">
                                                                <input class="custom-control-input" type="radio" name="featured" id="featured_no" value="0" {{ $editData->featured == 0 ? 'checked' : '' }}>
                                                                <label class="custom-control-label" for="featured_no">No</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-row" style="margin-top:10px;">
                                                        <div class="form-group col-6">
                                                            <label style="display:block;margin-bottom:6px;font-size:12px;font-weight:600;color:#334155;">Is Special Offer</label>
                                                            <div class="custom-control custom-radio custom-control-inline">
                                                                <input class="custom-control-input" type="radio" name="special_offer" id="special_offer_yes" value="1" {{ $editData->special_offer == 1 ? 'checked' : '' }}>
                                                                <label class="custom-control-label" for="special_offer_yes">Yes</label>
                                                            </div>
                                                            <div class="custom-control custom-radio custom-control-inline">
                                                                <input class="custom-control-input" type="radio" name="special_offer" id="special_offer_no" value="0" {{ $editData->special_offer == 0 ? 'checked' : '' }}>
                                                                <label class="custom-control-label" for="special_offer_no">No</label>
                                                            </div>
                                                        </div>
                                                        <div class="form-group col-6">
                                                            <label style="display:block;margin-bottom:6px;font-size:12px;font-weight:600;color:#334155;">Is Special Deals</label>
                                                            <div class="custom-control custom-radio custom-control-inline">
                                                                <input class="custom-control-input" type="radio" name="special_deals" id="special_deals_yes" value="1" {{ $editData->special_deals == 1 ? 'checked' : '' }}>
                                                                <label class="custom-control-label" for="special_deals_yes">Yes</label>
                                                            </div>
                                                            <div class="custom-control custom-radio custom-control-inline">
                                                                <input class="custom-control-input" type="radio" name="special_deals" id="special_deals_no" value="0" {{ $editData->special_deals == 0 ? 'checked' : '' }}>
                                                                <label class="custom-control-label" for="special_deals_no">No</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
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

    <!-- Combination Styles & Scripts -->
    <style>
        .color-size-pricing {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            padding: 14px;
            margin-bottom: 12px;
            transition: all 0.2s ease;
        }
        .color-size-pricing:hover {
            border-color: #cbd5e1;
            box-shadow: 0 4px 12px rgba(0,0,0,0.03);
        }
        .bulk-actions {
            background: #f8fafc;
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 16px;
            border: 1px solid #e2e8f0;
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }
        .bulk-actions button {
            border-radius: 6px;
            font-size: 12px;
            font-weight: 600;
        }
    </style>

    <script type="text/javascript">
        function updatePriceHints() {
            var cost = parseFloat($('#wholesalePrice').val()) || 0;
            var minPrice = parseFloat($('#minPrice').val()) || 0;
            var maxPrice = parseFloat($('#maxPrice').val()) || 0;

            if (cost > 0) {
                $('#priceHintBox').show();
                if (minPrice > 0) {
                    var minProfit = minPrice - cost;
                    $('#minProfit').text('৳' + minProfit.toFixed(2));
                } else {
                    $('#minProfit').text('-');
                }

                if (maxPrice > 0) {
                    var maxProfit = maxPrice - cost;
                    $('#maxProfit').text('৳' + maxProfit.toFixed(2));
                } else {
                    $('#maxProfit').text('-');
                }
            } else {
                $('#priceHintBox').hide();
            }
        }

        const existingVariants = @json($editData->variants ?? []);

        $(document).ready(function() {
            $('.select2').select2({
                theme: 'bootstrap4'
            });

            updatePriceHints();

            // Load existing combinations on page load
            loadExistingCombinations();

            // Image live preview
            $('#image').change(function(e) {
                var reader = new FileReader();
                reader.onload = function(event) {
                    $('#showImage').attr('src', event.target.result);
                };
                reader.readAsDataURL(e.target.files[0]);
            });

            // Generate combinations
            $('#generateCombinations').click(function() {
                generateColorSizeCombinations();
            });
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

            if (!selectedColorIds || !selectedSizeIds || selectedColorIds.length === 0 || selectedSizeIds.length === 0) {
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
                toastr.success(`Generated ${combinationIndex} combinations!`);
            }
        }

        function generateBulkActionsHtml() {
            return `
                <div class="bulk-actions">
                    <button type="button" class="btn btn-sm btn-outline-primary" onclick="setAllAdditionalPrices()">
                        <i class="fas fa-dollar-sign"></i> Set All Extra Prices
                    </button>
                    <button type="button" class="btn btn-sm btn-outline-success" onclick="setAllStockQuantities()">
                        <i class="fas fa-boxes"></i> Set All Stocks
                    </button>
                    <button type="button" class="btn btn-sm btn-outline-danger" onclick="clearAllCombinations()">
                        <i class="fas fa-trash"></i> Clear All
                    </button>
                </div>
            `;
        }

        function generateCombinationHtml(index, colorId, colorName, sizeId, sizeName, additionalPrice, stockQty, sku, variantId) {
            return `
                <div class="color-size-pricing" data-combination="${index}">
                    <div class="row align-items-end">
                        <div class="col-md-2">
                            <label class="form-label" style="font-size:12px;font-weight:600;color:#64748b;margin-bottom:4px;">Color</label>
                            <input type="text" value="${colorName}" readonly class="form-control" style="background:#e2e8f0;font-weight:600;border-color:#cbd5e1;">
                            <input type="hidden" name="combinations[${index}][color_id]" value="${colorId}">
                            <input type="hidden" name="combinations[${index}][color_name]" value="${colorName}">
                            ${variantId ? `<input type="hidden" name="combinations[${index}][id]" value="${variantId}">` : ''}
                        </div>
                        <div class="col-md-2">
                            <label class="form-label" style="font-size:12px;font-weight:600;color:#64748b;margin-bottom:4px;">Size</label>
                            <input type="text" value="${sizeName}" readonly class="form-control" style="background:#e2e8f0;font-weight:600;border-color:#cbd5e1;">
                            <input type="hidden" name="combinations[${index}][size_id]" value="${sizeId}">
                            <input type="hidden" name="combinations[${index}][size_name]" value="${sizeName}">
                        </div>
                        <div class="col-md-2">
                            <label class="form-label" style="font-size:12px;font-weight:600;color:#64748b;margin-bottom:4px;">Extra Price (৳)</label>
                            <input type="number" name="combinations[${index}][additional_price]" class="form-control" step="0.01" value="${additionalPrice}" min="0">
                        </div>
                        <div class="col-md-2">
                            <label class="form-label" style="font-size:12px;font-weight:600;color:#64748b;margin-bottom:4px;">Stock Qty <span class="text-danger">*</span></label>
                            <input type="number" name="combinations[${index}][stock_quantity]" class="form-control" value="${stockQty}" min="0" required>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label" style="font-size:12px;font-weight:600;color:#64748b;margin-bottom:4px;">SKU (Optional)</label>
                            <input type="text" name="combinations[${index}][sku]" class="form-control" value="${sku}" placeholder="Variant SKU">
                        </div>
                        <div class="col-md-1" style="text-align:right;">
                            <button type="button" class="btn btn-danger btn-sm" onclick="removeCombination(${index})" style="border-radius:6px;padding:8px 12px;">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </div>
                </div>
            `;
        }

        function showEmptyMessage() {
            $('#color-size-combinations').html(`
                <div class="text-center text-muted py-4">
                    <i class="fas fa-info-circle fa-2x mb-2" style="color:#94a3b8;"></i>
                    <p style="margin-bottom:4px;font-weight:600;">No combinations generated yet.</p>
                    <p style="font-size:12px;margin:0;">Select colors and sizes above, then click "Generate Combinations".</p>
                </div>
            `);
        }

        function removeCombination(index) {
            $(`[data-combination="${index}"]`).fadeOut(300, function() {
                $(this).remove();
                if ($('[data-combination]').length === 0) {
                    showEmptyMessage();
                }
            });
        }

        function setAllAdditionalPrices() {
            const price = prompt('Enter extra price for all combinations (৳):');
            if (price !== null && !isNaN(price) && price >= 0) {
                $('input[name*="additional_price"]').val(parseFloat(price).toFixed(2));
                toastr.success('Set all extra prices!');
            }
        }

        function setAllStockQuantities() {
            const stock = prompt('Enter stock quantity for all combinations:');
            if (stock !== null && !isNaN(stock) && stock >= 0) {
                $('input[name*="stock_quantity"]').val(parseInt(stock));
                toastr.success('Set all stock quantities!');
            }
        }

        function clearAllCombinations() {
            if (confirm('Clear all generated combinations?')) {
                showEmptyMessage();
                toastr.info('All combinations cleared!');
            }
        }
    </script>
@endsection
