@extends('backend.layouts.master')
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        {{-- Page Header --}}
        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:22px;flex-wrap:wrap;gap:12px;">
            <div>
                <h1 style="font-size:22px;font-weight:800;color:#0f172a;margin:0;">
                    <i class="fas fa-images" style="color:#6366f1;margin-right:8px;"></i>
                    @if (isset($editData)) Edit Banner @else Add Banner @endif
                </h1>
                <p style="color:#64748b;font-size:13px;margin:2px 0 0;">
                    <a href="{{ route('home') }}" style="color:#6366f1;text-decoration:none;">Home</a>
                    <span style="margin:0 6px;color:#cbd5e1;">/</span>
                    <a href="{{ route('banners.view') }}" style="color:#6366f1;text-decoration:none;">Banner</a>
                    <span style="margin:0 6px;color:#cbd5e1;">/</span>
                    @if (isset($editData)) Edit @else Add @endif
                </p>
            </div>
            <a class="btn btn-sm btn-primary" href="{{ route('banners.view') }}" style="display:inline-flex;align-items:center;gap:6px;padding:9px 18px;background:#6366f1;border:none;border-radius:8px;font-size:13px;font-weight:600;color:#fff;text-decoration:none;">
                <i class="fas fa-list"></i> Banner List
            </a>
        </div>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="card">
                    <div class="card-header">
                        <span class="card-title">
                            <i class="fas fa-cog" style="color:#6366f1;margin-right:6px;"></i>
                            Banner Campaign Asset Parameters
                        </span>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <form method="post"
                            action="{{ @$editData ? route('banners.update', $editData->id) : route('banners.store') }}"
                            id="myForm" enctype="multipart/form-data">
                            @csrf
                            
                            <div class="row">
                                {{-- Small Banner 1 --}}
                                <div class="col-md-6 mb-4">
                                    <div style="background:#f8fafc;border:1px solid #e2e8f0;border-radius:12px;padding:20px;height:100%;">
                                        <label style="font-weight:700;color:#0f172a;font-size:14px;display:flex;align-items:center;gap:6px;">
                                            <span style="background:#6366f1;color:#fff;width:24px;height:24px;border-radius:50%;display:inline-flex;align-items:center;justify-content:center;font-size:12px;">1</span>
                                            Homepage Small Banner One
                                        </label>
                                        <p style="font-size:12px;color:#64748b;margin:4px 0 15px 30px;">Dimensions limit: <span class="text-danger font-weight-bold">475px x 375px</span></p>
                                        
                                        <div style="display:flex;gap:15px;align-items:flex-start;margin-left:30px;">
                                            <div style="flex:1;">
                                                <div class="custom-file">
                                                    <input type="file" name="banner_small_image_one" id="banner_small_image_one" class="custom-file-input" accept="image/*" onchange="previewBanner(this, 'showImage_banner_small_image_one')">
                                                    <label class="custom-file-label" for="banner_small_image_one">Choose file</label>
                                                </div>
                                            </div>
                                            <div style="background:#fff;border:1px dashed #cbd5e1;border-radius:8px;padding:4px;width:90px;height:70px;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                                                <img id="showImage_banner_small_image_one" style="max-height:60px;max-width:80px;object-fit:contain;"
                                                    src="{{ !empty($editData->banner_small_image_one) ? url('upload/banner/' . $editData->banner_small_image_one) : url('frontend/no-image-icon.jpg') }}"
                                                    onerror="this.src='{{ url('frontend/no-image-icon.jpg') }}'">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- Small Banner 2 --}}
                                <div class="col-md-6 mb-4">
                                    <div style="background:#f8fafc;border:1px solid #e2e8f0;border-radius:12px;padding:20px;height:100%;">
                                        <label style="font-weight:700;color:#0f172a;font-size:14px;display:flex;align-items:center;gap:6px;">
                                            <span style="background:#6366f1;color:#fff;width:24px;height:24px;border-radius:50%;display:inline-flex;align-items:center;justify-content:center;font-size:12px;">2</span>
                                            Homepage Small Banner Two
                                        </label>
                                        <p style="font-size:12px;color:#64748b;margin:4px 0 15px 30px;">Dimensions limit: <span class="text-danger font-weight-bold">475px x 375px</span></p>
                                        
                                        <div style="display:flex;gap:15px;align-items:flex-start;margin-left:30px;">
                                            <div style="flex:1;">
                                                <div class="custom-file">
                                                    <input type="file" name="banner_small_image_two" id="banner_small_image_two" class="custom-file-input" accept="image/*" onchange="previewBanner(this, 'showImage_banner_small_image_two')">
                                                    <label class="custom-file-label" for="banner_small_image_two">Choose file</label>
                                                </div>
                                            </div>
                                            <div style="background:#fff;border:1px dashed #cbd5e1;border-radius:8px;padding:4px;width:90px;height:70px;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                                                <img id="showImage_banner_small_image_two" style="max-height:60px;max-width:80px;object-fit:contain;"
                                                    src="{{ !empty($editData->banner_small_image_two) ? url('upload/banner/' . $editData->banner_small_image_two) : url('frontend/no-image-icon.jpg') }}"
                                                    onerror="this.src='{{ url('frontend/no-image-icon.jpg') }}'">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- Category Banner --}}
                                <div class="col-md-6 mb-4">
                                    <div style="background:#f8fafc;border:1px solid #e2e8f0;border-radius:12px;padding:20px;height:100%;">
                                        <label style="font-weight:700;color:#0f172a;font-size:14px;display:flex;align-items:center;gap:6px;">
                                            <span style="background:#6366f1;color:#fff;width:24px;height:24px;border-radius:50%;display:inline-flex;align-items:center;justify-content:center;font-size:12px;">3</span>
                                            Category Wide Banner
                                        </label>
                                        <p style="font-size:12px;color:#64748b;margin:4px 0 15px 30px;">Dimensions limit: <span class="text-danger font-weight-bold">1500px x 130px</span></p>
                                        
                                        <div style="display:flex;gap:15px;align-items:flex-start;margin-left:30px;">
                                            <div style="flex:1;">
                                                <div class="custom-file">
                                                    <input type="file" name="category_banner_image" id="category_banner_image" class="custom-file-input" accept="image/*" onchange="previewBanner(this, 'showImage_category_banner_image')">
                                                    <label class="custom-file-label" for="category_banner_image">Choose file</label>
                                                </div>
                                            </div>
                                            <div style="background:#fff;border:1px dashed #cbd5e1;border-radius:8px;padding:4px;width:90px;height:70px;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                                                <img id="showImage_category_banner_image" style="max-height:60px;max-width:80px;object-fit:contain;"
                                                    src="{{ !empty($editData->category_banner_image) ? url('upload/banner/' . $editData->category_banner_image) : url('frontend/no-image-icon.jpg') }}"
                                                    onerror="this.src='{{ url('frontend/no-image-icon.jpg') }}'">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- Shop Page Banner --}}
                                <div class="col-md-6 mb-4">
                                    <div style="background:#f8fafc;border:1px solid #e2e8f0;border-radius:12px;padding:20px;height:100%;">
                                        <label style="font-weight:700;color:#0f172a;font-size:14px;display:flex;align-items:center;gap:6px;">
                                            <span style="background:#6366f1;color:#fff;width:24px;height:24px;border-radius:50%;display:inline-flex;align-items:center;justify-content:center;font-size:12px;">4</span>
                                            Shop Listing Banner
                                        </label>
                                        <p style="font-size:12px;color:#64748b;margin:4px 0 15px 30px;">Dimensions limit: <span class="text-danger font-weight-bold">1115px x 130px</span></p>
                                        
                                        <div style="display:flex;gap:15px;align-items:flex-start;margin-left:30px;">
                                            <div style="flex:1;">
                                                <div class="custom-file">
                                                    <input type="file" name="shop_page_banner" id="shop_page_banner" class="custom-file-input" accept="image/*" onchange="previewBanner(this, 'showImage_shop_page_banner')">
                                                    <label class="custom-file-label" for="shop_page_banner">Choose file</label>
                                                </div>
                                            </div>
                                            <div style="background:#fff;border:1px dashed #cbd5e1;border-radius:8px;padding:4px;width:90px;height:70px;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                                                <img id="showImage_shop_page_banner" style="max-height:60px;max-width:80px;object-fit:contain;"
                                                    src="{{ !empty($editData->shop_page_banner) ? url('upload/banner/' . $editData->shop_page_banner) : url('frontend/no-image-icon.jpg') }}"
                                                    onerror="this.src='{{ url('frontend/no-image-icon.jpg') }}'">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-12 text-right mt-3" style="border-top:1px solid #e2e8f0;padding-top:20px;margin-bottom:0;">
                                    <button type="submit" class="btn btn-primary px-5" style="background:#6366f1;border:none;padding:10px 30px;border-radius:8px;font-weight:600;">
                                        <i class="fas fa-save mr-1"></i> {{ @$editData ? 'Update Banners' : 'Save Banners' }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <script type="text/javascript">
        function previewBanner(input, targetId) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#' + targetId).attr('src', e.target.result);
                };
                reader.readAsDataURL(input.files[0]);
                $(input).siblings('.custom-file-label').addClass("selected").html(input.files[0].name);
            }
        }

        $(function () {
            $('#myForm').validate({
                rules: {
                    banner_small_image_one: { accept: "image/*" },
                    banner_small_image_two: { accept: "image/*" },
                    category_banner_image: { accept: "image/*" },
                    shop_page_banner: { accept: "image/*" }
                },
                errorElement: 'span',
                errorPlacement: function (error, element) {
                    error.addClass('invalid-feedback');
                    element.closest('.form-group').append(error);
                },
                highlight: function (element, errorClass, validClass) {
                    $(element).addClass('is-invalid');
                },
                unhighlight: function (element, errorClass, validClass) {
                    $(element).removeClass('is-invalid');
                }
            });
        });
    </script>
@endsection
