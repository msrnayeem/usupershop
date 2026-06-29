@extends('backend.layouts.master')
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        {{-- Page Header --}}
        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:22px;flex-wrap:wrap;gap:12px;">
            <div>
                <h1 style="font-size:22px;font-weight:800;color:#0f172a;margin:0;">
                    <i class="fas fa-address-book" style="color:#6366f1;margin-right:8px;"></i>
                    @if (isset($editData)) Edit Contact Details @else Add Contact Details @endif
                </h1>
                <p style="color:#64748b;font-size:13px;margin:2px 0 0;">
                    <a href="{{ route('home') }}" style="color:#6366f1;text-decoration:none;">Home</a>
                    <span style="margin:0 6px;color:#cbd5e1;">/</span>
                    <a href="{{ route('contacts.view') }}" style="color:#6366f1;text-decoration:none;">Contacts</a>
                    <span style="margin:0 6px;color:#cbd5e1;">/</span>
                    @if (isset($editData)) Edit @else Add @endif
                </p>
            </div>
            <a class="btn btn-sm btn-primary" href="{{ route('contacts.view') }}" style="display:inline-flex;align-items:center;gap:6px;padding:9px 18px;background:#6366f1;border:none;border-radius:8px;font-size:13px;font-weight:600;color:#fff;text-decoration:none;">
                <i class="fas fa-list"></i> Contacts List
            </a>
        </div>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="card">
                    <div class="card-header">
                        <span class="card-title">
                            <i class="fas fa-cog" style="color:#6366f1;margin-right:6px;"></i>
                            Company Coordinates Configuration
                        </span>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <form method="post"
                            action="{{ @$editData ? route('contacts.update', $editData->id) : route('contacts.store') }}"
                            id="myForm" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                {{-- Core Contact --}}
                                <div class="col-md-4 form-group">
                                    <label for="address" style="font-weight:600;color:#334155;font-size:13px;">Physical Address <span class="text-danger">*</span></label>
                                    <input type="text" name="address" value="{{ @$editData->address }}"
                                        class="form-control" id="address" placeholder="Office physical coordinates" required>
                                    <span style="color: red;">{{ $errors->has('address') ? $errors->first('address') : '' }}</span>
                                </div>
                                <div class="col-md-4 form-group">
                                    <label for="mobile" style="font-weight:600;color:#334155;font-size:13px;">Mobile No <span class="text-danger">*</span></label>
                                    <input type="text" name="mobile" value="{{ @$editData->mobile }}"
                                        class="form-control" id="mobile" placeholder="Customer care support phone" required>
                                    <span style="color: red;">{{ $errors->has('mobile') ? $errors->first('mobile') : '' }}</span>
                                </div>
                                <div class="col-md-4 form-group">
                                    <label for="email" style="font-weight:600;color:#334155;font-size:13px;">Support Email <span class="text-danger">*</span></label>
                                    <input type="email" name="email" value="{{ @$editData->email }}"
                                        class="form-control" id="email" placeholder="support@brand.com" required>
                                    <span style="color: red;">{{ $errors->has('email') ? $errors->first('email') : '' }}</span>
                                </div>

                                {{-- Facebook --}}
                                <div class="col-md-6 form-group mt-3">
                                    <div style="background:#f8fafc;padding:15px;border-radius:10px;border:1px solid #e2e8f0;">
                                        <label for="facebook" style="font-weight:700;color:#1877f2;font-size:13px;"><i class="fab fa-facebook mr-1"></i> Facebook Link</label>
                                        <input type="url" name="facebook" value="{{ @$editData->facebook }}"
                                            class="form-control mb-3" id="facebook" placeholder="https://www.facebook.com/brand" required>
                                        
                                        <div style="display:flex;gap:12px;align-items:center;">
                                            <div class="custom-file" style="flex:1;">
                                                <input type="file" name="facebook_icon" id="facebook_icon" class="custom-file-input" accept="image/*" onchange="previewIcon(this, 'show_facebook_icon')">
                                                <label class="custom-file-label" for="facebook_icon">Custom Icon</label>
                                            </div>
                                            <div style="width:40px;height:40px;border-radius:6px;border:1px solid #cbd5e1;background:#fff;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                                                <img id="show_facebook_icon" style="max-height:30px;max-width:30px;object-fit:contain;"
                                                    src="{{ !empty($editData->facebook_icon) ? url('upload/contact_icon/' . $editData->facebook_icon) : url('frontend/no-image-icon.jpg') }}"
                                                    onerror="this.src='{{ url('frontend/no-image-icon.jpg') }}'">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- Youtube --}}
                                <div class="col-md-6 form-group mt-3">
                                    <div style="background:#f8fafc;padding:15px;border-radius:10px;border:1px solid #e2e8f0;">
                                        <label for="youtube" style="font-weight:700;color:#ff0000;font-size:13px;"><i class="fab fa-youtube mr-1"></i> YouTube Channel</label>
                                        <input type="url" name="youtube" value="{{ @$editData->youtube }}"
                                            class="form-control mb-3" id="youtube" placeholder="https://youtube.com/@channel" required>
                                        
                                        <div style="display:flex;gap:12px;align-items:center;">
                                            <div class="custom-file" style="flex:1;">
                                                <input type="file" name="youtube_icon" id="youtube_icon" class="custom-file-input" accept="image/*" onchange="previewIcon(this, 'show_youtube_icon')">
                                                <label class="custom-file-label" for="youtube_icon">Custom Icon</label>
                                            </div>
                                            <div style="width:40px;height:40px;border-radius:6px;border:1px solid #cbd5e1;background:#fff;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                                                <img id="show_youtube_icon" style="max-height:30px;max-width:30px;object-fit:contain;"
                                                    src="{{ !empty($editData->youtube_icon) ? url('upload/contact_icon/' . $editData->youtube_icon) : url('frontend/no-image-icon.jpg') }}"
                                                    onerror="this.src='{{ url('frontend/no-image-icon.jpg') }}'">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- Twitter --}}
                                <div class="col-md-4 form-group mt-3">
                                    <div style="background:#f8fafc;padding:15px;border-radius:10px;border:1px solid #e2e8f0;">
                                        <label for="twitter" style="font-weight:700;color:#000;font-size:13px;"><i class="fab fa-twitter mr-1"></i> Twitter Profile</label>
                                        <input type="url" name="twitter" value="{{ @$editData->twitter }}"
                                            class="form-control mb-3" id="twitter" placeholder="https://twitter.com/brand" required>
                                        
                                        <div style="display:flex;gap:12px;align-items:center;">
                                            <div class="custom-file" style="flex:1;">
                                                <input type="file" name="twitter_icon" id="twitter_icon" class="custom-file-input" accept="image/*" onchange="previewIcon(this, 'show_twitter_icon')">
                                                <label class="custom-file-label" for="twitter_icon">Custom Icon</label>
                                            </div>
                                            <div style="width:40px;height:40px;border-radius:6px;border:1px solid #cbd5e1;background:#fff;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                                                <img id="show_twitter_icon" style="max-height:30px;max-width:30px;object-fit:contain;"
                                                    src="{{ !empty($editData->twitter_icon) ? url('upload/contact_icon/' . $editData->twitter_icon) : url('frontend/no-image-icon.jpg') }}"
                                                    onerror="this.src='{{ url('frontend/no-image-icon.jpg') }}'">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- Instagram --}}
                                <div class="col-md-4 form-group mt-3">
                                    <div style="background:#f8fafc;padding:15px;border-radius:10px;border:1px solid #e2e8f0;">
                                        <label for="instagram" style="font-weight:700;color:#e1306c;font-size:13px;"><i class="fab fa-instagram mr-1"></i> Instagram Link</label>
                                        <input type="url" name="instagram" value="{{ @$editData->instagram }}"
                                            class="form-control mb-3" id="instagram" placeholder="https://instagram.com/profile">
                                        
                                        <div style="display:flex;gap:12px;align-items:center;">
                                            <div class="custom-file" style="flex:1;">
                                                <input type="file" name="instagram_icon" id="instagram_icon" class="custom-file-input" accept="image/*" onchange="previewIcon(this, 'show_instagram_icon')">
                                                <label class="custom-file-label" for="instagram_icon">Custom Icon</label>
                                            </div>
                                            <div style="width:40px;height:40px;border-radius:6px;border:1px solid #cbd5e1;background:#fff;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                                                <img id="show_instagram_icon" style="max-height:30px;max-width:30px;object-fit:contain;"
                                                    src="{{ !empty($editData->instagram_icon) ? url('upload/contact_icon/' . $editData->instagram_icon) : url('frontend/no-image-icon.jpg') }}"
                                                    onerror="this.src='{{ url('frontend/no-image-icon.jpg') }}'">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- Telegram --}}
                                <div class="col-md-4 form-group mt-3">
                                    <div style="background:#f8fafc;padding:15px;border-radius:10px;border:1px solid #e2e8f0;">
                                        <label for="telegram" style="font-weight:700;color:#0088cc;font-size:13px;"><i class="fab fa-telegram mr-1"></i> Telegram Link</label>
                                        <input type="url" name="telegram" value="{{ @$editData->telegram }}"
                                            class="form-control mb-3" id="telegram" placeholder="https://t.me/channel">
                                        
                                        <div style="display:flex;gap:12px;align-items:center;">
                                            <div class="custom-file" style="flex:1;">
                                                <input type="file" name="telegram_icon" id="telegram_icon" class="custom-file-input" accept="image/*" onchange="previewIcon(this, 'show_telegram_icon')">
                                                <label class="custom-file-label" for="telegram_icon">Custom Icon</label>
                                            </div>
                                            <div style="width:40px;height:40px;border-radius:6px;border:1px solid #cbd5e1;background:#fff;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                                                <img id="show_telegram_icon" style="max-height:30px;max-width:30px;object-fit:contain;"
                                                    src="{{ !empty($editData->telegram_icon) ? url('upload/contact_icon/' . $editData->telegram_icon) : url('frontend/no-image-icon.jpg') }}"
                                                    onerror="this.src='{{ url('frontend/no-image-icon.jpg') }}'">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- Whatsapp --}}
                                <div class="col-md-4 form-group mt-3">
                                    <div style="background:#f8fafc;padding:15px;border-radius:10px;border:1px solid #e2e8f0;">
                                        <label for="whatsapp" style="font-weight:700;color:#22c55e;font-size:13px;"><i class="fab fa-whatsapp mr-1"></i> WhatsApp link</label>
                                        <input type="url" name="whatsapp" value="{{ @$editData->whatsapp }}"
                                            class="form-control mb-3" id="whatsapp" placeholder="https://wa.me/8801816622128">
                                        
                                        <div style="display:flex;gap:12px;align-items:center;">
                                            <div class="custom-file" style="flex:1;">
                                                <input type="file" name="whatsapp_icon" id="whatsapp_icon" class="custom-file-input" accept="image/*" onchange="previewIcon(this, 'show_whatsapp_icon')">
                                                <label class="custom-file-label" for="whatsapp_icon">Custom Icon</label>
                                            </div>
                                            <div style="width:40px;height:40px;border-radius:6px;border:1px solid #cbd5e1;background:#fff;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                                                <img id="show_whatsapp_icon" style="max-height:30px;max-width:30px;object-fit:contain;"
                                                    src="{{ !empty($editData->whatsapp_icon) ? url('upload/contact_icon/' . $editData->whatsapp_icon) : url('frontend/no-image-icon.jpg') }}"
                                                    onerror="this.src='{{ url('frontend/no-image-icon.jpg') }}'">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-12 text-right mt-4" style="border-top:1px solid #e2e8f0;padding-top:20px;margin-bottom:0;">
                                    <button type="submit" class="btn btn-primary px-4" style="background:#6366f1;border:none;font-weight:600;padding:10px 24px;border-radius:8px;">
                                        <i class="fas fa-save mr-1"></i> {{ @$editData ? 'Update Coordinates' : 'Save Coordinates' }}
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
        function previewIcon(input, targetId) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#' + targetId).attr('src', e.target.result);
                };
                reader.readAsDataURL(input.files[0]);
                $(input).siblings('.custom-file-label').addClass("selected").html(input.files[0].name);
            }
        }

        $(function() {
            $('#myForm').validate({
                rules: {
                    address: { required: true },
                    mobile: { required: true },
                    email: { required: true },
                    facebook: { required: true },
                    youtube: { required: true },
                    twitter: { required: true }
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
