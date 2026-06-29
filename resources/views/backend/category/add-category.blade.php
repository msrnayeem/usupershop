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
                        <div class="card">
                            <div class="card-header">
                                <span class="card-title">
                                    <i class="fas fa-edit" style="color:#6366f1;margin-right:6px;"></i>
                                    Category Details
                                </span>
                            </div>
                            <div class="card-body">
                                <form method="post" action="{{ @$editData ? route('categories.update', $editData->id) : route('categories.store') }}" id="myForm" enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-row">
                                        <div class="form-group col-md-4">
                                            <label for="name">Category Name (English)</label>
                                            <input type="text" name="name" value="{{ @$editData->name }}" class="form-control" id="name" placeholder="Enter category name" required>
                                            <span style="color: red;">{{ $errors->has('name') ? $errors->first('name') : '' }}</span>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="name_bn">Category Name (Bangla)</label>
                                            <input type="text" name="name_bn" value="{{ @$editData->name_bn }}" class="form-control" id="name_bn" placeholder="Enter category name in Bangla" required>
                                            <span style="color: red;">{{ $errors->has('name_bn') ? $errors->first('name_bn') : '' }}</span>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label>Image <span class="text-danger">(Recommended 120px x 120px)</span></label>
                                            <input type="file" name="image" id="image" class="form-control">
                                        </div>

                                        <div class="form-group col-md-2" style="display:flex;align-items:flex-end;">
                                            <img id="showImage" style="width: 80px;height:80px;border-radius:8px;border:1px solid #e2e8f0;object-fit:cover;"
                                                src="{{ !empty($editData->image) ? url('upload/category_images/' . $editData->image) : url('frontend/no-image-icon.jpg') }}">
                                        </div>
                                        <div class="form-group col-md-2"></div>

                                        <div class="form-group col-md-3" style="display:flex;align-items:center;padding-top:30px;">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" name="is_show" value="1" class="custom-control-input" id="is_show" {{ @$editData->is_show == 1 ? 'checked' : '' }}>
                                                <label class="custom-control-label" for="is_show" style="font-weight:600;color:#0f172a;cursor:pointer;">Show in Top Menu</label>
                                            </div>
                                        </div>

                                        <!-- SEO Fields -->
                                        <div class="form-group col-md-5">
                                            <label for="meta_title">Meta Title</label>
                                            <input type="text" name="meta_title" value="{{ @$editData->meta_title }}" class="form-control" id="meta_title" placeholder="Enter meta title for SEO">
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label for="meta_description">Meta Description</label>
                                            <textarea name="meta_description" class="form-control" id="meta_description" placeholder="Enter meta description for SEO" rows="2">{{ @$editData->meta_description }}</textarea>
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label for="meta_keywords">Meta Keywords</label>
                                            <textarea name="meta_keywords" class="form-control" id="meta_keywords" placeholder="Enter meta keywords for SEO" rows="2">{{ @$editData->meta_keywords }}</textarea>
                                        </div>

                                        <div class="form-group col-md-12 text-right" style="margin-top:20px;border-top:1px solid #e2e8f0;padding-top:20px;">
                                            <button type="submit" class="btn btn-primary" style="background:#6366f1;border:none;padding:9px 24px;border-radius:8px;font-weight:600;">
                                                <i class="fas fa-save mr-1"></i> {{ @$editData ? 'Update' : 'Save' }} Category
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
