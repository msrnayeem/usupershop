@extends('backend.layouts.master')
@section('content')
<div class="content-wrapper">
    {{-- Page Header --}}
    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:22px;flex-wrap:wrap;gap:12px;">
        <div>
            <h1 style="font-size:22px;font-weight:800;color:#0f172a;margin:0;">
                <i class="fas fa-palette" style="color:#6366f1;margin-right:8px;"></i>
                Color Settings
            </h1>
            <p style="color:#64748b;font-size:13px;margin:2px 0 0;">
                <a href="{{ route('home') }}" style="color:#6366f1;text-decoration:none;">Home</a>
                <span style="margin:0 6px;color:#cbd5e1;">/</span>
                Color Settings
            </p>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert" style="border:none;border-radius:8px;background:#f0fdf4;color:#15803d;margin-bottom:20px;">
                    <i class="fas fa-check-circle mr-1"></i> {{ session('success') }}
                    <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
                </div>
            @endif

            <div class="row">
                {{-- Element Color Form --}}
                <div class="col-md-8 mb-4">
                    <div class="card h-100">
                        <div class="card-header">
                            <span class="card-title">
                                <i class="fas fa-sliders-h" style="color:#6366f1;margin-right:6px;"></i>
                                Website Color Customization
                            </span>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('color-settings.update') }}" method="POST">
                                @csrf
                                <div class="row">
                                    @foreach($colorSettings as $setting)
                                        <div class="col-md-6 mb-3">
                                            <div class="form-group mb-0">
                                                <label for="{{ $setting->element_name }}" style="font-weight:600;color:#334155;font-size:13px;">{{ $setting->display_name }}</label>
                                                <div class="input-group mt-1">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text" style="padding:0;overflow:hidden;border:none;">
                                                            <input type="color" class="form-control form-control-color" id="{{ $setting->element_name }}" name="colors[{{ $setting->element_name }}]" value="{{ $setting->color_code }}" style="height:38px;width:44px;border:none;padding:0;cursor:pointer;">
                                                        </span>
                                                    </div>
                                                    <input type="text" class="form-control" value="{{ $setting->color_code }}" readonly id="text_{{ $setting->element_name }}" style="font-family:monospace;font-size:14px;border-top-right-radius:6px;border-bottom-right-radius:6px;">
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>

                                <div class="form-group mt-4 pt-3 text-right" style="border-top:1px solid #e2e8f0;margin-bottom:0;">
                                    <button type="submit" class="btn btn-primary" style="background:#6366f1;border:none;padding:10px 24px;border-radius:8px;font-weight:600;">
                                        <i class="fas fa-save mr-1"></i> Save Custom Colors
                                    </button>
                                    <button type="button" class="btn btn-warning ml-2" onclick="resetColors()" style="border-radius:8px;padding:10px 20px;font-weight:600;">
                                        <i class="fas fa-undo mr-1"></i> Reset to Default
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                {{-- Live Mock Preview --}}
                <div class="col-md-4 mb-4">
                    <div class="card h-100">
                        <div class="card-header bg-dark">
                            <span class="card-title font-weight-bold text-white"><i class="fas fa-eye mr-1"></i> Live Layout Preview</span>
                        </div>
                        <div class="card-body">
                            <div class="preview-container" style="border:1px solid #e2e8f0;border-radius:8px;overflow:hidden;box-shadow:0 4px 10px rgba(0,0,0,0.02);">
                                <!-- Header Preview -->
                                <div class="preview-header mb-3 p-3 text-center" id="preview-header" style="transition:background-color 0.2s ease;">
                                    <span class="preview-text font-weight-bold" id="preview-header-text" style="font-size:14px;transition:color 0.2s ease;">Storefront Header Text</span>
                                </div>

                                <div class="px-3">
                                    <!-- Search Icon Preview -->
                                    <div class="mb-3 d-flex align-items-center justify-content-between">
                                        <span style="font-size:13px;color:#64748b;">Search Toggle Button:</span>
                                        <button class="btn preview-search-btn" id="preview-search" style="width:38px;height:38px;border:none;border-radius:50%;display:flex;align-items:center;justify-content:center;transition:background-color 0.2s ease;">
                                            <i class="fas fa-search" id="preview-search-icon" style="transition:color 0.2s ease;"></i>
                                        </button>
                                    </div>

                                    <!-- Price Preview -->
                                    <div class="mb-3 d-flex align-items-center justify-content-between">
                                        <span style="font-size:13px;color:#64748b;">Price Tag Indicator:</span>
                                        <span class="h5 preview-price mb-0" id="preview-price" style="font-weight:800;transition:color 0.2s ease;">৳999.00</span>
                                    </div>

                                    <!-- Add to Cart Preview -->
                                    <div class="mb-4 d-flex align-items-center justify-content-between">
                                        <span style="font-size:13px;color:#64748b;">Action Button:</span>
                                        <button class="btn preview-cart-btn" id="preview-cart" style="border:none;border-radius:6px;padding:8px 16px;font-weight:700;transition:background-color 0.2s ease;">
                                            <span id="preview-cart-text" style="transition:color 0.2s ease;">Add to Cart</span>
                                        </button>
                                    </div>
                                </div>

                                <!-- Footer Preview -->
                                <div class="preview-footer p-3 text-center" id="preview-footer" style="transition:background-color 0.2s ease;">
                                    <span class="preview-text" id="preview-footer-text" style="font-size:12px;transition:color 0.2s ease;">Storefront Copyright Footer Text</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<form id="resetForm" action="{{ route('color-settings.reset') }}" method="POST" style="display: none;">
    @csrf
</form>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const colorInputs = document.querySelectorAll('input[type="color"]');
        
        colorInputs.forEach(input => {
            input.addEventListener('input', function() {
                updatePreview(this.id, this.value);
                document.getElementById('text_' + this.id).value = this.value;
            });
        });

        colorInputs.forEach(input => {
            updatePreview(input.id, input.value);
        });
    });

    function updatePreview(elementName, color) {
        switch(elementName) {
            case 'header_bg':
                document.getElementById('preview-header').style.backgroundColor = color;
                break;
            case 'header_text':
                document.getElementById('preview-header-text').style.color = color;
                break;
            case 'footer_bg':
                document.getElementById('preview-footer').style.backgroundColor = color;
                break;
            case 'footer_text':
                document.getElementById('preview-footer-text').style.color = color;
                break;
            case 'search_icon_bg':
                document.getElementById('preview-search').style.backgroundColor = color;
                break;
            case 'search_icon_color':
                document.getElementById('preview-search-icon').style.color = color;
                break;
            case 'add_to_cart_bg':
                document.getElementById('preview-cart').style.backgroundColor = color;
                break;
            case 'add_to_cart_text':
                document.getElementById('preview-cart-text').style.color = color;
                break;
            case 'price_color':
                document.getElementById('preview-price').style.color = color;
                break;
        }
    }

    function resetColors() {
        if(confirm('Are you sure you want to reset all colors to default?')) {
            document.getElementById('resetForm').submit();
        }
    }
</script>
@endpush