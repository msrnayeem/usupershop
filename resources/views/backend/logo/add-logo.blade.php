@extends('backend.layouts.master')
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        {{-- Page Header --}}
        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:22px;flex-wrap:wrap;gap:12px;">
            <div>
                <h1 style="font-size:22px;font-weight:800;color:#0f172a;margin:0;">
                    <i class="fas fa-image" style="color:#6366f1;margin-right:8px;"></i>
                    @if (isset($editData)) Edit Logo @else Add Logo @endif
                </h1>
                <p style="color:#64748b;font-size:13px;margin:2px 0 0;">
                    <a href="{{ route('home') }}" style="color:#6366f1;text-decoration:none;">Home</a>
                    <span style="margin:0 6px;color:#cbd5e1;">/</span>
                    <a href="{{ route('logos.view') }}" style="color:#6366f1;text-decoration:none;">Logo</a>
                    <span style="margin:0 6px;color:#cbd5e1;">/</span>
                    @if (isset($editData)) Edit @else Add @endif
                </p>
            </div>
            <a class="btn btn-sm btn-primary" href="{{ route('logos.view') }}" style="display:inline-flex;align-items:center;gap:6px;padding:9px 18px;background:#6366f1;border:none;border-radius:8px;font-size:13px;font-weight:600;color:#fff;text-decoration:none;">
                <i class="fas fa-list"></i> Logo List
            </a>
        </div>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="card">
                    <div class="card-header">
                        <span class="card-title">
                            <i class="fas fa-cog" style="color:#6366f1;margin-right:6px;"></i>
                            Logo Asset Information
                        </span>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <form method="post"
                            action="{{ @$editData ? route('logos.update', $editData->id) : route('logos.store') }}"
                            id="myForm" enctype="multipart/form-data">
                            @csrf
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="name" style="font-weight:600;color:#334155;font-size:13px;">Logo Name <span class="text-danger">*</span></label>
                                    <input type="text" name="name" value="{{ @$editData->name }}"
                                        class="form-control" id="name" placeholder="e.g. Primary Header Logo" required>
                                    <span style="color: red;">{{ $errors->has('name') ? $errors->first('name') : '' }}</span>
                                    <small class="text-muted mt-1 d-block">Admin identifier label</small>
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="image" style="font-weight:600;color:#334155;font-size:13px;">Upload Image <span class="text-danger">*</span></label>
                                    <div class="custom-file">
                                        <input type="file" name="image" id="image" class="custom-file-input" accept="image/*" onchange="previewImage(this)">
                                        <label class="custom-file-label" for="image">Choose image file...</label>
                                    </div>
                                    <small class="text-muted mt-1 d-block">Supported formats: JPG, PNG, WebP</small>
                                </div>

                                <div class="form-group col-md-12 mt-3" style="background:#f8fafc;padding:20px;border-radius:12px;border:1px solid #e2e8f0;display:flex;flex-direction:column;align-items:center;justify-content:center;gap:8px;">
                                    <span style="font-size:12px;font-weight:700;color:#64748b;text-transform:uppercase;letter-spacing:0.5px;">Logo Preview</span>
                                    <div style="background:#fff;border:1px dashed #cbd5e1;padding:12px;border-radius:8px;min-width:160px;min-height:90px;display:flex;align-items:center;justify-content:center;">
                                        <img id="showImage" style="max-height:80px;max-width:260px;object-fit:contain;"
                                            src="{{ !empty($editData->image) ? url('upload/logo_image/' . $editData->image) : url('frontend/no-image-icon.jpg') }}"
                                            onerror="this.src='{{ url('frontend/no-image-icon.jpg') }}'">
                                    </div>
                                </div>

                                <div class="form-group col-md-12 text-right mt-4" style="border-top:1px solid #e2e8f0;padding-top:20px;margin-bottom:0;">
                                    <button type="submit" class="btn btn-primary px-4" style="background:#6366f1;border:none;font-weight:600;padding:10px 24px;border-radius:8px;">
                                        <i class="fas fa-save mr-1"></i> {{ @$editData ? 'Update Logo' : 'Save Logo' }}
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
        function previewImage(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#showImage').attr('src', e.target.result);
                };
                reader.readAsDataURL(input.files[0]);
                $(input).siblings('.custom-file-label').addClass("selected").html(input.files[0].name);
            }
        }

        $(function() {
            $('#myForm').validate({
                rules: {
                    name: {
                        required: true
                    },
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
