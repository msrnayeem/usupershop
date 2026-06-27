@extends('backend.layouts.master')
@section('content')
<div class="content-wrapper">
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h5 class="m-0"><i class="fas fa-search text-primary"></i> SEO Settings</h5>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item active">SEO Settings</li>
          </ol>
        </div>
      </div>
    </div>
  </div>

  <section class="content">
    <div class="container-fluid">

      @if(session('success'))
      <div class="alert alert-success alert-dismissible fade show">
        <i class="fas fa-check-circle"></i> {{ session('success') }}
        <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
      </div>
      @endif

      <form action="{{ route('settings.seo.update') }}" method="POST" enctype="multipart/form-data">
        @csrf @method('PUT')

        <div class="row">
          <div class="col-md-8">

            {{-- ── Basic SEO ────────────────────────────────────────── --}}
            <div class="card shadow-sm mb-3">
              <div class="card-header bg-primary text-white">
                <h3 class="card-title"><i class="fas fa-tag mr-2"></i>Basic SEO</h3>
              </div>
              <div class="card-body">

                <div class="form-group">
                  <label class="font-weight-bold">🌐 Site Title (Browser Tab + Google-এ দেখাবে)</label>
                  <input type="text" name="seo_site_title"
                    value="{{ old('seo_site_title', $setting->seo_site_title ?? '') }}"
                    class="form-control" maxlength="200"
                    placeholder="U Super Shop | Best Online Shop in Bangladesh"
                    id="titleInput" oninput="countChars(this,'titleCount',60)">
                  <div class="d-flex justify-content-between mt-1">
                    <small class="text-muted">Google-এ সর্বোচ্চ ৬০ অক্ষর দেখায়</small>
                    <small id="titleCount" class="text-muted">0/60</small>
                  </div>
                </div>

                <div class="form-group">
                  <label class="font-weight-bold">📝 Meta Description (Google Search Result-এ দেখাবে)</label>
                  <textarea name="seo_meta_description" rows="4" class="form-control"
                    maxlength="500" id="descInput" oninput="countChars(this,'descCount',160)"
                    placeholder="সংক্ষিপ্ত বিবরণ...">{{ old('seo_meta_description', $setting->seo_meta_description ?? '') }}</textarea>
                  <div class="d-flex justify-content-between mt-1">
                    <small class="text-muted">Google-এ সর্বোচ্চ ১৬০ অক্ষর দেখায়। বাংলা ও English মিলিয়ে লিখুন।</small>
                    <small id="descCount" class="text-muted">0/160</small>
                  </div>
                </div>

                <div class="form-group">
                  <label class="font-weight-bold">🔑 Meta Keywords (comma দিয়ে আলাদা করুন)</label>
                  <textarea name="seo_meta_keywords" rows="3" class="form-control"
                    placeholder="U Super Shop, usuper.shop, online shop bangladesh, ...">{{ old('seo_meta_keywords', $setting->seo_meta_keywords ?? '') }}</textarea>
                  <small class="text-muted">প্রতিটি keyword comma (,) দিয়ে আলাদা করুন। বাংলা ও English উভয়ই দিন।</small>
                </div>

                <div class="form-group">
                  <label class="font-weight-bold">✅ Google Verification Code</label>
                  <input type="text" name="seo_google_verification"
                    value="{{ old('seo_google_verification', $setting->seo_google_verification ?? '') }}"
                    class="form-control" style="font-family:monospace"
                    placeholder="Google Search Console থেকে verification code">
                  <small class="text-muted">
                    <a href="https://search.google.com/search-console" target="_blank">Google Search Console</a>
                    → Add Property → HTML Meta tag থেকে content value কপি করুন
                  </small>
                </div>

              </div>
            </div>

            {{-- ── Favicon & Logo ──────────────────────────────────── --}}
            <div class="card shadow-sm mb-3">
              <div class="card-header bg-warning">
                <h3 class="card-title"><i class="fas fa-star mr-2"></i>Favicon & Logo (Google Search-এ দেখাবে)</h3>
              </div>
              <div class="card-body">

                <div class="alert alert-info" style="font-size:13px">
                  <i class="fas fa-info-circle"></i>
                  <strong>Google Search-এ Website-এর Logo দেখানো হয় Schema.org-এর মাধ্যমে।</strong>
                  Logo upload করলে Google Search result-এ website-এর পাশে এই logo দেখাবে।
                </div>

                <div class="row">
                  {{-- Favicon --}}
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="font-weight-bold">🌐 Favicon (Browser Tab-এ ছোট icon)</label>
                      @if(!empty($setting->seo_favicon))
                      <div style="margin-bottom:8px;display:flex;align-items:center;gap:10px">
                        <img src="{{ asset('upload/seo/' . $setting->seo_favicon) }}"
                          style="width:32px;height:32px;border-radius:4px;border:1px solid #ddd;object-fit:contain">
                        <span style="font-size:13px;color:#888">বর্তমান Favicon</span>
                      </div>
                      @else
                      <div style="margin-bottom:8px;display:flex;align-items:center;gap:10px">
                        <div style="width:32px;height:32px;background:#e8001d;border-radius:4px;display:flex;align-items:center;justify-content:center;color:#fff;font-size:13px;font-weight:800">U</div>
                        <span style="font-size:13px;color:#888">Default Favicon</span>
                      </div>
                      @endif
                      <div class="custom-file">
                        <input type="file" class="custom-file-input" id="faviconFile"
                          name="seo_favicon" accept="image/x-icon,image/png,image/jpeg">
                        <label class="custom-file-label" for="faviconFile">Favicon বেছে নিন</label>
                      </div>
                      <small class="text-muted d-block mt-1">
                        <strong>32×32px বা 16×16px</strong> | ICO, PNG<br>
                        Browser tab-এ website-এর পাশে দেখাবে
                      </small>
                    </div>
                  </div>

                  {{-- Logo --}}
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="font-weight-bold">🏷️ Website Logo (Google Search & Schema)</label>
                      @if(!empty($setting->seo_logo))
                      <div style="margin-bottom:8px">
                        <img src="{{ asset('upload/seo/' . $setting->seo_logo) }}"
                          style="max-width:120px;max-height:60px;border-radius:6px;border:1px solid #ddd;object-fit:contain;background:#f8f8f8;padding:4px">
                        <div style="font-size:13px;color:#888;margin-top:3px">বর্তমান Logo</div>
                      </div>
                      @else
                      <div style="margin-bottom:8px">
                        <img src="{{ asset('upload/logo/' . (\App\Models\Logo::first()->image ?? 'logo.png')) }}"
                          style="max-width:120px;max-height:60px;border-radius:6px;border:1px solid #ddd;object-fit:contain;background:#f8f8f8;padding:4px"
                          onerror="this.style.display='none'">
                        <div style="font-size:13px;color:#888;margin-top:3px">বর্তমান Logo</div>
                      </div>
                      @endif
                      <div class="custom-file">
                        <input type="file" class="custom-file-input" id="logoFile"
                          name="seo_logo" accept="image/png,image/jpeg,image/webp">
                        <label class="custom-file-label" for="logoFile">Logo বেছে নিন</label>
                      </div>
                      <small class="text-muted d-block mt-1">
                        <strong>512×512px বা 1200×630px</strong> | PNG, WebP<br>
                        Google Search result-এ website-এর পাশে দেখাবে
                      </small>
                    </div>
                  </div>
                </div>

                {{-- Preview how Google shows it --}}
                <div style="background:#f8f9fb;border-radius:10px;padding:14px;margin-top:4px">
                  <div style="font-size:13px;font-weight:700;color:#555;margin-bottom:8px">Google Search-এ কেমন দেখাবে:</div>
                  <div style="display:flex;align-items:center;gap:10px;background:#fff;border-radius:8px;padding:10px 14px;border:1px solid #eee">
                    <div style="width:28px;height:28px;border-radius:50%;overflow:hidden;background:#f0f0f0;flex-shrink:0;display:flex;align-items:center;justify-content:center">
                      @if(!empty($setting->seo_logo))
                      <img src="{{ asset('upload/seo/' . $setting->seo_logo) }}" style="width:100%;height:100%;object-fit:cover">
                      @else
                      <div style="width:28px;height:28px;background:#e8001d;display:flex;align-items:center;justify-content:center;color:#fff;font-size:13px;font-weight:800">U</div>
                      @endif
                    </div>
                    <div>
                      <div style="font-size:13px;font-weight:600;color:#333">U Super Shop</div>
                      <div style="font-size:13px;color:#888">https://usuper.shop</div>
                    </div>
                  </div>
                </div>

              </div>
            </div>

            {{-- ── OG Image ─────────────────────────────────────────── --}}
            <div class="card shadow-sm mb-3">
              <div class="card-header bg-success text-white">
                <h3 class="card-title"><i class="fas fa-image mr-2"></i>OG Image (Facebook / WhatsApp Share Image)</h3>
              </div>
              <div class="card-body">

                @if(!empty($setting->seo_og_image))
                <div style="margin-bottom:12px">
                  <img src="{{ asset('upload/seo/' . $setting->seo_og_image) }}"
                    style="max-width:300px;border-radius:8px;border:1px solid #ddd">
                  <div style="font-size:13px;color:#888;margin-top:4px">বর্তমান OG Image</div>
                </div>
                @endif

                <div class="custom-file">
                  <input type="file" class="custom-file-input" id="ogImage"
                    name="seo_og_image" accept="image/jpeg,image/png">
                  <label class="custom-file-label" for="ogImage">OG Image বেছে নিন</label>
                </div>
                <small class="text-muted d-block mt-1">
                  Recommended: <strong>1200×630px</strong> | JPG বা PNG | সর্বোচ্চ 2MB<br>
                  Facebook, WhatsApp, Twitter-এ link share করলে এই ছবি দেখাবে
                </small>

                <div id="ogPreview" style="display:none;margin-top:10px">
                  <img id="ogPreviewImg" style="max-width:300px;border-radius:8px">
                </div>

              </div>
            </div>

            {{-- ── Social Media ────────────────────────────────────── --}}
            <div class="card shadow-sm mb-3">
              <div class="card-header" style="background:#1877f2;color:#fff">
                <h3 class="card-title"><i class="fas fa-share-alt mr-2"></i>Social Media Pages</h3>
              </div>
              <div class="card-body">
                <div class="form-group">
                  <label class="font-weight-bold"><i class="fab fa-facebook" style="color:#1877f2"></i> Facebook Page</label>
                  <input type="url" name="social_facebook"
                    value="{{ old('social_facebook', $setting->social_facebook ?? '') }}"
                    class="form-control" placeholder="https://www.facebook.com/usupershop">
                </div>
                <div class="form-group">
                  <label class="font-weight-bold"><i class="fab fa-youtube" style="color:#ff0000"></i> YouTube Channel</label>
                  <input type="url" name="social_youtube"
                    value="{{ old('social_youtube', $setting->social_youtube ?? '') }}"
                    class="form-control" placeholder="https://youtube.com/@usupershop">
                </div>
                <div class="form-group">
                  <label class="font-weight-bold"><i class="fab fa-instagram" style="color:#e1306c"></i> Instagram</label>
                  <input type="url" name="social_instagram"
                    value="{{ old('social_instagram', $setting->social_instagram ?? '') }}"
                    class="form-control" placeholder="https://www.instagram.com/usupershop">
                </div>
                <div class="form-group">
                  <label class="font-weight-bold"><i class="fab fa-telegram" style="color:#0088cc"></i> Telegram Channel</label>
                  <input type="url" name="social_telegram"
                    value="{{ old('social_telegram', $setting->social_telegram ?? '') }}"
                    class="form-control" placeholder="https://t.me/usupershop1">
                </div>
                <div class="form-group">
                  <label class="font-weight-bold"><i class="fab fa-tiktok"></i> TikTok</label>
                  <input type="url" name="social_tiktok"
                    value="{{ old('social_tiktok', $setting->social_tiktok ?? '') }}"
                    class="form-control" placeholder="https://tiktok.com/@usupershop">
                </div>
              </div>
            </div>

            {{-- ── Business Info ─────────────────────────────────── --}}
            <div class="card shadow-sm mb-3">
              <div class="card-header bg-dark text-white">
                <h3 class="card-title"><i class="fas fa-building mr-2"></i>Business Information (Schema.org)</h3>
              </div>
              <div class="card-body">
                <div class="form-group">
                  <label class="font-weight-bold">📍 Address</label>
                  <input type="text" name="business_address"
                    value="{{ old('business_address', $setting->business_address ?? 'Dhaka, Bangladesh') }}"
                    class="form-control" placeholder="Dhaka, Bangladesh">
                </div>
                <div class="form-group">
                  <label class="font-weight-bold">📧 Support Email</label>
                  <input type="email" name="business_email"
                    value="{{ old('business_email', $setting->business_email ?? 'usupershopbd@gmail.com') }}"
                    class="form-control" placeholder="usupershopbd@gmail.com">
                </div>
                <div class="alert alert-info" style="font-size:13px">
                  <i class="fas fa-info-circle"></i>
                  এই তথ্যগুলো <strong>Schema.org JSON-LD</strong> হিসেবে website-এ automatically যোগ হবে।
                  Google এই তথ্য ব্যবহার করে Business-কে search result-এ দেখায়।
                </div>
              </div>
            </div>

            <button type="submit" class="btn btn-primary btn-lg px-5 mb-4">
              <i class="fas fa-save mr-2"></i>SEO Settings Save করুন
            </button>

          </div>

          {{-- Right Panel --}}
          <div class="col-md-4">

            {{-- Google Preview --}}
            <div class="card shadow-sm mb-3" style="position:sticky;top:70px">
              <div class="card-header bg-dark text-white">
                <h3 class="card-title"><i class="fab fa-google mr-2"></i>Google Preview</h3>
              </div>
              <div class="card-body">
                <div style="font-family:Arial,sans-serif;padding:10px;background:#fff;border-radius:6px;border:1px solid #eee">
                  <div style="font-size:13px;color:#006621">https://usuper.shop</div>
                  <div id="gTitle" style="font-size:16px;color:#1a0dab;font-weight:400;line-height:1.3;margin:2px 0;cursor:pointer">
                    {{ $setting->seo_site_title ?? 'U Super Shop | Best Online Shop in Bangladesh' }}
                  </div>
                  <div id="gDesc" style="font-size:13px;color:#545454;line-height:1.4">
                    {{ Str::limit($setting->seo_meta_description ?? '', 160) }}
                  </div>
                </div>

                <div class="mt-3" style="font-size:13px;color:#555">
                  <strong>Title:</strong>
                  <span id="titleLen" class="badge badge-sm {{ strlen($setting->seo_site_title ?? '') > 60 ? 'badge-danger' : 'badge-success' }}">
                    {{ strlen($setting->seo_site_title ?? '') }}/60
                  </span>
                  <br><br>
                  <strong>Description:</strong>
                  <span id="descLen" class="badge badge-sm {{ strlen($setting->seo_meta_description ?? '') > 160 ? 'badge-warning' : 'badge-success' }}">
                    {{ strlen($setting->seo_meta_description ?? '') }}/160
                  </span>
                </div>
              </div>
            </div>

            {{-- Pages to link --}}
            <div class="card shadow-sm">
              <div class="card-header bg-info text-white">
                <h3 class="card-title"><i class="fas fa-link mr-2"></i>Important Pages</h3>
              </div>
              <div class="card-body" style="font-size:13px">
                <p class="text-muted mb-2">SEO-তে এই page গুলো submit করুন:</p>
                @foreach([
                  ['Special Offers', '/speacial-offers'],
                  ['Product List', '/product-list'],
                  ['Customer Signup', '/customer-signup'],
                  ['Customer Login', '/customer-login'],
                  ['Seller Signup', '/seller/signup'],
                  ['User Guide', '/user-guide'],
                  ['Pricing', '/pricing'],
                ] as $page)
                <div style="padding:5px 0;border-bottom:1px solid #f0f0f0;display:flex;justify-content:space-between">
                  <span>{{ $page[0] }}</span>
                  <code style="font-size:13px;color:#1e25fa">{{ $page[1] }}</code>
                </div>
                @endforeach
              </div>
            </div>

          </div>
        </div>
      </form>
    </div>
  </section>
</div>

@push('scripts')
<script>
function countChars(el, id, ideal) {
  var l = el.value.length;
  var el2 = document.getElementById(id);
  el2.textContent = l + '/' + ideal;
  el2.className = l > ideal ? 'text-danger font-weight-bold' : l > ideal * .85 ? 'text-warning' : 'text-muted';
  // Update preview
  if (el.name === 'seo_site_title') {
    document.getElementById('gTitle').textContent = el.value || 'Site Title...';
    document.getElementById('titleLen').textContent = l + '/60';
    document.getElementById('titleLen').className = 'badge badge-sm ' + (l > 60 ? 'badge-danger' : 'badge-success');
  }
  if (el.name === 'seo_meta_description') {
    document.getElementById('gDesc').textContent = el.value.substring(0, 160) + (el.value.length > 160 ? '...' : '');
    document.getElementById('descLen').textContent = l + '/160';
    document.getElementById('descLen').className = 'badge badge-sm ' + (l > 160 ? 'badge-warning' : 'badge-success');
  }
}

document.getElementById('ogImage').addEventListener('change', function() {
  if (this.files[0]) {
    var r = new FileReader();
    r.onload = e => {
      document.getElementById('ogPreviewImg').src = e.target.result;
      document.getElementById('ogPreview').style.display = 'block';
    };
    r.readAsDataURL(this.files[0]);
    document.querySelector('.custom-file-label').textContent = this.files[0].name;
  }
});

// Init char counts
document.querySelectorAll('#titleInput, #descInput').forEach(el => {
  if (el.value) countChars(el, el.id === 'titleInput' ? 'titleCount' : 'descCount', el.id === 'titleInput' ? 60 : 160);
});
</script>
@endpush
@endsection
