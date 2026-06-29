@extends('backend.layouts.master')
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        {{-- Page Header --}}
        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:22px;flex-wrap:wrap;gap:12px;">
            <div>
                <h1 style="font-size:22px;font-weight:800;color:#0f172a;margin:0;">
                    <i class="fas fa-tools" style="color:#6366f1;margin-right:8px;"></i>
                    @if (isset($editData)) Edit Meta Settings @else Add Meta Settings @endif
                </h1>
                <p style="color:#64748b;font-size:13px;margin:2px 0 0;">
                    <a href="{{ route('home') }}" style="color:#6366f1;text-decoration:none;">Home</a>
                    <span style="margin:0 6px;color:#cbd5e1;">/</span>
                    <a href="{{ route('settings.view') }}" style="color:#6366f1;text-decoration:none;">Settings</a>
                    <span style="margin:0 6px;color:#cbd5e1;">/</span>
                    @if (isset($editData)) Edit @else Add @endif
                </p>
            </div>
            <a class="btn btn-sm btn-primary" href="{{ route('settings.view') }}" style="display:inline-flex;align-items:center;gap:6px;padding:9px 18px;background:#6366f1;border:none;border-radius:8px;font-size:13px;font-weight:600;color:#fff;text-decoration:none;">
                <i class="fas fa-list"></i> Settings List
            </a>
        </div>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="card">
                    <div class="card-header">
                        <span class="card-title">
                            <i class="fas fa-cog" style="color:#6366f1;margin-right:6px;"></i>
                            App Configuration form
                        </span>
                    </div>
                    <div class="card-body">
                        <form method="post" action="{{ @$editData ? route('settings.update', $editData->id) : route('settings.store') }}" id="myForm">
                            @csrf
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="app_name">App Name <span class="text-danger">*</span></label>
                                    <input type="text" name="app_name" value="{{ @$editData->app_name }}" class="form-control" id="app_name" placeholder="Enter app name..." required>
                                    <span style="color: red;">{{ $errors->has('app_name') ? $errors->first('app_name') : '' }}</span>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="keywords">Meta Keywords <span class="text-danger">*</span></label>
                                    <input type="text" name="keywords" value="{{ @$editData->keywords }}" class="form-control" id="keywords" placeholder="Enter keywords..." required>
                                    <span style="color: red;">{{ $errors->has('keywords') ? $errors->first('keywords') : '' }}</span>
                                </div>

                                <div class="form-group col-md-12">
                                    <label for="summernote">Description</label>
                                    <textarea name="description" id="summernote" class="form-control" rows="4" placeholder="Enter description...">{{ @$editData->description }}</textarea>
                                    <span style="color: red;">{{ $errors->has('description') ? $errors->first('description') : '' }}</span>
                                </div>

                                {{-- WhatsApp Notify Number (Admin only) --}}
                                <div class="form-group col-md-12" style="border:1px solid #bbf7d0; border-radius:12px; padding:20px; margin-top:15px; background:#f0fdf4;">
                                    <label for="whatsapp_notify_number" style="color:#16a34a; font-weight:700; font-size:15px; display:flex; align-items:center; gap:8px;">
                                        <i class="fab fa-whatsapp" style="font-size:20px;"></i>
                                        WhatsApp Notification Number
                                        <span class="badge badge-success" style="background:#16a34a; color:#fff; font-size:10px; padding:3px 8px; border-radius:10px;">ADMIN ONLY</span>
                                    </label>
                                    <div class="input-group" style="margin-top:10px;">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" style="background:#22c55e; color:#fff; border:none; font-weight:700; border-top-left-radius:8px; border-bottom-left-radius:8px;">+880</span>
                                        </div>
                                        <input type="text" name="whatsapp_notify_number" value="{{ @$editData->whatsapp_notify_number }}" class="form-control" id="whatsapp_notify_number" placeholder="01816622128" maxlength="15" style="border-top-right-radius:8px; border-bottom-right-radius:8px;">
                                    </div>
                                    <small style="color:#475569; margin-top:12px; display:block; line-height:1.7;">
                                        <i class="fas fa-info-circle mr-1"></i> <strong>Configuration Requirements in <code>.env</code> file:</strong><br>
                                        <code style="background:#dcfce7; color:#166534; padding:2px 6px; border-radius:4px; font-family:monospace; font-size:12px;">WHATSAPP_TOKEN</code> — Meta Developer access token<br>
                                        <code style="background:#dcfce7; color:#166534; padding:2px 6px; border-radius:4px; font-family:monospace; font-size:12px;">WHATSAPP_PHONE_NUMBER_ID</code> — Meta API phone number ID<br>
                                        <code style="background:#dcfce7; color:#166534; padding:2px 6px; border-radius:4px; font-family:monospace; font-size:12px;">ADMIN_WHATSAPP_NUMBER=8801816622128</code> — WhatsApp receiver number<br>
                                        🔗 Setup endpoint mappings on <a href="https://developers.facebook.com" target="_blank" style="color:#166534; font-weight:700; text-decoration:underline;">developers.facebook.com</a>
                                    </small>
                                </div>

                                <div class="form-group col-md-12 text-right" style="margin-top:25px; border-top:1px solid #e2e8f0; padding-top:20px;">
                                    <button type="submit" class="btn btn-primary" style="background:#6366f1; border:none; padding:10px 30px; border-radius:8px; font-weight:600;">
                                        <i class="fas fa-save mr-1"></i> {{ @$editData ? 'Update Settings' : 'Save Settings' }}
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
        $(function() {
            $('#summernote').summernote({
                height: 200,
                callbacks: {
                    onChange: function(contents, $editable) {
                        $('#summernote').val(contents);
                    }
                }
            });

            $('#myForm').validate({
                rules: {
                    app_name: {
                        required: true
                    },
                    keywords: {
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
