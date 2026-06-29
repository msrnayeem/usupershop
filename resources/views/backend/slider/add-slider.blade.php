@extends('backend.layouts.master')
@section('content')
<div class="content-wrapper">
    {{-- Page Header --}}
    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:22px;flex-wrap:wrap;gap:12px;">
        <div>
            <h1 style="font-size:22px;font-weight:800;color:#0f172a;margin:0;">
                <i class="fas fa-images text-primary" style="margin-right:8px;"></i>
                {{ isset($editData) ? 'Edit Slider' : 'Add New Slider' }}
            </h1>
            <p style="color:#64748b;font-size:13px;margin:2px 0 0;">
                <a href="{{ route('home') }}" style="color:#6366f1;text-decoration:none;">Home</a>
                <span style="margin:0 6px;color:#cbd5e1;">/</span>
                <a href="{{ route('sliders.view') }}" style="color:#6366f1;text-decoration:none;">Sliders</a>
                <span style="margin:0 6px;color:#cbd5e1;">/</span>
                {{ isset($editData) ? 'Edit' : 'Add' }}
            </p>
        </div>
        <a class="btn btn-sm btn-primary" href="{{ route('sliders.view') }}" style="display:inline-flex;align-items:center;gap:6px;padding:9px 18px;background:#6366f1;border:none;border-radius:8px;font-size:13px;font-weight:600;color:#fff;text-decoration:none;">
            <i class="fas fa-list"></i> Sliders List
        </a>
    </div>

    <section class="content">
        <div class="container-fluid">
            @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert" style="border:none;border-radius:8px;background:#fef2f2;color:#b91c1c;margin-bottom:20px;">
                    <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
                    @foreach($errors->all() as $err)<div>⚠️ {{ $err }}</div>@endforeach
                </div>
            @endif

            <div class="row">
                <div class="col-md-7 mb-4">
                    <div class="card h-100">
                        <div class="card-header">
                            <span class="card-title">
                                <i class="fas fa-sliders-h" style="color:#6366f1;margin-right:6px;"></i>
                                Slider Parameters Config
                            </span>
                        </div>
                        <div class="card-body">
                            <form action="{{ isset($editData) ? route('sliders.update', $editData->id) : route('sliders.store') }}"
                                method="POST" enctype="multipart/form-data" id="myForm">
                                @csrf
                                @if(isset($editData)) @method('POST') @endif

                                {{-- Slider Name --}}
                                <div class="form-group">
                                    <label class="font-weight-bold" style="font-size:13px;color:#334155;">Slider Name / Title <span class="text-danger">*</span></label>
                                    <input type="text" name="name"
                                        value="{{ old('name', $editData->name ?? '') }}"
                                        class="form-control @error('name') is-invalid @enderror"
                                        placeholder="e.g. Winter Campaign Slider" required>
                                    @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    <small class="text-muted mt-1 d-block">Admin identifier label (not displayed on storefront)</small>
                                </div>

                                {{-- Image Upload --}}
                                <div class="form-group">
                                    <label class="font-weight-bold" style="font-size:13px;color:#334155;">
                                        Slider Image
                                        @if(!isset($editData))<span class="text-danger">*</span>@else<span class="text-muted">(Leave blank to keep existing)</span>@endif
                                    </label>

                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input @error('image') is-invalid @enderror"
                                            id="sliderImage" name="image" accept="image/*"
                                            onchange="previewImage(this)">
                                        <label class="custom-file-label" for="sliderImage">Choose image file...</label>
                                    </div>
                                    @error('image')<div class="text-danger mt-1" style="font-size:13px;">{{ $message }}</div>@enderror
                                    <small class="text-muted mt-1 d-block">Recommended Dimension: <strong>1400x500px</strong> (Max 2MB)</small>

                                    {{-- Image Previews --}}
                                    <div style="display:flex;gap:15px;margin-top:15px;flex-wrap:wrap;">
                                        @if(isset($editData) && $editData->image)
                                            <div style="background:#f8fafc;border:1px solid #e2e8f0;border-radius:10px;padding:8px;text-align:center;">
                                                <span style="font-size:11px;font-weight:700;color:#64748b;display:block;margin-bottom:6px;text-transform:uppercase;">Current Image</span>
                                                <img src="{{ asset('upload/slider_images/' . $editData->image) }}"
                                                    style="max-height:100px;border-radius:6px;max-width:180px;object-fit:contain;">
                                            </div>
                                        @endif
                                        <div id="imagePreview" style="background:#f0fdf4;border:1px dashed #22c55e;border-radius:10px;padding:8px;text-align:center;display:none;">
                                            <span style="font-size:11px;font-weight:700;color:#166534;display:block;margin-bottom:6px;text-transform:uppercase;">New Selection Preview</span>
                                            <img id="previewImg" style="max-height:100px;border-radius:6px;max-width:180px;object-fit:contain;">
                                        </div>
                                    </div>
                                </div>

                                {{-- Link --}}
                                <div class="form-group">
                                    <label class="font-weight-bold" style="font-size:13px;color:#334155;">
                                        Slider Action URL Link
                                        <span class="badge badge-light ml-1" style="font-weight:600;border:1px solid #cbd5e1;">Optional</span>
                                    </label>

                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" style="background:#f1f5f9;"><i class="fas fa-link"></i></span>
                                        </div>
                                        <input type="url" name="slider_link"
                                            value="{{ old('slider_link', $editData->slider_link ?? '') }}"
                                            class="form-control @error('slider_link') is-invalid @enderror"
                                            placeholder="https://usuper.shop/category/winter-clothing"
                                            id="sliderLinkInput">
                                        @error('slider_link')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>
                                    <small class="text-muted mt-1 d-block">Navigates user to this link when slider is clicked</small>

                                    {{-- Quick link suggestions --}}
                                    <div style="margin-top:10px;display:flex;gap:6px;flex-wrap:wrap;align-items:center;">
                                        <span style="font-size:12px;color:#64748b;font-weight:600;">Quick Presets:</span>
                                        @foreach([
                                            ['label'=>'🛍️ Products List', 'url'=>'/product-list'],
                                            ['label'=>'💎 Subscription Packages', 'url'=>'/pricing'],
                                            ['label'=>'🚀 Dropship Portal', 'url'=>'/user-guide'],
                                            ['label'=>'🔗 Absolute Target', 'url'=>'https://'],
                                        ] as $q)
                                            <button type="button" class="btn btn-xs btn-outline-secondary"
                                                style="font-size:11px;padding:3px 10px;border-radius:6px;font-weight:600;"
                                                onclick="setLink('{{ $q['url'] }}')">{{ $q['label'] }}</button>
                                        @endforeach
                                    </div>
                                </div>

                                {{-- Link Target --}}
                                <div class="form-group" id="targetGroup" style="{{ empty(old('slider_link', $editData->slider_link ?? '')) ? 'display:none' : '' }}">
                                    <label class="font-weight-bold" style="font-size:13px;color:#334155;">Link Open Window Target</label>
                                    <select name="link_target" class="form-control select2" style="max-width:300px">
                                        <option value="_self" {{ (old('link_target', $editData->link_target ?? '_self') == '_self') ? 'selected' : '' }}>
                                            Same Window (Default)
                                        </option>
                                        <option value="_blank" {{ (old('link_target', $editData->link_target ?? '_self') == '_blank') ? 'selected' : '' }}>
                                            New Tab Window (_blank)
                                        </option>
                                    </select>
                                </div>

                                {{-- Submit --}}
                                <div class="form-group text-right mt-4 pt-3 style=border-top:1px solid #e2e8f0;margin-bottom:0;">
                                    <button type="submit" class="btn btn-primary px-5" style="background:#6366f1;border:none;padding:10px 30px;border-radius:8px;font-weight:600;">
                                        <i class="fas fa-save mr-1"></i>
                                        {{ isset($editData) ? 'Update Slider' : 'Save Slider' }}
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                {{-- Info Column --}}
                <div class="col-md-5 mb-4">
                    <div class="card h-100">
                        <div class="card-header bg-dark">
                            <span class="card-title font-weight-bold text-white"><i class="fas fa-question-circle mr-1"></i> Slider Customization Tips</span>
                        </div>
                        <div class="card-body" style="font-size:13px;color:#475569;line-height:1.8;">
                            <h6 class="font-weight-bold text-dark mb-2">💡 Interactive Actions:</h6>
                            <p>Sliders are perfect for showcasing seasonal campaign discounts. Adding internal or external routing URLs will boost campaign click-through rates.</p>
                            
                            <h6 class="font-weight-bold text-dark mt-4 mb-2">📐 Perfect Slider Sizing:</h6>
                            <p>To avoid layout shifts, maintain identical dimensions across all storefront slides. Recommended size is <strong>1400x500px</strong>.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $('.select2').select2({
            theme: 'bootstrap4'
        });

        $('#myForm').validate({
            rules: {
                name: { required: true }
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

    function previewImage(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('previewImg').src = e.target.result;
                document.getElementById('imagePreview').style.display = 'block';
            };
            reader.readAsDataURL(input.files[0]);
            document.querySelector('.custom-file-label').textContent = input.files[0].name;
        }
    }

    function setLink(url) {
        var input = document.getElementById('sliderLinkInput');
        input.value = url;
        input.focus();
        document.getElementById('targetGroup').style.display = '';
    }

    document.getElementById('sliderLinkInput').addEventListener('input', function() {
        document.getElementById('targetGroup').style.display = this.value.trim() ? '' : 'none';
    });
</script>
@endpush
