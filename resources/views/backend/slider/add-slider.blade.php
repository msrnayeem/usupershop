@extends('backend.layouts.master')
@section('content')
<div class="content-wrapper">
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h5 class="m-0">
            <i class="fas fa-images text-primary"></i>
            {{ isset($editData) ? 'Slider Edit করুন' : 'নতুন Slider যোগ করুন' }}
          </h5>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('sliders.view') }}">Sliders</a></li>
            <li class="breadcrumb-item active">{{ isset($editData) ? 'Edit' : 'Add' }}</li>
          </ol>
        </div>
      </div>
    </div>
  </div>

  <section class="content">
    <div class="container-fluid">

      @if($errors->any())
      <div class="alert alert-danger alert-dismissible">
        <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
        @foreach($errors->all() as $err)<div>⚠️ {{ $err }}</div>@endforeach
      </div>
      @endif

      <div class="row">
        <div class="col-md-7">
          <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
              <h3 class="card-title">
                <i class="fas fa-{{ isset($editData) ? 'edit' : 'plus' }} mr-2"></i>
                {{ isset($editData) ? 'Slider Edit' : 'নতুন Slider' }}
              </h3>
            </div>
            <div class="card-body">
              <form action="{{ isset($editData) ? route('sliders.update', $editData->id) : route('sliders.store') }}"
                method="POST" enctype="multipart/form-data">
                @csrf
                @if(isset($editData)) @method('POST') @endif

                {{-- Slider Name --}}
                <div class="form-group">
                  <label class="font-weight-bold">Slider নাম / Title <span class="text-danger">*</span></label>
                  <input type="text" name="name"
                    value="{{ old('name', $editData->name ?? '') }}"
                    class="form-control @error('name') is-invalid @enderror"
                    placeholder="যেমন: Summer Sale Banner">
                  @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                  <small class="text-muted">শুধু admin panel-এ দেখাবে, frontend-এ নয়</small>
                </div>

                {{-- Image Upload --}}
                <div class="form-group">
                  <label class="font-weight-bold">
                    Slider Image
                    @if(!isset($editData))<span class="text-danger">*</span>@else<span class="text-muted">(পরিবর্তন না করলে খালি রাখুন)</span>@endif
                  </label>

                  {{-- Current image preview --}}
                  @if(isset($editData) && $editData->image)
                  <div style="margin-bottom:10px">
                    <img src="{{ asset('upload/slider_images/' . $editData->image) }}"
                      style="max-width:200px;border-radius:8px;border:1px solid #ddd">
                    <div style="font-size:13px;color:#888;margin-top:4px">বর্তমান ছবি</div>
                  </div>
                  @endif

                  <div class="custom-file">
                    <input type="file" class="custom-file-input @error('image') is-invalid @enderror"
                      id="sliderImage" name="image" accept="image/jpeg,image/png,image/webp"
                      onchange="previewImage(this)">
                    <label class="custom-file-label" for="sliderImage">ছবি বেছে নিন</label>
                  </div>
                  @error('image')<div class="text-danger" style="font-size:13px;margin-top:4px">{{ $message }}</div>@enderror
                  <small class="text-muted">JPG, PNG, WebP — সর্বোচ্চ ২MB | Recommended: 1400×500px</small>

                  {{-- New image preview --}}
                  <div id="imagePreview" style="margin-top:10px;display:none">
                    <img id="previewImg" style="max-width:250px;border-radius:8px;border:1px solid #ddd">
                    <div style="font-size:13px;color:#888;margin-top:4px">নতুন ছবি preview</div>
                  </div>
                </div>

                {{-- Link (Optional) --}}
                <div class="form-group">
                  <label class="font-weight-bold">
                    Slider Link
                    <span class="badge badge-secondary ml-1" style="font-size:12px">অপশনাল</span>
                  </label>

                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="fas fa-link"></i></span>
                    </div>
                    <input type="url" name="slider_link"
                      value="{{ old('slider_link', $editData->slider_link ?? '') }}"
                      class="form-control @error('slider_link') is-invalid @enderror"
                      placeholder="https://usuper.shop/product-list (খালি রাখলে link কাজ করবে না)"
                      id="sliderLinkInput">
                    @error('slider_link')<div class="invalid-feedback">{{ $message }}</div>@enderror
                  </div>
                  <small class="text-muted">
                    Slider-এ click করলে এই page-এ যাবে। <strong>খালি রাখলে কোনো link কাজ করবে না।</strong>
                  </small>

                  {{-- Quick link suggestions --}}
                  <div style="margin-top:8px;display:flex;gap:6px;flex-wrap:wrap">
                    <span style="font-size:13px;color:#888;align-self:center">Quick:</span>
                    @foreach([
                      ['label'=>'🛍️ সব পণ্য', 'url'=>'/product-list'],
                      ['label'=>'💎 Pricing', 'url'=>'/pricing'],
                      ['label'=>'🚀 Dropshipper', 'url'=>'/user-guide'],
                      ['label'=>'🔗 External', 'url'=>'https://'],
                    ] as $q)
                    <button type="button" class="btn btn-xs btn-outline-secondary"
                      style="font-size:13px;padding:3px 8px"
                      onclick="setLink('{{ $q['url'] }}')">{{ $q['label'] }}</button>
                    @endforeach
                  </div>
                </div>

                {{-- Link Target --}}
                <div class="form-group" id="targetGroup" style="{{ empty(old('slider_link', $editData->slider_link ?? '')) ? 'display:none' : '' }}">
                  <label class="font-weight-bold">Link খুলবে কোথায়?</label>
                  <select name="link_target" class="form-control" style="max-width:300px">
                    <option value="_self" {{ (old('link_target', $editData->link_target ?? '_self') == '_self') ? 'selected' : '' }}>
                      Same Window (একই tab-এ)
                    </option>
                    <option value="_blank" {{ (old('link_target', $editData->link_target ?? '_self') == '_blank') ? 'selected' : '' }}>
                      New Tab (নতুন tab-এ)
                    </option>
                  </select>
                </div>

                {{-- Submit --}}
                <div class="d-flex gap-2" style="gap:10px">
                  <button type="submit" class="btn btn-primary px-5">
                    <i class="fas fa-save mr-1"></i>
                    {{ isset($editData) ? 'Update করুন' : 'Save করুন' }}
                  </button>
                  <a href="{{ route('sliders.view') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left mr-1"></i> Back
                  </a>
                </div>
              </form>
            </div>
          </div>
        </div>

        {{-- Help Card --}}
        <div class="col-md-5">
          <div class="card shadow-sm">
            <div class="card-header bg-info text-white">
              <h3 class="card-title"><i class="fas fa-lightbulb mr-2"></i>Slider Link ব্যবহার</h3>
            </div>
            <div class="card-body" style="font-size:13px;line-height:1.9">
              <p><strong>Link যোগ করলে:</strong></p>
              <ul style="padding-left:18px;margin-bottom:12px">
                <li>User Slider-এ click করলে সেই page-এ যাবে</li>
                <li>Mobile-এ tap করলেও কাজ করবে</li>
                <li>Link না দিলে Slider সুধু দেখাবে, click করলে কিছু হবে না</li>
              </ul>
              <hr>
              <p><strong>Link-এর উদাহরণ:</strong></p>
              <ul style="padding-left:18px">
                <li><code>https://usuper.shop/product-list</code> — সব পণ্য</li>
                <li><code>https://usuper.shop/pricing</code> — Pricing</li>
                <li><code>https://youtube.com/...</code> — YouTube</li>
                <li><code>https://wa.me/8801816622128</code> — WhatsApp</li>
              </ul>
            </div>
          </div>
        </div>
      </div>

    </div>
  </section>
</div>

@push('scripts')
<script>
function previewImage(input) {
  if (input.files && input.files[0]) {
    var reader = new FileReader();
    reader.onload = function(e) {
      document.getElementById('previewImg').src = e.target.result;
      document.getElementById('imagePreview').style.display = 'block';
    };
    reader.readAsDataURL(input.files[0]);
    // Update file label
    document.querySelector('.custom-file-label').textContent = input.files[0].name;
  }
}

function setLink(url) {
  var input = document.getElementById('sliderLinkInput');
  input.value = url;
  input.focus();
  document.getElementById('targetGroup').style.display = '';
}

// Show/hide target based on link input
document.getElementById('sliderLinkInput').addEventListener('input', function() {
  document.getElementById('targetGroup').style.display = this.value.trim() ? '' : 'none';
});
</script>
@endpush
@endsection
