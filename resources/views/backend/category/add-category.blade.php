@extends('backend.layouts.master')
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        {{-- Page Header --}}
        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:22px;flex-wrap:wrap;gap:12px;">
            <div>
                <h1 style="font-size:22px;font-weight:800;color:#0f172a;margin:0;">
                    <i class="fas fa-tags" style="color:#6366f1;margin-right:8px;"></i>
                    @if (isset($editData)) Edit Category @else Add Category @endif
                </h1>
                <p style="color:#64748b;font-size:13px;margin:2px 0 0;">
                    <a href="{{ route('home') }}" style="color:#6366f1;text-decoration:none;">Home</a>
                    <span style="margin:0 6px;color:#cbd5e1;">/</span>
                    <a href="{{ route('categories.view') }}" style="color:#6366f1;text-decoration:none;">Categories</a>
                    <span style="margin:0 6px;color:#cbd5e1;">/</span>
                    @if (isset($editData)) Edit @else Add @endif
                </p>
            </div>
            <a class="btn btn-sm btn-primary" href="{{ route('categories.view') }}" style="display:inline-flex;align-items:center;gap:6px;padding:9px 18px;background:#6366f1;border:none;border-radius:8px;font-size:13px;font-weight:600;color:#fff;text-decoration:none;">
                <i class="fas fa-list"></i> Categories List
            </a>
        </div>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <section class="col-md-12">
                        <form method="post" action="{{ @$editData ? route('categories.update', $editData->id) : route('categories.store') }}" id="myForm" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <!-- Column 1: Category Info -->
                                <div class="col-lg-4 col-md-12">
                                    <div class="card mb-4" style="border: 1px solid #e2e8f0; border-radius: 12px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05); height: calc(100% - 24px);">
                                        <div class="card-header" style="background:#f8fafc; border-bottom: 1px solid #e2e8f0; border-radius: 12px 12px 0 0;">
                                            <h3 class="card-title" style="font-size:15px; font-weight:700; color:#0f172a; margin:0;">
                                                <i class="fas fa-info-circle" style="color:#6366f1; margin-right:6px;"></i> Category Information
                                            </h3>
                                        </div>
                                        <div class="card-body" style="padding: 20px;">
                                            <div class="form-group">
                                                <label for="name" style="font-weight:600; color:#334155;">Category Name (English) <span class="text-danger">*</span></label>
                                                <input type="text" name="name" value="{{ @$editData->name }}" class="form-control" id="name" placeholder="Enter category name" required>
                                                <span style="color: red;">{{ $errors->has('name') ? $errors->first('name') : '' }}</span>
                                            </div>
                                            <div class="form-group">
                                                <label for="name_bn" style="font-weight:600; color:#334155;">Category Name (Bangla) <span class="text-danger">*</span></label>
                                                <input type="text" name="name_bn" value="{{ @$editData->name_bn }}" class="form-control" id="name_bn" placeholder="Enter category name in Bangla" required>
                                                <span style="color: red;">{{ $errors->has('name_bn') ? $errors->first('name_bn') : '' }}</span>
                                            </div>
                                            <div class="form-group mb-0" style="margin-top:15px;">
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" name="is_show" value="1" class="custom-control-input" id="is_show" {{ @$editData->is_show == 1 ? 'checked' : '' }}>
                                                    <label class="custom-control-label" for="is_show" style="font-weight:600; color:#0f172a; cursor:pointer;">Show in Top Menu</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Column 2: Category Image -->
                                <div class="col-lg-4 col-md-12">
                                    <div class="card mb-4" style="border: 1px solid #e2e8f0; border-radius: 12px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05); height: calc(100% - 24px);">
                                        <div class="card-header" style="background:#f8fafc; border-bottom: 1px solid #e2e8f0; border-radius: 12px 12px 0 0;">
                                            <h3 class="card-title" style="font-size:15px; font-weight:700; color:#0f172a; margin:0;">
                                                <i class="fas fa-image" style="color:#6366f1; margin-right:6px;"></i> Category Image
                                            </h3>
                                        </div>
                                        <div class="card-body" style="padding: 20px;">
                                            <div class="form-group">
                                                <label style="font-weight:600; color:#334155; margin-bottom: 8px;">Upload Image</label>
                                                <input type="file" name="image" id="image" class="form-control">
                                                <small class="text-muted" style="margin-top: 4px; display: block;">Recommended size: 120px x 120px</small>
                                            </div>
                                            <div class="text-center" style="margin-top: 15px; padding: 15px; background: #f8fafc; border-radius: 8px; border: 1px dashed #cbd5e1;">
                                                <img id="showImage" style="width: 100px; height: 100px; border-radius: 8px; border: 1px solid #e2e8f0; object-fit: cover;"
                                                    src="{{ !empty($editData->image) ? url('upload/category_images/' . $editData->image) : url('frontend/no-image-icon.jpg') }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Column 3: SEO & Save -->
                                <div class="col-lg-4 col-md-12">
                                    <div class="card mb-4" style="border: 1px solid #e2e8f0; border-radius: 12px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05);">
                                        <div class="card-header" style="background:#f8fafc; border-bottom: 1px solid #e2e8f0; border-radius: 12px 12px 0 0;">
                                            <h3 class="card-title" style="font-size:15px; font-weight:700; color:#0f172a; margin:0;">
                                                <i class="fas fa-search" style="color:#6366f1; margin-right:6px;"></i> SEO & Save
                                            </h3>
                                        </div>
                                        <div class="card-body" style="padding: 20px;">
                                            <div class="form-group">
                                                <label for="meta_title" style="font-weight:600; color:#334155;">Meta Title</label>
                                                <input type="text" name="meta_title" value="{{ @$editData->meta_title }}" class="form-control" id="meta_title" placeholder="Meta Title">
                                            </div>
                                            <div class="form-group">
                                                <label for="meta_description" style="font-weight:600; color:#334155;">Meta Description</label>
                                                <textarea name="meta_description" class="form-control" id="meta_description" placeholder="Meta Description" rows="2" style="font-size:12px;">{{ @$editData->meta_description }}</textarea>
                                            </div>
                                            <div class="form-group">
                                                <label for="meta_keywords" style="font-weight:600; color:#334155;">Meta Keywords</label>
                                                <textarea name="meta_keywords" class="form-control" id="meta_keywords" placeholder="Keywords" rows="2" style="font-size:12px;">{{ @$editData->meta_keywords }}</textarea>
                                            </div>
                                            <div style="margin-top: 20px; padding-top: 15px; border-top: 1px solid #e2e8f0;">
                                                <button type="submit" class="btn btn-primary btn-block" style="background:#6366f1; border:none; padding:10px; border-radius:8px; font-weight:700; font-size:14px; display:flex; align-items:center; justify-content:center; gap:8px; width:100%;">
                                                    <i class="fas fa-save"></i> {{ @$editData ? 'Update' : 'Save' }} Category
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </section>
                </div>
            </div>
        </section>
    </div>

    <script type="text/javascript">
        $(function() {
            // Live preview
            $('#image').change(function(e) {
                var reader = new FileReader();
                reader.onload = function(event) {
                    $('#showImage').attr('src', event.target.result);
                };
                reader.readAsDataURL(e.target.files[0]);
            });

            $('#myForm').validate({
                rules: {
                    name: {
                        required: true
                    },
                    name_bn: {
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
@endsection
