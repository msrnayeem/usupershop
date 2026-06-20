@extends('backend.layouts.master')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Color Settings</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                        <li class="breadcrumb-item active">Color Settings</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Website Color Customization</h3>
                        </div>
                        <div class="card-body">
                            @if(session('success'))
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    {{ session('success') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                </div>
                            @endif

                            <form action="{{ route('color-settings.update') }}" method="POST">
                                @csrf
                                <div class="row">
                                    @foreach($colorSettings as $setting)
                                    <div class="col-md-6 mb-3">
                                        <div class="form-group">
                                            <label for="{{ $setting->element_name }}">{{ $setting->display_name }}</label>
                                            <div class="input-group">
                                                <input type="color" 
                                                       class="form-control form-control-color" 
                                                       id="{{ $setting->element_name }}"
                                                       name="colors[{{ $setting->element_name }}]" 
                                                       value="{{ $setting->color_code }}"
                                                       style="height: 40px;">
                                                <input type="text" 
                                                       class="form-control" 
                                                       value="{{ $setting->color_code }}" 
                                                       readonly
                                                       id="text_{{ $setting->element_name }}"
                                                       style="max-width: 100px;">
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>

                                <div class="form-group mt-3">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save"></i> Save Colors
                                    </button>
                                    <button type="button" class="btn btn-warning ml-2" onclick="resetColors()">
                                        <i class="fas fa-undo"></i> Reset to Default
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Live Preview</h3>
                        </div>
                        <div class="card-body">
                            <div class="preview-container">
                                <!-- Header Preview -->
                                <div class="preview-header mb-3 p-3" id="preview-header">
                                    <span class="preview-text" id="preview-header-text">Header Text</span>
                                </div>

                                <!-- Search Icon Preview -->
                                <div class="mb-3">
                                    <button class="btn preview-search-btn" id="preview-search">
                                        <i class="fas fa-search" id="preview-search-icon"></i>
                                    </button>
                                </div>

                                <!-- Price Preview -->
                                <div class="mb-3">
                                    <span class="h4 preview-price" id="preview-price">$99.99</span>
                                </div>

                                <!-- Add to Cart Preview -->
                                <div class="mb-3">
                                    <button class="btn preview-cart-btn" id="preview-cart">
                                        <span id="preview-cart-text">Add to Cart</span>
                                    </button>
                                </div>

                                <!-- Footer Preview -->
                                <div class="preview-footer p-3" id="preview-footer">
                                    <span class="preview-text" id="preview-footer-text">Footer Text</span>
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

<style>
.form-control-color {
    padding: 0;
    border: none;
}

.preview-container {
    border: 1px solid #ddd;
    border-radius: 5px;
    overflow: hidden;
}

.preview-header, .preview-footer {
    border-radius: 0;
}

.preview-search-btn, .preview-cart-btn {
    padding: 8px 16px;
    border: none;
    border-radius: 4px;
}

.preview-price {
    font-weight: bold;
}

.alert-dismissible .btn-close {
    position: absolute;
    top: 0;
    right: 0;
    padding: 0.75rem 1.25rem;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Update preview on color change
    const colorInputs = document.querySelectorAll('input[type="color"]');
    
    colorInputs.forEach(input => {
        input.addEventListener('change', function() {
            updatePreview(this.id, this.value);
            document.getElementById('text_' + this.id).value = this.value;
        });
    });

    // Initial preview update
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
@endsection