@extends('backend.layouts.master')
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        {{-- Page Header --}}
        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:22px;flex-wrap:wrap;gap:12px;">
            <div>
                <h1 style="font-size:22px;font-weight:800;color:#0f172a;margin:0;">
                    <i class="fas fa-search" style="color:#6366f1;margin-right:8px;"></i>
                    SEO Search Configurations
                </h1>
                <p style="color:#64748b;font-size:13px;margin:2px 0 0;">
                    <a href="{{ route('home') }}" style="color:#6366f1;text-decoration:none;">Home</a>
                    <span style="margin:0 6px;color:#cbd5e1;">/</span>
                    SEO Settings
                </p>
            </div>
        </div>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" style="border:none;border-radius:8px;background:#f0fdf4;color:#15803d;margin-bottom:20px;">
                        <i class="fas fa-check-circle mr-1"></i> {{ session('success') }}
                        <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
                    </div>
                @endif

                <form action="{{ route('settings.seo.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-md-8">
                            {{-- Basic SEO --}}
                            <div class="card mb-4">
                                <div class="card-header">
                                    <span class="card-title">
                                        <i class="fas fa-tag" style="color:#6366f1;margin-right:6px;"></i>
                                        Search Engine Optimizations (Meta Tags)
                                    </span>
                                </div>
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="titleInput" style="font-weight:600;color:#334155;font-size:13px;">🌐 Browser Tab Site Title</label>
                                        <input type="text" name="seo_site_title" value="{{ old('seo_site_title', $setting->seo_site_title ?? '') }}" class="form-control" id="titleInput" maxlength="200" placeholder="e.g. U Super Shop | Best E-Commerce in Bangladesh" oninput="countChars(this,'titleCount',60)" required>
                                        <div class="d-flex justify-content-between mt-1" style="font-size:11px;">
                                            <span class="text-muted">Search engines display up to 60 characters</span>
                                            <span id="titleCount" class="text-muted font-weight-bold">0/60</span>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="descInput" style="font-weight:600;color:#334155;font-size:13px;">📝 Search Meta Description</label>
                                        <textarea name="seo_meta_description" id="descInput" rows="4" class="form-control" maxlength="500" placeholder="Enter brief website summary details..." oninput="countChars(this,'descCount',160)" required>{{ old('seo_meta_description', $setting->seo_meta_description ?? '') }}</textarea>
                                        <div class="d-flex justify-content-between mt-1" style="font-size:11px;">
                                            <span class="text-muted">Ideal length is around 160 characters</span>
                                            <span id="descCount" class="text-muted font-weight-bold">0/160</span>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="seo_meta_keywords" style="font-weight:600;color:#334155;font-size:13px;">🔑 Search Meta Keywords</label>
                                        <textarea name="seo_meta_keywords" id="seo_meta_keywords" rows="3" class="form-control" placeholder="comma, separated, list, of, keywords..." required>{{ old('seo_meta_keywords', $setting->seo_meta_keywords ?? '') }}</textarea>
                                        <small class="text-muted mt-1 d-block">Split tags using comma symbols (,)</small>
                                    </div>

                                    <div class="form-group mb-0">
                                        <label for="seo_google_verification" style="font-weight:600;color:#334155;font-size:13px;">✅ Google Site Verification Token</label>
                                        <input type="text" name="seo_google_verification" id="seo_google_verification" value="{{ old('seo_google_verification', $setting->seo_google_verification ?? '') }}" class="form-control" style="font-family:monospace;font-size:13px;" placeholder="e.g. google-site-verification-id">
                                        <small class="text-muted mt-1 d-block">Google Webmasters Search Console HTML Tag activation key</small>
                                    </div>
                                </div>
                            </div>

                            {{-- Brand Assets --}}
                            <div class="card mb-4">
                                <div class="card-header">
                                    <span class="card-title">
                                        <i class="fas fa-image" style="color:#6366f1;margin-right:6px;"></i>
                                        Search Result Logos & Favicons
                                    </span>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group mb-0">
                                                <label style="font-weight:600;color:#334155;font-size:13px;">🌐 Browser Tab Favicon (16x16 / 32x32)</label>
                                                <div style="display:flex;align-items:center;gap:12px;margin-bottom:12px;">
                                                    @if(!empty($setting->seo_favicon))
                                                        <img src="{{ asset('upload/seo/' . $setting->seo_favicon) }}" style="width:36px;height:36px;border-radius:6px;border:1px solid #cbd5e1;object-fit:contain;background:#f8fafc;padding:4px;">
                                                    @else
                                                        <div style="width:36px;height:36px;background:#6366f1;border-radius:6px;display:flex;align-items:center;justify-content:center;color:#fff;font-size:14px;font-weight:800;">U</div>
                                                    @endif
                                                    <span style="font-size:12px;color:#64748b;">Active Web Favicon Icon</span>
                                                </div>
                                                <div class="custom-file">
                                                    <input type="file" class="custom-file-input" id="faviconFile" name="seo_favicon" accept="image/x-icon,image/png,image/jpeg">
                                                    <label class="custom-file-label" for="faviconFile">Upload Icon</label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group mb-0">
                                                <label style="font-weight:600;color:#334155;font-size:13px;">🏷️ Structured Logo Schema Image</label>
                                                <div style="display:flex;align-items:center;gap:12px;margin-bottom:12px;">
                                                    @if(!empty($setting->seo_logo))
                                                        <img src="{{ asset('upload/seo/' . $setting->seo_logo) }}" style="max-height:36px;max-width:120px;border-radius:6px;border:1px solid #cbd5e1;object-fit:contain;background:#f8fafc;padding:4px;">
                                                    @else
                                                        <img src="{{ asset('upload/logo/' . (\App\Models\Logo::first()->image ?? 'logo.png')) }}" style="max-height:36px;max-width:120px;border-radius:6px;border:1px solid #cbd5e1;object-fit:contain;background:#f8fafc;padding:4px;" onerror="this.style.display='none'">
                                                    @endif
                                                    <span style="font-size:12px;color:#64748b;">Structured Metadata Logo</span>
                                                </div>
                                                <div class="custom-file">
                                                    <input type="file" class="custom-file-input" id="logoFile" name="seo_logo" accept="image/png,image/jpeg,image/webp">
                                                    <label class="custom-file-label" for="logoFile">Upload Logo</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Social OG Share Image --}}
                            <div class="card mb-4">
                                <div class="card-header">
                                    <span class="card-title">
                                        <i class="fas fa-share-alt" style="color:#6366f1;margin-right:6px;"></i>
                                        Social Sharing Banner (OpenGraph OG Image)
                                    </span>
                                </div>
                                <div class="card-body">
                                    <div style="margin-bottom:15px;">
                                        @if(!empty($setting->seo_og_image))
                                            <img src="{{ asset('upload/seo/' . $setting->seo_og_image) }}" style="max-width:260px;border-radius:8px;border:1px solid #cbd5e1;box-shadow:0 2px 8px rgba(0,0,0,0.05);display:block;margin-bottom:8px;">
                                            <span style="font-size:12px;color:#64748b;">Active Facebook Link Preview Banner</span>
                                        @endif
                                    </div>
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="ogImage" name="seo_og_image" accept="image/jpeg,image/png">
                                        <label class="custom-file-label" for="ogImage">Upload Share Banner</label>
                                    </div>
                                    <small class="text-muted mt-2 d-block">Recommended Dimension: <strong>1200x630 pixels</strong> (JPG, PNG)</small>

                                    <div id="ogPreview" style="display:none;margin-top:15px;">
                                        <img id="ogPreviewImg" style="max-width:260px;border-radius:8px;border:1px solid #cbd5e1;">
                                    </div>
                                </div>
                            </div>

                            {{-- Social Media Accounts --}}
                            <div class="card mb-4">
                                <div class="card-header">
                                    <span class="card-title">
                                        <i class="fas fa-network-wired" style="color:#6366f1;margin-right:6px;"></i>
                                        Brand Profile Social Coordinates
                                    </span>
                                </div>
                                <div class="card-body">
                                    <div class="form-group">
                                        <label style="font-weight:600;color:#334155;font-size:13px;"><i class="fab fa-facebook mr-1" style="color:#1877f2;"></i> Facebook URL</label>
                                        <input type="url" name="social_facebook" value="{{ old('social_facebook', $setting->social_facebook ?? '') }}" class="form-control" placeholder="https://www.facebook.com/brand">
                                    </div>
                                    <div class="form-group">
                                        <label style="font-weight:600;color:#334155;font-size:13px;"><i class="fab fa-youtube mr-1" style="color:#ff0000;"></i> YouTube Channel URL</label>
                                        <input type="url" name="social_youtube" value="{{ old('social_youtube', $setting->social_youtube ?? '') }}" class="form-control" placeholder="https://youtube.com/@channel">
                                    </div>
                                    <div class="form-group">
                                        <label style="font-weight:600;color:#334155;font-size:13px;"><i class="fab fa-instagram mr-1" style="color:#e1306c;"></i> Instagram Profile URL</label>
                                        <input type="url" name="social_instagram" value="{{ old('social_instagram', $setting->social_instagram ?? '') }}" class="form-control" placeholder="https://instagram.com/profile">
                                    </div>
                                    <div class="form-group">
                                        <label style="font-weight:600;color:#334155;font-size:13px;"><i class="fab fa-telegram mr-1" style="color:#0088cc;"></i> Telegram Channel link</label>
                                        <input type="url" name="social_telegram" value="{{ old('social_telegram', $setting->social_telegram ?? '') }}" class="form-control" placeholder="https://t.me/channel">
                                    </div>
                                    <div class="form-group mb-0">
                                        <label style="font-weight:600;color:#334155;font-size:13px;"><i class="fab fa-tiktok mr-1" style="color:#000;"></i> TikTok Channel URL</label>
                                        <input type="url" name="social_tiktok" value="{{ old('social_tiktok', $setting->social_tiktok ?? '') }}" class="form-control" placeholder="https://tiktok.com/@brand">
                                    </div>
                                </div>
                            </div>

                            {{-- Business Schema --}}
                            <div class="card mb-4">
                                <div class="card-header bg-dark">
                                    <span class="card-title font-weight-bold text-white"><i class="fas fa-building mr-1"></i> Business Metadata Settings</span>
                                </div>
                                <div class="card-body">
                                    <div class="form-group">
                                        <label style="font-weight:600;color:#334155;font-size:13px;">📍 Business Physical Address</label>
                                        <input type="text" name="business_address" value="{{ old('business_address', $setting->business_address ?? 'Dhaka, Bangladesh') }}" class="form-control" placeholder="Office physical locations">
                                    </div>
                                    <div class="form-group mb-0">
                                        <label style="font-weight:600;color:#334155;font-size:13px;">📧 Customer Support Email</label>
                                        <input type="email" name="business_email" value="{{ old('business_email', $setting->business_email ?? 'support@usuper.shop') }}" class="form-control" placeholder="support@brand.com">
                                    </div>
                                </div>
                            </div>

                            <div class="form-group" style="margin-bottom:40px;">
                                <button type="submit" class="btn btn-primary btn-lg" style="background:#6366f1;border:none;padding:12px 35px;border-radius:8px;font-weight:600;box-shadow: 0 4px 6px -1px rgba(99,102,241,0.2);">
                                    <i class="fas fa-save mr-2"></i> Save SEO Configurations
                                </button>
                            </div>
                        </div>

                        {{-- Sidebar Preview Column --}}
                        <div class="col-md-4">
                            <div class="card mb-4" style="position:sticky;top:20px;">
                                <div class="card-header bg-dark">
                                    <span class="card-title font-weight-bold text-white"><i class="fab fa-google mr-1"></i> Google Search Engine Mock</span>
                                </div>
                                <div class="card-body">
                                    <div style="font-family:Arial, sans-serif;padding:15px;background:#fff;border-radius:8px;border:1px solid #cbd5e1;box-shadow:0 2px 6px rgba(0,0,0,0.02);">
                                        <div style="font-size:12px;color:#006621;margin-bottom:3px;">https://usuper.shop</div>
                                        <div id="gTitle" style="font-size:17px;color:#1a0dab;font-weight:400;line-height:1.2;cursor:pointer;margin-bottom:5px;">
                                            {{ $setting->seo_site_title ?? 'U Super Shop | Online E-Commerce Portal' }}
                                        </div>
                                        <div id="gDesc" style="font-size:13px;color:#545454;line-height:1.4;word-wrap:break-word;">
                                            {{ Str::limit($setting->seo_meta_description ?? 'Best bargains on fashion items, lifestyle products, organic groceries, cosmetics and accessories.', 160) }}
                                        </div>
                                    </div>

                                    <div class="mt-4" style="font-size:12px;color:#475569;border-top:1px solid #e2e8f0;padding-top:15px;">
                                        <div class="d-flex justify-content-between mb-2">
                                            <span>Site Title Length:</span>
                                            <span id="titleLen" class="badge {{ strlen($setting->seo_site_title ?? '') > 60 ? 'badge-danger' : 'badge-success' }}" style="padding:4px 8px;">
                                                {{ strlen($setting->seo_site_title ?? '') }}/60
                                            </span>
                                        </div>
                                        <div class="d-flex justify-content-between">
                                            <span>Meta Description Length:</span>
                                            <span id="descLen" class="badge {{ strlen($setting->seo_meta_description ?? '') > 160 ? 'badge-warning' : 'badge-success' }}" style="padding:4px 8px;">
                                                {{ strlen($setting->seo_meta_description ?? '') }}/160
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </section>
    </div>
@endsection

@push('scripts')
    <script>
        function countChars(el, id, ideal) {
            var l = el.value.length;
            var el2 = document.getElementById(id);
            el2.textContent = l + '/' + ideal;
            el2.className = l > ideal ? 'text-danger font-weight-bold' : l > ideal * .85 ? 'text-warning font-weight-bold' : 'text-muted';
            
            if (el.name === 'seo_site_title') {
                document.getElementById('gTitle').textContent = el.value || 'Site Title...';
                document.getElementById('titleLen').textContent = l + '/60';
                document.getElementById('titleLen').className = 'badge ' + (l > 60 ? 'badge-danger' : 'badge-success');
            }
            if (el.name === 'seo_meta_description') {
                document.getElementById('gDesc').textContent = el.value.substring(0, 160) + (el.value.length > 160 ? '...' : '');
                document.getElementById('descLen').textContent = l + '/160';
                document.getElementById('descLen').className = 'badge ' + (l > 160 ? 'badge-warning' : 'badge-success');
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
                document.querySelector("label[for='ogImage']").textContent = this.files[0].name;
            }
        });

        document.getElementById('faviconFile').addEventListener('change', function() {
            if (this.files[0]) {
                document.querySelector("label[for='faviconFile']").textContent = this.files[0].name;
            }
        });

        document.getElementById('logoFile').addEventListener('change', function() {
            if (this.files[0]) {
                document.querySelector("label[for='logoFile']").textContent = this.files[0].name;
            }
        });

        document.querySelectorAll('#titleInput, #descInput').forEach(el => {
            if (el.value) countChars(el, el.id === 'titleInput' ? 'titleCount' : 'descCount', el.id === 'titleInput' ? 60 : 160);
        });
    </script>
@endpush
